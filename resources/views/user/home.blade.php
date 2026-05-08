@extends('layouts.user')

@section('title', 'Dashboard — Telkom Career Hub')

@section('content')
<div class="page-container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 1.5rem; font-weight: 800;">Selamat Datang, {{ Auth::user()->nama_lengkap }}!</h1>
        <p style="color: var(--muted)">Lihat lowongan terbaru yang sesuai dengan profilmu.</p>
    </div>

    @if($activePPDB)
    <div class="ppdb-carousel" style="margin-bottom: 3rem;">
        <div class="ppdb-slides">
            <div class="ppdb-slide">
                <div style="display: flex; gap: 2rem; align-items: center;">
                    <div style="flex: 1;">
                        <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.5rem;">{{ $activePPDB->judul }}</h3>
                        <p style="font-size: 1rem; opacity: 0.9; margin-bottom: 1rem;">{{ $activePPDB->deskripsi }}</p>
                        <a href="{{ $activePPDB->link_info }}" target="_blank" class="btn" style="background: white; color: var(--primary); border: none;">Info Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 2rem; align-items: start;">
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem;">Lowongan Untukmu</h2>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach($latestLowongans as $job)
                <div class="job-card" onclick="window.location.href='{{ route('user.lowongan.show', $job->lowongan_id) }}'">
                    <div class="job-card-header">
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <div style="width: 40px; height: 40px; background: #f1f5f9; border-radius: 0; display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--primary)">
                                {{ substr($job->perusahaan->nama_perusahaan, 0, 2) }}
                            </div>
                            <div>
                                <div class="job-title" style="font-size: 1rem;">{{ $job->judul }}</div>
                                <div class="job-company" style="font-size: 0.8125rem;">{{ $job->perusahaan->nama_perusahaan }}</div>
                            </div>
                        </div>
                        <span class="pill" style="font-size: 0.6875rem;">{{ $job->jurusan->kode_jurusan }}</span>
                    </div>
                    <div class="job-meta">
                        <span class="job-tag" style="font-size: 0.6875rem;">{{ $job->lokasi }}</span>
                        <span class="job-tag" style="font-size: 0.6875rem;">{{ $job->tipe_pekerjaan }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            <div style="margin-top: 1.5rem; text-align: center;">
                <a href="{{ route('user.lowongan.index') }}" style="color: var(--primary); font-weight: 600; font-size: 0.875rem;">Lihat Semua Lowongan &rarr;</a>
            </div>
        </div>

        <aside>
            <div class="card" style="padding: 1.5rem;">
                <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem;">Kelengkapan Profil</h3>
                <div style="height: 8px; background: var(--bg); border-radius: 4px; margin-bottom: 0.5rem; overflow: hidden;">
                    <div style="width: 65%; height: 100%; background: var(--primary);"></div>
                </div>
                <p style="font-size: 0.75rem; color: var(--muted); margin-bottom: 1.5rem;">Profil Anda 65% lengkap. Lengkapi untuk melamar pekerjaan.</p>
                <a href="{{ route('user.profil.index') }}" class="btn btn-primary btn-block">Lengkapi Profil</a>
            </div>

            <div class="card" style="margin-top: 1.5rem; padding: 1.5rem; background: var(--primary-light); border: 1px solid var(--primary);">
                <h3 style="font-size: 0.875rem; font-weight: 700; color: var(--primary); margin-bottom: 0.5rem;">Bantuan Karir</h3>
                <p style="font-size: 0.75rem; color: var(--text); line-height: 1.5;">Butuh bantuan dalam mencari pekerjaan atau membuat CV? Hubungi tim karir kami.</p>
                <a href="#" class="btn btn-block" style="margin-top: 1rem; border-color: var(--primary); color: var(--primary);">Hubungi Kami</a>
            </div>
        </aside>
    </div>
</div>
@endsection
