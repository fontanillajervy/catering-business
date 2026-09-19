<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Response;

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

    public function export(ReportService $reportService = null, string $period = 'daily')
    {
        $reportService ??= app(ReportService::class);
        $period = strtolower($period);

        if (! in_array($period, ['daily', 'weekly', 'monthly', 'yearly'], true)) {
            abort(404);
        }

        $summary = $reportService->getSummary($period);
        $filename = 'report-' . $period . '-' . now()->format('YmdHis') . '.csv';
        $csv = $this->buildCsv($summary, $period);

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    protected function buildCsv(array $summary, string $period): string
    {
        $rows = [
            ['Period', ucfirst($period)],
            ['Reservations', $summary['reservation_count']],
            ['Confirmed Reservations', $summary['confirmed_reservations']],
            ['Completed Events', $summary['completed_events']],
            ['Cancelled Reservations', $summary['cancelled_reservations']],
            ['Inquiries', $summary['inquiry_count']],
            ['Estimated Revenue', $summary['estimated_revenue']],
        ];

        $handle = fopen('php://temp', 'r+');

        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return $csv !== false ? $csv : '';
    }
}
