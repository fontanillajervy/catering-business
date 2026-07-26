@extends('layouts.admin')

@section('content')
<div class="content-card p-4">
    <h1 class="fw-bold mb-4">Reservations</h1>
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr><th>Client</th><th>Event</th><th>Date</th><th>Status</th></tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->full_name }}</td>
                        <td>{{ $reservation->event_type }}</td>
                        <td>{{ $reservation->event_date }}</td>
                        <td>{{ $reservation->status }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4">No reservations found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
