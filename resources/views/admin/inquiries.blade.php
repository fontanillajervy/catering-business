@extends('layouts.admin')

@section('content')
<div class="content-card p-4">
    <div class="mb-4"><h1 class="fw-bold mb-1">Inquiries</h1><p class="text-muted mb-0">Track messages from prospective clients.</p></div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Client</th>
                    <th class="d-none d-md-table-cell">Inquiry</th>
                    <th class="d-none d-lg-table-cell">Message</th>
                    <th class="d-none d-sm-table-cell">Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($inquiries as $inquiry)
                    <tr>
                        <td>
                            <strong>{{ $inquiry->full_name }}</strong>
                            <br><small class="text-muted">{{ $inquiry->email }}</small>
                            <br><small class="text-muted d-md-none">{{ $inquiry->subject }}</small>
                        </td>
                        <td class="d-none d-md-table-cell">
                            {{ $inquiry->subject }}
                            <br><small class="text-muted">{{ $inquiry->category }}</small>
                        </td>
                        <td class="d-none d-lg-table-cell text-muted">{{ \Illuminate\Support\Str::limit($inquiry->message, 80) }}</td>
                        <td class="d-none d-sm-table-cell"><span class="badge-soft">{{ ucwords(str_replace('_', ' ', $inquiry->status)) }}</span></td>
                        <td>
                            <div class="d-flex flex-column flex-md-row gap-2">
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.inquiries.show', $inquiry) }}">View</a>
                                <form method="POST" action="{{ route('admin.inquiries.status', $inquiry) }}" class="d-flex gap-1">
                                    @csrf @method('PATCH')
                                    <select name="status" class="form-select form-select-sm" style="max-width:100px">
                                        <option value="new" @selected($inquiry->status === 'new')>New</option>
                                        <option value="in_progress" @selected($inquiry->status === 'in_progress')>In progress</option>
                                        <option value="responded" @selected($inquiry->status === 'responded')>Responded</option>
                                        <option value="closed" @selected($inquiry->status === 'closed')>Closed</option>
                                    </select>
                                    <button class="btn btn-sm luxury-btn">Save</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">No inquiries found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
@media(max-width:576px){
    .table td:last-child{display:flex;flex-direction:column;gap:.5rem}
    .table td:last-child form{flex-direction:column;width:100%}
    .table td:last-child select{width:100%}
    .table td:last-child button{width:100%}
    .table td:first-child{width:100%}
}
</style>
@endsection
