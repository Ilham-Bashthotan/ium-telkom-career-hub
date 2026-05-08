<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') — Telkom Career Hub</title>
    <link rel="stylesheet" href="{{ asset('docs/wireframe/styles.css') }}">
    <!-- We should probably move the CSS to a proper place later, but for now we use the one from wireframe as requested to "continue" from it -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* Premium Admin-specific adjustments */
        :root {
            --sidebar-width: 280px;
            --sidebar-bg: #1e293b;
            --sidebar-text: #94a3b8;
            --sidebar-active: #ffffff;
            --sidebar-active-bg: rgba(255, 255, 255, 0.1);
        }

        .admin-shell {
            display: flex;
            min-height: 100vh;
            background: #f1f5f9;
        }

        .admin-sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
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
            padding: 2rem;
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
            border-radius: 8px;
            color: var(--sidebar-text);
            font-weight: 500;
            font-size: 0.9375rem;
            transition: all 0.2s ease;
        }

        .sidebar-link:hover {
            color: #fff;
            background: var(--sidebar-active-bg);
        }

        .sidebar-link.active {
            color: #fff;
            background: var(--primary);
            box-shadow: 0 4px 12px rgba(238, 45, 36, 0.3);
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
            background: #fff;
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
        }

        .breadcrumb {
            display: flex;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--muted);
            margin-bottom: 1.5rem;
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
            letter-spacing: -0.02em;
        }

        /* Stat Grid Improvements */
        .admin-stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card-premium {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card-premium:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .stat-info .label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 0.25rem;
        }

        .stat-info .value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text);
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
    </style>
    @yield('styles')
</head>
<body>
    <div class="admin-shell">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <div style="width: 32px; height: 32px; background: var(--primary); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="shield" style="width: 20px; height: 20px; color: #fff;"></i>
                </div>
                <span>TCH Admin</span>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard"></i> Dashboard
                </a>
                <a href="{{ route('admin.lowongan.index') }}" class="sidebar-link {{ request()->routeIs('admin.lowongan.*') ? 'active' : '' }}">
                    <i data-lucide="briefcase"></i> Lowongan Kerja
                </a>
                <a href="{{ route('admin.mitra.index') }}" class="sidebar-link {{ request()->routeIs('admin.mitra.*') ? 'active' : '' }}">
                    <i data-lucide="building-2"></i> Mitra Industri
                </a>
                <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i data-lucide="users"></i> Management User
                </a>
                <a href="{{ route('admin.ppdb.index') }}" class="sidebar-link {{ request()->routeIs('admin.ppdb.*') ? 'active' : '' }}">
                    <i data-lucide="graduation-cap"></i> Info PPDB
                </a>
                <a href="{{ route('admin.crawl.index') }}" class="sidebar-link {{ request()->routeIs('admin.crawl.*') ? 'active' : '' }}">
                    <i data-lucide="search"></i> Web Crawler
                </a>
                
                <div style="margin-top: 2rem; padding: 0 1rem; font-size: 0.75rem; font-weight: 700; color: rgba(255,255,255,0.3); text-transform: uppercase; letter-spacing: 0.05em;">Sistem</div>
                
                <a href="#" class="sidebar-link">
                    <i data-lucide="settings"></i> Pengaturan
                </a>
            </nav>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-link" style="width: 100%; background: none; border: none; cursor: pointer; text-align: left;">
                        <i data-lucide="log-out"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Topbar -->
            <header class="admin-topbar">
                <div class="topbar-left">
                    <button id="sidebar-toggle" style="background: none; border: none; cursor: pointer; color: var(--muted); display: none;">
                        <i data-lucide="menu"></i>
                    </button>
                    <div style="font-weight: 600; color: var(--muted)">Selamat datang, Admin</div>
                </div>
                
                <div class="topbar-right" style="display: flex; align-items: center; gap: 1.5rem;">
                    <div style="position: relative;">
                        <i data-lucide="bell" style="width: 20px; height: 20px; color: var(--muted); cursor: pointer;"></i>
                        <span style="position: absolute; top: -2px; right: -2px; width: 8px; height: 8px; background: var(--primary); border-radius: 50%; border: 2px solid #fff;"></span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="text-align: right;">
                            <div style="font-size: 0.875rem; font-weight: 700;">Ilham Bashthotan</div>
                            <div style="font-size: 0.75rem; color: var(--muted)">Super Admin</div>
                        </div>
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--secondary)">
                            IB
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
</body>
</html>
