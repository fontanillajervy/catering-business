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
                    <div class="mb-3">
                        <label class="form-label" for="name">Name</label>
                        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        <div class="form-text">At least 8 characters.</div>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="password_confirmation">Confirm password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <button class="btn luxury-btn w-100" type="submit">Create team admin</button>
                </form>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card p-4 h-100">
                <h5 class="fw-bold mb-3">Created team admins</h5>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="d-none d-md-table-cell">Email</th>
                                <th class="d-none d-md-table-cell">Access</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $user->name }}</div>
                                        <small class="d-md-none text-muted">{{ $user->email }}</small>
                                    </td>
                                    <td class="d-none d-md-table-cell">{{ $user->email }}</td>
                                    <td class="d-none d-md-table-cell">
                                        <div class="d-flex flex-column gap-2">
                                            <span class="badge-soft">Res. & Inquiries</span>
                                            <form method="POST" action="{{ route('admin.users.reset', $user) }}" class="row g-2 align-items-center">
                                                @csrf
                                                @method('PUT')
                                                <div class="col-md-5">
                                                    <input type="password" name="password" class="form-control form-control-sm" placeholder="New password" required minlength="8">
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="password" name="password_confirmation" class="form-control form-control-sm" placeholder="Confirm" required minlength="8">
                                                </div>
                                                <div class="col-md-2 d-grid">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">Reset</button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-muted text-center py-3">No team admins yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .badge-soft {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: .35rem .7rem;
        font-size: .72rem;
        font-weight: 700;
        background: rgba(47, 170, 164, 0.12);
        color: #0d6efd;
    }
    @media(max-width:768px){
        .row.g-4{gap:1rem!important}
        .card{margin-bottom:1rem}
        .table-responsive{overflow-x:auto}
    }
    @media(max-width:576px){
        .card{padding:.75rem!important}
        .card h5{font-size:.95rem}
        .form-label{font-size:.9rem}
        .form-control{font-size:.9rem}
    }
</style>
@endsection
