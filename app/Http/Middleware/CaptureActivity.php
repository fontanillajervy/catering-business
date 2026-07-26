<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CaptureActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->is('admin/*') || $request->is('admin')) {
            ActivityLog::create([
                'user_id' => 1,
                'action' => $request->route()?->getName() ?? 'admin-request',
                'activity_date' => now()->toDateString(),
                'activity_time' => now()->toTimeString(),
                'description' => 'Admin activity captured for ' . $request->path(),
            ]);
        }

        return $response;
    }
}
