@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="admin-card p-4 p-lg-5">
                <h1 class="fw-bold mb-2">Choose a new password</h1>
                <p class="text-muted">Use at least 8 characters.</p>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="mb-3"><label class="form-label" for="email">Email</label><input id="email" type="email" name="email" value="{{ old('email', $email) }}" class="form-control form-control-lg" required></div>
                    <div class="mb-3"><label class="form-label" for="password">New password</label><input id="password" type="password" name="password" class="form-control form-control-lg" required></div>
                    <div class="mb-3"><label class="form-label" for="password_confirmation">Confirm new password</label><input id="password_confirmation" type="password" name="password_confirmation" class="form-control form-control-lg" required></div>
                    <button class="btn btn-primary w-100 py-2" type="submit">Reset password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
