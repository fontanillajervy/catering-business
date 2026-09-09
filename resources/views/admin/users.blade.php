@extends('layouts.admin')

@section('content')
<div class="content-card p-4">
    <div class="mb-4">
        <h1 class="fw-bold mb-1">Team Admins</h1>
        <p class="text-muted mb-0">Create staff accounts for reservations and inquiries. These accounts cannot access reports, analytics, or activity logs.</p>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

    <div class="row g-4">
        <div class="col-lg-12 col-xl-4">
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
        <div class="col-lg-12 col-xl-8">
            <div class="card p-4 h-100">
                <h5 class="fw-bold mb-3">Created team admins</h5>
                <div class="table-responsive">
                    <table class="table align-middle mb-0 team-admin-table">
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
                                        <div class="team-admin-access">
                                            <span class="badge-soft">Res. & Inquiries</span>
                                            <form method="POST" action="{{ route('admin.users.reset', $user) }}" class="team-admin-reset-form">
                                                @csrf
                                                @method('PUT')
                                                <input type="password" name="password" class="form-control form-control-sm" placeholder="New password" required minlength="8">
                                                <input type="password" name="password_confirmation" class="form-control form-control-sm" placeholder="Confirm" required minlength="8">
                                                <div class="d-grid">
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
    .team-admin-table { table-layout: fixed; min-width: 560px; }
    .team-admin-table th, .team-admin-table td { padding: .65rem .7rem; }
    .team-admin-table th:nth-child(1), .team-admin-table td:nth-child(1) { width: 20%; }
    .team-admin-table th:nth-child(2), .team-admin-table td:nth-child(2) { width: 27%; }
    .team-admin-table th:nth-child(3), .team-admin-table td:nth-child(3) { width: 53%; }
    .team-admin-table td { vertical-align: top; }
    .team-admin-table td:nth-child(2) { overflow-wrap: anywhere; }
    .team-admin-access { display: grid; gap: .45rem; }
    .team-admin-reset-form { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) auto; gap: .35rem; align-items: center; }
    .team-admin-reset-form .form-control { padding: .4rem .55rem; font-size: .78rem; }
    .team-admin-reset-form .btn { padding: .4rem .6rem; font-size: .78rem; }
    .team-admin-reset-form .form-control { min-width: 0; }
    .team-admin-reset-form .btn { white-space: nowrap; }
    @media(max-width:768px){
        .row.g-4{gap:1rem!important}
        .card{margin-bottom:1rem}
        .table-responsive{overflow-x:auto}
        .team-admin-table { min-width: 560px; }
    }
    @media(max-width:576px){
        .card{padding:.75rem!important}
        .card h5{font-size:.95rem}
        .form-label{font-size:.9rem}
        .form-control{font-size:.9rem}
    }
</style>
@endsection
