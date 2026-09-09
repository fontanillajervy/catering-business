@extends('layouts.app')

@section('title', 'Book an event | 3YOS Catering')

@section('content')
<div class="container py-5"><div class="row justify-content-center"><div class="col-lg-9"><div class="form-card">
    <div class="mb-4"><span class="eyebrow">Reservation request</span><h1 class="fw-bold mt-2 mb-2">Plan your perfect event.</h1><p class="text-muted mb-0">We accept up to three events each day so every celebration gets the attention it deserves.</p></div>
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <form method="POST" action="{{ route('reservation.store') }}" id="reservation-form">@csrf<input type="text" name="website" class="d-none" tabindex="-1" autocomplete="off"><input type="hidden" name="form_started" value="{{ now()->timestamp }}">
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Full name</label><input type="text" name="full_name" value="{{ old('full_name') }}" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Contact number</label><input type="text" name="contact_number" value="{{ old('contact_number') }}" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Email address</label><input type="email" name="email" value="{{ old('email') }}" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Complete address</label><input type="text" name="address" value="{{ old('address') }}" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Event type</label><select name="event_type" class="form-select" required><option value="">Select an event type</option>@foreach(['Wedding','Birthday','Debut','Anniversary','Corporate Event','Baptism','Graduation','Other'] as $type)<option value="{{ $type }}" @selected(old('event_type') === $type)>{{ $type }}</option>@endforeach</select></div>
            <div class="col-md-6"><label class="form-label">Catering package</label><select name="package_id" id="package_id" class="form-select" required><option value="">Select a package</option>@foreach($packages as $package)<option value="{{ $package->id }}" data-price="{{ $package->price }}" @selected(old('package_id') == $package->id)>{{ $package->name }} — from &#8369;{{ number_format($package->price, 0) }}/guest</option>@endforeach</select></div>
            <div class="col-md-6"><label class="form-label">Event date</label><input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" min="{{ now()->toDateString() }}" class="form-control" required><div id="date-availability" class="form-text">Choose a date to check availability.</div></div>
            <div class="col-md-6"><label class="form-label">Event time</label><input type="time" name="event_time" value="{{ old('event_time') }}" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Venue</label><input type="text" name="venue" value="{{ old('venue') }}" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Expected guests</label><input type="number" name="guest_count" id="guest_count" value="{{ old('guest_count') }}" min="1" max="1000" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Estimated budget (&#8369;)</label><input type="number" step="0.01" name="estimated_budget" id="estimated_budget" value="{{ old('estimated_budget') }}" min="0" class="form-control" required></div>
            <div class="col-12"><label class="form-label">Additional services</label><textarea name="additional_services" class="form-control" rows="2">{{ old('additional_services') }}</textarea></div>
            <div class="col-12"><label class="form-label">Special requests</label><textarea name="special_requests" class="form-control" rows="2">{{ old('special_requests') }}</textarea></div>
            <div class="col-12"><label class="form-label">Additional notes</label><textarea name="additional_notes" class="form-control" rows="2">{{ old('additional_notes') }}</textarea></div>
            <div class="col-12">
                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                @error('g-recaptcha-response')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12"><button type="submit" id="submit-reservation" class="btn btn-primary">Submit reservation request</button></div>
        </div>
    </form>
</div></div></div></div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
const dateInput=document.getElementById('event_date'), availability=document.getElementById('date-availability'), submitButton=document.getElementById('submit-reservation');
dateInput.addEventListener('change', async () => { if (!dateInput.value) return; availability.textContent='Checking availability…'; submitButton.disabled=true; try { const response=await fetch(`{{ route('reservation.availability') }}?date=${encodeURIComponent(dateInput.value)}`); const data=await response.json(); if (data.available) { availability.textContent=`Available — ${data.remaining} event slot${data.remaining===1?'':'s'} remaining.`; availability.className='form-text text-success'; submitButton.disabled=false; } else { availability.textContent='This date is fully booked. Please choose another date.'; availability.className='form-text text-danger'; } } catch { availability.textContent='We could not check this date. Please try again.'; availability.className='form-text text-danger'; } });
</script>
@endsection
