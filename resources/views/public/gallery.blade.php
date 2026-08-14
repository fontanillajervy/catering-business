@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="fw-bold mb-4">Gallery</h1>
    <div class="row g-4">
        @forelse($galleryItems as $item)
            <div class="col-md-6 col-lg-4"><article class="card h-100 overflow-hidden"><img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="w-100" style="height:250px;object-fit:cover"><div class="p-3"><div class="d-flex justify-content-between gap-2"><h5>{{ $item->title }}</h5>@if($item->is_featured)<span class="badge text-bg-warning">Featured</span>@endif</div>@if($item->event_type)<p class="small text-muted mb-2">{{ $item->event_type }}</p>@endif<p class="text-muted mb-0">{{ $item->description }}</p></div></article></div>
        @empty
            <div class="col-12"><div class="card p-5 text-center text-muted">Our event gallery is being updated. Please check back soon.</div></div>
        @endforelse
    </div>
</div>
@endsection
