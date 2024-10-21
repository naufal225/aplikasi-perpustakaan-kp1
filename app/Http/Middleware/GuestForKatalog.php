<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestForKatalog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah pengguna sudah login dengan guard 'web' (umum)
        if (Auth::guard('web')->check()) {
            return redirect('/katalog'); // Redirect ke dashboard umum (member) jika login
        }

        // Lanjutkan ke request berikutnya (untuk guest atau admin)
        return $next($request);
    }
}
