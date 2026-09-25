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

                <form method="POST" action="{{ route('reservation.store') }}" id="reservation-form" onsubmit="return confirm('Submit this reservation request? Your reservation ID will be emailed to you.')">@csrf<input type="text" name="website" class="d-none" tabindex="-1" autocomplete="off"><input type="hidden" name="form_started" value="{{ now()->timestamp }}">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label" for="full_name">Full name</label><input id="full_name" type="text" name="full_name" value="{{ old('full_name') }}" class="form-control" autocomplete="name" required><div class="form-text">Enter the name of the person coordinating this event.</div></div>
                        <div class="col-md-6"><label class="form-label" for="contact_number">Contact number</label><input id="contact_number" type="tel" name="contact_number" value="{{ old('contact_number') }}" class="form-control" inputmode="tel" pattern="\+63[0-9]{10}" maxlength="13" placeholder="+639123456789" title="Use +63 followed by exactly 10 digits." required><div class="form-text">Use +63 followed by exactly 10 digits, for example +639123456789.</div></div>
                        <div class="col-md-6"><label class="form-label" for="email">Email address</label><input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" autocomplete="email" required><div class="form-text">Your reservation ID and status notifications will be sent to this address.</div></div>
                        <div class="col-md-6"><label class="form-label" for="address">Complete address</label><input id="address" type="text" name="address" value="{{ old('address') }}" class="form-control" autocomplete="street-address" required><div class="form-text">Include your city or municipality.</div></div>
                        <div class="col-md-6"><label class="form-label" for="event_type">Event type</label><select id="event_type" name="event_type" class="form-select" required><option value="">Select an event type</option>@foreach(['Wedding','Birthday','Debut','Anniversary','Corporate Event','Baptism','Graduation','Other'] as $type)<option value="{{ $type }}" @selected(old('event_type') === $type)>{{ $type }}</option>@endforeach</select><div class="form-text">Choose the closest match for your occasion.</div></div>
                        <div class="col-md-6"><label class="form-label" for="package_id">Catering package</label><select name="package_id" id="package_id" class="form-select" required><option value="">Select a package</option>@foreach($packages as $package)<option value="{{ $package->id }}" data-price="{{ $package->price }}" data-min-guests="{{ $package->min_guests }}" data-max-guests="{{ $package->max_guests }}" @selected(old('package_id') == $package->id)>{{ $package->name }} ({{ $package->min_guests }}–{{ $package->max_guests }} guests)</option>@endforeach</select><div class="form-text">Package availability depends on the event guest count.</div></div>
                        <div class="col-md-6"><label class="form-label" for="event_date">Event date</label><input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" min="{{ now()->addDays(2)->toDateString() }}" class="form-control" required><div id="date-availability" class="date-availability form-text">Choose a date at least 2 days in advance.</div></div>
                        <div class="col-md-6"><label class="form-label" for="event_time">Event time</label><input id="event_time" type="time" name="event_time" value="{{ old('event_time') }}" class="form-control" required><div class="form-text">Enter the event start time.</div></div>
                        <div class="col-md-6"><label class="form-label" for="venue">Venue</label><input id="venue" type="text" name="venue" value="{{ old('venue') }}" class="form-control" required><div class="form-text">Enter the venue name and location.</div></div>
                        <div class="col-md-6"><label class="form-label" for="guest_count">Expected guests</label><input type="number" name="guest_count" id="guest_count" value="{{ old('guest_count') }}" min="1" max="1000" class="form-control" required><div class="form-text" id="guest-guidance">Enter your expected number of attendees.</div></div>
                        <div class="col-md-6"><label class="form-label" for="estimated_total">Estimated total</label><output id="estimated_total" class="form-control" aria-live="polite">Choose package + guests</output><div class="form-text">Auto-calculated total.</div></div>
                        <div class="col-12"><label class="form-label" for="additional_services">Additional services</label><textarea id="additional_services" name="additional_services" class="form-control" rows="2">{{ old('additional_services') }}</textarea><div class="form-text">Optional: list services such as styling, tables, or equipment.</div></div>
                        <div class="col-12"><label class="form-label" for="special_requests">Special requests</label><textarea id="special_requests" name="special_requests" class="form-control" rows="2">{{ old('special_requests') }}</textarea><div class="form-text">Optional: share dietary needs or event-specific requests.</div></div>
                        <div class="col-12"><label class="form-label" for="additional_notes">Additional notes</label><textarea id="additional_notes" name="additional_notes" class="form-control" rows="2">{{ old('additional_notes') }}</textarea><div class="form-text">Optional: anything else our team should know.</div></div>
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
    #estimated_total{display:flex;flex-wrap:wrap;align-items:center;width:100%;min-height:46px;height:auto;overflow-wrap:anywhere;white-space:normal;background:#fff;line-height:1.5;font-weight:700}
    body.dark-mode #estimated_total{background:#151515;border-color:#555047;color:#f5f1e9}
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

const packageSelect = document.getElementById('package_id');
const guestInput = document.getElementById('guest_count');
const estimatedTotal = document.getElementById('estimated_total');
const guestGuidance = document.getElementById('guest-guidance');
const updateEstimate = () => {
    const option = packageSelect?.selectedOptions[0];
    const guests = Number(guestInput?.value);
    if (!option?.dataset.price || !guests) {
        estimatedTotal.textContent = 'Choose package + guests';
        return;
    }
    const minimum = Number(option.dataset.minGuests);
    const maximum = Number(option.dataset.maxGuests);
    guestInput.min = String(minimum);
    guestInput.max = String(maximum);
    guestGuidance.textContent = `This package serves ${minimum} to ${maximum} guests.`;
    if (guests < minimum || guests > maximum) {
        estimatedTotal.textContent = `Choose between ${minimum} and ${maximum} guests for this package`;
        return;
    }
    const total = Number(option.dataset.price) * guests;
    estimatedTotal.textContent = `PHP ${total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
};
packageSelect?.addEventListener('change', updateEstimate);
guestInput?.addEventListener('input', updateEstimate);
updateEstimate();

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
