@extends('layouts.admin')

@section('content')
<div class="content-card p-4">
    <div class="mb-4"><h1 class="fw-bold mb-1">Gallery</h1><p class="text-muted mb-0">Add event photos and update the public gallery.</p></div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <section class="card p-3 mb-4">
        <h2 class="h5">Add photo</h2>
        <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data" onsubmit="return confirm('Add this photo to the public gallery?')">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label" for="new-title">Photo title</label><input id="new-title" class="form-control" name="title" placeholder="Photo title" required><div class="form-text">Use a short description of the event photo.</div></div>
                <div class="col-md-6"><label class="form-label" for="new-event-type">Event type</label><input id="new-event-type" class="form-control" name="event_type" placeholder="Wedding, Birthday, or Other Events"><div class="form-text">Enter exactly “Other Events” to show this under that filter.</div></div>
                <div class="col-md-8"><label class="form-label" for="new-description">Description</label><textarea id="new-description" class="form-control" name="description" placeholder="Short description" rows="2"></textarea><div class="form-text">Optional context for visitors.</div></div>
                <div class="col-md-4"><label class="form-label" for="new-image">Photo file</label><input id="new-image" class="form-control" type="file" name="image" accept="image/jpeg,image/png,image/webp" required><div class="form-text">Upload JPG, PNG, or WebP up to 5 MB.</div></div>
            </div>
            <div class="form-check mt-3"><input class="form-check-input" type="checkbox" name="is_featured" value="1" id="newFeatured"><label class="form-check-label" for="newFeatured">Featured image</label><div class="form-text">Featured images receive a label in the public gallery.</div></div>
            <button class="btn luxury-btn mt-3" type="submit">Upload photo</button>
        </form>
    </section>
    <div class="row g-4">
        @forelse($galleryItems as $item)
            <div class="col-md-6">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" style="height:220px;object-fit:cover" class="w-100">
                    <div class="p-3">
                        <form method="POST" action="{{ route('admin.gallery.update', $item) }}" enctype="multipart/form-data" onsubmit="return confirm('Save changes to this gallery photo?')">
                            @csrf @method('PUT')
                            <label class="form-label" for="title-{{ $item->id }}">Photo title</label><input id="title-{{ $item->id }}" class="form-control mb-1" name="title" value="{{ $item->title }}" required><div class="form-text mb-2">Keep the title descriptive and brief.</div>
                            <label class="form-label" for="event-{{ $item->id }}">Event type</label><input id="event-{{ $item->id }}" class="form-control mb-1" name="event_type" value="{{ $item->event_type }}" placeholder="Other Events"><div class="form-text mb-2">Use “Other Events” to match the public filter.</div>
                            <label class="form-label" for="description-{{ $item->id }}">Description</label><textarea id="description-{{ $item->id }}" class="form-control mb-1" name="description" rows="2">{{ $item->description }}</textarea><div class="form-text mb-2">Optional caption shown to visitors.</div>
                            <label class="form-label" for="image-{{ $item->id }}">Replace image</label><input id="image-{{ $item->id }}" class="form-control mb-1" type="file" name="image" accept="image/jpeg,image/png,image/webp"><div class="form-text mb-2">Leave blank to retain this image; JPG, PNG, or WebP up to 5 MB.</div>
                            <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="is_featured" value="1" id="featured-{{ $item->id }}" @checked($item->is_featured)><label class="form-check-label" for="featured-{{ $item->id }}">Featured image</label></div>
                            <div class="d-flex gap-2"><button class="btn btn-sm luxury-btn" type="submit">Update</button>
                        </form>
                        <form method="POST" action="{{ route('admin.gallery.destroy', $item) }}" onsubmit="return confirm('Delete this gallery photo? This cannot be undone.');">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" type="submit">Delete</button></form></div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><p class="text-muted">No gallery photos yet.</p></div>
        @endforelse
    </div>
</div>
@endsection