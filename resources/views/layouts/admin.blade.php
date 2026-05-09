<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') — Telkom Career Hub</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* Dashboard Specific Layout */
        :root {
            --sidebar-width: 280px;
        }

        .admin-shell {
            display: flex;
            min-height: 100vh;
            background: var(--bg);
        }

        .admin-sidebar {
            width: var(--sidebar-width);
            background: #111827; /* Deep professional dark */
            color: #94a3b8;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 100;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #fff;
            font-weight: 800;
            font-size: 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sidebar-nav {
            flex: 1;
            padding: 1.5rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: var(--radius-sm);
            color: #94a3b8;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .sidebar-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-link.active {
            color: #fff;
            background: var(--primary);
            box-shadow: 0 4px 12px rgba(238, 45, 36, 0.2);
        }

        .sidebar-link i, .sidebar-link svg {
            width: 18px;
            height: 18px;
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .admin-main {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .admin-topbar {
            height: 72px;
            background: var(--surface-glass);
            backdrop-filter: var(--glass-blur);
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .admin-content {
            padding: 2rem;
            flex: 1;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            color: var(--muted);
            margin-bottom: 1.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.025em;
            color: var(--text);
        }

        /* Stat Grid Improvements */
        .admin-stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            padding: 1.5rem;
        }

        .stat-icon {
            width: 54px;
            height: 54px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon i, .stat-icon svg {
            width: 24px;
            height: 24px;
        }

        .stat-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text);
            line-height: 1;
        }

        /* Table Improvements */
        .table-container {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .admin-table th {
            background: var(--bg);
            padding: 1rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--line);
        }

        .admin-table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--line);
            font-size: 0.875rem;
            vertical-align: middle;
        }

        .admin-table tr:last-child td {
            border-bottom: none;
        }

        .admin-table tr:hover td {
            background: rgba(248, 250, 252, 0.5);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .sidebar-toggle-btn {
            display: none;
            background: none;
            border: none;
            color: var(--text);
            cursor: pointer;
            padding: 0.5rem;
            margin-left: -0.5rem;
            border-radius: var(--radius-sm);
            align-items: center;
            justify-content: center;
        }
        .sidebar-toggle-btn:hover {
            background: rgba(0,0,0,0.05);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(17, 24, 39, 0.4);
            z-index: 90;
            backdrop-filter: blur(4px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        body.sidebar-expanded .sidebar-overlay {
            display: block;
            opacity: 1;
        }

        @media (max-width: 1024px) {
            .sidebar-toggle-btn {
                display: flex;
            }
            body:not(.sidebar-expanded) {
                --sidebar-width: 80px;
            }
            body:not(.sidebar-expanded) .sidebar-header span, 
            body:not(.sidebar-expanded) .sidebar-link span, 
            body:not(.sidebar-expanded) .sidebar-footer span, 
            body:not(.sidebar-expanded) .sidebar-header div:last-child {
                display: none;
            }
            body:not(.sidebar-expanded) .sidebar-header {
                justify-content: center;
                padding: 1.5rem 0;
            }
            body:not(.sidebar-expanded) .sidebar-link {
                justify-content: center;
                padding: 0.75rem;
            }
            body:not(.sidebar-expanded) .sidebar-nav {
                padding: 1.5rem 0.5rem;
            }
            body.sidebar-expanded {
                --sidebar-width: 280px;
            }
        }

        @media (max-width: 768px) {
            body:not(.sidebar-expanded) {
                --sidebar-width: 0px;
            }
            body:not(.sidebar-expanded) .admin-sidebar {
                transform: translateX(-100%);
            }
            body.sidebar-expanded {
                --sidebar-width: 0px; /* Don't push content */
            }
            body.sidebar-expanded .admin-sidebar {
                transform: translateX(0);
                width: 280px;
                box-shadow: 4px 0 24px rgba(0,0,0,0.2);
            }
        }
    </style>
    @yield('styles')
    @stack('styles')
</head>
<body>
    <div class="sidebar-overlay" onclick="document.body.classList.remove('sidebar-expanded')"></div>
    <div class="admin-shell">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <div style="background:var(--primary);color:white;width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:900">T</div>
                <span>Admin Hub</span>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.lowongan.index') }}" class="sidebar-link {{ request()->routeIs('admin.lowongan.*') ? 'active' : '' }}">
                    <i data-lucide="briefcase"></i> <span>Lowongan Kerja</span>
                </a>
                <a href="{{ route('admin.mitra.index') }}" class="sidebar-link {{ request()->routeIs('admin.mitra.*') ? 'active' : '' }}">
                    <i data-lucide="building-2"></i> <span>Mitra Industri</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i data-lucide="users"></i> <span>Management User</span>
                </a>
                <a href="{{ route('admin.ppdb.index') }}" class="sidebar-link {{ request()->routeIs('admin.ppdb.*') ? 'active' : '' }}">
                    <i data-lucide="graduation-cap"></i> <span>Info PPDB</span>
                </a>
                <a href="{{ route('admin.crawl.index') }}" class="sidebar-link {{ request()->routeIs('admin.crawl.*') ? 'active' : '' }}">
                    <i data-lucide="search"></i> <span>Web Crawler</span>
                </a>
                
                <div style="margin-top: 2rem; padding: 0 1rem; font-size: 0.7rem; font-weight: 700; color: rgba(255,255,255,0.2); text-transform: uppercase; letter-spacing: 0.1em;">Sistem</div>
                
                <a href="#" class="sidebar-link">
                    <i data-lucide="settings"></i> <span>Pengaturan</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-link" style="width: 100%; background: none; border: none; cursor: pointer; text-align: left;">
                        <i data-lucide="log-out"></i> <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Topbar -->
            <header class="admin-topbar">
                <div class="topbar-left" style="display: flex; align-items: center; gap: 1rem;">
                    <button class="sidebar-toggle-btn" onclick="document.body.classList.toggle('sidebar-expanded')">
                        <i data-lucide="menu"></i>
                    </button>
                    <div style="font-weight: 600; color: var(--muted); font-size: 0.875rem">Panel Administrasi</div>
                </div>
                
                <div class="topbar-right" style="display: flex; align-items: center; gap: 1.5rem;">
                    <div style="position: relative; cursor: pointer;">
                        <i data-lucide="bell" style="width: 20px; height: 20px; color: var(--muted);"></i>
                        <span style="position: absolute; top: -2px; right: -2px; width: 8px; height: 8px; background: var(--primary); border-radius: 50%; border: 2px solid #fff;"></span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem; padding-left: 1.5rem; border-left: 1px solid var(--line);">
                        <div style="text-align: right;">
                            <div style="font-size: 0.875rem; font-weight: 700; color: var(--text)">{{ Auth::user()->name ?? 'Admin' }}</div>
                            <div style="font-size: 0.75rem; color: var(--muted)">Administrator</div>
                        </div>
                        <div style="width: 40px; height: 40px; border-radius: 12px; background: var(--primary-light); display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--primary)">
                            {{ substr(Auth::user()->name ?? 'AD', 0, 2) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
    @yield('scripts')
    @stack('scripts')
</body>
</html>
