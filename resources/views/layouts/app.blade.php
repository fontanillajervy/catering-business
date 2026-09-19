<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '3YOS Catering | Exceptional celebrations')</title>
    <link rel="icon" type="image/png" href="{{ request()->getBaseUrl() }}/images/logo-transparent.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--ink:#20201d;--muted:#6f6d66;--cream:#f8f6f1;--paper:#fffdf9;--wine:#6d3024;--terracotta:#b66545;--gold:#c7984b;--line:#e7e1d7}
        *{box-sizing:border-box}
        body{font-family:'DM Sans',sans-serif;color:var(--ink);background:var(--cream)}
        h1,h2,h3,h4,h5,.display-font{font-family:'Playfair Display',Georgia,serif}
        a{text-decoration:none}
        .navbar{background:rgba(255,253,249,.94)!important;border-bottom:1px solid rgba(32,32,29,.07);backdrop-filter:blur(14px)}
        .navbar-brand{color:var(--wine)!important;font-family:'Playfair Display',Georgia,serif;font-size:1.4rem;font-weight:800;letter-spacing:.02em}
        .nav-link{color:var(--ink)!important;font-size:.9rem;font-weight:600;padding:.8rem .85rem!important}
        .nav-link:hover,.nav-link.active{color:var(--terracotta)!important}
        .btn{border-radius:999px;font-weight:700;font-size:.88rem;letter-spacing:.02em;padding:.76rem 1.35rem;transition:.2s ease}
        .btn-primary{background:var(--wine);border-color:var(--wine)}
        .btn-primary:hover,.btn-primary:focus{background:#512218;border-color:#512218;transform:translateY(-2px)}
        .btn-outline-primary{color:var(--wine);border-color:var(--wine)}
        .btn-outline-primary:hover{background:var(--wine);border-color:var(--wine)}
        .eyebrow{color:var(--terracotta);font-size:.75rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase}
        .theme-toggle{border:1px solid var(--line);background:transparent;color:var(--ink);padding:.48rem .7rem;font-size:.78rem;font-weight:700;border-radius:999px}
        .footer{margin-top:3rem;background:#211b18;color:#f6f0e8;padding-top:2rem;padding-bottom:1.25rem}
        .footer a{color:#f6f0e8;text-decoration:none}
        .footer a:hover{color:#e7b77a}
        .footer-title{font-family:'Playfair Display',Georgia,serif;font-size:1.55rem}
        .footer-kicker{color:#d9a45f;font-size:.68rem;font-weight:800;letter-spacing:.15em;text-transform:uppercase}
        .footer-heading{color:#fffaf3;font-size:.76rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase}
        .footer-links{display:grid;gap:.58rem;font-size:.9rem}
        .footer-contact{display:flex;align-items:center;gap:.7rem;padding:.78rem 0;border-top:1px solid rgba(255,255,255,.12)}
        .footer-contact-icon{display:grid;place-items:center;flex:0 0 30px;width:30px;height:30px;border:1px solid rgba(231,183,122,.45);border-radius:50%;color:#e7b77a;font-size:.68rem;font-weight:800}
        .footer-contact small{display:block;color:#c8bdb3;font-size:.7rem;letter-spacing:.04em;text-transform:uppercase}
        .footer-facebook{display:inline-flex;align-items:center;gap:.6rem;padding:.7rem .9rem;border:1px solid rgba(231,183,122,.6);color:#fff8ef!important;font-size:.82rem;font-weight:700;transition:.2s ease;border-radius:999px}
        .footer-facebook:hover{background:#b66545;border-color:#b66545;color:#fff!important;transform:translateY(-2px)}
        body.dark-mode{--ink:#f5f1e9;--muted:#c9c3b9;--cream:#151515;--paper:#201f1d;--line:#575148;--wine:#e6ad92;--terracotta:#edb18f;--gold:#e7bd72;background:var(--cream);color:var(--ink)}
        body.dark-mode .navbar{background:rgba(27,26,24,.95)!important;border-color:#403c35}
        body.dark-mode .navbar-brand,body.dark-mode .nav-link,body.dark-mode .theme-toggle{color:#f5f1e9!important}
        body.dark-mode .form-card,body.dark-mode .service-tile,body.dark-mode .process-card,body.dark-mode .cta-panel,body.dark-mode .occasion-panel{background:#201f1d!important;color:#f5f1e9}
        body.dark-mode .form-control,body.dark-mode .form-select{background:#151515;border-color:#555047;color:#f5f1e9}
        body.dark-mode .text-muted{color:var(--muted)!important}
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top py-2">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ request()->getBaseUrl() }}/images/logo-transparent.png" alt="3YOS Catering Services" style="height:48px;width:auto;object-fit:contain;border-radius:50%;background:transparent">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}">Services</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('packages*') ? 'active' : '' }}" href="{{ route('packages') }}">Packages</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}" href="{{ route('gallery') }}">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('reservation.status') ? 'active' : '' }}" href="{{ route('reservation.status') }}">Status</a></li>
                    <li class="nav-item ms-lg-2"><button type="button" class="theme-toggle" id="customerThemeToggle" aria-label="Enable dark mode" title="Enable dark mode"><span aria-hidden="true">&#9790;</span></button></li>
                    <li class="nav-item ms-lg-2"><a class="btn btn-primary" href="{{ route('reservation') }}">Book an event</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main>@yield('content')</main>

    <footer class="footer">
        <div class="container">
            <div class="row g-5 pb-5">
                <div class="col-lg-4">
                    <div class="footer-kicker mb-2">Catering & party needs</div>
                    <div class="footer-title">3YOS Catering</div>
                    <p class="text-white-50 mt-3 mb-0">Thoughtful food, graceful styling, and dependable service for celebrations that deserve to feel effortless.</p>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="footer-heading mb-3">Explore</div>
                    <div class="footer-links">
                        <a href="{{ route('home') }}">Home</a>
                        <a href="{{ route('services') }}">Services</a>
                        <a href="{{ route('packages') }}">Packages</a>
                        <a href="{{ route('reservation') }}">Book now</a>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="footer-heading mb-3">Get in touch</div>
                    <div class="footer-contact">
                        <span class="footer-contact-icon">FB</span>
                        <div>
                            <small>Facebook</small>
                            <a href="https://www.facebook.com/profile.php?id=100063690915629" target="_blank" rel="noopener noreferrer">Message 3YOS Catering</a>
                        </div>
                    </div>
                    <div class="footer-contact">
                        <span class="footer-contact-icon">IN</span>
                        <div>
                            <small>Inquiry</small>
                            <a href="{{ route('inquiry') }}">Tell us about your event</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="footer-heading mb-3">Start planning</div>
                    <p class="text-white-50 small mb-3">Share your date, venue, guest count, and celebration vision. We’ll help you build the right package.</p>
                    <a href="{{ route('reservation') }}" class="footer-facebook">Book an event <span>→</span></a>
                </div>
            </div>
            <div class="border-top border-secondary pt-4 d-flex flex-column flex-md-row justify-content-between gap-2 small text-white-50">
                <span>&copy; {{ date('Y') }} 3YOS Catering Services & Party Needs. All rights reserved.</span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (() => {
            const button = document.getElementById('customerThemeToggle');
            if (!button) return;
            const applyTheme = (dark) => {
                document.body.classList.toggle('dark-mode', dark);
                button.innerHTML = dark ? '&#9788;' : '&#9790;';
                button.setAttribute('aria-label', dark ? 'Enable light mode' : 'Enable dark mode');
                button.setAttribute('title', dark ? 'Enable light mode' : 'Enable dark mode');
                button.setAttribute('aria-pressed', String(dark));
            };
            applyTheme(localStorage.getItem('customer-theme') === 'dark');
            button.addEventListener('click', () => {
                const dark = !document.body.classList.contains('dark-mode');
                localStorage.setItem('customer-theme', dark ? 'dark' : 'light');
                applyTheme(dark);
            });
        })();
    </script>
</body>
</html>
