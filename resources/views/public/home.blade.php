@extends('layouts.app')

@section('content')
<div class="container">
    <section class="hero-section p-4 p-lg-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="hero-badge">Premium catering & event styling</span>
                <h1 class="display-5 fw-bold mt-3 mb-3">Elegant catering for unforgettable celebrations</h1>
                <p class="lead text-muted">From intimate gatherings to grand occasions, we deliver refined menus, polished service, and stress-free planning tailored to your event.</p>
                <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
                    <a href="{{ route('reservation') }}" class="btn btn-primary px-4 py-2">Make a Reservation</a>
                    <a href="{{ route('packages') }}" class="btn btn-outline-primary px-4 py-2">View Packages</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="soft-card p-4 p-lg-4">
                    <h3 class="fw-bold mb-3">Why clients choose us</h3>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><span class="feature-icon me-2">✓</span>Custom menus for every theme</li>
                        <li class="mb-2"><span class="feature-icon me-2">✓</span>Reliable staffing and presentation</li>
                        <li class="mb-2"><span class="feature-icon me-2">✓</span>Flexible packages for any budget</li>
                        <li><span class="feature-icon me-2">✓</span>Professional service from planning to execution</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="row g-4 mt-2">
        <div class="col-md-4">
            <div class="soft-card p-4 h-100">
                <h5 class="fw-bold">Wedding Catering</h5>
                <p class="text-muted mb-0">Elegant plated meals and buffet solutions designed for your celebration.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="soft-card p-4 h-100">
                <h5 class="fw-bold">Birthday & Debut</h5>
                <p class="text-muted mb-0">Bright, festive menus that feel personal and effortlessly memorable.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="soft-card p-4 h-100">
                <h5 class="fw-bold">Corporate Events</h5>
                <p class="text-muted mb-0">Professional dining experiences for meetings, seminars, and team events.</p>
            </div>
        </div>
    </div>
</div>
@endsection
