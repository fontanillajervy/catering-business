<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $expectedEmail = env('ADMIN_EMAIL', 'admin@3yos.com');
        $expectedPassword = env('ADMIN_PASSWORD', 'admin123');

        if ($email === $expectedEmail && $password === $expectedPassword) {
            $request->session()->put('is_admin', true);

            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid admin credentials.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('is_admin');

        return redirect()->route('admin.login');
    }
}
