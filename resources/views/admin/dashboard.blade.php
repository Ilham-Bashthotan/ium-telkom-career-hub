@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span style="color: var(--text)">Dashboard Overview</span>
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Ringkasan Sistem</h1>
        <p style="color: var(--muted); margin-top: 0.25rem;">Pantau statistik dan aktivitas terbaru Telkom Career Hub.</p>
    </div>
    <div style="display: flex; gap: 1rem;">
        <button class="btn">
            <i data-lucide="download" style="width: 16px; height: 16px"></i> Ekspor Laporan
        </button>
        <a href="{{ route('admin.lowongan.create') }}" class="btn btn-primary">
            <i data-lucide="plus" style="width: 16px; height: 16px"></i> Tambah Lowongan
        </a>
    </div>
</div>

<div class="admin-stat-grid">
    <div class="card stat-card">
        <div class="stat-icon" style="background: #eff6ff; color: #3b82f6;">
            <i data-lucide="briefcase"></i>
        </div>
        <div>
            <div class="stat-label">Lowongan Aktif</div>
            <div class="stat-value">{{ $activeLowongan }}</div>
        </div>
    </div>

    <div class="card stat-card">
        <div class="stat-icon" style="background: #fff1f0; color: var(--primary);">
            <i data-lucide="users"></i>
        </div>
        <div>
            <div class="stat-label">User Terdaftar</div>
            <div class="stat-value">{{ $totalUsers }}</div>
        </div>
    </div>

    <div class="card stat-card">
        <div class="stat-icon" style="background: #f0fdf4; color: #16a34a;">
            <i data-lucide="building-2"></i>
        </div>
        <div>
            <div class="stat-label">Mitra Industri</div>
            <div class="stat-value">{{ $totalMitra }}</div>
        </div>
    </div>

    <div class="card stat-card">
        <div class="stat-icon" style="background: #fff7ed; color: #ea580c;">
            <i data-lucide="search"></i>
        </div>
        <div>
            <div class="stat-label">Pending Crawl</div>
            <div class="stat-value">5</div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 1.5rem;">
    <!-- Recent Lowongan -->
    <div class="table-container">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; background: #fff;">
            <h3 style="font-size: 1.125rem; font-weight: 700;">Lowongan Terbaru</h3>
            <a href="{{ route('admin.lowongan.index') }}" class="btn btn-sm" style="font-size: 0.75rem;">Lihat Semua</a>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Judul Lowongan</th>
                    <th>Perusahaan</th>
                    <th>Status</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Mock data for visualization -->
                <tr>
                    <td>
                        <div style="font-weight: 700; color: var(--text);">Fullstack Developer</div>
                        <div style="font-size: 0.75rem; color: var(--muted)">PPLG / RPL</div>
                    </td>
                    <td>PT Telkom Indonesia</td>
                    <td>
                        <span class="pill" style="background: #dcfce7; color: #166534;">Aktif</span>
                    </td>
                    <td style="text-align: right;">
                        <button class="btn btn-sm" style="padding: 4px;"><i data-lucide="edit-3" style="width: 14px; height: 14px"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="font-weight: 700; color: var(--text);">UI/UX Designer</div>
                        <div style="font-size: 0.75rem; color: var(--muted)">DKV</div>
                    </td>
                    <td>Gojek Tokopedia</td>
                    <td>
                        <span class="pill" style="background: #dcfce7; color: #166534;">Aktif</span>
                    </td>
                    <td style="text-align: right;">
                        <button class="btn btn-sm" style="padding: 4px;"><i data-lucide="edit-3" style="width: 14px; height: 14px"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Activity Log -->
    <div class="card">
        <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 1.125rem; font-weight: 700;">Aktivitas Terbaru</h3>
            <button class="btn btn-sm" style="padding: 4px; border: none; background: none;"><i data-lucide="refresh-cw" style="width: 16px; height: 16px; color: var(--muted);"></i></button>
        </div>
        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
            <div style="display: flex; gap: 1rem;">
                <div style="width: 10px; height: 10px; background: var(--primary); border-radius: 3px; margin-top: 0.4rem; flex-shrink: 0; box-shadow: 0 2px 4px rgba(238, 45, 36, 0.3)"></div>
                <div>
                    <div style="font-size: 0.875rem; font-weight: 600; color: var(--text)">Konfirmasi 3 Lowongan Baru</div>
                    <div style="font-size: 0.75rem; color: var(--muted)">10 menit yang lalu • Oleh Admin</div>
                </div>
            </div>
            <div style="display: flex; gap: 1rem;">
                <div style="width: 10px; height: 10px; background: #94a3b8; border-radius: 3px; margin-top: 0.4rem; flex-shrink: 0;"></div>
                <div>
                    <div style="font-size: 0.875rem; font-weight: 600; color: var(--text)">Web Crawler selesai memindai</div>
                    <div style="font-size: 0.75rem; color: var(--muted)">1 jam yang lalu • Link: linkedin.com</div>
                </div>
            </div>
            <div style="display: flex; gap: 1rem;">
                <div style="width: 10px; height: 10px; background: #94a3b8; border-radius: 3px; margin-top: 0.4rem; flex-shrink: 0;"></div>
                <div>
                    <div style="font-size: 0.875rem; font-weight: 600; color: var(--text)">User "Budi Santoso" diverifikasi</div>
                    <div style="font-size: 0.75rem; color: var(--muted)">3 jam yang lalu • Alumni 2024</div>
                </div>
            </div>
        </div>
        <button class="btn btn-block" style="margin-top: 2rem; background: var(--bg); border-style: dashed; color: var(--muted);">
            Lihat Semua Log
        </button>
    </div>
</div>
@endsection
