@extends('layouts.admin')

@section('content')
<div class="content-card p-4">
    <h1 class="fw-bold mb-4">Reports</h1>
    <div class="row g-4">
        @foreach(['daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly', 'yearly' => 'Yearly'] as $key => $label)
            @php $summary = ${$key}; @endphp
            <div class="col-md-6">
                <div class="card p-4 h-100">
                    <h4>{{ $label }} Report</h4>
                    <ul class="mb-3">
                        <li>Reservations: {{ $summary['reservation_count'] }}</li>
                        <li>Confirmed: {{ $summary['confirmed_reservations'] }}</li>
                        <li>Completed: {{ $summary['completed_events'] }}</li>
                        <li>Cancelled: {{ $summary['cancelled_reservations'] }}</li>
                        <li>Estimated Revenue: ₱{{ number_format($summary['estimated_revenue'], 2) }}</li>
                    </ul>
                    <a class="btn btn-outline-primary" href="{{ route('admin.reports.export', ['type' => 'csv']) }}">Export CSV</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
