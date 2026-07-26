<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate(['email' => ['required', 'email'], 'password' => ['required', 'string']]);
        $email = $request->input('email');
        $password = $request->input('password');
        $expectedEmail = env('ADMIN_EMAIL', 'admin@3yos.com');
        $expectedPassword = env('ADMIN_PASSWORD', 'admin123');

        $user = User::where('email', $email)->first();
        $isPrimaryAdmin = $email === $expectedEmail && $password === $expectedPassword;
        $isTeamAdmin = $user && Hash::check($password, $user->password);

        if ($isPrimaryAdmin || $isTeamAdmin) {
            $request->session()->regenerate();
            $request->session()->put('is_admin', true);
            $request->session()->put('admin_role', $isPrimaryAdmin ? 'full' : 'limited');

            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid admin credentials.');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
