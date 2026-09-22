@extends('layouts.admin')

@section('content')
<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3">
    <div><div class="page-kicker mb-1">Business snapshot</div><h1 class="fw-bold mb-1" style="font-family:Manrope,sans-serif;letter-spacing:-.045em">Good day, admin.</h1><p class="text-muted mb-0">Here is a live overview of your catering operations.</p></div>
    <a class="btn luxury-btn px-3" href="{{ route('admin.reservations') }}">Review reservations</a>
</div>
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><span class="badge-soft">Bookings</span><h3>{{ $reservationCount }}</h3><p class="mb-0 text-muted">Total reservation requests</p></div></div>
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><span class="badge-soft">Inbox</span><h3>{{ $inquiryCount }}</h3><p class="mb-0 text-muted">Customer inquiries received</p></div></div>
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><span class="badge-soft">Services</span><h3>{{ $serviceCount }}</h3><p class="mb-0 text-muted">Active service offerings</p></div></div>
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><span class="badge-soft">Packages</span><h3>{{ $packageCount }}</h3><p class="mb-0 text-muted">Published catering packages</p></div></div>
</div>
<div class="row g-4">
    <div class="col-lg-7"><div class="card p-4 h-100"><div class="d-flex align-items-center justify-content-between mb-4"><div><h5 class="fw-bold mb-1">Priority workspace</h5><p class="text-muted small mb-0">Keep client communication and booking decisions moving.</p></div><span class="badge-soft">Today</span></div><div class="workflow-item"><div class="workflow-icon">01</div><div><strong>Review reservation requests</strong><p class="text-muted mb-0">Confirm availability, update status, and respond to event needs.</p></div><a href="{{ route('admin.reservations') }}">Open</a></div><div class="workflow-item"><div class="workflow-icon">02</div><div><strong>Reply to inquiries</strong><p class="text-muted mb-0">Give prospective clients a timely, helpful response.</p></div><a href="{{ route('admin.inquiries') }}">Open</a></div>@if(session('admin_role') === 'full')<div class="workflow-item"><div class="workflow-icon">03</div><div><strong>Keep packages current</strong><p class="text-muted mb-0">Update inclusions, pricing, and featured offerings.</p></div><a href="{{ route('admin.packages.index') }}">Manage</a></div>@endif</div></div>
    <div class="col-lg-5"><div class="card p-4 h-100"><h5 class="fw-bold mb-1">Quick actions</h5><p class="text-muted small mb-4">Frequently used management tools.</p><div class="d-grid gap-2"><a class="quick-link" href="{{ route('admin.inquiries') }}"><span>Client inquiries</span><b>→</b></a><a class="quick-link" href="{{ route('admin.reservations') }}"><span>Reservation calendar</span><b>→</b></a>@if(session('admin_role') === 'full')<a class="quick-link" href="{{ route('admin.packages.index') }}"><span>Package editor</span><b>→</b></a><a class="quick-link" href="{{ route('admin.analytics') }}"><span>Business analytics</span><b>→</b></a>@endif</div></div></div>
</div>

<div class="card p-4 mt-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h5 class="fw-bold mb-1">Booked calendar</h5>
            <p class="text-muted small mb-0">Who is booked in {{ $sidebarCalendar['monthLabel'] }}</p>
        </div>
        <span class="badge-soft">{{ count($sidebarCalendar['bookings']) }} days</span>
    </div>

    <div class="calendar-weekdays" aria-label="Calendar weekdays">
        <span>Sun</span>
        <span>Mon</span>
        <span>Tue</span>
        <span>Wed</span>
        <span>Thu</span>
        <span>Fri</span>
        <span>Sat</span>
    </div>

    <div class="calendar-grid" aria-live="polite">
        @foreach($sidebarCalendar['days'] as $day)
            <a href="{{ route('admin.reservations', ['date_from' => $day['date'], 'date_to' => $day['date']]) }}" class="calendar-day-link {{ $day['isCurrentMonth'] ? 'calendar-day--current' : 'calendar-day--muted' }} {{ $day['isSelected'] ? 'calendar-day--selected' : '' }}" title="Open bookings for {{ \Carbon\Carbon::parse($day['date'])->format('M j, Y') }}">
                <div class="calendar-day {{ $day['isCurrentMonth'] ? 'calendar-day--current' : 'calendar-day--muted' }} {{ $day['isSelected'] ? 'calendar-day--selected' : '' }}">
                    <span class="calendar-day-number">{{ $day['day'] }}</span>
                    @if(!empty($day['bookings']))
                        @foreach(array_slice($day['bookings'], 0, 2) as $customer)
                            <span class="calendar-booking">{{ \Illuminate\Support\Str::limit($customer, 14) }}</span>
                        @endforeach
                        @if(count($day['bookings']) > 2)
                            <span class="calendar-more">+{{ count($day['bookings']) - 2 }} more</span>
                        @endif
                    @endif
                </div>
            </a>
        @endforeach
    </div>
</div>

@if($selectedDate)
    <div class="card p-4 mt-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h5 class="fw-bold mb-1">Bookings for {{ \Carbon\Carbon::parse($selectedDate)->format('M j, Y') }}</h5>
                <p class="text-muted small mb-0">Jump into the reservations list for this date.</p>
            </div>
            <a class="btn luxury-btn btn-sm" href="{{ route('admin.reservations', ['date_from' => $selectedDate, 'date_to' => $selectedDate]) }}">Open list</a>
        </div>

        @if($selectedReservations->isEmpty())
            <p class="text-muted mb-0">No reservations booked on this date.</p>
        @else
            <div class="d-grid gap-2">
                @foreach($selectedReservations as $reservation)
                    <a class="selected-day-booking" href="{{ route('admin.reservations', ['search' => $reservation->reservation_code]) }}">
                        <div>
                            <strong>{{ $reservation->full_name }}</strong>
                            <div class="small text-muted">{{ $reservation->event_type }} • {{ $reservation->event_time }}</div>
                        </div>
                        <span class="status-badge status-badge--{{ $reservation->status }}">{{ $reservation->status }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endif

<style>
.workflow-item{display:flex;align-items:center;gap:1rem;padding:1rem 0;border-top:1px solid var(--line)}
.workflow-item:first-of-type{border-top:0}
.workflow-icon{width:35px;height:35px;display:grid;place-items:center;border-radius:9px;background:var(--mint);color:var(--teal-dark);font-size:.7rem;font-weight:800}
.workflow-item strong{font-size:.9rem}
.workflow-item p{font-size:.8rem;margin-top:.15rem}
.workflow-item a{margin-left:auto;color:var(--teal-dark);font-weight:800;text-decoration:none;font-size:.8rem}
.quick-link{display:flex;justify-content:space-between;align-items:center;padding:.9rem 1rem;border:1px solid var(--line);border-radius:9px;color:var(--ink);font-weight:700;text-decoration:none;transition:.18s}
.quick-link:hover{border-color:#9bd5cf;background:var(--mint);color:var(--teal-dark)}
.quick-link b{font-size:1.1rem;color:var(--teal)}
.calendar-weekdays{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:.45rem;margin-top:.5rem;margin-bottom:.55rem;color:#607787;font-size:.7rem;font-weight:800;letter-spacing:.08em;text-transform:uppercase}
.calendar-weekdays span{text-align:center}
.calendar-grid{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:.45rem}
.calendar-day-link{display:block;text-decoration:none;color:inherit}
.calendar-day{min-height:95px;padding:.5rem .45rem;border:1px solid var(--line);border-radius:10px;background:#f9fbfc;display:flex;flex-direction:column;gap:.2rem;align-items:flex-start;transition:.18s ease}
.calendar-day:hover{transform:translateY(-1px);box-shadow:0 8px 18px rgba(12,31,46,.08)}
.calendar-day--muted{opacity:.62;background:#f5f7f9}
.calendar-day--current{background:#fff}
.calendar-day--selected{outline:2px solid #0d8b83;outline-offset:1px;background:#ecf9f7}
.calendar-day-number{display:inline-flex;align-items:center;justify-content:center;width:26px;height:26px;border-radius:50%;font-size:.72rem;font-weight:800;color:#30495b;background:#edf4f6}
.calendar-booking{display:inline-block;max-width:100%;padding:.15rem .35rem;border-radius:999px;background:#dff5f2;color:#0b7d74;font-size:.62rem;font-weight:700;line-height:1.3;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.calendar-more{font-size:.62rem;color:#607787;font-weight:700}
.selected-day-booking{display:flex;justify-content:space-between;align-items:center;gap:1rem;padding:.75rem .9rem;border:1px solid var(--line);border-radius:10px;background:#f9fbfc;color:var(--ink);text-decoration:none;transition:.18s ease}
.selected-day-booking:hover{border-color:#9bd5cf;background:var(--mint);text-decoration:none}
.status-badge{display:inline-flex;align-items:center;padding:.28rem .55rem;border-radius:999px;font-size:.65rem;font-weight:800;letter-spacing:.04em;text-transform:uppercase}
.status-badge--pending{background:#fff1c8;color:#8a6613}
.status-badge--confirmed{background:#dff5f2;color:#0b7d74}
.status-badge--completed{background:#e6f4ea;color:#2d6b4d}
.status-badge--cancelled{background:#fde5e5;color:#b63b3b}
body.dark-mode .calendar-weekdays{color:#9bb0c2}
body.dark-mode .calendar-day{background:#1a2d3f;border-color:#2d4257}
body.dark-mode .calendar-day:hover{box-shadow:0 8px 20px rgba(0,0,0,.18)}
body.dark-mode .calendar-day--muted{background:#132536;opacity:.8}
body.dark-mode .calendar-day--current{background:#172a3b}
body.dark-mode .calendar-day--selected{background:#123b42;outline-color:#75d8cf}
body.dark-mode .calendar-day-number{background:#233d50;color:#e6f3ff}
body.dark-mode .calendar-booking{background:#164d4b;color:#dffaf7}
body.dark-mode .calendar-more{color:#c5d6e6}
body.dark-mode .selected-day-booking{background:#1a2d3f;border-color:#2d4257;color:#edf5fb}
body.dark-mode .selected-day-booking:hover{background:#173844}
body.dark-mode .status-badge--pending{background:#56461b;color:#fbe8a1}
body.dark-mode .status-badge--confirmed{background:#123b42;color:#dcfffb}
body.dark-mode .status-badge--completed{background:#173b2d;color:#d8f8e2}
body.dark-mode .status-badge--cancelled{background:#4a2325;color:#ffdede}

@media(max-width:992px){
    .row.g-4 > [class*="col-"]{margin-bottom:1rem}
}

@media(max-width:768px){
    .workflow-item{gap:.75rem;padding:.75rem 0}
    .workflow-item strong{font-size:.85rem}
    .workflow-item p{font-size:.75rem}
    .workflow-item a{margin-left:0;margin-top:.5rem;font-size:.75rem}
    .quick-link{padding:.75rem;font-size:.9rem}
    .quick-link b{font-size:1rem}
    .calendar-day{min-height:80px;padding:.45rem .3rem}
}

@media(max-width:575px){
    .workflow-item{align-items:flex-start;flex-direction:column}
    .workflow-item a{width:100%;text-align:center;padding:.4rem;margin-left:0;margin-top:.5rem}
    .quick-link{flex-direction:column;align-items:flex-start;padding:.6rem}
    .quick-link b{align-self:flex-end;margin-top:.4rem;font-size:1rem}
    .quick-link span{width:100%}
    .calendar-weekdays{font-size:.6rem;gap:.3rem}
    .calendar-day{min-height:72px;padding:.35rem .25rem}
    .calendar-booking{font-size:.55rem}
}
</style>
@endsection
