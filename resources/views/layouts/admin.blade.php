<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3YOS Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg: #f5efe8;
            --surface: #fffdf9;
            --surface-2: #f8ede3;
            --text: #1f2937;
            --muted: #6b7280;
            --accent: #8b5e3c;
            --accent-2: #c77f45;
            --border: rgba(139, 94, 60, 0.16);
        }
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: linear-gradient(135deg, #f7efe7 0%, #efe3d2 100%);
            color: var(--text);
        }
        .sidebar {
            background: linear-gradient(180deg, #121826 0%, #1f2937 100%);
        }
        .sidebar .nav-link {
            color: #e5e7eb;
            border-radius: 12px;
            padding: 0.8rem 0.9rem;
            margin-bottom: 0.35rem;
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.12);
            color: #fff;
        }
        .sidebar-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.12);
            font-size: 0.95rem;
        }
        .content-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 22px;
            box-shadow: 0 16px 40px rgba(0,0,0,0.06);
        }
        .stat-card {
            background: linear-gradient(135deg, var(--surface) 0%, var(--surface-2) 100%);
            border: 1px solid var(--border);
            border-radius: 18px;
            min-height: 140px;
        }
        .table thead {
            background: #f8ede3;
            color: var(--accent);
        }
        .table td, .table th {
            vertical-align: middle;
        }
        .badge-soft {
            background: rgba(139, 94, 60, 0.12);
            color: var(--accent);
            border-radius: 999px;
            padding: 0.35rem 0.7rem;
            font-weight: 700;
            font-size: 0.8rem;
        }
        .luxury-btn {
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #fff;
            border: none;
        }
        .header-bar {
            background: rgba(255,255,255,0.78);
            backdrop-filter: blur(12px);
        }
        .stat-card, .mini-card, .content-card, .table-responsive, .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }
        .stat-card:hover, .mini-card:hover, .content-card:hover, .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
        }
        body.dark-mode {
            background: linear-gradient(135deg, #0f172a 0%, #111827 100%);
            color: #f8fafc;
        }
        body.dark-mode .header-bar {
            background: rgba(17,24,39,0.9);
            color: #f8fafc;
        }
        body.dark-mode .content-card,
        body.dark-mode .stat-card,
        body.dark-mode .card {
            background: #1f2937;
            color: #f8fafc;
            border-color: rgba(255,255,255,0.08);
        }
        body.dark-mode .text-muted {
            color: #cbd5e1 !important;
        }
        body.dark-mode main :is(h1,h2,h3,h4,h5,h6,p,span,td,th,label,small) {
            color: inherit;
        }
        body.dark-mode main .text-muted { color: #cbd5e1 !important; }
        body.dark-mode .badge-soft { background:rgba(226, 175, 132, .18); color:#f5c69f; }
        body.dark-mode .mini-card,
        body.dark-mode [style*="background:#f8ede3"] { background:#293548 !important; color:#f8fafc; }
        body.dark-mode .table thead {
            background: #334155;
            color: #f8fafc;
        }
        body.dark-mode .sidebar {
            background: linear-gradient(180deg, #020617 0%, #0f172a 100%);
        }
        body.dark-mode .btn-outline-secondary {
            color: #f8fafc;
            border-color: #64748b;
        }
        body.dark-mode .table { --bs-table-color:#f8fafc; --bs-table-bg:transparent; --bs-table-hover-color:#fff; --bs-table-hover-bg:rgba(255,255,255,.06); --bs-table-striped-color:#f8fafc; --bs-table-striped-bg:rgba(255,255,255,.04); }
        body.dark-mode .form-control, body.dark-mode .form-select { background:#111827; color:#f8fafc; border-color:#475569; }
        body.dark-mode .form-control:focus, body.dark-mode .form-select:focus { background:#111827; color:#fff; }
        body.dark-mode .dropdown-menu { background:#1f2937; border-color:#475569; }
        body.dark-mode .dropdown-item { color:#f8fafc; }
        body.dark-mode .dropdown-item:hover { background:#334155; color:#fff; }
        body:not(.dark-mode) { background:linear-gradient(135deg,#f7efe7 0%,#efe3d2 100%); color:#1f2937; }
        body:not(.dark-mode) .content-card, body:not(.dark-mode) .stat-card, body:not(.dark-mode) .card { color:#1f2937; }
        body:not(.dark-mode) .table { --bs-table-color:#1f2937; --bs-table-bg:transparent; --bs-table-hover-color:#1f2937; --bs-table-hover-bg:rgba(139,94,60,.06); }
        body:not(.dark-mode) .form-control, body:not(.dark-mode) .form-select { color:#1f2937; background:#fff; }
        .table-responsive { -webkit-overflow-scrolling:touch; }
        @media (max-width: 991px) {
            .sidebar { position:fixed; inset:0 auto 0 0; z-index:1050; width:min(82vw,320px); min-height:100vh!important; overflow-y:auto; transform:translateX(-105%); transition:transform .22s ease; box-shadow:16px 0 34px rgba(0,0,0,.24); }
            body.mobile-admin-nav-open .sidebar { transform:translateX(0); }
            .admin-nav-backdrop { display:none; position:fixed; inset:0; z-index:1040; background:rgba(2,6,23,.55); }
            body.mobile-admin-nav-open .admin-nav-backdrop { display:block; }
            .sidebar > .p-4 { padding:1.4rem!important; }
            .sidebar nav { display:block; padding:1rem!important; }
            .sidebar .nav-link { margin-bottom:.35rem; padding:.75rem .8rem; }
            .sidebar-icon { width:28px; height:28px; }
            .header-bar { padding:1rem!important; }
        }
        @media (max-width: 575px) {
            body { overflow-x:hidden; }
            main > .p-4 { padding:1rem!important; }
            .content-card { border-radius:14px; }
            .btn { min-height:42px; display:inline-flex; align-items:center; justify-content:center; }
            .form-control,.form-select { min-height:44px; font-size:16px; }
            .admin-heading { width:100%; }
            .admin-heading h4 { font-size:1.05rem; }
            .admin-header-actions { display:grid!important; grid-template-columns:repeat(2,minmax(0,1fr)); width:100%; }
            .admin-header-actions > *, .admin-header-actions .btn { width:100%; min-width:0; }
            .admin-header-actions .dropdown-menu { max-width:calc(100vw - 2rem); }
        }
    </style>
</head>
<body>
<div class="admin-nav-backdrop" id="adminNavBackdrop"></div>
<div class="container-fluid">
    <div class="row min-vh-100">
        <aside class="col-lg-3 col-xl-2 sidebar text-white p-0">
            <div class="p-4 border-bottom border-secondary">
                <h4 class="fw-bold mb-1">3YOS Admin</h4>
                <p class="mb-0 small text-white-50">Luxury Operations Suite</p>
            </div>
            <nav class="p-3">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><span class="sidebar-icon">◉</span> Dashboard</a>
                <a class="nav-link {{ request()->routeIs('admin.reservations') ? 'active' : '' }}" href="{{ route('admin.reservations') }}"><span class="sidebar-icon">▣</span> Reservations</a>
                <a class="nav-link {{ request()->routeIs('admin.inquiries') ? 'active' : '' }}" href="{{ route('admin.inquiries') }}"><span class="sidebar-icon">✉</span> Inquiries</a>
                @if(session('admin_role') === 'full')
                <a class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}" href="{{ route('admin.users') }}"><span class="sidebar-icon">♙</span> Team Admins</a>
                <a class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}" href="{{ route('admin.reports') }}"><span class="sidebar-icon">◫</span> Reports</a>
                <a class="nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}" href="{{ route('admin.analytics') }}"><span class="sidebar-icon">⬢</span> Analytics</a>
                <a class="nav-link {{ request()->routeIs('admin.activity-logs') ? 'active' : '' }}" href="{{ route('admin.activity-logs') }}"><span class="sidebar-icon">⌁</span> Activity Logs</a>
                @endif
                <a class="nav-link {{ request()->routeIs('admin.backups') ? 'active' : '' }}" href="{{ route('admin.backups') }}"><span class="sidebar-icon">⬇</span> Backups</a>
            </nav>
        </aside>

        <main class="col-lg-9 col-xl-10 p-0">
            <header class="header-bar border-bottom p-3 px-4 d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-2">
                <div class="admin-heading d-flex align-items-center gap-2">
                    <button class="btn btn-outline-secondary d-lg-none" type="button" id="adminMobileMenu" aria-controls="adminSidebar" aria-expanded="false">☰ Menu</button>
                    <div>
                    <h4 class="fw-bold mb-1">Admin Panel</h4>
                    <p class="text-muted mb-0 small">Manage reservations, inquiries, reports, and activity logs</p>
                    </div>
                </div>
                <div class="admin-header-actions d-flex gap-2 flex-wrap align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">🔔 Notifications</button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">2 new reservations</a></li>
                            <li><a class="dropdown-item" href="#">1 new inquiry</a></li>
                            <li><a class="dropdown-item" href="#">Package update pending</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-outline-secondary btn-sm" id="themeToggle">🌙 Dark Mode</button>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">View Site</a>
                    <form method="POST" action="{{ route('admin.logout') }}">@csrf<button class="btn btn-outline-danger btn-sm">Logout</button></form>
                </div>
            </header>

            <div class="p-4">
                @yield('content')
            </div>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const mobileMenu = document.getElementById('adminMobileMenu');
    const navBackdrop = document.getElementById('adminNavBackdrop');
    const closeMobileMenu = () => { document.body.classList.remove('mobile-admin-nav-open'); mobileMenu?.setAttribute('aria-expanded', 'false'); };
    mobileMenu?.addEventListener('click', () => { const isOpen = document.body.classList.toggle('mobile-admin-nav-open'); mobileMenu.setAttribute('aria-expanded', String(isOpen)); });
    navBackdrop?.addEventListener('click', closeMobileMenu);
    document.querySelectorAll('.sidebar .nav-link').forEach(link => link.addEventListener('click', closeMobileMenu));
    const themeToggle = document.getElementById('themeToggle');
    const savedTheme = localStorage.getItem('admin-theme');
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-mode');
        themeToggle.textContent = '☀️ Light Mode';
    }
    themeToggle.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        const isDark = document.body.classList.contains('dark-mode');
        localStorage.setItem('admin-theme', isDark ? 'dark' : 'light');
        themeToggle.textContent = isDark ? '☀️ Light Mode' : '🌙 Dark Mode';
    });
</script>
</body>
</html>
