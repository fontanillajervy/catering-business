@extends('layouts.admin')

@section('content')
<div class="content-card p-4">
	<div class="mb-4">
		<a class="text-decoration-none small" href="{{ route('admin.packages.index') }}">Back to packages</a>
		<h1 class="fw-bold mt-2 mb-1">{{ $package->exists ? 'Edit package' : 'Add package' }}</h1>
		<p class="text-muted mb-0">Set the guest range and per-person rate used to calculate the reservation total.</p>
	</div>
	<form method="POST" enctype="multipart/form-data" onsubmit="return confirm('{{ $package->exists ? 'Save these package updates?' : 'Add this package to the website?' }}')" action="{{ $package->exists ? route('admin.packages.update', $package) : route('admin.packages.store') }}">
		@csrf
		@if($package->exists) @method('PUT') @endif
		<div class="row g-3">
			<div class="col-md-6"><label class="form-label" for="name">Package name</label><input id="name" class="form-control" name="name" value="{{ old('name', $package->name) }}" required><div class="form-text">Use a short name customers can recognize.</div></div>
			<div class="col-md-3"><label class="form-label" for="price">Rate per guest (PHP)</label><input id="price" class="form-control" name="price" type="number" min="0" step="0.01" value="{{ old('price', $package->price) }}" required><div class="form-text">Used to calculate the full event estimate.</div></div>
			<div class="col-md-3 d-flex align-items-end"><div class="form-check mb-2"><input class="form-check-input" type="checkbox" value="1" name="is_featured" id="featured" @checked(old('is_featured', $package->is_featured))><label class="form-check-label" for="featured">Featured package</label><div class="form-text">Featured packages receive extra emphasis.</div></div></div>
			<div class="col-md-6"><label class="form-label" for="min_guests">Minimum guests</label><input id="min_guests" class="form-control" name="min_guests" type="number" min="1" value="{{ old('min_guests', $package->min_guests) }}" required><div class="form-text">Lowest booking size supported.</div></div>
			<div class="col-md-6"><label class="form-label" for="max_guests">Maximum guests</label><input id="max_guests" class="form-control" name="max_guests" type="number" min="1" value="{{ old('max_guests', $package->max_guests) }}" required><div class="form-text">Must be equal to or greater than the minimum.</div></div>
			<div class="col-12"><label class="form-label" for="description">Description</label><textarea id="description" class="form-control" name="description" rows="3">{{ old('description', $package->description) }}</textarea><div class="form-text">Briefly describe who this package is for.</div></div>
			<div class="col-md-6"><label class="form-label" for="menu">Package inclusions / menu</label><textarea id="menu" class="form-control" name="menu" rows="4">{{ old('menu', $package->menu) }}</textarea><div class="form-text">List the food and service inclusions.</div></div>
			<div class="col-md-6"><label class="form-label" for="freebies">Freebies</label><textarea id="freebies" class="form-control" name="freebies" rows="4">{{ old('freebies', $package->freebies) }}</textarea><div class="form-text">Optional complimentary items or services.</div></div>
			<div class="col-md-6"><label class="form-label" for="addons">Add-ons</label><textarea id="addons" class="form-control" name="addons" rows="3">{{ old('addons', $package->addons) }}</textarea><div class="form-text">Optional extras customers may request.</div></div>
			<div class="col-md-6"><label class="form-label" for="event_type">Suggested event types</label><input id="event_type" class="form-control" name="event_type" value="{{ old('event_type', $package->event_type) }}"><div class="form-text">Separate multiple event types with commas.</div></div>
			<div class="col-12"><label class="form-label" for="image">Package image</label><input id="image" class="form-control" type="file" name="image" accept="image/jpeg,image/png,image/webp"><div class="form-text">Upload JPG, PNG, or WebP up to 5 MB. Leave blank to keep the current image.</div>
				@if($package->image_path)<img class="mt-3" src="{{ asset('storage/' . $package->image_path) }}" alt="Current {{ $package->name }} package image" style="max-width:320px;max-height:200px;object-fit:cover">@endif
			</div>
			<div class="col-12 d-flex gap-2"><button class="btn luxury-btn" type="submit">{{ $package->exists ? 'Update package' : 'Add package' }}</button><a class="btn btn-outline-secondary" href="{{ route('admin.packages.index') }}">Cancel</a></div>
		</div>
	</form>
</div>
@endsection
