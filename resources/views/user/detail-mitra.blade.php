@extends('layouts.user')

@section('title', $mitra->nama_perusahaan . ' — Telkom Career Hub')

@section('styles')
<style>
    .mitra-banner {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        padding: 4rem 3rem;
        border-radius: var(--radius-lg);
        color: white;
        margin-bottom: 2rem;
        display: flex;
        gap: 2.5rem;
        align-items: center;
    }
    .mitra-logo-large {
        width: 120px;
        height: 120px;
        background: white;
        border-radius: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary);
        flex-shrink: 0;
        overflow: hidden;
    }
    .detail-grid {
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 2.5rem;
    }
</style>
@endsection

@section('content')
<div class="page-container">
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('user.mitra.index') }}" class="btn" style="color: var(--muted); border: none;"><i data-lucide="arrow-left" style="width: 18px; height: 18px"></i> Kembali ke Daftar Mitra</a>
    </div>

    <div class="mitra-banner">
        <div class="mitra-logo-large">
            @if($mitra->logo)
                <img src="{{ asset('storage/' . $mitra->logo) }}" alt="{{ $mitra->nama_perusahaan }}" style="max-width: 100%; max-height: 100%;">
            @else
                {{ substr($mitra->nama_perusahaan, 0, 2) }}
            @endif
        </div>
        <div>
            <h1 style="font-size: 2.25rem; font-weight: 800; letter-spacing: -0.025em; margin-bottom: 0.5rem;">{{ $mitra->nama_perusahaan }}</h1>
            <p style="font-size: 1.125rem; opacity: 0.8; margin-bottom: 1.5rem;">{{ $mitra->sektor_industri }}</p>
            <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                @if($mitra->is_mitra)
                    <span class="pill" style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.2);">Mitra Strategis</span>
                @endif
                <span class="pill" style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.2);">Verified Company</span>
            </div>
        </div>
    </div>

    <div class="detail-grid">
        <aside>
            <div class="card" style="padding: 2rem;">
                <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 1.5rem;">Tentang Perusahaan</h3>
                <p style="font-size: 0.875rem; color: var(--secondary); line-height: 1.8; margin-bottom: 2rem;">
                    {{ $mitra->deskripsi }}
                </p>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 0.5rem;">Website</label>
                    <a href="{{ $mitra->website }}" target="_blank" style="color: var(--primary); font-weight: 600;">{{ $mitra->website ?: 'Tidak tersedia' }}</a>
                </div>
            </div>
        </aside>

        <main>
            <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">Lowongan Aktif ({{ $mitra->lowongans->count() }})</h2>
            
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @forelse($mitra->lowongans as $job)
                <div class="job-card" onclick="window.location.href='{{ route('user.lowongan.show', $job->lowongan_id) }}'">
                    <div class="job-card-header">
                        <div class="job-title">{{ $job->judul }}</div>
                        <span class="pill">{{ $job->jurusan->nama_jurusan }}</span>
                    </div>
                    <div class="job-meta">
                        <span class="job-tag"><i data-lucide="clock" style="width:14px;height:14px;margin-right:4px"></i> {{ $job->tipe_pekerjaan }}</span>
                        <span class="job-tag"><i data-lucide="map-pin" style="width:14px;height:14px;margin-right:4px"></i> {{ $job->lokasi }}</span>
                    </div>
                </div>
                @empty
                <div class="card" style="text-align: center; color: var(--muted); padding: 3rem;">
                    <i data-lucide="inbox" style="width: 48px; height: 48px; margin: 0 auto 1rem; opacity: 0.3;"></i>
                    <p>Saat ini tidak ada lowongan aktif dari perusahaan ini.</p>
                </div>
                @endforelse
            </div>
        </main>
    </div>
</div>
@endsection
