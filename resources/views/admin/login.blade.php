@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="admin-card p-4 p-lg-5">
                <div class="text-center mb-4">
                    <span class="hero-badge">Secure access</span>
                    <h1 class="fw-bold mt-3 mb-2">Admin Login</h1>
                    <p class="text-muted">Access the management dashboard securely.</p>
                </div>
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('admin.login.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control form-control-lg" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg" required>
                    </div>
                    <div class="text-end mb-3"><a href="{{ route('password.request') }}" class="small">Forgot password?</a></div>
                    <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
