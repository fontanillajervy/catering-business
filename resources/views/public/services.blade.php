@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="fw-bold mb-4">Our Services</h1>
    <div class="row g-4">
        @foreach($services as $service)
            <div class="col-md-6">
                <div class="card h-100 p-3">
                    <h4>{{ $service->name }}</h4>
                    <p class="text-muted">{{ $service->description }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
