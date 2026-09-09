@extends('layouts.admin')

@section('content')
<div class="content-card p-4">
    <h1 class="fw-bold mb-1">Backups</h1>
    <p class="text-muted mb-4">Create a downloadable snapshot of your catering data.</p>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <form method="POST" action="{{ route('admin.backups.create') }}" class="mb-3">@csrf<button class="btn btn-primary">Create Backup</button></form>
    <div class="card p-4">
        <div class="backup-list">
            @forelse($backups as $backup)
                <div class="backup-row">
                    <div><strong>{{ $backup }}</strong><small class="d-block text-muted">{{ number_format(filesize(storage_path('app/backups/' . $backup)) / 1024, 1) }} KB</small></div>
                    <div class="backup-actions">
                        <form method="POST" action="{{ route('admin.backups.download') }}">@csrf<input type="hidden" name="backup" value="{{ $backup }}"><button class="btn btn-sm btn-outline-secondary" type="submit">Download</button></form>
                        <form method="POST" action="{{ route('admin.backups.restore') }}" onsubmit="return confirm('Restore this backup? Current database data will be replaced.');">@csrf<input type="hidden" name="backup" value="{{ $backup }}"><button class="btn btn-sm btn-outline-danger" type="submit">Restore</button></form>
                        <form method="POST" action="{{ route('admin.backups.delete') }}" onsubmit="return confirm('Delete this backup permanently?');">@csrf @method('DELETE')<input type="hidden" name="backup" value="{{ $backup }}"><button class="btn btn-sm btn-outline-danger" type="submit">Delete</button></form>
                    </div>
                </div>
            @empty
                <p class="mb-0 text-muted">No backups found.</p>
            @endforelse
        </div>
    </div>
</div>
<style>.backup-list{display:grid;gap:.75rem}.backup-row{display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:.85rem 0;border-bottom:1px solid var(--line)}.backup-row:last-child{border-bottom:0}.backup-row strong{font-size:.85rem}.backup-actions{display:flex;gap:.5rem;flex-wrap:wrap}.backup-actions form{margin:0}@media(max-width:575px){.backup-row{align-items:flex-start;flex-direction:column}.backup-actions{width:100%}.backup-actions form,.backup-actions .btn{flex:1;width:100%}}</style>
@endsection
