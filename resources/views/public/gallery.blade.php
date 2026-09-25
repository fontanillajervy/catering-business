@extends('layouts.app')

@section('content')
<div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                <div>
                    <div class="eyebrow mb-2">Celebrations by 3YOS</div>
                    <h1 class="fw-bold mb-1">Gallery</h1>
                    <p class="text-muted mb-0">Browse event photos by celebration type.</p>
                </div>
                <form method="GET" action="{{ route('gallery') }}" class="gallery-filter">
                    <label for="event_type" class="form-label mb-1">Event type</label>
                    <div class="d-flex gap-2">
                        <select id="event_type" name="event_type" class="form-select">
                            <option value="">All events</option>
                            @foreach($eventTypes as $type)
                                <option value="{{ $type }}" @selected($eventType === $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary" type="submit">Filter</button>
                    </div>
                    <div class="form-text">Choose “Other Events” for celebrations outside the listed types.</div>
                </form>
            </div>
            <div class="row g-4">
                @forelse($galleryItems as $item)
                    <div class="col-md-6 col-lg-4"><article class="card h-100 overflow-hidden"><img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="w-100" style="height:250px;object-fit:cover"><div class="p-3"><div class="d-flex justify-content-between gap-2"><h5>{{ $item->title }}</h5>@if($item->is_featured)<span class="badge text-bg-warning">Featured</span>@endif</div>@if($item->event_type)<p class="small text-muted mb-2">{{ $item->event_type }}</p>@endif<p class="text-muted mb-0">{{ $item->description }}</p></div></article></div>
                @empty
                    <div class="col-12"><div class="card p-5 text-center text-muted">No gallery items match this event type yet.</div></div>
                @endforelse
            </div>
        </div>
        <style>
            .gallery-filter{min-width:min(100%,330px)}
            @media(max-width:575px){.gallery-filter{width:100%}}
        </style>
        @endsection
