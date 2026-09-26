<h1>New event booking request</h1>
<p>Reservation ID: <strong>{{ $reservation->reservation_code }}</strong></p>
<p>Customer: {{ $reservation->full_name }}</p>
<p>Email: {{ $reservation->email }}</p>
<p>Phone: {{ $reservation->contact_number }}</p>
<p>Event: {{ $reservation->event_type }}</p>
<p>Date and time: {{ \Carbon\Carbon::parse($reservation->event_date)->format('F j, Y') }} at {{ $reservation->event_time }}</p>
<p>Venue: {{ $reservation->venue }}</p>
<p>Guests: {{ $reservation->guest_count }}</p>
<p>Estimated total: PHP {{ number_format((float) $reservation->estimated_budget, 2) }}</p>