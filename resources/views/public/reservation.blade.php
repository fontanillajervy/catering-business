@extends('layouts.app')

@section('title', 'Book an event | 3YOS Catering')

@section('content')
<div class="container py-4 py-lg-5">
    <div class="page-heading">
        <div class="eyebrow">Reservation request</div>
        <h1 class="fw-bold mt-2 mb-2">Plan your perfect event.</h1>
        <p class="text-muted mb-0">We accept up to three events each day so every celebration gets the attention it deserves.</p>
    </div>

    @if(session('reservation_code') || (isset($reservation) && $reservation))
        @php($statusCode = session('reservation_code') ?: ($reservation->reservation_code ?? null))
        @php($statusLabel = session('reservation_status') ?: ($reservation->status ?? 'pending'))
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8">
                <div class="alert alert-info mb-0 px-3 py-2 text-start">
                    <div class="small text-uppercase fw-bold opacity-75">Current status</div>
                    <div class="fw-semibold text-capitalize">{{ str_replace('_', ' ', $statusLabel) }}</div>
                    <div class="small mt-1"><strong>ID:</strong> {{ $statusCode }}</div>
                </div>
            </div>
        </div>
    @endif

    <div class="row g-4 g-lg-5 reservation-shell">
        <div class="col-lg-4">
            <aside class="reservation-sidebar">
                <div class="eyebrow mb-2">Before you submit</div>
                <h2>We’ll make it easy.</h2>
                <ul class="reservation-checklist">
                    <li>Tell us your guest count and preferred date.</li>
                    <li>Choose a package that fits your budget and vibe.</li>
                    <li>We’ll confirm availability and recommend the right setup.</li>
                </ul>
                <div class="reservation-tile">
                    <strong>Best for</strong>
                    <p>Weddings, debut parties, birthdays, corporate events, and intimate family celebrations.</p>
                </div>
            </aside>
        </div>

        <div class="col-lg-8">
            <div class="form-card p-4 p-lg-5">
                @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                @if(session('success'))
                    <div id="reservation-toast" class="floating-toast show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="floating-toast__icon">✓</div>
                        <div class="floating-toast__content">
                            <strong>Reservation sent</strong>
                            <div>{{ session('success') }}</div>
                        </div>
                        <button type="button" class="floating-toast__close" aria-label="Close notification">&times;</button>
                    </div>
                @endif

                <form method="POST" action="{{ route('reservation.store') }}" id="reservation-form">@csrf<input type="text" name="website" class="d-none" tabindex="-1" autocomplete="off"><input type="hidden" name="form_started" value="{{ now()->timestamp }}">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Full name</label><input type="text" name="full_name" value="{{ old('full_name') }}" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Contact number</label><input type="text" name="contact_number" value="{{ old('contact_number') }}" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Email address</label><input type="email" name="email" value="{{ old('email') }}" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Complete address</label><input type="text" name="address" value="{{ old('address') }}" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Event type</label><select name="event_type" class="form-select" required><option value="">Select an event type</option>@foreach(['Wedding','Birthday','Debut','Anniversary','Corporate Event','Baptism','Graduation','Other'] as $type)<option value="{{ $type }}" @selected(old('event_type') === $type)>{{ $type }}</option>@endforeach</select></div>
                        <div class="col-md-6"><label class="form-label">Catering package</label><select name="package_id" id="package_id" class="form-select" required><option value="">Select a package</option>@foreach($packages as $package)<option value="{{ $package->id }}" data-price="{{ $package->price }}" @selected(old('package_id') == $package->id)>{{ $package->name }} — from &#8369;{{ number_format($package->price, 0) }}/guest</option>@endforeach</select></div>
                        <div class="col-md-6"><label class="form-label">Event date</label><input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" min="{{ now()->addDays(2)->toDateString() }}" class="form-control" required><div id="date-availability" class="date-availability form-text">Choose a date at least 2 days in advance.</div></div>
                        <div class="col-md-6"><label class="form-label">Event time</label><input type="time" name="event_time" value="{{ old('event_time') }}" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Venue</label><input type="text" name="venue" value="{{ old('venue') }}" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Expected guests</label><input type="number" name="guest_count" id="guest_count" value="{{ old('guest_count') }}" min="1" max="1000" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Estimated budget (&#8369;)</label><input type="number" step="1" min="0" name="estimated_budget" id="estimated_budget" value="{{ old('estimated_budget') }}" class="form-control" required></div>
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
            </div>
        </div>
    </div>
</div>

<style>
    .page-heading{padding:1rem 0 2rem}
    .page-heading h1{font-size:clamp(2.4rem,4vw,4rem);line-height:1.05;letter-spacing:-.04em}
    .reservation-shell{margin-top:1rem}
    .reservation-sidebar{background:linear-gradient(160deg,#f5ebdf,#f0e2d0);border:1px solid rgba(109,48,36,.08);border-radius:24px;padding:2rem;position:sticky;top:90px}
    .reservation-sidebar h2{font-size:clamp(1.8rem,2vw,2.3rem);margin-bottom:1rem}
    .reservation-checklist{list-style:none;padding:0;margin:1rem 0 1.5rem;display:grid;gap:.9rem}
    .reservation-checklist li{position:relative;padding-left:1.8rem;color:var(--muted);line-height:1.6}
    .reservation-checklist li:before{content:'✓';position:absolute;left:0;top:0;color:var(--wine);font-weight:800}
    .reservation-tile{margin-top:1rem;padding:1.2rem;background:#f7efe7;border-radius:18px;border:1px solid rgba(109,48,36,.08)}
    .reservation-tile strong{display:block;margin-bottom:.25rem}
    .reservation-tile p{margin:0;color:var(--muted);line-height:1.6}
    .form-card{background:#fdf9f5;border:1px solid rgba(109,48,36,.08);border-radius:24px;box-shadow:0 22px 50px rgba(32,32,29,.06)}
    .form-label{font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--muted)}
    .form-control,.form-select{border:1px solid #e7ddd0;border-radius:14px;padding:.8rem 1rem;background:#fff;color:var(--ink)}
    .form-control:focus,.form-select:focus{border-color:var(--wine);box-shadow:0 0 0 .2rem rgba(109,48,36,.12)}
    .date-availability{display:block;margin-top:.45rem;font-size:.82rem}
    .floating-toast{position:fixed;right:1.25rem;bottom:1.25rem;display:flex;align-items:center;gap:.9rem;width:min(360px,calc(100vw - 2rem));background:#1f1c1a;color:#fff;padding:1rem 1rem;border-radius:16px;box-shadow:0 20px 50px rgba(0,0,0,.18);opacity:0;transform:translateY(20px);transition:.28s ease;z-index:2000}
    .floating-toast.show{opacity:1;transform:translateY(0)}
    .floating-toast__icon{display:grid;place-items:center;width:32px;height:32px;border-radius:50%;background:rgba(255,255,255,.12);font-weight:800;color:#d8f7d0}
    .floating-toast__content{flex:1;font-size:.92rem}
    .floating-toast__content strong{display:block;margin-bottom:.15rem}
    .floating-toast__close{border:0;background:transparent;color:#fff;opacity:.8;font-size:1.4rem;line-height:1}
    @media (max-width:991.98px){.reservation-sidebar{position:static}} 
    @media (max-width:575px){.page-heading{padding-top:.5rem}.form-card{padding:1.25rem!important}}
</style>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
const reservationToast = document.getElementById('reservation-toast');
if (reservationToast) {
    const closeButton = reservationToast.querySelector('.floating-toast__close');
    const hideToast = () => reservationToast.classList.remove('show');
    setTimeout(hideToast, 6000);
    closeButton?.addEventListener('click', hideToast);
}

const dateInput=document.getElementById('event_date'), availability=document.getElementById('date-availability'), submitButton=document.getElementById('submit-reservation');
if (dateInput && availability && submitButton) {
    const minReservationDate = new Date();
    minReservationDate.setDate(minReservationDate.getDate() + 2);

    const formatDateInputValue = (d) => {
        const year = d.getFullYear();
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const day = String(d.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };

    dateInput.addEventListener('change', async () => { if (!dateInput.value) return;
        const selectedDate = new Date(dateInput.value + 'T00:00:00');
        const earliestAllowed = new Date(formatDateInputValue(minReservationDate) + 'T00:00:00');

        if (selectedDate < earliestAllowed) {
            availability.textContent='Reservations must be booked at least 2 days in advance.';
            availability.className='date-availability text-danger';
            submitButton.disabled=true;
            return;
        }

        availability.textContent='Checking availability…'; submitButton.disabled=true; try { const response=await fetch(`{{ route('reservation.availability') }}?date=${encodeURIComponent(dateInput.value)}`); const data=await response.json(); if (data.available) { availability.textContent=`Available — ${data.remaining} event slot${data.remaining===1?'':'s'} remaining.`; availability.className='date-availability text-success'; submitButton.disabled=false; } else { availability.textContent='This date is fully booked. Please choose another date.'; availability.className='date-availability text-danger'; } } catch { availability.textContent='We could not check this date. Please try again.'; availability.className='date-availability text-danger'; } });
}
</script>
@endsection
