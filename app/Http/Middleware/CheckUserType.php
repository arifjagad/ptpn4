<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    public function handle($request, Closure $next, ...$types)
    {
        if (!Auth::check() || !in_array(Auth::user()->user_type, $types)) {
            return redirect('login');
        }

        return $next($request);
    }
}
