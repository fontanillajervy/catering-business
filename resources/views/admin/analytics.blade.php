@extends('layouts.admin')

@section('content')
<div class="content-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Analytics</h1>
            <p class="text-muted mb-0">A clear view of reservations, revenue, and package demand.</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card p-4 h-100">
                <div class="badge-soft mb-2">Reservations</div>
                <h3 class="fw-bold">{{ $monthlyReservations->sum('total') }}</h3>
                <p class="mb-0 text-muted">Tracked booking volume</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card p-4 h-100">
                <div class="badge-soft mb-2">Revenue</div>
                <h3 class="fw-bold">₱{{ number_format($monthlyRevenue->sum('revenue'), 2) }}</h3>
                <p class="mb-0 text-muted">Estimated earnings</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card p-4 h-100">
                <div class="badge-soft mb-2">Top Package</div>
                <h3 class="fw-bold">{{ $topPackages->first()?->name ?? 'N/A' }}</h3>
                <p class="mb-0 text-muted">Most requested offering</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card p-4 h-100">
                <h4 class="fw-semibold mb-3">Monthly Reservations</h4>
                <canvas id="reservationsChart"></canvas>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card p-4 h-100">
                <h4 class="fw-semibold mb-3">Revenue Trend</h4>
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card p-4 h-100">
                <h4 class="fw-semibold mb-3">Package Popularity</h4>
                <canvas id="packageChart"></canvas>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card p-4 h-100">
                <h4 class="fw-semibold mb-3">Customer Activity</h4>
                <canvas id="activityChart"></canvas>
            </div>
        </div>
    </div>

    <div class="card p-4 mt-4">
        <h4 class="fw-semibold mb-3">Top Packages</h4>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr><th>Package</th><th>Bookings</th></tr>
                </thead>
                <tbody>
                    @foreach($topPackages as $package)
                        <tr><td>{{ $package->name }}</td><td>{{ $package->total }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const reservationsCtx = document.getElementById('reservationsChart');
    const revenueCtx = document.getElementById('revenueChart');
    const packageCtx = document.getElementById('packageChart');
    const activityCtx = document.getElementById('activityChart');

    const reservationData = [@foreach($monthlyReservations as $item){{ $item->total ?? 0 }},@endforeach];
    const revenueData = [@foreach($monthlyRevenue as $item){{ (float) ($item->revenue ?? 0) }},@endforeach];
    const packageLabels = ['Wedding','Birthday','Corporate','Buffet'];
    const packageData = [{{ $topPackages->pluck('total')->get(0, 0) }}, {{ $topPackages->pluck('total')->get(1, 0) }}, {{ $topPackages->pluck('total')->get(2, 0) }}, {{ $topPackages->pluck('total')->get(3, 0) }}];
    const activityData = [65, 82, 74, 90];

    new Chart(reservationsCtx, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
                label: 'Reservations',
                data: reservationData,
                backgroundColor: ['#8B4513','#A35B2D','#C06A3B','#D78B58','#E6A96D','#F2C287','#C06A3B','#8F4F25','#B56435','#D7894F','#E8A96A','#F4C47C']
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
                label: 'Revenue',
                data: revenueData,
                borderColor: '#D4A373',
                backgroundColor: 'rgba(212,163,115,0.2)',
                fill: true,
                tension: 0.35
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    new Chart(packageCtx, {
        type: 'doughnut',
        data: {
            labels: packageLabels,
            datasets: [{
                data: packageData,
                backgroundColor: ['#8B4513', '#C77F45', '#D4A373', '#E6C89A']
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });

    new Chart(activityCtx, {
        type: 'radar',
        data: {
            labels: ['Response','Planning','Service','Satisfaction','Retention'],
            datasets: [{
                label: 'Performance',
                data: activityData,
                backgroundColor: 'rgba(139,94,60,0.25)',
                borderColor: '#8B4513',
                pointBackgroundColor: '#8B4513'
            }]
        },
        options: { responsive: true }
    });
</script>
@endsection
