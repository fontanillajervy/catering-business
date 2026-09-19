@extends('layouts.app')

@section('title', 'Check Reservation Status | 3YOS Catering')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="form-card p-4 p-lg-5">
                <div class="mb-4">
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                        <div>
                            <span class="eyebrow">Reservation status</span>
                            <h1 class="fw-bold mt-2 mb-2">Check your booking</h1>
                            <p class="text-muted mb-0">Enter the unique reservation ID you received after submitting your request.</p>
                        </div>

                        @if($reservation)
                            <div class="alert alert-success mb-0 px-3 py-2 text-start">
                                <div class="small text-uppercase fw-bold opacity-75">Current status</div>
                                <div class="fw-semibold text-capitalize">{{ str_replace('_', ' ', $reservation->status) }}</div>
                                <div class="small mt-1"><strong>ID:</strong> {{ $reservation->reservation_code }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <form method="GET" action="{{ route('reservation.status') }}" class="mb-4">
                    <div class="input-group input-group-lg">
                        <input type="text" name="code" value="{{ old('code', $code ?? '') }}" class="form-control" placeholder="e.g. RES-ABCD1234" required>
                        <button type="submit" class="btn btn-primary">Check status</button>
                    </div>
                </form>

                @if($reservation)
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="small text-muted">Client</div>
                            <div class="fw-semibold">{{ $reservation->full_name }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="small text-muted">Reservation ID</div>
                            <div class="fw-semibold">{{ $reservation->reservation_code }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="small text-muted">Event date</div>
                            <div class="fw-semibold">{{ \Carbon\Carbon::parse($reservation->event_date)->format('M j, Y') }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="small text-muted">Event type</div>
                            <div class="fw-semibold">{{ $reservation->event_type }}</div>
                        </div>
                    </div>
                @elseif($code !== '')
                    <div class="alert alert-warning mb-0">
                        We could not find a reservation with that ID. Please check the code and try again.
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('reservation') }}" class="btn btn-outline-primary">Back to reservation form</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
