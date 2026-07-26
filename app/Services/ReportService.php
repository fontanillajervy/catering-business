<?php

namespace App\Services;

use App\Models\Inquiry;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getSummary(string $period): array
    {
        $start = match ($period) {
            'daily' => now()->subDay()->startOfDay(),
            'weekly' => now()->subWeek()->startOfDay(),
            'monthly' => now()->subMonth()->startOfDay(),
            'yearly' => now()->subYear()->startOfDay(),
            default => now()->startOfDay(),
        };

        $reservations = Reservation::where('created_at', '>=', $start)->count();
        $inquiries = Inquiry::where('created_at', '>=', $start)->count();
        $revenue = Reservation::where('created_at', '>=', $start)->sum('estimated_budget');

        return [
            'period' => $period,
            'reservations' => $reservations,
            'inquiries' => $inquiries,
            'revenue' => (float) $revenue,
        ];
    }
}
