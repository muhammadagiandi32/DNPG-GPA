<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        // Periksa apakah pengguna telah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Ambil peran pengguna saat ini
        $userRole = Auth::user()->role;

        // Periksa apakah peran pengguna saat ini memiliki izin yang diperlukan
        foreach ($roles as $role) {
            if ($userRole->permissions->contains('name', $role)) {
                return $next($request);
            }
        }

        // Jika tidak memiliki izin, arahkan pengguna ke halaman tidak diizinkan
        return abort(403, 'Unauthorized');
    }
}
