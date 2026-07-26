<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index(ReportService $reportService)
    {
        $daily = $reportService->getSummary('daily');
        $weekly = $reportService->getSummary('weekly');
        $monthly = $reportService->getSummary('monthly');
        $yearly = $reportService->getSummary('yearly');

        return view('admin.reports', compact('daily', 'weekly', 'monthly', 'yearly'));
    }

    public function export(string $type)
    {
        $content = match ($type) {
            'csv' => $this->buildCsv(),
            default => 'Unsupported export type.'
        };

        $filename = 'reports-' . now()->format('YmdHis') . '.csv';
        $path = storage_path('app/' . $filename);
        file_put_contents($path, $content);

        return response()->download($path, $filename)->deleteFileAfterSend(true);
    }

    protected function buildCsv(): string
    {
        $rows = [
            ['Type', 'Value'],
            ['Reservations', \App\Models\Reservation::count()],
            ['Inquiries', \App\Models\Inquiry::count()],
        ];

        return implode(PHP_EOL, array_map(fn ($row) => implode(',', $row), $rows));
    }
}
