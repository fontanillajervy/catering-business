<?php

namespace App\Http\Controllers;

use App\Services\BackupService;
use Illuminate\Http\Request;

class BackupController extends Controller
{
    public function index(BackupService $backupService)
    {
        $backups = $backupService->listBackups();

        return view('admin.backups', compact('backups'));
    }

    public function createBackup(BackupService $backupService)
    {
        $path = $backupService->create();

        return back()->with('success', 'Database backup created successfully.');
    }

    public function restoreBackup(Request $request, BackupService $backupService)
    {
        $data = $request->validate(['backup' => ['required', 'string']]);
        $restoredRows = $backupService->restore($data['backup']);

        return back()->with('success', "Backup restored successfully ({$restoredRows} rows).");
    }

    public function downloadBackup(Request $request, BackupService $backupService)
    {
        $data = $request->validate(['backup' => ['required', 'string']]);

        return response()->download($backupService->pathFor($data['backup']));
    }

    public function deleteBackup(Request $request, BackupService $backupService)
    {
        $data = $request->validate(['backup' => ['required', 'string']]);
        $backupService->delete($data['backup']);

        return back()->with('success', 'Backup deleted successfully.');
    }
}
