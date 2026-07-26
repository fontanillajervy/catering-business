<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->get('is_admin', false)) {
            return redirect()->route('admin.login')->with('error', 'You need admin access to continue.');
        }

        return $next($request);
    }
}
