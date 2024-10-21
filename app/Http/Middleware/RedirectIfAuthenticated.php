<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // Jika tidak ada guard yang diberikan, gunakan null (default guard)
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            // Cek apakah user sudah login di guard tertentu (admin atau member)
            if (Auth::guard($guard)->check()) {
                // Redirect berdasarkan guard
                if ($guard === 'admin') {
                    return redirect('/home');
                }

                if ($guard === 'member') {
                    return redirect('/katalog');
                }

                // Jika guard lain, redirect ke HOME default
                return redirect(RouteServiceProvider::HOME);
            }
        }

        // Jika tidak ada yang login, lanjutkan ke request berikutnya (guest)
        return $next($request);
    }
}
