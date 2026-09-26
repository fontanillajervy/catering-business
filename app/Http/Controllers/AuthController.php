<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\ActivityLog;
use Illuminate\Support\Str;

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
        $isFullAdminUser = $user && $user->role === 'full' && Hash::check($password, $user->password);
        $isTeamAdmin = $user && $user->role === 'limited' && Hash::check($password, $user->password);

        if ($isPrimaryAdmin || $isFullAdminUser || $isTeamAdmin) {
            $request->session()->regenerate();
            $request->session()->put('is_admin', true);
            $request->session()->put('admin_role', $isPrimaryAdmin || $isFullAdminUser ? 'full' : 'limited');
            $request->session()->put('admin_user_id', $user?->id);
            $request->session()->put('admin_name', $isPrimaryAdmin ? 'Primary Administrator' : $user->name);
            $request->session()->put('admin_email', $email);
            $this->logAuthentication($request, 'Signed in');

            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid admin credentials.');
    }

    public function showForgotPasswordForm()
    {
        return view('admin.forgot-password');
    }

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status !== Password::RESET_LINK_SENT) {
            return back()->with('error', 'We could not send the reset link. Please try again shortly.');
        }

        if (config('mail.default') === 'log' || config('mail.default') === 'array') {
            return back()->with('status', 'Development mode: password reset email was written to the Laravel log.');
        }

        return back()->with('status', 'If that Team Admin email exists, a password reset link has been sent.');
    }

    public function showResetPasswordForm(Request $request, string $token)
    {
        return view('admin.reset-password', ['token' => $token, 'email' => $request->query('email')]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function (User $user, string $password) {
            $user->forceFill(['password' => Hash::make($password), 'remember_token' => Str::random(60)])->save();
            event(new PasswordReset($user));
        });

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('admin.login')->with('success', 'Password reset successfully. You can now sign in.')
            : back()->withInput($request->only('email'))->with('error', 'This reset link is invalid or has expired.');
    }

    public function logout(Request $request)
    {
        if ($request->session()->get('is_admin')) {
            $this->logAuthentication($request, 'Signed out');
        }
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    private function logAuthentication(Request $request, string $action): void
    {
        ActivityLog::create([
            'user_id' => $request->session()->get('admin_user_id'),
            'actor_name' => $request->session()->get('admin_name', 'Unknown administrator'),
            'actor_email' => $request->session()->get('admin_email'),
            'actor_role' => $request->session()->get('admin_role', 'limited'),
            'action' => $action,
            'method' => 'SESSION',
            'ip_address' => $request->ip(),
            'activity_date' => now()->toDateString(),
            'activity_time' => now()->toTimeString(),
            'description' => $action . ' to the admin panel.',
        ]);
    }
}
