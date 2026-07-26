@extends('layouts.admin')

@section('content')
<div class="content-card p-4">
    <div class="mb-4">
        <h1 class="fw-bold mb-1">Team Admins</h1>
        <p class="text-muted mb-0">Create staff accounts for reservations and inquiries. These accounts cannot access reports, analytics, or activity logs.</p>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card p-4 h-100">
                <h5 class="fw-bold mb-3">Add team admin</h5>
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    <div class="mb-3"><label class="form-label" for="name">Name</label><input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label class="form-label" for="email">Email</label><input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label class="form-label" for="password">Password</label><input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required><div class="form-text">At least 8 characters.</div>@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-4"><label class="form-label" for="password_confirmation">Confirm password</label><input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required></div>
                    <button class="btn luxury-btn" type="submit">Create team admin</button>
                </form>
            </div>
        </div>
        <div class="col-lg-7"><div class="card p-4 h-100"><h5 class="fw-bold mb-3">Created team admins</h5><div class="table-responsive"><table class="table mb-0"><thead><tr><th>Name</th><th>Email</th><th>Access</th></tr></thead><tbody>@forelse($users as $user)<tr><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>Reservations and inquiries only</td></tr>@empty<tr><td colspan="3" class="text-muted text-center py-3">No team admins yet.</td></tr>@endforelse</tbody></table></div></div></div>
    </div>
</div>
@endsection
