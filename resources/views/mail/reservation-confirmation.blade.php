<h1>Reservation request received</h1>
<p>Hello {{ $fullName }},</p>
<p>We received your {{ $eventType }} reservation request for {{ \Carbon\Carbon::parse($eventDate)->format('F j, Y') }}.</p>
<p>Your reservation ID is <strong>{{ $reservationCode }}</strong>. Keep this ID to check your reservation status.</p>
<p>Estimated package total: PHP {{ number_format($estimatedBudget, 2) }}</p>
<p>Check status: <a href="{{ route('reservation.status', ['code' => $reservationCode]) }}">{{ route('reservation.status', ['code' => $reservationCode]) }}</a></p>