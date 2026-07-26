<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::latest()->take(50)->get();

        return view('admin.activity-logs', compact('logs'));
    }
}
