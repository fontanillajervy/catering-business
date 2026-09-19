@extends('layouts.admin')

@section('content')
<div class="content-card p-4">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4 align-items-stretch">
        <div>
            <h1 class="fw-bold mb-1">Reservations</h1>
            <p class="text-muted mb-0">Review customer information, then accept, cancel, or update each booking.</p>
        </div>
        <a class="btn luxury-btn align-self-md-start" href="{{ route('admin.reservations') }}">Refresh bookings</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-3 mb-4 reservation-stats">
        <div class="col-sm-6 col-xl-3">
            <div class="reservation-stat reservation-stat--customers"><span>Customers</span><strong>{{ $customerCount }}</strong><small>Unique customer emails</small></div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="reservation-stat reservation-stat--pending"><span>Pending</span><strong>{{ $pendingCount }}</strong><small>Need a decision</small></div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="reservation-stat reservation-stat--accepted"><span>Accepted</span><strong>{{ $acceptedCount }}</strong><small>Confirmed bookings</small></div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="reservation-stat reservation-stat--cancelled"><span>Cancelled</span><strong>{{ $cancelledCount }}</strong><small>Closed bookings</small></div>
        </div>
    </div>

    <div class="table-responsive d-none d-md-block">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Unique ID</th>
                    <th>Customer</th>
                    <th>Event</th>
                    <th>Schedule</th>
                    <th>Guests</th>
                    <th>Contract</th>
                    <th>Status</th>
                    <th>Payment</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                    @php($statusLabel = $reservation->status === 'confirmed' ? 'Accepted' : ucfirst($reservation->status))
                    @php($paymentType = $reservation->payment_type ?? $reservation->payment_status ?? 'Unpaid')
                    <tr>
                        <td>
                            <div class="fw-semibold text-break">{{ $reservation->reservation_code ?? '—' }}</div>
                        </td>
                        <td>
                            <strong>{{ $reservation->full_name }}</strong><br>
                            <a class="customer-contact" href="mailto:{{ $reservation->email }}">{{ $reservation->email }}</a><br>
                            <a class="customer-contact" href="tel:{{ $reservation->contact_number }}">{{ $reservation->contact_number }}</a>
                        </td>
                        <td>
                            {{ $reservation->event_type }}<br>
                            <small class="text-muted">{{ $reservation->venue }}</small>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($reservation->event_date)->format('M j, Y') }}<br>
                            <small class="text-muted">{{ $reservation->event_time }}</small>
                        </td>
                        <td><strong>{{ $reservation->guest_count }}</strong></td>
                        <td>
                            <div class="contract-cell">
                                @forelse($reservation->contractFiles() as $contractIndex => $contractPath)
                                    <div class="contract-item">
                                        <a class="contract-view-link" href="{{ asset('storage/' . $contractPath) }}" target="_blank" rel="noopener">View {{ $contractIndex + 1 }}</a>
                                        <form method="POST" action="{{ route('admin.reservations.contract.delete', [$reservation, $contractIndex]) }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="contract-delete" title="Delete contract image" aria-label="Delete contract image">×</button>
                                        </form>
                                    </div>
                                @empty
                                    <span class="contract-none">None</span>
                                @endforelse

                                <form method="POST" action="{{ route('admin.reservations.contract', $reservation) }}" enctype="multipart/form-data" class="contract-upload-form">
                                    @csrf
                                    <label class="contract-file-picker">
                                        <span>Upload</span>
                                        <input type="file" name="service_contract[]" accept="image/jpeg,image/png,image/webp" onchange="this.form.submit()" multiple required>
                                    </label>
                                    <button class="btn btn-sm luxury-btn" type="submit">Save</button>
                                </form>
                            </div>
                        </td>
                        <td>
                            <div class="status-cell">
                                <span class="status-badge status-badge--{{ $reservation->status }}">{{ $statusLabel }}</span>
                                <form method="POST" action="{{ route('admin.reservations.status', $reservation) }}">
                                    @csrf @method('PATCH')
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="pending" @selected($reservation->status === 'pending')>Pending</option>
                                        <option value="confirmed" @selected($reservation->status === 'confirmed')>Accepted</option>
                                        <option value="completed" @selected($reservation->status === 'completed')>Completed</option>
                                        <option value="cancelled" @selected($reservation->status === 'cancelled')>Cancelled</option>
                                    </select>
                                    <button class="btn btn-sm luxury-btn" type="submit">Save</button>
                                </form>
                            </div>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.reservations.status', $reservation) }}" class="payment-form">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="{{ $reservation->status }}">
                                <div class="payment-stack">
                                    <select name="payment_type" class="form-select form-select-sm">
                                        <option value="Unpaid" @selected($paymentType === 'Unpaid')>Unpaid</option>
                                        <option value="Downpayment" @selected($paymentType === 'Downpayment')>Downpayment</option>
                                        <option value="Full Payment" @selected($paymentType === 'Full Payment')>Full Payment</option>
                                    </select>
                                    <label class="payment-field-label">Paid</label>
                                    <input type="number" name="amount_paid" min="0" step="0.01" value="{{ old('amount_paid', $reservation->amount_paid ?? 0) }}" class="form-control form-control-sm" placeholder="0.00">
                                    <small class="payment-balance">Balance: ₱{{ number_format((float) ($reservation->balance ?? max(0, ($reservation->estimated_budget ?? 0) - ($reservation->amount_paid ?? 0))), 2) }}</small>
                                    <button class="btn btn-sm luxury-btn" type="submit">Save</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No reservations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="reservation-mobile-list d-md-none">
        @forelse($reservations as $reservation)
            @php($statusLabel = $reservation->status === 'confirmed' ? 'Accepted' : ucfirst($reservation->status))
            @php($paymentType = $reservation->payment_type ?? $reservation->payment_status ?? 'Unpaid')
            <article class="reservation-mobile-card">
                <div class="d-flex justify-content-between gap-3">
                    <div>
                        <h5 class="mb-1">{{ $reservation->full_name }}</h5>
                        <a class="customer-contact" href="tel:{{ $reservation->contact_number }}">{{ $reservation->contact_number }}</a>
                    </div>
                    <span class="status-badge status-badge--{{ $reservation->status }}">{{ $statusLabel }}</span>
                </div>
                <div class="mobile-event-info">
                    <div><span>Event</span><strong>{{ $reservation->event_type }}</strong></div>
                    <div><span>Date</span><strong>{{ \Carbon\Carbon::parse($reservation->event_date)->format('M j, Y') }}</strong></div>
                    <div><span>Guests</span><strong>{{ $reservation->guest_count }}</strong></div>
                </div>
                <div class="mb-3">
                    <span class="reservation-id-label">Unique ID</span>
                    <div class="fw-semibold">{{ $reservation->reservation_code ?? '—' }}</div>
                </div>
                <a class="customer-contact d-inline-block mb-3" href="mailto:{{ $reservation->email }}">{{ $reservation->email }}</a>
                @include('admin.partials.reservation-actions', ['reservation' => $reservation, 'mobile' => true])
                <details class="mt-3">
                    <summary>View booking details</summary>
                    <div class="mobile-detail-list">
                        <p><span>Package</span>{{ $reservation->package?->name ?? 'Custom package' }}</p>
                        <p><span>Budget</span>₱{{ number_format($reservation->estimated_budget, 2) }}</p>
                        <p><span>Venue</span>{{ $reservation->venue }}</p>
                        <p><span>Service contract</span>
                            @if($reservation->service_contract)
                                <a class="customer-contact" href="{{ asset('storage/' . $reservation->service_contract) }}" target="_blank" rel="noopener">View image</a>
                            @else
                                <span class="contract-none">None</span>
                            @endif
                        </p>
                    </div>
                </details>
            </article>
        @empty
            <div class="text-center text-muted py-4">No reservations found.</div>
        @endforelse
    </div>
</div>

<style>
    .reservation-stat { height: 100%; padding: 1rem 1.1rem; border: 1px solid var(--border); border-radius: 12px; background: var(--surface-2); }
    .reservation-stat span, .reservation-stat small { display: block; }
    .reservation-stat span, .mobile-event-info span, .mobile-detail-list span { font-size: .68rem; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; }
    .reservation-stat strong { display: block; font-size: 1.7rem; line-height: 1.1; margin: .22rem 0; }
    .reservation-stat small, .mobile-event-info span, .mobile-detail-list span { color: var(--muted); }
    .reservation-stat--customers { border-left: 4px solid #5279a8; }
    .reservation-stat--pending { border-left: 4px solid #d49b28; }
    .reservation-stat--accepted { border-left: 4px solid #21895b; }
    .reservation-stat--cancelled { border-left: 4px solid #c74e4e; }
    .status-badge { display: inline-block; height: max-content; padding: .35rem .65rem; border-radius: 999px; font-size: .75rem; font-weight: 800; }
    .status-badge--pending { color: #714d00; background: #fff1c9; }
    .status-badge--confirmed { color: #0a5a35; background: #d9f7e6; }
    .status-badge--completed { color: #164f85; background: #dceeff; }
    .status-badge--cancelled { color: #8d2020; background: #ffe0e0; }
    body.dark-mode .status-badge--pending { color: #f7d57a; background: rgba(146, 99, 0, 0.28); border: 1px solid rgba(247, 213, 122, 0.45); }
    body.dark-mode .status-badge--confirmed { color: #9ae3b7; background: rgba(24, 96, 64, 0.34); border: 1px solid rgba(154, 227, 183, 0.45); }
    body.dark-mode .status-badge--completed { color: #9ad0ff; background: rgba(24, 76, 128, 0.38); border: 1px solid rgba(154, 208, 255, 0.45); }
    body.dark-mode .status-badge--cancelled { color: #ffb0b0; background: rgba(127, 34, 34, 0.34); border: 1px solid rgba(255, 176, 176, 0.4); }
    .customer-contact { font-size: .82rem; color: var(--accent); text-decoration: none; }
    .reservation-mobile-card { padding: 1rem; margin-bottom: .75rem; border: 1px solid var(--border); border-radius: 12px; background: var(--surface); }
    .reservation-mobile-card h5 { font-size: 1rem; }
    .mobile-event-info { display: grid; grid-template-columns: repeat(3, 1fr); gap: .5rem; padding: .8rem 0; }
    .mobile-event-info strong { display: block; font-size: .82rem; margin-top: .15rem; }
    .mobile-detail-list { padding-top: .75rem; }
    .mobile-detail-list p { margin: 0 0 .65rem; }
    .mobile-detail-list p:last-child { margin: 0; }
    .reservation-mobile-card summary { cursor: pointer; font-weight: 700; color: var(--accent); }
    .reservation-actions { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: .5rem; padding-top: .75rem; border-top: 1px solid var(--border); }
    .reservation-actions form { display: flex; gap: .5rem; }
    .reservation-actions .form-select { width: auto; }
    .reservation-action-group { display: flex; flex-direction: column; gap: .3rem; min-width: 0; }
    .reservation-action-label { font-size: .64rem; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); }
    .reservation-action-group > form { display: flex; gap: .5rem; }
    .reservation-action-group .form-select { width: auto; }
    .contract-upload-form { display: flex; align-items: center; gap: .4rem; }
    .contract-file-picker { position: relative; display: inline-flex; align-items: center; justify-content: center; min-height: 26px; padding: .24rem .45rem; border: 1px solid var(--line); border-radius: 7px; background: var(--surface); color: var(--ink); font-size: .6rem; font-weight: 700; white-space: nowrap; cursor: pointer; }
    .contract-file-picker input { position: absolute; width: 1px; height: 1px; opacity: 0; overflow: hidden; }
    .contract-item { display: inline-flex; align-items: center; gap: .25rem; }
    .contract-delete { border: 0; background: transparent; color: #c74e4e; font-size: .95rem; line-height: 1; cursor: pointer; padding: 0 .15rem; }
    .contract-delete:hover { color: #8d2020; }
    .contract-view-link { font-size: .6rem; color: var(--teal-dark); font-weight: 700; text-decoration: none; }
    .contract-view-link:hover { text-decoration: underline; }
    .contract-none { display: inline-flex; padding: .18rem .38rem; border: 1px solid var(--line); border-radius: 999px; color: var(--muted); font-size: .6rem; font-weight: 700; }
    .contract-cell { display: flex; align-items: flex-start; flex-direction: column; gap: .18rem; min-width: 0; }
    .status-cell { display: flex; align-items: center; gap: .4rem; flex-wrap: wrap; }
    .status-cell form { display: flex; align-items: center; gap: .35rem; min-width: 0; }
    .status-cell .form-select { width: 104px; }
    .status-cell .btn { height: 31px; padding: .3rem .55rem; font-size: .7rem; }
    .payment-stack { display: flex; flex-direction: column; gap: .35rem; min-width: 150px; }
    .payment-field-label { font-size: .6rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: var(--muted); }
    .payment-balance { font-size: .72rem; color: var(--muted); }
    .payment-form { display: flex; }
    @media (max-width: 767px) {
        .reservation-action-group { width: 100%; }
        .reservation-action-group > form { width: 100%; }
        .reservation-action-group .form-select, .contract-upload-form .form-control, .payment-stack .form-select, .payment-stack .form-control { width: 100%; min-width: 0; }
        .reservation-actions { display: block; }
        .reservation-actions form { display: flex; width: 100%; }
        .reservation-actions .btn { width: auto; }
        .payment-stack { min-width: 0; }
    }
</style>
@endsection
