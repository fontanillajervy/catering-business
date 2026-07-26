<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3YOS Catering</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg: #f7f1e8;
            --surface: #ffffff;
            --surface-2: #fffaf3;
            --text: #1f2937;
            --muted: #6b7280;
            --accent: #8b5e3c;
            --accent-2: #c77f45;
            --border: rgba(139, 94, 60, 0.16);
        }
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: linear-gradient(135deg, var(--bg), #efe2d0);
            color: var(--text);
        }
        .navbar {
            background: rgba(255,255,255,0.95) !important;
            backdrop-filter: blur(12px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        }
        .navbar-brand {
            font-weight: 800;
            letter-spacing: 0.04em;
            color: var(--accent) !important;
        }
        .nav-link {
            color: var(--text) !important;
            font-weight: 600;
        }
        .hero-section, .section-card, .form-card, .admin-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 24px;
            box-shadow: 0 16px 45px rgba(0,0,0,0.07);
        }
        .hero-section {
            background: linear-gradient(135deg, #fff7ed 0%, #fffdf9 100%);
        }
        .hero-badge {
            display: inline-block;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: rgba(139, 94, 60, 0.1);
            color: var(--accent);
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            border: none;
            box-shadow: 0 8px 20px rgba(139, 94, 60, 0.22);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
        }
        .soft-card {
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: 18px;
        }
        .text-muted { color: var(--muted) !important; }
        .footer {
            background: #1d232e;
            color: #f9fafb;
        }
        .form-control, .form-select {
            border-radius: 12px;
            border: 1px solid rgba(139, 94, 60, 0.2);
            padding: 0.8rem 0.9rem;
        }
        .form-label {
            font-weight: 600;
            color: var(--text);
        }
        .feature-icon {
            width: 48px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: rgba(139, 94, 60, 0.12);
            color: var(--accent);
            font-size: 1.2rem;
            font-weight: 700;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">3YOS Catering</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('services') }}">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('packages') }}">Packages</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('reservation') }}">Reservation</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('inquiry') }}">Inquiry</a></li>
            </ul>
        </div>
    </div>
</nav>
<main class="py-4 py-lg-5">
    @yield('content')
</main>
<footer class="footer py-4 mt-5">
    <div class="container text-center text-lg-start">
        <div class="row align-items-center g-3">
            <div class="col-lg-8">
                <h5 class="mb-1">3YOS Catering Services & Party Needs</h5>
                <p class="mb-0 text-white-50">Elegant events, curated menus, and seamless service for every occasion.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('reservation') }}" class="btn btn-outline-light">Plan Your Event</a>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
