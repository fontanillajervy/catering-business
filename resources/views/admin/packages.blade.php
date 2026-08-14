@extends('layouts.admin')

@section('content')
<div class="content-card p-4">
    <div class="d-flex justify-content-between gap-3 mb-4">
        <div><h1 class="fw-bold mb-1">Packages</h1><p class="text-muted mb-0">Create, update, feature, or remove your catering packages.</p></div>
        <a class="btn luxury-btn" href="{{ route('admin.packages.create') }}">Add package</a>
    </div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="table-responsive"><table class="table table-hover align-middle mb-0">
        <thead><tr><th>Package</th><th>Price / guest</th><th>Guest range</th><th>Featured</th><th class="text-end">Actions</th></tr></thead>
        <tbody>
        @forelse($packages as $package)
            <tr>
                <td><strong>{{ $package->name }}</strong><br><small class="text-muted">{{ str($package->description)->limit(65) }}</small></td>
                <td>PHP {{ number_format($package->price, 2) }}</td><td>{{ $package->min_guests }} to {{ $package->max_guests }}</td><td>{{ $package->is_featured ? 'Yes' : 'No' }}</td>
                <td class="text-end"><a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.packages.edit', $package) }}">Edit</a><form class="d-inline" method="POST" action="{{ route('admin.packages.destroy', $package) }}" onsubmit="return confirm('Delete this package?');">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No packages yet.</td></tr>
        @endforelse
        </tbody>
    </table></div>
</div>
@endsection
