@extends('layouts.user')

@section('title', 'Beranda — Telkom Career Hub')

@section('content')
<div class="page-container">
    
    <!-- Hero Section -->
    <div style="padding: 4rem 0; text-align: center; max-width: 800px; margin: 0 auto;">
        <h1 style="font-size: 3.5rem; font-weight: 800; letter-spacing: -0.05em; line-height: 1.1; margin-bottom: 1.5rem;">
            Bangun Karir Impianmu <span style="color: var(--primary)">Mulai dari Sini</span>
        </h1>
        <p style="font-size: 1.125rem; color: var(--muted); margin-bottom: 2.5rem; line-height: 1.6">
            Platform karir eksklusif untuk siswa dan alumni SMK Telkom Bandung. Temukan lowongan kerja, magang, dan mitra industri terbaik dalam satu tempat.
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <a href="{{ route('user.lowongan.index') }}" 
               onclick="return guardNav(event, '{{ route('user.lowongan.index') }}')"
               class="btn btn-primary" style="padding: 0.75rem 2rem; font-size: 1rem;">Cari Lowongan <i data-lucide="arrow-right" style="width: 18px; height: 18px"></i></a>
            <a href="{{ route('user.mitra.index') }}" class="btn" style="padding: 0.75rem 2rem; font-size: 1rem;">Mitra Industri</a>
        </div>
    </div>

    <!-- PPDB Carousel -->
    <div style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
        <h2 style="font-size: 1.5rem; font-weight: 700;">Informasi PPDB</h2>
    </div>
    <div class="ppdb-carousel">
        <div class="ppdb-slides" id="ppdb-slides">
            @forelse($ppdbs as $ppdb)
            <div class="ppdb-slide">
                <div style="display: flex; gap: 2rem; align-items: center;">
                    <div style="flex: 1;">
                        <h3 style="font-size: 2rem; font-weight: 800; margin-bottom: 1rem;">{{ $ppdb->judul }}</h3>
                        <p style="font-size: 1.125rem; opacity: 0.9; margin-bottom: 1.5rem;">{{ $ppdb->konten }}</p>
                        <div style="display: flex; gap: 1rem; align-items: center; font-size: 0.875rem; font-weight: 600;">
                            <span style="display: flex; align-items: center; gap: 0.5rem;"><i data-lucide="calendar" style="width:16px;height:16px"></i> {{ $ppdb->tanggal_mulai ? $ppdb->tanggal_mulai->format('d M') : '-' }} – {{ $ppdb->tanggal_selesai ? $ppdb->tanggal_selesai->format('d M Y') : '-' }}</span>
                            <span style="display: flex; align-items: center; gap: 0.5rem;"><i data-lucide="map-pin" style="width:16px;height:16px"></i> Kampus Bandung</span>
                        </div>
                    </div>
                    <div style="width: 300px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        @if($ppdb->banner_url)
                            <img src="{{ asset('storage/' . $ppdb->banner_url) }}" alt="{{ $ppdb->judul }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i data-lucide="graduation-cap" style="width: 80px; height: 80px; opacity: 0.5"></i>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="ppdb-slide">
                <div style="text-align: center;">
                    <h3 style="font-size: 1.5rem; font-weight: 800;">Belum Ada Informasi PPDB</h3>
                    <p style="opacity: 0.8;">Nantikan informasi pendaftaran siswa baru SMK Telkom Bandung di sini.</p>
                </div>
            </div>
            @endforelse
        </div>
        <div class="ppdb-nav">
            <button class="ppdb-btn" onclick="movePpdb(-1)"><i data-lucide="chevron-left"></i></button>
            <button class="ppdb-btn" onclick="movePpdb(1)"><i data-lucide="chevron-right"></i></button>
        </div>
    </div>

    <!-- Job Listings -->
    <div style="margin: 4rem 0 2rem; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700;">Lowongan Terbaru</h2>
            <p style="font-size: 0.875rem; color: var(--muted)">Kesempatan karir terbaru untuk pengembangan potensimu.</p>
        </div>
        <a href="{{ route('user.lowongan.index') }}" 
           onclick="return guardNav(event, '{{ route('user.lowongan.index') }}')"
           class="btn">Lihat Semua <i data-lucide="arrow-right" style="width:16px;height:16px"></i></a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
        @foreach($latestLowongans as $job)
        <div class="job-card" 
             @auth
                onclick="window.location.href='{{ route('user.lowongan.show', $job->lowongan_id) }}'"
             @else
                onclick="return guardNav(event, '{{ route('user.lowongan.show', $job->lowongan_id) }}')"
             @endauth>
            <div class="job-card-header">
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <div style="width: 48px; height: 48px; background: #f1f5f9; border-radius: 0; display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--primary)">
                        {{ substr($job->perusahaan->nama_perusahaan, 0, 2) }}
                    </div>
                    <div>
                        <div class="job-title">{{ $job->judul }}</div>
                        <div class="job-company">{{ $job->perusahaan->nama_perusahaan }}</div>
                    </div>
                </div>
                <span class="pill">{{ $job->jurusan->kode_jurusan }}</span>
            </div>
            <div class="job-meta">
                <span class="job-tag"><i data-lucide="clock" style="width:12px;height:12px;margin-right:4px"></i> {{ $job->tipe_pekerjaan }}</span>
                <span class="job-tag"><i data-lucide="map-pin" style="width:12px;height:12px;margin-right:4px"></i> {{ $job->lokasi }}</span>
            </div>
            <p style="font-size: 0.875rem; color: var(--muted); margin-bottom: 1.5rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                {{ Str::limit($job->deskripsi, 100) }}
            </p>
            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; border-top: 1px solid var(--line);">
                <span style="font-size: 0.875rem; font-weight: 700; color: var(--text)">{{ $job->gaji }}</span>
                <span style="font-size: 0.75rem; color: var(--muted)">{{ $job->tanggal_posting ? $job->tanggal_posting->diffForHumans() : '-' }}</span>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Partners -->
    <div style="margin: 4rem 0 2rem; text-align: center;">
        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Mitra Industri Terpercaya</h2>
        <p style="font-size: 0.875rem; color: var(--muted)">Bekerja sama dengan lebih dari {{ $mitraCount }} perusahaan teknologi terkemuka.</p>
    </div>
    <div class="partner-grid">
        @foreach($partners as $partner)
        <div class="logo-icon" 
             @auth
                onclick="window.location.href='{{ route('user.mitra.show', $partner->perusahaan_id) }}'"
             @else
                onclick="return guardNav(event, '{{ route('user.mitra.show', $partner->perusahaan_id) }}')"
             @endauth
             title="{{ $partner->nama_perusahaan }}">
            @if($partner->logo)
                <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->nama_perusahaan }}" style="max-width: 70%; max-height: 70%; object-fit: contain;">
            @else
                {{ substr($partner->nama_perusahaan, 0, 2) }}
            @endif
        </div>
        @endforeach
    </div>

    <div style="margin-top: 2rem; text-align: center;">
        <a href="{{ route('user.mitra.index') }}" class="btn">Lihat Semua Mitra <i data-lucide="arrow-right" style="width:16px;height:16px"></i></a>
    </div>

</div>
@endsection

@section('scripts')
<script>
    // PPDB Carousel
    let ppdbIndex = 0;
    function movePpdb(dir) {
        const slides = document.querySelectorAll('.ppdb-slide');
        if (slides.length === 0) return;
        ppdbIndex = (ppdbIndex + dir + slides.length) % slides.length;
        document.getElementById('ppdb-slides').style.transform = 'translateX(-' + (ppdbIndex * 100) + '%)';
    }

    // Auto-play carousel
    setInterval(() => movePpdb(1), 5000);
</script>
@endsection
