<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = session('user');

        if (!$user || !in_array($user['role'], $roles)) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}