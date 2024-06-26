<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginRequest extends FormRequest
{
    public $isKaryawanPimpinan = false;
    public $isKaryawanPelaksana = false;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Try to authenticate with email/password
        if (Auth::attempt(['email' => $this->identifier, 'password' => $this->password])) {
            RateLimiter::clear($this->throttleKey());
            Log::info('Authenticated with email/password');
            return;
        }

        // Mengecek data yang dikirim sama atau tidak dari tabel dan kolom KARYAWAN PELAKSANA
        $userFP = DB::table('FPERSUTAMA')
            ->where('UPAKM', $this->identifier) // Dianggap username
            ->where('UPAKM', $this->password) // Dianggap password
            ->first();

        // Pengecekan apakah login berdasarkan data yang ditemukan
        if ($userFP) {
            Session::put('nik', $userFP->NIK);
            Session::put('isKaryawanPelaksana', true); // Store the flag in session
            Auth::loginUsingId($userFP->NIKSAP); // Auth
            RateLimiter::clear($this->throttleKey());
            Log::info('Authenticated with FPERSUTAMA', ['user' => $userFP]);
            return;
        }

        // Mengecek data yang dikirim sama atau tidak dari tabel dan kolom KARYAWAN PIMPINAN
        $userP = DB::table('PERSUTAMA')
            ->where('NIK', $this->identifier) // Dianggap username
            ->whereRaw("PWDCOMPARE('$this->password', UPAX, 0) = 1") // Dianggap password (ada enkripsi)
            ->first();
        
        // Pengecekan apakah login berdasarkan data yang ditemukan
        if ($userP) {
            Session::put('nik', $userP->NIK);
            Session::put('isKaryawanPimpinan', true); // Store the flag in session
            Auth::loginUsingId($userP->NIKSAP); // Auth
            RateLimiter::clear($this->throttleKey());
            Log::info('Authenticated with PERSUTAMA', ['user' => $userP]);
            return;
        }
        
        RateLimiter::hit($this->throttleKey());
        Log::error('Authentication failed', ['identifier' => $this->identifier]);
        
        throw ValidationException::withMessages([
            'identifier' => trans('auth.failed'),
        ]);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('email')) . '|' . $this->ip();
    }
}