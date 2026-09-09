<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Package;
use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

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
        $customerCount = Reservation::query()->distinct('email')->count('email');
        $pendingCount = $reservations->where('status', 'pending')->count();
        $acceptedCount = $reservations->where('status', 'confirmed')->count();
        $cancelledCount = $reservations->where('status', 'cancelled')->count();

        return view('admin.reservations', compact('reservations', 'customerCount', 'pendingCount', 'acceptedCount', 'cancelledCount'));
    }

    public function inquiries()
    {
        $inquiries = Inquiry::latest()->get();

        return view('admin.inquiries', compact('inquiries'));
    }

    public function showInquiry(Inquiry $inquiry)
    {
        if ($inquiry->status === 'new') {
            $inquiry->update(['status' => 'in_progress']);
        }

        return view('admin.inquiry-show', compact('inquiry'));
    }

    public function replyToInquiry(Request $request, Inquiry $inquiry)
    {
        $data = $request->validate(['reply' => ['required', 'string', 'max:5000']]);

        $mailSent = false;
        $mailError = null;

        try {
            Mail::raw($data['reply'], function ($message) use ($inquiry) {
                $message->to($inquiry->email, $inquiry->full_name)->subject('Re: ' . $inquiry->subject);
            });
            $mailSent = true;
        } catch (\Throwable $exception) {
            $mailError = $exception;
            report($exception);
        }

        $inquiry->update(['admin_reply' => $data['reply'], 'replied_at' => now(), 'status' => 'responded']);

        if ($mailSent) {
            return redirect()->route('admin.inquiries.show', $inquiry)->with('success', 'Reply sent to ' . $inquiry->email . '.');
        }

        return back()->with(
            'error',
            'Reply was saved locally, but email delivery failed. Check MAIL_* settings in .env. Details: ' . ($mailError?->getMessage() ?? 'Unknown mail error.')
        );
    }

    public function destroyInquiry(Inquiry $inquiry)
    {
        $inquiry->delete();
        return redirect()->route('admin.inquiries')->with('success', 'Inquiry deleted.');
    }

    public function analytics()
    {
        $months = collect(range(0, 11))->map(fn ($offset) => now()->startOfMonth()->subMonths(11 - $offset));
        $reservations = Reservation::select(['id', 'package_id', 'status', 'estimated_budget', 'created_at'])->get();
        $monthlyReservations = $months->map(fn ($month) => (object) [
            'label' => $month->format('M'),
            'total' => $reservations->filter(fn ($reservation) => $reservation->created_at->format('Y-m') === $month->format('Y-m'))->count(),
        ]);
        $monthlyRevenue = $months->map(fn ($month) => (object) [
            'label' => $month->format('M'),
            'revenue' => $reservations->filter(fn ($reservation) => $reservation->created_at->format('Y-m') === $month->format('Y-m') && in_array($reservation->status, ['confirmed', 'completed'], true))->sum('estimated_budget'),
        ]);

        $topPackages = Reservation::join('packages', 'packages.id', '=', 'reservations.package_id')
            ->select('packages.name', DB::raw('COUNT(*) as total'))
            ->groupBy('packages.name')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $activity = Inquiry::where('created_at', '>=', now()->subDays(6)->startOfDay())->get()
            ->groupBy(fn ($inquiry) => $inquiry->created_at->toDateString());
        $activityLabels = collect(range(0, 6))->map(fn ($offset) => now()->subDays(6 - $offset)->format('D'));
        $activityData = collect(range(0, 6))->map(fn ($offset) => $activity->get(now()->subDays(6 - $offset)->toDateString(), collect())->count());

        return view('admin.analytics', compact('monthlyReservations', 'monthlyRevenue', 'topPackages', 'activityLabels', 'activityData'));
    }

    public function updateReservationStatus(Request $request, Reservation $reservation)
    {
        $reservation->update($request->validate(['status' => ['required', 'in:pending,confirmed,completed,cancelled']]));
        return back()->with('success', 'Reservation status updated.');
    }

    public function uploadReservationContract(Request $request, Reservation $reservation)
    {
        $data = $request->validate([
            'service_contract' => ['required', 'array', 'min:1', 'max:10'],
            'service_contract.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $paths = $reservation->service_contracts ?? [];
        foreach ($data['service_contract'] as $file) {
            $paths[] = $file->store('service-contracts', 'public');
        }
        $reservation->update(['service_contracts' => $paths]);

        return back()->with('success', count($data['service_contract']) . ' contract image(s) uploaded.');
    }

    public function deleteReservationContract(Request $request, Reservation $reservation, int $contract)
    {
        $files = $reservation->contractFiles();
        abort_unless(isset($files[$contract]), 404);

        Storage::disk('public')->delete($files[$contract]);
        $files = array_values(array_diff($files, [$files[$contract]]));

        $reservation->update([
            'service_contract' => null,
            'service_contracts' => $files,
        ]);

        return back()->with('success', 'Contract image deleted.');
    }

    public function updateInquiryStatus(Request $request, Inquiry $inquiry)
    {
        $inquiry->update($request->validate(['status' => ['required', 'in:new,in_progress,responded,closed']]));
        return back()->with('success', 'Inquiry status updated.');
    }
}
