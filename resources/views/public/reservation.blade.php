@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-card p-4 p-lg-5">
                <div class="mb-4">
                    <span class="hero-badge">Reservation request</span>
                    <h1 class="fw-bold mt-3 mb-2">Plan your perfect event</h1>
                    <p class="text-muted mb-0">Share your details and we’ll help you create a tailored catering experience for your celebration.</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('reservation.store') }}">
                    @csrf
                    <input type="text" name="website" class="d-none" tabindex="-1" autocomplete="off">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Full Name</label><input type="text" name="full_name" class="form-control form-control-lg" required></div>
                        <div class="col-md-6"><label class="form-label">Contact Number</label><input type="text" name="contact_number" class="form-control form-control-lg" required></div>
                        <div class="col-md-6"><label class="form-label">Email Address</label><input type="email" name="email" class="form-control form-control-lg" required></div>
                        <div class="col-md-6"><label class="form-label">Complete Address</label><input type="text" name="address" class="form-control form-control-lg" required></div>
                        <div class="col-md-6"><label class="form-label">Event Type</label><input type="text" name="event_type" class="form-control form-control-lg" required></div>
                        <div class="col-md-6"><label class="form-label">Event Date</label><input type="date" name="event_date" class="form-control form-control-lg" required></div>
                        <div class="col-md-6"><label class="form-label">Event Time</label><input type="text" name="event_time" class="form-control form-control-lg" required></div>
                        <div class="col-md-6"><label class="form-label">Venue</label><input type="text" name="venue" class="form-control form-control-lg" required></div>
                        <div class="col-md-6"><label class="form-label">Expected Guests</label><input type="number" name="guest_count" class="form-control form-control-lg" required></div>
                        <div class="col-md-6"><label class="form-label">Estimated Budget</label><input type="number" step="0.01" name="estimated_budget" class="form-control form-control-lg" required></div>
                        <div class="col-12"><label class="form-label">Additional Services</label><textarea name="additional_services" class="form-control" rows="3"></textarea></div>
                        <div class="col-12"><label class="form-label">Special Requests</label><textarea name="special_requests" class="form-control" rows="3"></textarea></div>
                        <div class="col-12"><label class="form-label">Additional Notes</label><textarea name="additional_notes" class="form-control" rows="3"></textarea></div>
                        <div class="col-12">
                            <label class="form-label">Security Verification</label>
                            <input type="hidden" name="captcha_token" value="demo-captcha">
                            <div class="alert alert-info mb-0">Captcha check passed (demo mode).</div>
                        </div>
                        <div class="col-12"><button type="submit" class="btn btn-primary px-4 py-2">Submit Reservation</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
