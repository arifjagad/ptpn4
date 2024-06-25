<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $fillable = [
        'user_id',
        'nik',
        'niksap',
        'jabatan',
        'nomor_telp',
        'jenis_kelamin',
        'status_perjalanan',
        'asal_perusahaan',
    ];

    protected $attributes = [
        'status_perjalanan' => 'Tersedia', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
