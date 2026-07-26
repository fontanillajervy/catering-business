<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Package;
use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $reservationCount = Reservation::count();
        $inquiryCount = Inquiry::count();
        $serviceCount = Service::count();
        $packageCount = Package::count();

        return view('admin.dashboard', compact('reservationCount', 'inquiryCount', 'serviceCount', 'packageCount'));
    }

    public function reservations()
    {
        $reservations = Reservation::with('client', 'package')->latest()->get();

        return view('admin.reservations', compact('reservations'));
    }

    public function inquiries()
    {
        $inquiries = Inquiry::latest()->get();

        return view('admin.inquiries', compact('inquiries'));
    }

    public function analytics()
    {
        $monthlyReservations = Reservation::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        $monthlyRevenue = Reservation::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(estimated_budget) as revenue'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        $topPackages = Reservation::join('packages', 'packages.id', '=', 'reservations.package_id')
            ->select('packages.name', DB::raw('COUNT(*) as total'))
            ->groupBy('packages.name')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('admin.analytics', compact('monthlyReservations', 'monthlyRevenue', 'topPackages'));
    }
}
