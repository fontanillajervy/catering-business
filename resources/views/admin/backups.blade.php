@extends('layouts.admin')

@section('content')
<div class="content-card p-4">
    <h1 class="fw-bold mb-1">Backups</h1>
    <p class="text-muted mb-4">Create a downloadable snapshot of your catering data.</p>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <form method="POST" action="{{ route('admin.backups.create') }}" class="mb-3">@csrf<button class="btn btn-primary">Create Backup</button></form>
    <div class="card p-4">
        <ul class="mb-0">
            @forelse($backups as $backup)
                <li>{{ $backup }}</li>
            @empty
                <li>No backups found.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
