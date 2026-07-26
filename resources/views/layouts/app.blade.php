<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '3YOS Catering | Exceptional celebrations')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --ink:#20201d; --muted:#6f6d66; --cream:#f8f6f1; --paper:#fffdf9; --wine:#6d3024; --terracotta:#b66545; --gold:#c7984b; --line:#e7e1d7; }
        * { box-sizing: border-box; }
        body { font-family:'DM Sans',sans-serif; color:var(--ink); background:var(--cream); }
        h1,h2,h3,h4,h5,.display-font { font-family:'Playfair Display',Georgia,serif; }
        .navbar { background:rgba(255,253,249,.94)!important; border-bottom:1px solid rgba(32,32,29,.07); backdrop-filter:blur(14px); }
        .navbar-brand { color:var(--wine)!important; font-family:'Playfair Display',Georgia,serif; font-size:1.4rem; font-weight:800; letter-spacing:.02em; }
        .brand-mark { display:inline-grid; place-items:center; width:30px; height:30px; margin-right:.45rem; border-radius:50%; color:#fff; background:var(--wine); font-family:'DM Sans',sans-serif; font-size:.76rem; letter-spacing:-.08em; vertical-align:2px; }
        .nav-link { color:var(--ink)!important; font-size:.9rem; font-weight:600; padding:.8rem .85rem!important; }
        .nav-link:hover,.nav-link.active { color:var(--terracotta)!important; }
        .btn { border-radius:0; font-weight:700; font-size:.88rem; letter-spacing:.02em; padding:.76rem 1.35rem; transition:.2s ease; }
        .btn-primary { background:var(--wine); border-color:var(--wine); }
        .btn-primary:hover,.btn-primary:focus { background:#512218; border-color:#512218; transform:translateY(-2px); }
        .btn-outline-primary { color:var(--wine); border-color:var(--wine); }
        .btn-outline-primary:hover { background:var(--wine); border-color:var(--wine); }
        .eyebrow { color:var(--terracotta); font-size:.75rem; font-weight:800; letter-spacing:.16em; text-transform:uppercase; }
        .page-heading { max-width:700px; margin:1.5rem auto 2.5rem; text-align:center; }
        .page-heading h1 { font-size:clamp(2.15rem,4vw,3.45rem); }
        .page-heading p { color:var(--muted); font-size:1.05rem; }
        .soft-card,.card,.form-card,.section-card { background:var(--paper); border:1px solid var(--line)!important; border-radius:0!important; box-shadow:none!important; }
        .soft-card,.card { transition:transform .2s ease,box-shadow .2s ease; }
        .soft-card:hover,.card:hover { transform:translateY(-4px); box-shadow:0 14px 28px rgba(54,39,26,.08)!important; }
        .feature-icon { display:inline-grid; place-items:center; width:32px; height:32px; color:var(--wine); background:#f0e4d6; border-radius:50%; font-size:.9rem; font-weight:800; }
        .form-card { padding:clamp(1.5rem,4vw,3.25rem)!important; }
        .form-control,.form-select { border:1px solid #dcd4c8; border-radius:0; padding:.78rem .9rem; }
        .form-control:focus,.form-select:focus { border-color:var(--terracotta); box-shadow:0 0 0 .2rem rgba(182,101,69,.13); }
        .form-label { font-weight:700; font-size:.88rem; }
        .footer { margin-top:5rem; background:#25231f; color:#f6f0e8; }
        .footer a { color:#f6f0e8; text-decoration:none; }
        .footer a:hover { color:#e7b77a; }
        .footer-title { font-family:'Playfair Display',Georgia,serif; font-size:1.35rem; }
        .text-muted { color:var(--muted)!important; }
        .theme-toggle { border:1px solid var(--line); background:transparent; color:var(--ink); padding:.48rem .7rem; font-size:.78rem; font-weight:700; }
        body.dark-mode { --ink:#f5f1e9; --muted:#c9c3b9; --cream:#151515; --paper:#201f1d; --line:#575148; --wine:#e6ad92; --terracotta:#edb18f; --gold:#e7bd72; background:var(--cream); color:var(--ink); }
        body.dark-mode .navbar { background:rgba(27,26,24,.95)!important; border-color:#403c35; }
        body.dark-mode .navbar-brand,body.dark-mode .nav-link,body.dark-mode .theme-toggle { color:#f5f1e9!important; }
        body.dark-mode .soft-card,body.dark-mode .card,body.dark-mode .form-card,body.dark-mode .section-card { background:#201f1d!important; color:#f5f1e9; }
        body.dark-mode .form-control,body.dark-mode .form-select { background:#151515; border-color:#555047; color:#f5f1e9; }
        body.dark-mode .form-control:focus,body.dark-mode .form-select:focus { background:#151515; color:#fff; }
        body.dark-mode .hero { background:linear-gradient(115deg,#251e19,#171615 60%,#33251f)!important; }
        body.dark-mode .bg-paper { background:#201f1d!important; }
        body.dark-mode .occasion-panel { background:#302820!important; }
        body.dark-mode .text-muted { color:var(--muted)!important; }
        body.dark-mode main :is(h1,h2,h3,h4,h5,h6,p,li,dt,dd,label,legend,td,th) { color:inherit; }
        body.dark-mode main .text-muted { color:var(--muted)!important; }
        body.dark-mode main .btn-primary { color:#fff; }
        body.dark-mode main .btn-outline-primary { color:var(--wine); border-color:var(--wine); }
        body.dark-mode main .btn-outline-primary:hover { color:#201510; background:var(--wine); }
        body.dark-mode .navbar-toggler { border-color:var(--line); }
        body.dark-mode .navbar-toggler-icon { filter:invert(1); }
        .table-responsive { -webkit-overflow-scrolling:touch; }
        @media (max-width:991px) { .navbar-collapse { padding:.8rem 0; } .navbar-nav { align-items:stretch!important; } .nav-link { padding:.7rem 0!important; } .theme-toggle { width:100%; min-height:44px; text-align:left; } .navbar .btn { width:100%; } }
        @media (max-width:575px) { body { overflow-x:hidden; } .container { padding-left:1rem; padding-right:1rem; } .page-heading { margin:1rem auto 2rem; } .page-heading h1 { font-size:2.2rem; } .btn { min-height:44px; display:inline-flex; align-items:center; justify-content:center; } .form-control,.form-select { min-height:46px; font-size:16px; } .footer { margin-top:3rem; } }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top py-2">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}"><span class="brand-mark">3Y</span>3YOS Catering</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}">Services</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('packages*') ? 'active' : '' }}" href="{{ route('packages') }}">Packages</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('gallery') }}">Gallery</a></li>
                <li class="nav-item ms-lg-2"><button type="button" class="theme-toggle" id="customerThemeToggle" aria-pressed="false">Dark mode</button></li>
                <li class="nav-item ms-lg-2"><a class="btn btn-primary" href="{{ route('reservation') }}">Book an event</a></li>
            </ul>
        </div>
    </div>
</nav>
<main>@yield('content')</main>
<footer class="footer pt-5 pb-4">
    <div class="container">
        <div class="row g-4 pb-4">
            <div class="col-lg-5"><div class="footer-title">3YOS Catering</div><p class="text-white-50 mt-2 mb-0">Thoughtful food, graceful styling, and dependable service for celebrations that deserve to feel effortless.</p></div>
            <div class="col-6 col-lg-3"><div class="fw-bold mb-2">Explore</div><div class="d-grid gap-1"><a href="{{ route('services') }}">Services</a><a href="{{ route('packages') }}">Packages</a><a href="{{ route('gallery') }}">Gallery</a></div></div>
            <div class="col-6 col-lg-4"><div class="fw-bold mb-2">Let’s plan together</div><p class="text-white-50 small mb-3">Tell us about your date, venue, and vision.</p><a href="{{ route('inquiry') }}" class="btn btn-outline-light">Send an inquiry</a></div>
        </div>
        <div class="border-top border-secondary pt-3 small text-white-50">&copy; {{ date('Y') }} 3YOS Catering Services & Party Needs. All rights reserved.</div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
(() => { const button = document.getElementById('customerThemeToggle'); if (!button) return; const applyTheme = (dark) => { document.body.classList.toggle('dark-mode', dark); button.textContent = dark ? 'Light mode' : 'Dark mode'; button.setAttribute('aria-pressed', String(dark)); }; applyTheme(localStorage.getItem('customer-theme') === 'dark'); button.addEventListener('click', () => { const dark = !document.body.classList.contains('dark-mode'); localStorage.setItem('customer-theme', dark ? 'dark' : 'light'); applyTheme(dark); }); })();
</script>
</body>
</html>
