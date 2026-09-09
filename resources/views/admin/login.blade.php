@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .input-group .btn-outline-secondary {
        border-left: 0;
        padding: 0.76rem 0.85rem;
        font-size: 0.9rem;
        white-space: nowrap;
    }
    .input-group .form-control:focus ~ .btn-outline-secondary {
        border-color: #20201d;
    }
    @media (max-width: 576px) {
        .col-md-7 {
            padding: 0 1rem;
        }
    }
</style>
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
                        <div class="input-group">
                            <input type="password" id="password-login" name="password" class="form-control form-control-lg" required>
                            <button type="button" class="btn btn-outline-secondary" id="toggle-password-login" tabindex="-1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-end mb-3"><a href="{{ route('password.request') }}" class="small">Forgot password?</a></div>
                    <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
                </form>
                <script>
                    document.getElementById('toggle-password-login').addEventListener('click', function() {
                        const input = document.getElementById('password-login');
                        const icon = this.querySelector('i');
                        if (input.type === 'password') {
                            input.type = 'text';
                            icon.classList.remove('fa-eye');
                            icon.classList.add('fa-eye-slash');
                        } else {
                            input.type = 'password';
                            icon.classList.remove('fa-eye-slash');
                            icon.classList.add('fa-eye');
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
