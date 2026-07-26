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

        return back()->with('success', 'Backup created: ' . $path);
    }

    public function restoreBackup(Request $request, BackupService $backupService)
    {
        $backup = $request->input('backup');
        $backupService->restore($backup);

        return back()->with('success', 'Backup restored: ' . $backup);
    }
}
