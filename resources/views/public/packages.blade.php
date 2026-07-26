@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="fw-bold mb-4">Packages</h1>
    <div class="row g-4">
        @foreach($packages as $package)
            <div class="col-md-6">
                <div class="card h-100 p-3">
                    <h4>{{ $package->name }}</h4>
                    <p class="text-muted">{{ $package->description }}</p>
                    <p class="fw-bold">₱{{ number_format($package->price, 2) }}</p>
                    <a href="{{ route('packages.show', $package->slug) }}" class="btn btn-outline-primary">View Details</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
