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

                <form method="POST" action="{{ route('inquiry.store') }}" onsubmit="return confirm('Send this inquiry to 3YOS Catering?')">
                    @csrf
                    <input type="text" name="website" class="d-none" tabindex="-1" autocomplete="off">
                    <input type="hidden" name="form_started" value="{{ now()->timestamp }}">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label" for="full_name">Full name</label><input id="full_name" type="text" name="full_name" value="{{ old('full_name') }}" class="form-control form-control-lg" autocomplete="name" required><div class="form-text">Enter the name we should use when replying.</div></div>
                        <div class="col-md-6"><label class="form-label" for="contact_number">Contact number</label><input id="contact_number" type="tel" name="contact_number" value="{{ old('contact_number') }}" class="form-control form-control-lg" inputmode="tel" pattern="\+63[0-9]{10}" maxlength="13" placeholder="+639123456789" title="Use +63 followed by exactly 10 digits." required><div class="form-text">Use +63 followed by exactly 10 digits, for example +639123456789.</div></div>
                        <div class="col-md-6"><label class="form-label" for="email">Email address</label><input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg" autocomplete="email" required><div class="form-text">We’ll send our reply to this address.</div></div>
                        <div class="col-md-6"><label class="form-label" for="subject">Subject</label><input id="subject" type="text" name="subject" value="{{ old('subject') }}" class="form-control form-control-lg" required><div class="form-text">Summarize what you’d like to ask about.</div></div>
                        <div class="col-md-6"><label class="form-label" for="category">Category</label><select id="category" name="category" class="form-select form-select-lg" required><option value="">Select a category</option>@foreach(['General Inquiry','Reservation','Packages','Pricing','Custom Event','Others'] as $category)<option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>@endforeach</select><div class="form-text">Choose the topic closest to your question.</div></div>
                        <div class="col-12"><label class="form-label" for="message">Message</label><textarea id="message" name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea><div class="form-text">Include event date, guest count, or other details that help us answer.</div></div>
                        <div class="col-12">
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                            @error('g-recaptcha-response')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12"><button type="submit" class="btn btn-primary px-4 py-2">Submit Inquiry</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
