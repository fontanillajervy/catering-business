<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class BackupService
{
    public function create(): string
    {
        $filename = 'backup-' . now()->format('YmdHis') . '-' . Str::lower(Str::random(6)) . '.json';
        $path = storage_path('app/backups/' . $filename);
        if (! is_dir(dirname($path))) {
            if (! mkdir(dirname($path), 0755, true) && ! is_dir(dirname($path))) {
                throw new \RuntimeException('The backup directory could not be created. Check storage permissions.');
            }
        }

        $contents = ['created_at' => now()->toIso8601String(), 'tables' => []];

        DB::transaction(function () use (&$contents): void {
            foreach ($this->tables() as $table) {
                if (Schema::hasTable($table)) {
                    $contents['tables'][$table] = DB::table($table)->get()->map(fn ($row) => (array) $row)->all();
                }
            }
        });

        $temporaryPath = $path . '.tmp';
        $written = file_put_contents($temporaryPath, json_encode($contents, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR), LOCK_EX);
        if ($written === false || ! rename($temporaryPath, $path)) {
            @unlink($temporaryPath);
            throw new \RuntimeException('The database backup could not be written. Check storage permissions.');
        }

        return $path;
    }

    public function restore(string $backup): int
    {
        $path = $this->pathFor($backup);
        $contents = json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
        $tables = $contents['tables'] ?? null;

        if (! is_array($tables) || $tables === []) {
            throw new \RuntimeException('The selected backup has an invalid format.');
        }

        $restoreTables = array_values(array_filter(
            array_intersect($this->tables(), array_keys($tables)),
            fn (string $table) => Schema::hasTable($table),
        ));
        if ($restoreTables === []) {
            throw new \RuntimeException('The backup contains no tables available in this database.');
        }

        foreach ($restoreTables as $table) {
            if (! is_array($tables[$table])) {
                throw new \RuntimeException("Invalid data for {$table}.");
            }
            foreach ($tables[$table] as $row) {
                if (! is_array($row)) {
                    throw new \RuntimeException("Invalid row data for {$table}.");
                }
            }
        }

        $restoredRows = 0;
        $driver = DB::getDriverName();

        $this->disableForeignKeys($driver);

        try {
            DB::transaction(function () use ($restoreTables, $tables, &$restoredRows): void {
                foreach (array_reverse($restoreTables) as $table) {
                    DB::table($table)->delete();
                }

                foreach ($restoreTables as $table) {
                    $rows = $tables[$table];
                    $columns = Schema::getColumnListing($table);

                    foreach (array_chunk($rows, 100) as $chunk) {
                        if ($chunk !== []) {
                            $normalizedChunk = array_map(
                                fn (array $row) => array_intersect_key($row, array_flip($columns)),
                                $chunk,
                            );
                            DB::table($table)->insert($normalizedChunk);
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
        if (! unlink($this->pathFor($backup))) {
            throw new \RuntimeException('The selected backup could not be deleted.');
        }
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

        $backups = array_values(array_filter(scandir($dir), fn ($file) => str_ends_with($file, '.json')));
        rsort($backups);

        return $backups;
    }

    private function tables(): array
    {
        return array_values(array_filter(
            Schema::getTableListing(),
            fn (string $table) => $table !== 'migrations',
        ));
    }
}
