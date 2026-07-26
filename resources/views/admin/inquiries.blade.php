@extends('layouts.admin')

@section('content')
<div class="content-card p-4">
    <h1 class="fw-bold mb-4">Inquiries</h1>
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr><th>Name</th><th>Subject</th><th>Category</th><th>Status</th></tr>
            </thead>
            <tbody>
                @forelse($inquiries as $inquiry)
                    <tr>
                        <td>{{ $inquiry->full_name }}</td>
                        <td>{{ $inquiry->subject }}</td>
                        <td>{{ $inquiry->category }}</td>
                        <td>{{ $inquiry->status }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4">No inquiries found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
