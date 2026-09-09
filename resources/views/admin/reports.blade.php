@extends('layouts.admin')

@section('content')
<div class="content-card p-4">
    <h1 class="fw-bold mb-2">Reports</h1>
    <p class="text-muted mb-4">Booking and confirmed-revenue summaries.</p>
    
    <div class="row g-4">
        @foreach(['daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly', 'yearly' => 'Yearly'] as $key => $label)
            @php($summary = ${$key})
            <div class="col-md-6 col-lg-6">
                <div class="card p-4 h-100">
                    <h4 class="fw-bold mb-3">{{ $label }} report</h4>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2"><span class="badge-soft me-2">Reservations</span> <strong>{{ $summary['reservation_count'] }}</strong></li>
                        <li class="mb-2"><span class="badge-soft me-2">Confirmed</span> <strong>{{ $summary['confirmed_reservations'] }}</strong></li>
                        <li class="mb-2"><span class="badge-soft me-2">Completed</span> <strong>{{ $summary['completed_events'] }}</strong></li>
                        <li class="mb-2"><span class="badge-soft me-2">Cancelled</span> <strong>{{ $summary['cancelled_reservations'] }}</strong></li>
                        <li class="mb-2"><span class="badge-soft me-2">Inquiries</span> <strong>{{ $summary['inquiry_count'] }}</strong></li>
                        <li class="mb-3"><span class="badge-soft me-2">Est. Revenue</span> <strong>₱{{ number_format($summary['estimated_revenue'], 2) }}</strong></li>
                    </ul>
                    <a class="btn btn-outline-secondary w-100" href="{{ route('admin.reports.export', ['type' => 'csv']) }}">Download CSV</a>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
@media(max-width:768px){
    .card{padding:1rem!important}
    .card h4{font-size:1rem;margin-bottom:1rem}
    .card ul li{font-size:.9rem}
}

@media(max-width:576px){
    .card{padding:.75rem!important}
    .card h4{font-size:.95rem}
    .badge-soft{font-size:.65rem;padding:.15rem .35rem}
    .btn{width:100%;font-size:.85rem}
}
</style>
@endsection
