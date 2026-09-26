<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Mail\ReservationConfirmationMail;
use App\Mail\NewReservationNotificationMail;
use App\Models\Client;
use App\Models\Package;
use App\Models\Reservation;
use App\Services\RecaptchaVerifier;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function availability(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'date' => ['required', 'date', 'after_or_equal:' . now()->addDays(2)->toDateString(), function ($attribute, $value, $fail) {
                $minDate = now()->addDays(2)->toDateString();
                if ($value < $minDate) {
                    $fail('Reservations must be scheduled at least 2 days in advance.');
                }
            }],
        ]);
        $bookings = Reservation::whereDate('event_date', $data['date'])
            ->where('status', '!=', 'cancelled')
            ->count();

        return response()->json(['bookings' => $bookings, 'remaining' => max(0, 3 - $bookings), 'available' => $bookings < 3]);
    }

    public function store(StoreReservationRequest $request, RecaptchaVerifier $recaptchaVerifier)
    {
        if (now()->timestamp - (int) $request->input('form_started') < 3) {
            return back()->withInput()->withErrors(['full_name' => 'Unable to submit this request. Please try again.']);
        }

        if (! $recaptchaVerifier->verify($request->input('g-recaptcha-response'), $request->ip() ?? '')) {
            return back()->withInput()->withErrors(['g-recaptcha-response' => 'Please verify that you are not a robot.']);
        }

        $bookings = Reservation::whereDate('event_date', $request->input('event_date'))
            ->where('status', '!=', 'cancelled')
            ->count();

        if ($bookings >= 3) {
            return back()->withInput()->withErrors(['event_date' => 'This date is fully booked. Please select another date.']);
        }

        $package = Package::findOrFail($request->integer('package_id'));
        $guestCount = $request->integer('guest_count');
        if ($guestCount < $package->min_guests || $guestCount > $package->max_guests) {
            return back()->withInput()->withErrors([
                'guest_count' => "This package is available for {$package->min_guests} to {$package->max_guests} guests.",
            ]);
        }

        $client = Client::firstOrCreate(
            ['email' => $request->input('email')],
            [
                'name' => $request->input('full_name'),
                'phone' => $request->input('contact_number'),
                'address' => $request->input('address'),
            ]
        );

        $reservationCode = $this->generateReservationCode();

        $reservation = Reservation::create([
            'client_id' => $client->id,
            'package_id' => $request->input('package_id'),
            'full_name' => $request->input('full_name'),
            'contact_number' => $request->input('contact_number'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'event_type' => $request->input('event_type'),
            'event_date' => $request->input('event_date'),
            'event_time' => $request->input('event_time'),
            'venue' => $request->input('venue'),
            'guest_count' => $request->input('guest_count'),
            'estimated_budget' => round((float) $package->price * $guestCount, 2),
            'additional_services' => $request->input('additional_services'),
            'special_requests' => $request->input('special_requests'),
            'additional_notes' => $request->input('additional_notes'),
            'status' => 'pending',
            'reservation_code' => $reservationCode,
        ]);

        $request->session()->flash('reservation_code', $reservationCode);
        $request->session()->flash('reservation_status', 'pending');

        $customerEmailFailed = false;
        try {
            Mail::to($request->input('email'))->send(new ReservationConfirmationMail(
                $reservationCode,
                $request->input('full_name'),
                $request->input('event_type'),
                $request->input('event_date'),
                round((float) $package->price * $guestCount, 2),
            ));
        } catch (\Throwable $exception) {
            report($exception);
            $customerEmailFailed = true;
        }

        $businessEmailFailed = false;
        $notificationAddress = config('mail.booking_notification_address');
        if (filled($notificationAddress)) {
            try {
                Mail::to($notificationAddress)->send(new NewReservationNotificationMail($reservation));
            } catch (\Throwable $exception) {
                report($exception);
                $businessEmailFailed = true;
            }
        } else {
            $businessEmailFailed = true;
        }

        $message = $customerEmailFailed
            ? 'Your reservation was received, but we could not email your reservation ID. Please save this ID: ' . $reservationCode . '.'
            : 'Your reservation request has been received. Your reservation ID is ' . $reservationCode . '. Please keep this code to check your reservation status.';

        if ($businessEmailFailed) {
            $message .= ' The business notification email could not be sent; please contact the business to confirm your request.';
        }

        return redirect()->back()->with('success', $message);
    }

    private function generateReservationCode(): string
    {
        do {
            $code = 'RES-' . strtoupper(Str::random(8));
        } while (Reservation::where('reservation_code', $code)->exists());

        return $code;
    }
}
