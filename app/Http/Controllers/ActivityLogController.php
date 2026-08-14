<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $logs = ActivityLog::query()
            ->when($request->filled('actor'), fn ($query) => $query->where('actor_email', $request->string('actor')))
            ->when($request->filled('action'), fn ($query) => $query->where('action', 'like', '%' . $request->string('action') . '%'))
            ->latest()->paginate(30)->withQueryString();
        $actors = ActivityLog::whereNotNull('actor_email')->select('actor_email', 'actor_name')->distinct()->orderBy('actor_name')->get();

        return view('admin.activity-logs', compact('logs', 'actors'));
    }
}
