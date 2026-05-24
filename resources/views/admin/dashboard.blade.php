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
            <p style="color: var(--muted); margin-top: 0.25rem;">Pantau statistik dan aktivitas terbaru Telkom Career Hub.
            </p>
        </div>
        <div style="display: flex; gap: 1rem;">
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
                <div class="stat-value">{{ $pendingCrawl }}</div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 1.5rem; align-items: start;">
        <div class="card" style="padding: 0; overflow: hidden;">
            <div
                style="padding: 1.5rem; border-bottom: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; background: #fff; gap: 1rem;">
                <div>
                    <h3 style="font-size: 1.125rem; font-weight: 700;">Lowongan Terbaru</h3>
                    <p style="font-size: 0.8125rem; color: var(--muted); margin-top: 0.25rem;">Data aktual dari database,
                        termasuk hasil crawl yang masih draft.</p>
                </div>
                <a href="{{ route('admin.lowongan.index') }}" class="btn btn-sm" style="font-size: 0.75rem;">Lihat Semua</a>
            </div>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Judul Lowongan</th>
                        <th>Perusahaan</th>
                        <th>Sumber</th>
                        <th>Status</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLowongans as $lowongan)
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: var(--text);">{{ $lowongan->judul }}</div>
                                <div style="font-size: 0.75rem; color: var(--muted); margin-top: 0.25rem;">
                                    {{ $lowongan->jurusan->nama_jurusan ?? 'Semua Jurusan' }}</div>
                            </td>
                            <td>{{ $lowongan->perusahaan->nama_perusahaan ?? '-' }}</td>
                            <td>
                                <span class="pill"
                                    style="background: #eff6ff; color: #2563eb;">{{ strtoupper($lowongan->sumber) }}</span>
                            </td>
                            <td>
                                @if ($lowongan->status === 'aktif')
                                    <span class="pill" style="background: #dcfce7; color: #166534;">Aktif</span>
                                @elseif($lowongan->status === 'draft')
                                    <span class="pill" style="background: #fff7ed; color: #ea580c;">Draft</span>
                                @else
                                    <span class="pill" style="background: #fee2e2; color: #991b1b;">Nonaktif</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('admin.lowongan.edit', $lowongan->lowongan_id) }}" class="btn btn-sm"
                                    style="padding: 4px;">
                                    <i data-lucide="edit-3" style="width: 14px; height: 14px"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 3rem 1.5rem; text-align: center; color: var(--muted);">
                                Belum ada lowongan yang tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div class="card">
                <div
                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; gap: 1rem;">
                    <h3 style="font-size: 1.125rem; font-weight: 700; margin: 0;">Status Crawler</h3>
                    <a href="{{ route('admin.crawl.index') }}" class="btn btn-sm" style="font-size: 0.75rem;">Buka
                        Crawler</a>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                    <div style="display: flex; justify-content: space-between; gap: 1rem;">
                        <span style="color: var(--muted); font-size: 0.875rem;">Status</span>
                        <span class="pill"
                            style="background: #eff6ff; color: #2563eb;">{{ strtoupper($crawlStatus) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; gap: 1rem;">
                        <span style="color: var(--muted); font-size: 0.875rem;">Run hari ini</span>
                        <strong>{{ $crawlDailyRuns }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; gap: 1rem;">
                        <span style="color: var(--muted); font-size: 0.875rem;">Dibuat</span>
                        <strong>{{ $crawlSummary['created'] ?? 0 }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; gap: 1rem;">
                        <span style="color: var(--muted); font-size: 0.875rem;">Dilewati</span>
                        <strong>{{ $crawlSummary['skipped'] ?? 0 }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; gap: 1rem;">
                        <span style="color: var(--muted); font-size: 0.875rem;">Gagal</span>
                        <strong>{{ $crawlSummary['failed'] ?? 0 }}</strong>
                    </div>
                </div>
            </div>

            <div class="card">
                <div
                    style="margin-bottom: 1.25rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
                    <h3 style="font-size: 1.125rem; font-weight: 700; margin: 0;">Aktivitas Terbaru</h3>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @forelse($recentActivities as $activity)
                        <div style="display: flex; gap: 0.9rem;">
                            <div
                                style="width: 10px; height: 10px; background: var(--primary); border-radius: 3px; margin-top: 0.4rem; flex-shrink: 0; box-shadow: 0 2px 4px rgba(238, 45, 36, 0.3)">
                            </div>
                            <div>
                                <div style="font-size: 0.875rem; font-weight: 600; color: var(--text)">
                                    {{ $activity->aksi }}</div>
                                <div style="font-size: 0.75rem; color: var(--muted)">
                                    {{ $activity->created_at->diffForHumans() }} • {{ $activity->admin->nama ?? 'Admin' }}
                                </div>
                                @if ($activity->detail)
                                    <div style="font-size: 0.75rem; color: var(--muted); margin-top: 0.25rem;">
                                        {{ $activity->detail }}</div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div style="color: var(--muted); font-size: 0.875rem;">Belum ada aktivitas terbaru.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
