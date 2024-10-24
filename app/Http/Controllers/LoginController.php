<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request) {
        $credentials = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ], [
            "email.required" => "Masukan Email Anda",
            "email.email" => "Pastikan Email Anda Valid",
            "password.required" => "Masukan Password Anda"
        ]);

        $remember = $request->has('ingatSaya');

        if(Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended("/home");
        }

        return back()->with("LoginError", "Login Gagal");
    }

    public function logout(Request $request) {
    // Logout hanya dari guard 'admin'
    Auth::guard('admin')->logout();

    // Invalidasi session untuk guard 'admin' saja
    $request->session()->invalidate();

    // Regenerate CSRF token untuk keamanan
    $request->session()->regenerateToken();

    // Redirect setelah logout
    return redirect('/');
}

}
