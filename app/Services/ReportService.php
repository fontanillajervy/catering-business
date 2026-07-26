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

        $reservations = Reservation::where('created_at', '>=', $start);

        return [
            'period' => $period,
            'reservation_count' => $reservations->count(),
            'confirmed_reservations' => (clone $reservations)->where('status', 'confirmed')->count(),
            'completed_events' => (clone $reservations)->where('status', 'completed')->count(),
            'cancelled_reservations' => (clone $reservations)->where('status', 'cancelled')->count(),
            'inquiry_count' => Inquiry::where('created_at', '>=', $start)->count(),
            'estimated_revenue' => (float) (clone $reservations)->whereIn('status', ['confirmed', 'completed'])->sum('estimated_budget'),
        ];
    }
}
