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
    public function index(?Request $request = null)
    {
        $request ??= request();
        $reservationCount = Reservation::count();
        $inquiryCount = Inquiry::count();
        $serviceCount = Service::count();
        $packageCount = Package::count();

        return view('admin.dashboard', compact('reservationCount', 'inquiryCount', 'serviceCount', 'packageCount'));
    }

    public function reservations(Request $request)
    {
        $status = $request->input('status');
        $paymentStatus = $request->input('payment_status');
        $search = $request->input('search');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $query = Reservation::with('client', 'package')->latest();

        if ($status && in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'], true)) {
            $query->where('status', $status);
        }

        if ($paymentStatus && in_array($paymentStatus, ['Unpaid', 'Downpayment', 'Fully Paid'], true)) {
            $query->where('payment_status', $paymentStatus);
        }

        if ($search !== null && trim($search) !== '') {
            $term = trim($search);
            $query->where(function ($subQuery) use ($term) {
                $subQuery->where('full_name', 'like', '%' . $term . '%')
                    ->orWhere('email', 'like', '%' . $term . '%')
                    ->orWhere('contact_number', 'like', '%' . $term . '%')
                    ->orWhere('reservation_code', 'like', '%' . $term . '%');
            });
        }

        if ($dateFrom) {
            $query->whereDate('event_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('event_date', '<=', $dateTo);
        }

        $reservations = $query->get();
        $customerCount = Reservation::query()->distinct('email')->count('email');
        $pendingCount = Reservation::query()->where('status', 'pending')->count();
        $acceptedCount = Reservation::query()->where('status', 'confirmed')->count();
        $cancelledCount = Reservation::query()->where('status', 'cancelled')->count();

        return view('admin.reservations', compact(
            'reservations',
            'customerCount',
            'pendingCount',
            'acceptedCount',
            'cancelledCount',
            'status',
            'paymentStatus',
            'search',
            'dateFrom',
            'dateTo',
        ))->with([
            'filterStatus' => $status,
            'filterPaymentStatus' => $paymentStatus,
            'search' => $search,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }

    public function exportReservationsCsv(Request $request)
    {
        $query = Reservation::query()->latest();

        $status = $request->input('status');
        $paymentStatus = $request->input('payment_status');
        $search = trim((string) $request->input('search', ''));
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        if ($status && in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'], true)) {
            $query->where('status', $status);
        }

        if ($paymentStatus && in_array($paymentStatus, ['Unpaid', 'Downpayment', 'Fully Paid'], true)) {
            $query->where('payment_status', $paymentStatus);
        }

        if ($search !== '') {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('full_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('contact_number', 'like', '%' . $search . '%')
                    ->orWhere('reservation_code', 'like', '%' . $search . '%');
            });
        }

        if ($dateFrom) {
            $query->whereDate('event_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('event_date', '<=', $dateTo);
        }

        $reservations = $query->get();

        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, ['Reservation Code', 'Customer Name', 'Email', 'Contact Number', 'Event Type', 'Event Date', 'Venue', 'Status', 'Payment Status', 'Amount Paid', 'Balance']);

        foreach ($reservations as $reservation) {
            fputcsv($handle, [
                $reservation->reservation_code ?? '',
                $reservation->full_name ?? '',
                $reservation->email ?? '',
                $reservation->contact_number ?? '',
                $reservation->event_type ?? '',
                $reservation->event_date ? \Carbon\Carbon::parse($reservation->event_date)->format('Y-m-d') : '',
                $reservation->venue ?? '',
                $reservation->status ?? '',
                $reservation->payment_status ?? '',
                (string) ($reservation->amount_paid ?? 0),
                (string) ($reservation->balance ?? 0),
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        $filename = 'reservations-' . now()->format('YmdHis') . '.csv';

        return response($csv ?: '', 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
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
        $previousStatus = $reservation->status;
        $data = $request->validate([
            'status' => ['sometimes', 'required', 'in:pending,confirmed,completed,cancelled'],
            'payment_status' => ['sometimes', 'nullable', 'in:Unpaid,Downpayment,Fully Paid'],
            'payment_type' => ['sometimes', 'nullable', 'in:Unpaid,Downpayment,Full Payment'],
            'amount_paid' => ['sometimes', 'nullable', 'numeric', 'min:0', 'max:' . (float) ($reservation->estimated_budget ?? 0)],
            'mark_fully_paid' => ['sometimes', 'nullable', 'boolean'],
        ]);

        $totalAmount = (float) ($reservation->estimated_budget ?? 0);
        $amountPaid = (float) ($data['amount_paid'] ?? $reservation->amount_paid ?? 0);

        if ($request->boolean('mark_fully_paid')) {
            $data['payment_status'] = 'Fully Paid';
            $data['payment_type'] = 'Full Payment';
            $data['amount_paid'] = $totalAmount;
            $data['balance'] = 0.0;
        } elseif (array_key_exists('amount_paid', $data) || array_key_exists('payment_type', $data) || array_key_exists('payment_status', $data) || $request->has('amount_paid') || $request->has('payment_type')) {
            if ($amountPaid <= 0) {
                $data['payment_status'] = 'Unpaid';
                $data['payment_type'] = $data['payment_type'] ?? 'Unpaid';
            } elseif ($amountPaid >= $totalAmount) {
                $data['payment_status'] = 'Fully Paid';
                $data['payment_type'] = $data['payment_type'] ?? 'Full Payment';
            } else {
                $data['payment_status'] = 'Downpayment';
                $data['payment_type'] = $data['payment_type'] ?? 'Downpayment';
            }

            $data['amount_paid'] = $amountPaid;
            $data['balance'] = round(max(0, $totalAmount - $amountPaid), 2);
        }

        if (! isset($data['balance']) && $reservation->amount_paid !== null) {
            $data['balance'] = round(max(0, $totalAmount - ($reservation->amount_paid ?? 0)), 2);
        }

        $reservation->update($data);

        $notificationFailed = false;
        if (isset($data['status']) && $data['status'] !== $previousStatus) {
            try {
                Mail::to($reservation->email)->send(new \App\Mail\ReservationStatusMail(
                    $reservation->reservation_code,
                    $reservation->full_name,
                    $reservation->status,
                ));
            } catch (\Throwable $exception) {
                report($exception);
                $notificationFailed = true;
            }
        }

        $message = $request->input('status') === 'cancelled'
            ? 'Reservation cancelled.'
            : (($request->has('amount_paid') || $request->boolean('mark_fully_paid'))
                ? 'Payment details updated.'
                : 'Reservation status updated.');

        if ($notificationFailed) {
            $message .= ' Email notification could not be sent; check Gmail SMTP settings.';
        }

        return back()->with('success', $message);
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
