@extends('layouts.admin')

@section('content')
<div class="content-card p-4">
    <h1 class="fw-bold mb-4">Activity Logs</h1>
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr><th>Action</th><th>Date</th><th>Time</th><th>Description</th></tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->activity_date }}</td>
                        <td>{{ $log->activity_time }}</td>
                        <td>{{ $log->description }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4">No activity logs found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
