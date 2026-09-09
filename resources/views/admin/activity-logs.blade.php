@extends('layouts.admin')

@section('content')
<div class="content-card">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
        <div>
            <div class="page-kicker mb-1">Security audit</div>
            <h1 class="fw-bold mb-1">Activity logs</h1>
            <p class="text-muted mb-0">Track which administrator accessed the panel and the actions they performed.</p>
        </div>
        <span class="badge-soft">{{ $logs->total() }} records</span>
    </div>
    
    <form class="row g-2 p-3 mb-4 audit-filter" method="GET">
        <div class="col-md-5 col-12">
            <label class="visually-hidden" for="actor">Administrator</label>
            <select id="actor" name="actor" class="form-select">
                <option value="">All administrators</option>
                @foreach($actors as $actor)
                    <option value="{{ $actor->actor_email }}" @selected(request('actor') === $actor->actor_email)>{{ $actor->actor_name }} — {{ $actor->actor_email }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-5 col-12">
            <label class="visually-hidden" for="action">Action</label>
            <input id="action" name="action" class="form-control" value="{{ request('action') }}" placeholder="Search actions, e.g. signed in or updated">
        </div>
        <div class="col-md-2 col-12">
            <button class="btn luxury-btn w-100">Filter logs</button>
        </div>
    </form>
    
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Administrator</th>
                    <th class="d-none d-md-table-cell">Action</th>
                    <th class="d-none d-lg-table-cell">When</th>
                    <th class="d-none d-xl-table-cell">Source</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>
                            <div class="actor-avatar">{{ str($log->actor_name ?: 'U')->substr(0, 1)->upper() }}</div>
                            <div class="d-inline-block align-middle ms-2">
                                <strong>{{ $log->actor_name ?: 'Unknown administrator' }}</strong>
                                <br><small class="text-muted">{{ $log->actor_email ?: 'Old log entry' }}</small>
                                <br><small class="d-md-none text-muted">{{ $log->action }}</small>
                            </div>
                        </td>
                        <td class="d-none d-md-table-cell">
                            <strong>{{ $log->action }}</strong>
                            <br><small class="text-muted">{{ $log->description }}</small>
                        </td>
                        <td class="d-none d-lg-table-cell">
                            <strong>{{ $log->created_at?->format('M j, Y') ?? $log->activity_date }}</strong>
                            <br><small class="text-muted">{{ $log->created_at?->format('g:i A') ?? $log->activity_time }}</small>
                        </td>
                        <td class="d-none d-xl-table-cell">
                            <span class="method-label">{{ $log->method ?? 'LEGACY' }}</span>
                            <br><small class="text-muted">{{ $log->ip_address ?: 'Not recorded' }}</small>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-5">No activity logs match these filters.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())<div class="mt-4">{{ $logs->links() }}</div>@endif
</div>

<style>
@media(max-width:576px){
    .audit-filter{padding:.75rem!important}
    .audit-filter .col-12{margin-bottom:.5rem}
}
.audit-filter{background:#f7fafb;border:1px solid var(--line);border-radius:11px}
.actor-avatar{display:inline-grid;place-items:center;width:34px;height:34px;border-radius:50%;background:var(--mint);color:var(--teal-dark);font-size:.78rem;font-weight:800}
.method-label{display:inline-block;padding:.2rem .42rem;border:1px solid var(--line);border-radius:5px;color:var(--muted);font-size:.63rem;font-weight:800;letter-spacing:.06em}
body.dark-mode .audit-filter{background:#1d3343}
</style>
@endsection
