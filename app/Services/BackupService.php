<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class BackupService
{
    private const TABLES = [
        'users',
        'services',
        'packages',
        'clients',
        'reservations',
        'inquiries',
        'activity_logs',
        'settings',
        'notification_templates',
        'gallery_items',
    ];

    public function create(): string
    {
        $filename = 'backup-' . now()->format('YmdHis') . '.json';
        $path = storage_path('app/backups/' . $filename);
        if (! is_dir(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $contents = ['created_at' => now()->toIso8601String(), 'tables' => []];

        foreach (self::TABLES as $table) {
            $contents['tables'][$table] = DB::table($table)->get()->map(fn ($row) => (array) $row)->all();
        }

        file_put_contents($path, json_encode($contents, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));

        return $path;
    }

    public function restore(string $backup): int
    {
        $path = $this->pathFor($backup);
        $contents = json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
        $tables = $contents['tables'] ?? null;

        if (! is_array($tables)) {
            throw new \RuntimeException('The selected backup has an invalid format.');
        }

        $restoreTables = array_values(array_intersect(self::TABLES, array_keys($tables)));
        $restoredRows = 0;
        $driver = DB::getDriverName();

        $this->disableForeignKeys($driver);

        try {
            DB::transaction(function () use ($restoreTables, $tables, &$restoredRows): void {
                foreach (array_reverse($restoreTables) as $table) {
                    DB::table($table)->truncate();
                }

                foreach ($restoreTables as $table) {
                    $rows = $tables[$table];
                    if (! is_array($rows)) {
                        throw new \RuntimeException("Invalid data for {$table}.");
                    }

                    foreach (array_chunk($rows, 500) as $chunk) {
                        if ($chunk !== []) {
                            DB::table($table)->insert($chunk);
                            $restoredRows += count($chunk);
                        }
                    }
                }
            });
        } finally {
            $this->enableForeignKeys($driver);
        }

        return $restoredRows;
    }

    public function pathFor(string $backup): string
    {
        if ($backup === basename($backup) && str_ends_with($backup, '.json')) {
            $path = storage_path('app/backups/' . $backup);
            if (is_file($path)) {
                return $path;
            }
        }

        throw new \InvalidArgumentException('Invalid backup file.');
    }

    public function delete(string $backup): void
    {
        unlink($this->pathFor($backup));
    }

    private function disableForeignKeys(string $driver): void
    {
        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');
        } elseif ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }
    }

    private function enableForeignKeys(string $driver): void
    {
        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON');
        } elseif ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
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
