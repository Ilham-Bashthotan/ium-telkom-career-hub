@extends('layouts.user')

@section('title', $lowongan->judul . ' — Telkom Career Hub')

@section('styles')
<style>
    .detail-container {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 2rem;
        align-items: start;
    }
    .detail-header {
        padding: 2.5rem;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        margin-bottom: 2rem;
    }
    .detail-body {
        padding: 2.5rem;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
    }
    .detail-section-title {
        font-size: 1.125rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--primary-light);
        color: var(--text);
    }
    .btn-saved {
        background: var(--bg);
        color: var(--primary);
        border-color: var(--primary);
    }
    .description-content a {
        color: #2563eb;
        text-decoration: underline;
        font-weight: 500;
    }
    .description-content a:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="page-container">
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('user.lowongan.index') }}" class="btn" style="color: var(--muted); border: none;"><i data-lucide="arrow-left" style="width: 18px; height: 18px"></i> Kembali ke Lowongan</a>
    </div>



    <div class="detail-container">
        <div>
            <div class="detail-header">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
                    <div style="display: flex; gap: 1.5rem; align-items: center;">
                        <div style="width: 64px; height: 64px; background: #f1f5f9; border-radius: 0; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.25rem; color: var(--primary)">
                            {{ substr($lowongan->perusahaan->nama_perusahaan, 0, 2) }}
                        </div>
                        <div>
                            <h1 style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.025em; line-height: 1.2;">{{ $lowongan->judul }}</h1>
                            <p style="color: var(--primary); font-weight: 600;">{{ $lowongan->perusahaan->nama_perusahaan }}</p>
                        </div>
                    </div>
                    <span class="pill" style="padding: 0.5rem 1rem; font-size: 0.875rem;">{{ $lowongan->jurusan->kode_jurusan ?? 'Umum' }}</span>
                </div>
                <div class="job-meta">
                    <span class="job-tag"><i data-lucide="clock" style="width:14px;height:14px;margin-right:4px"></i> {{ $lowongan->tipe_pekerjaan }}</span>
                    <span class="job-tag"><i data-lucide="map-pin" style="width:14px;height:14px;margin-right:4px"></i> {{ $lowongan->lokasi }}</span>
                    <span class="job-tag"><i data-lucide="banknote" style="width:14px;height:14px;margin-right:4px"></i> {{ $lowongan->gaji }}</span>
                </div>
            </div>

            <div class="detail-body">
                <div class="detail-section" style="margin-bottom: 2.5rem;">
                    <h2 class="detail-section-title">Deskripsi Pekerjaan</h2>
                    <div class="description-content" style="color: var(--text); line-height: 1.8;">
                        {!! $lowongan->deskripsi !!}
                    </div>
                </div>

                <div class="detail-section">
                    <h2 class="detail-section-title">Informasi Tambahan</h2>
                    <div class="detail-row" style="display:flex; padding: 0.75rem 0; border-bottom: 1px solid var(--line);">
                        <span class="detail-key" style="width: 180px; color: var(--muted); font-size: 0.875rem;">Deadline</span>
                        <span class="detail-val" style="font-weight: 600;">{{ $lowongan->tanggal_expired ? $lowongan->tanggal_expired->format('d / m / Y') : '-' }}</span>
                    </div>
                    <div class="detail-row" style="display:flex; padding: 0.75rem 0; border-bottom: 1px solid var(--line);">
                        <span class="detail-key" style="width: 180px; color: var(--muted); font-size: 0.875rem;">Sumber</span>
                        <span class="detail-val" style="font-weight: 600;">{{ $lowongan->sumber }}</span>
                    </div>
                </div>
            </div>
        </div>

        <aside>
            <div class="card" style="position: sticky; top: 100px;">
                <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 1rem;">Tertarik dengan posisi ini?</h3>
                <p style="font-size: 0.875rem; color: var(--muted); margin-bottom: 1.5rem;">Lamar sekarang melalui link resmi perusahaan di bawah ini.</p>
                
                @if($lowongan->link_apply)
                    <a href="{{ $lowongan->link_apply }}" target="_blank" class="btn btn-primary btn-block" style="padding: 0.875rem; margin-bottom: 0.75rem;">Lamar Sekarang <i data-lucide="external-link" style="width:16px;height:16px"></i></a>
                @else
                    <button class="btn btn-primary btn-block" disabled style="opacity: 0.5; cursor: not-allowed; padding: 0.875rem; margin-bottom: 0.75rem;">Link Tidak Tersedia</button>
                @endif
                
                <form action="{{ route('user.lowongan.save', $lowongan->lowongan_id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-block {{ $isSaved ? 'btn-saved' : '' }}" style="padding: 0.875rem;">
                        <i data-lucide="{{ $isSaved ? 'bookmark-check' : 'bookmark' }}" style="width:16px;height:16px"></i> 
                        {{ $isSaved ? 'Tersimpan' : 'Simpan Lowongan' }}
                    </button>
                </form>
                
                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--line);">
                    <p style="font-size: 0.75rem; color: var(--muted); text-align: center;">Dibagikan oleh tim rekrutmen resmi {{ $lowongan->perusahaan->nama_perusahaan }}.</p>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
