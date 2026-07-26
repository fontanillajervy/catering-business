<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Client;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function store(StoreReservationRequest $request)
    {
        $client = Client::firstOrCreate(
            ['email' => $request->input('email')],
            [
                'name' => $request->input('full_name'),
                'phone' => $request->input('contact_number'),
                'address' => $request->input('address'),
            ]
        );

        Reservation::create([
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
            'estimated_budget' => $request->input('estimated_budget'),
            'additional_services' => $request->input('additional_services'),
            'special_requests' => $request->input('special_requests'),
            'additional_notes' => $request->input('additional_notes'),
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Your reservation request has been received.');
    }
}
