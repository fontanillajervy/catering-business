@extends('layouts.admin')

@section('content')
<div class="content-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Dashboard</h1>
            <p class="text-muted mb-0">A quick snapshot of your catering business operations.</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3"><div class="stat-card p-4 h-100"><div class="badge-soft mb-2">Reservations</div><h3 class="fw-bold">{{ $reservationCount }}</h3><p class="mb-0 text-muted">Active booking requests</p></div></div>
        <div class="col-md-3"><div class="stat-card p-4 h-100"><div class="badge-soft mb-2">Inquiries</div><h3 class="fw-bold">{{ $inquiryCount }}</h3><p class="mb-0 text-muted">Customer questions</p></div></div>
        <div class="col-md-3"><div class="stat-card p-4 h-100"><div class="badge-soft mb-2">Services</div><h3 class="fw-bold">{{ $serviceCount }}</h3><p class="mb-0 text-muted">Available offerings</p></div></div>
        <div class="col-md-3"><div class="stat-card p-4 h-100"><div class="badge-soft mb-2">Packages</div><h3 class="fw-bold">{{ $packageCount }}</h3><p class="mb-0 text-muted">Curated package options</p></div></div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3"><a class="btn luxury-btn w-100" href="{{ route('admin.reservations') }}">Reservations</a></div>
        <div class="col-md-3"><a class="btn btn-outline-secondary w-100" href="{{ route('admin.inquiries') }}">Inquiries</a></div>
        <div class="col-md-3"><a class="btn btn-outline-secondary w-100" href="{{ route('admin.analytics') }}">Analytics</a></div>
        <div class="col-md-3"><a class="btn btn-outline-secondary w-100" href="{{ route('admin.activity-logs') }}">Activity Logs</a></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Executive Snapshot</h5>
                    <span class="badge-soft">Live view</span>
                </div>
                <div class="p-3 rounded-3 mb-3" style="background:#f8ede3;">
                    <div class="fw-semibold">Priority actions</div>
                    <div class="text-muted small">Review new reservations and answer inquiries promptly.</div>
                </div>
                <div class="p-3 rounded-3" style="background:#f8ede3;">
                    <div class="fw-semibold">Service momentum</div>
                    <div class="text-muted small">Keep package offerings aligned with current demand and customer preferences.</div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card p-4 h-100">
                <h5 class="fw-bold mb-3">Performance Overview</h5>
                <div class="row g-3">
                    <div class="col-6"><div class="mini-card p-3 rounded-3" style="background:#f8ede3;"><div class="fw-semibold">Response</div><div class="text-muted small">High priority</div></div></div>
                    <div class="col-6"><div class="mini-card p-3 rounded-3" style="background:#f8ede3;"><div class="fw-semibold">Scheduling</div><div class="text-muted small">On track</div></div></div>
                    <div class="col-6"><div class="mini-card p-3 rounded-3" style="background:#f8ede3;"><div class="fw-semibold">Packages</div><div class="text-muted small">Updated</div></div></div>
                    <div class="col-6"><div class="mini-card p-3 rounded-3" style="background:#f8ede3;"><div class="fw-semibold">Client care</div><div class="text-muted small">Excellent</div></div></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
