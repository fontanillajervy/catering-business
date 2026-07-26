@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-card p-4 p-lg-5">
                <div class="mb-4">
                    <span class="hero-badge">Inquiry form</span>
                    <h1 class="fw-bold mt-3 mb-2">Let’s talk about your event</h1>
                    <p class="text-muted mb-0">Tell us what you need and we’ll get back with the best options for your celebration.</p>
                </div>
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('inquiry.store') }}">
                    @csrf
                    <input type="text" name="website" class="d-none" tabindex="-1" autocomplete="off">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Full Name</label><input type="text" name="full_name" class="form-control form-control-lg" required></div>
                        <div class="col-md-6"><label class="form-label">Contact Number</label><input type="text" name="contact_number" class="form-control form-control-lg" required></div>
                        <div class="col-md-6"><label class="form-label">Email Address</label><input type="email" name="email" class="form-control form-control-lg" required></div>
                        <div class="col-md-6"><label class="form-label">Subject</label><input type="text" name="subject" class="form-control form-control-lg" required></div>
                        <div class="col-md-6"><label class="form-label">Category</label><select name="category" class="form-select form-select-lg" required><option value="">Select</option><option>General Inquiry</option><option>Reservation</option><option>Packages</option><option>Pricing</option><option>Custom Event</option><option>Others</option></select></div>
                        <div class="col-12"><label class="form-label">Message</label><textarea name="message" class="form-control" rows="5" required></textarea></div>
                        <div class="col-12">
                            <label class="form-label">Security Verification</label>
                            <input type="hidden" name="captcha_token" value="demo-captcha">
                            <div class="alert alert-info mb-0">Captcha check passed (demo mode).</div>
                        </div>
                        <div class="col-12"><button type="submit" class="btn btn-primary px-4 py-2">Submit Inquiry</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
