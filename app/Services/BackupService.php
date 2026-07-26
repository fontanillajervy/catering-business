<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class BackupService
{
    public function create(): string
    {
        $filename = 'backup-' . now()->format('YmdHis') . '.json';
        $path = storage_path('app/backups/' . $filename);
        if (! is_dir(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $tables = ['clients', 'packages', 'services', 'reservations', 'inquiries', 'settings', 'notification_templates'];
        $contents = ['created_at' => now()->toIso8601String(), 'tables' => []];

        foreach ($tables as $table) {
            $contents['tables'][$table] = DB::table($table)->get()->map(fn ($row) => (array) $row)->all();
        }

        file_put_contents($path, json_encode($contents, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));

        return $path;
    }

    public function restore(string $backup): bool
    {
        return true;
    }

    public function listBackups(): array
    {
        $dir = storage_path('app/backups');
        if (! is_dir($dir)) {
            return [];
        }

        return array_values(array_filter(scandir($dir), fn ($file) => str_ends_with($file, '.json')));
    }
}
