<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class BackupService
{
    public function create(): string
    {
        $filename = 'backup-' . now()->format('YmdHis') . '.sql';
        $path = storage_path('app/backups/' . $filename);
        if (! is_dir(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        file_put_contents($path, 'Backup placeholder generated at ' . now()->toDateTimeString());

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

        return array_values(array_filter(scandir($dir), fn ($file) => $file !== '.' && $file !== '..'));
    }
}
