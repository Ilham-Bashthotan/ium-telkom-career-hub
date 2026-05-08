@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <span>/</span>
    <span style="color: var(--text); font-weight: 600;">Dashboard</span>
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard Overview</h1>
        <p style="color: var(--muted); margin-top: 0.25rem;">Pantau statistik dan aktivitas terbaru sistem.</p>
    </div>
    <div style="display: flex; gap: 1rem;">
        <button class="btn">
            <i data-lucide="download" style="width: 16px; height: 16px"></i> Unduh Laporan
        </button>
        <a href="{{ route('admin.lowongan.create') }}" class="btn btn-primary">
            <i data-lucide="plus" style="width: 16px; height: 16px"></i> Lowongan Baru
        </a>
    </div>
</div>

<div class="admin-stat-grid">
    <div class="stat-card-premium">
        <div class="stat-card-icon" style="background: #eff6ff; color: #3b82f6;">
            <i data-lucide="briefcase"></i>
        </div>
        <div class="stat-info">
            <div class="label">Total Lowongan Aktif</div>
            <div class="value">{{ $activeLowongan }}</div>
            <div style="font-size: 0.75rem; color: #10b981; font-weight: 700; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.25rem;">
                <i data-lucide="trending-up" style="width: 12px; height: 12px"></i> +12% dari bulan lalu
            </div>
        </div>
    </div>

    <div class="stat-card-premium">
        <div class="stat-card-icon" style="background: #fdf2f8; color: #db2777;">
            <i data-lucide="users"></i>
        </div>
        <div class="stat-info">
            <div class="label">User Terdaftar</div>
            <div class="value">{{ $totalUsers }}</div>
            <div style="font-size: 0.75rem; color: #10b981; font-weight: 700; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.25rem;">
                <i data-lucide="trending-up" style="width: 12px; height: 12px"></i> +5.4% dari bulan lalu
            </div>
        </div>
    </div>

    <div class="stat-card-premium">
        <div class="stat-card-icon" style="background: #fff7ed; color: #ea580c;">
            <i data-lucide="building-2"></i>
        </div>
        <div class="stat-info">
            <div class="label">Mitra Industri</div>
            <div class="value">{{ $totalMitra }}</div>
            <div style="font-size: 0.75rem; color: var(--muted); font-weight: 500; margin-top: 0.5rem;">
                Aktif menjalin kerjasama
            </div>
        </div>
    </div>

    <div class="stat-card-premium">
        <div class="stat-card-icon" style="background: #f0fdf4; color: #16a34a;">
            <i data-lucide="search"></i>
        </div>
        <div class="stat-info">
            <div class="label">Crawl Menunggu</div>
            <div class="value">5</div>
            <div style="font-size: 0.75rem; color: #f59e0b; font-weight: 700; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.25rem;">
                <i data-lucide="alert-circle" style="width: 12px; height: 12px"></i> Perlu validasi manual
            </div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 1.5rem;">
    <!-- Recent Lowongan -->
    <div class="card" style="padding: 0;">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 1.125rem; font-weight: 700;">Lowongan Terbaru</h3>
            <a href="{{ route('admin.lowongan.index') }}" style="font-size: 0.875rem; color: var(--primary); font-weight: 600;">Lihat Semua</a>
        </div>
        <div style="padding: 0;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 1px solid var(--line);">
                        <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Judul Lowongan</th>
                        <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Perusahaan</th>
                        <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Status</th>
                        <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Mock data for visualization based on wireframe -->
                    <tr style="border-bottom: 1px solid var(--line);">
                        <td style="padding: 1rem 1.5rem;">
                            <div style="font-weight: 600;">Fullstack Developer</div>
                            <div style="font-size: 0.75rem; color: var(--muted)">PPLG / RPL</div>
                        </td>
                        <td style="padding: 1rem 1.5rem; font-size: 0.875rem;">PT Telkom Indonesia</td>
                        <td style="padding: 1rem 1.5rem;">
                            <span class="pill" style="background: #dcfce7; color: #166534;">Aktif</span>
                        </td>
                        <td style="padding: 1rem 1.5rem;">
                            <button style="background: none; border: none; color: var(--muted); cursor: pointer;"><i data-lucide="more-horizontal" style="width: 16px; height: 16px"></i></button>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--line);">
                        <td style="padding: 1rem 1.5rem;">
                            <div style="font-weight: 600;">UI/UX Designer</div>
                            <div style="font-size: 0.75rem; color: var(--muted)">DKV</div>
                        </td>
                        <td style="padding: 1rem 1.5rem; font-size: 0.875rem;">Gojek Tokopedia</td>
                        <td style="padding: 1rem 1.5rem;">
                            <span class="pill" style="background: #dcfce7; color: #166534;">Aktif</span>
                        </td>
                        <td style="padding: 1rem 1.5rem;">
                            <button style="background: none; border: none; color: var(--muted); cursor: pointer;"><i data-lucide="more-horizontal" style="width: 16px; height: 16px"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Activity Log -->
    <div class="card">
        <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 1.125rem; font-weight: 700;">Aktivitas Terbaru</h3>
            <i data-lucide="refresh-cw" style="width: 16px; height: 16px; color: var(--muted); cursor: pointer;"></i>
        </div>
        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
            <div style="display: flex; gap: 1rem;">
                <div style="width: 8px; height: 8px; background: var(--primary); border-radius: 50%; margin-top: 0.4rem; flex-shrink: 0;"></div>
                <div>
                    <div style="font-size: 0.875rem; font-weight: 600;">Admin mengonfirmasi 3 Lowongan Baru</div>
                    <div style="font-size: 0.75rem; color: var(--muted)">10 menit yang lalu</div>
                </div>
            </div>
            <div style="display: flex; gap: 1rem;">
                <div style="width: 8px; height: 8px; background: #94a3b8; border-radius: 50%; margin-top: 0.4rem; flex-shrink: 0;"></div>
                <div>
                    <div style="font-size: 0.875rem; font-weight: 600;">Web Crawler menemukan 5 sumber baru</div>
                    <div style="font-size: 0.75rem; color: var(--muted)">1 jam yang lalu</div>
                </div>
            </div>
            <div style="display: flex; gap: 1rem;">
                <div style="width: 8px; height: 8px; background: #94a3b8; border-radius: 50%; margin-top: 0.4rem; flex-shrink: 0;"></div>
                <div>
                    <div style="font-size: 0.875rem; font-weight: 600;">User "Budi Santoso" berhasil diverifikasi</div>
                    <div style="font-size: 0.75rem; color: var(--muted)">3 jam yang lalu</div>
                </div>
            </div>
        </div>
        <button class="btn btn-block" style="margin-top: 2rem; background: #f8fafc; border: 1px dashed var(--line); color: var(--muted);">
            Lihat Semua Log
        </button>
    </div>
</div>
@endsection
