<h1>Reservation status updated</h1>
<p>Hello {{ $fullName }},</p>
<p>The status of reservation <strong>{{ $reservationCode }}</strong> is now {{ str_replace('_', ' ', $status) }}.</p>
<p><a href="{{ route('reservation.status', ['code' => $reservationCode]) }}">Check your reservation status</a></p>