@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card p-4">
        <h1 class="fw-bold">{{ $package->name }}</h1>
        <p class="text-muted">{{ $package->description }}</p>
        <p><strong>Price:</strong> ₱{{ number_format($package->price, 2) }}</p>
        <p><strong>Guests:</strong> {{ $package->min_guests }} - {{ $package->max_guests }}</p>
        <p><strong>Menu:</strong> {{ $package->menu }}</p>
        <p><strong>Freebies:</strong> {{ $package->freebies }}</p>
        <p><strong>Addons:</strong> {{ $package->addons }}</p>
    </div>
</div>
@endsection
