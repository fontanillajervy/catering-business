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
    </style>
</head>
<body>
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
                <a class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}" href="{{ route('admin.reports') }}"><span class="sidebar-icon">◫</span> Reports</a>
                <a class="nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}" href="{{ route('admin.analytics') }}"><span class="sidebar-icon">⬢</span> Analytics</a>
                <a class="nav-link {{ request()->routeIs('admin.activity-logs') ? 'active' : '' }}" href="{{ route('admin.activity-logs') }}"><span class="sidebar-icon">⌁</span> Activity Logs</a>
                <a class="nav-link {{ request()->routeIs('admin.backups') ? 'active' : '' }}" href="{{ route('admin.backups') }}"><span class="sidebar-icon">⬇</span> Backups</a>
            </nav>
        </aside>

        <main class="col-lg-9 col-xl-10 p-0">
            <header class="header-bar border-bottom p-3 px-4 d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-2">
                <div>
                    <h4 class="fw-bold mb-1">Admin Panel</h4>
                    <p class="text-muted mb-0 small">Manage reservations, inquiries, reports, and activity logs</p>
                </div>
                <div class="d-flex gap-2 flex-wrap align-items-center">
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
