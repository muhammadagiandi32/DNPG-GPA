<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        // Periksa apakah pengguna sedang masuk
        if (!Auth::check()) {
            return redirect('/login');
        }
        // Ambil izin yang diminta dari parameter middleware
        $requestedPermission = $permission;

        // Ambil izin-izin yang dimiliki oleh peran pengguna saat ini
        $userPermissions = Auth::user()->role->permissions->pluck('name')->toArray();

        // Periksa apakah pengguna memiliki izin yang diminta
        if (in_array($requestedPermission, $userPermissions)) {
            return $next($request);
        }

        // Jika tidak memiliki izin, arahkan pengguna ke halaman tidak diizinkan
        return abort(403, 'Unauthorized');

        // // Ambil izin yang diberikan oleh pengguna
        // $userPermissions = Auth::user()->permissions()->pluck('id')->toArray();

        // // Periksa apakah pengguna memiliki setidaknya satu dari izin yang diperlukan
        // foreach ($permissions as $permission) {
        //     if (in_array($permission, $userPermissions)) {
        //         return $next($request);
        //     }
        // }

        // // Jika pengguna tidak memiliki izin yang diperlukan, kembalikan 403 Forbidden
        // abort(403, 'Unauthorized action.');
    }
}
