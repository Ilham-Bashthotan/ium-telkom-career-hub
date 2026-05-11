@extends('layouts.user')

@section('title', 'Beranda — Telkom Career Hub')

@section('content')
    <div class="page-container">
        <style>
            .ppdb-image-frame {
                width: 300px;
                height: 200px;
                border-radius: 16px;
                overflow: hidden;
                border: 1px solid rgba(255, 255, 255, 0.25);
                background: rgba(255, 255, 255, 0.12);
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
            }

            .ppdb-image-btn {
                width: 100%;
                height: 100%;
                padding: 0;
                margin: 0;
                border: none;
                background: transparent;
                cursor: zoom-in;
            }

            .ppdb-image-fill {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }

            .ppdb-image-placeholder {
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: rgba(255, 255, 255, 0.75);
            }

            .image-modal {
                position: fixed;
                inset: 0;
                background: rgba(2, 6, 23, 0.88);
                display: none;
                align-items: center;
                justify-content: center;
                z-index: 1200;
                padding: 1.5rem;
            }

            .image-modal.active {
                display: flex;
            }

            .image-modal-inner {
                max-width: min(1100px, 96vw);
                max-height: 92vh;
                position: relative;
            }

            .image-modal img {
                width: 100%;
                max-height: 92vh;
                object-fit: contain;
                border-radius: 12px;
                display: block;
                box-shadow: 0 20px 48px rgba(0, 0, 0, 0.45);
            }

            .image-modal-close {
                position: absolute;
                top: -42px;
                right: 0;
                border: none;
                background: rgba(255, 255, 255, 0.2);
                color: #fff;
                width: 34px;
                height: 34px;
                border-radius: 999px;
                cursor: pointer;
                font-size: 1.25rem;
                line-height: 1;
            }

            .ppdb-carousel {
                position: relative;
            }

            .ppdb-side-btn {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                z-index: 11;
                width: 42px;
                height: 42px;
                border-radius: 999px;
                border: 1px solid rgba(255, 255, 255, 0.35);
                background: rgba(255, 255, 255, 0.22);
                color: #fff;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: background 0.2s ease, transform 0.2s ease;
            }

            .ppdb-side-btn:hover {
                background: rgba(255, 255, 255, 0.35);
            }

            .ppdb-side-btn:active {
                transform: translateY(-50%) scale(0.95);
            }

            .ppdb-side-btn.ppdb-prev {
                left: 1rem;
            }

            .ppdb-side-btn.ppdb-next {
                right: 1rem;
            }

            .ppdb-indicators {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 0.5rem;
                margin-top: 1rem;
            }

            .ppdb-dot {
                width: 10px;
                height: 10px;
                border-radius: 999px;
                border: 0;
                background: rgba(15, 23, 42, 0.25);
                cursor: pointer;
                transition: all 0.2s ease;
                padding: 0;
            }

            .ppdb-dot.active {
                width: 24px;
                background: var(--primary);
            }

            @media (max-width: 768px) {
                .ppdb-side-btn.ppdb-prev {
                    left: 0.5rem;
                }

                .ppdb-side-btn.ppdb-next {
                    right: 0.5rem;
                }
            }
        </style>

        <!-- Hero Section -->
        <div style="padding: 4rem 0; text-align: center; max-width: 800px; margin: 0 auto;">
            <h1
                style="font-size: 3.5rem; font-weight: 800; letter-spacing: -0.05em; line-height: 1.1; margin-bottom: 1.5rem;">
                Bangun Karir Impianmu <span style="color: var(--primary)">Mulai dari Sini</span>
            </h1>
            <p style="font-size: 1.125rem; color: var(--muted); margin-bottom: 2.5rem; line-height: 1.6">
                Platform karir eksklusif untuk siswa dan alumni SMK Telkom Bandung. Temukan lowongan kerja, magang, dan
                mitra industri terbaik dalam satu tempat.
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="{{ route('user.lowongan.index') }}"
                    onclick="return guardNav(event, '{{ route('user.lowongan.index') }}')" class="btn btn-primary"
                    style="padding: 0.75rem 2rem; font-size: 1rem;">Cari Lowongan <i data-lucide="arrow-right"
                        style="width: 18px; height: 18px"></i></a>
                <a href="{{ route('user.mitra.index') }}" class="btn"
                    style="padding: 0.75rem 2rem; font-size: 1rem;">Mitra Industri</a>
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
                                <div
                                    style="display: flex; gap: 1rem; align-items: center; font-size: 0.875rem; font-weight: 600;">
                                    <span style="display: flex; align-items: center; gap: 0.5rem;"><i data-lucide="calendar"
                                            style="width:16px;height:16px"></i>
                                        {{ $ppdb->tanggal_mulai ? $ppdb->tanggal_mulai->format('d M') : '-' }} –
                                        {{ $ppdb->tanggal_selesai ? $ppdb->tanggal_selesai->format('d M Y') : '-' }}</span>
                                    <span style="display: flex; align-items: center; gap: 0.5rem;"><i data-lucide="map-pin"
                                            style="width:16px;height:16px"></i> Kampus Bandung</span>
                                </div>
                            </div>
                            <div class="ppdb-image-frame">
                                @if ($ppdb->banner_url)
                                    <button type="button" class="ppdb-image-btn"
                                        onclick='openImageModal(@json(asset('storage/' . $ppdb->banner_url)), @json($ppdb->judul))'
                                        aria-label="Lihat gambar penuh {{ $ppdb->judul }}">
                                        <img src="{{ asset('storage/' . $ppdb->banner_url) }}" alt="{{ $ppdb->judul }}"
                                            class="ppdb-image-fill">
                                    </button>
                                @else
                                    <div class="ppdb-image-placeholder" aria-label="Gambar belum tersedia">
                                        <i data-lucide="graduation-cap" style="width: 80px; height: 80px; opacity: 0.6"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="ppdb-slide">
                        <div style="text-align: center;">
                            <h3 style="font-size: 1.5rem; font-weight: 800;">Belum Ada Informasi PPDB</h3>
                            <p style="opacity: 0.8;">Nantikan informasi pendaftaran siswa baru SMK Telkom Bandung di sini.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
            <button type="button" class="ppdb-side-btn ppdb-prev" id="ppdb-prev" aria-label="Slide sebelumnya">
                <i data-lucide="chevron-left" style="width:18px;height:18px"></i>
            </button>
            <button type="button" class="ppdb-side-btn ppdb-next" id="ppdb-next" aria-label="Slide berikutnya">
                <i data-lucide="chevron-right" style="width:18px;height:18px"></i>
            </button>
        </div>
        <div class="ppdb-indicators" id="ppdb-indicators" aria-label="Indikator slide PPDB"></div>

        <!-- Job Listings -->
        <div style="margin: 4rem 0 2rem; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700;">Lowongan Terbaru</h2>
                <p style="font-size: 0.875rem; color: var(--muted)">Kesempatan karir terbaru untuk pengembangan potensimu.
                </p>
            </div>
            <a href="{{ route('user.lowongan.index') }}"
                onclick="return guardNav(event, '{{ route('user.lowongan.index') }}')" class="btn">Lihat Semua <i
                    data-lucide="arrow-right" style="width:16px;height:16px"></i></a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
            @foreach ($latestLowongans as $job)
                <div class="job-card"
                    @auth
onclick="window.location.href='{{ route('user.lowongan.show', $job->lowongan_id) }}'"
             @else
                onclick="return guardNav(event, '{{ route('user.lowongan.show', $job->lowongan_id) }}')" @endauth>
                    <div class="job-card-header">
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <div
                                style="width: 48px; height: 48px; background: #f1f5f9; border-radius: 0; display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--primary)">
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
                        <span class="job-tag"><i data-lucide="clock" style="width:12px;height:12px;margin-right:4px"></i>
                            {{ $job->tipe_pekerjaan }}</span>
                        <span class="job-tag"><i data-lucide="map-pin" style="width:12px;height:12px;margin-right:4px"></i>
                            {{ $job->lokasi }}</span>
                    </div>
                    <p
                        style="font-size: 0.875rem; color: var(--muted); margin-bottom: 1.5rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ Str::limit($job->deskripsi, 100) }}
                    </p>
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; border-top: 1px solid var(--line);">
                        <span style="font-size: 0.875rem; font-weight: 700; color: var(--text)">{{ $job->gaji }}</span>
                        <span
                            style="font-size: 0.75rem; color: var(--muted)">{{ $job->tanggal_posting ? $job->tanggal_posting->diffForHumans() : '-' }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Partners -->
        <div style="margin: 4rem 0 2rem; text-align: center;">
            <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Mitra Industri Terpercaya</h2>
            <p style="font-size: 0.875rem; color: var(--muted)">Bekerja sama dengan lebih dari {{ $mitraCount }}
                perusahaan teknologi terkemuka.</p>
        </div>
        <div class="partner-grid">
            @foreach ($partners as $partner)
                <div class="logo-icon"
                    @auth
onclick="window.location.href='{{ route('user.mitra.show', $partner->perusahaan_id) }}'"
             @else
                onclick="return guardNav(event, '{{ route('user.mitra.show', $partner->perusahaan_id) }}')" @endauth
                    title="{{ $partner->nama_perusahaan }}">
                    @if ($partner->logo)
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->nama_perusahaan }}"
                            style="max-width: 70%; max-height: 70%; object-fit: contain;">
                    @else
                        {{ substr($partner->nama_perusahaan, 0, 2) }}
                    @endif
                </div>
            @endforeach
        </div>

        <div style="margin-top: 2rem; text-align: center;">
            <a href="{{ route('user.mitra.index') }}" class="btn">Lihat Semua Mitra <i data-lucide="arrow-right"
                    style="width:16px;height:16px"></i></a>
        </div>

    </div>

    <div class="image-modal" id="image-modal" onclick="closeImageModal(event)">
        <div class="image-modal-inner">
            <button type="button" class="image-modal-close" onclick="closeImageModal(event)"
                aria-label="Tutup preview">&times;</button>
            <img id="image-modal-preview" src="" alt="Preview gambar PPDB">
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // PPDB Carousel
        const ppdbSlidesEl = document.getElementById('ppdb-slides');
        const ppdbSlides = Array.from(document.querySelectorAll('#ppdb-slides .ppdb-slide'));
        const ppdbIndicatorsEl = document.getElementById('ppdb-indicators');
        const ppdbPrevBtn = document.getElementById('ppdb-prev');
        const ppdbNextBtn = document.getElementById('ppdb-next');
        let ppdbIndex = 0;
        let ppdbAutoPlay = null;
        let ppdbIsMoving = false;

        function updatePpdbSlide(nextIndex) {
            if (!ppdbSlidesEl || ppdbSlides.length === 0) return;

            ppdbIndex = (nextIndex + ppdbSlides.length) % ppdbSlides.length;
            ppdbSlidesEl.style.transform = 'translateX(-' + (ppdbIndex * 100) + '%)';

            const dots = ppdbIndicatorsEl ? ppdbIndicatorsEl.querySelectorAll('.ppdb-dot') : [];
            dots.forEach((dot, index) => {
                const isActive = index === ppdbIndex;
                dot.classList.toggle('active', isActive);
                dot.setAttribute('aria-current', isActive ? 'true' : 'false');
            });
        }

        function movePpdb(dir) {
            if (ppdbSlides.length <= 1 || ppdbIsMoving) return;

            ppdbIsMoving = true;
            updatePpdbSlide(ppdbIndex + dir);
            window.setTimeout(() => {
                ppdbIsMoving = false;
            }, 550);
            restartPpdbAutoPlay();
        }

        function renderPpdbIndicators() {
            if (!ppdbIndicatorsEl) return;

            ppdbIndicatorsEl.innerHTML = '';
            ppdbSlides.forEach((_, index) => {
                const dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'ppdb-dot' + (index === 0 ? ' active' : '');
                dot.setAttribute('aria-label', 'Buka slide ' + (index + 1));
                dot.setAttribute('aria-current', index === 0 ? 'true' : 'false');
                dot.addEventListener('click', function() {
                    if (ppdbIsMoving) return;
                    updatePpdbSlide(index);
                    restartPpdbAutoPlay();
                });
                ppdbIndicatorsEl.appendChild(dot);
            });
        }

        function startPpdbAutoPlay() {
            if (ppdbSlides.length <= 1) return;
            ppdbAutoPlay = window.setInterval(function() {
                updatePpdbSlide(ppdbIndex + 1);
            }, 5000);
        }

        function restartPpdbAutoPlay() {
            if (ppdbAutoPlay) {
                window.clearInterval(ppdbAutoPlay);
                ppdbAutoPlay = null;
            }
            startPpdbAutoPlay();
        }

        if (ppdbPrevBtn) {
            ppdbPrevBtn.addEventListener('click', function(event) {
                event.preventDefault();
                movePpdb(-1);
            });
        }

        if (ppdbNextBtn) {
            ppdbNextBtn.addEventListener('click', function(event) {
                event.preventDefault();
                movePpdb(1);
            });
        }

        renderPpdbIndicators();
        updatePpdbSlide(0);
        startPpdbAutoPlay();

        function openImageModal(imageUrl, imageAlt) {
            const modal = document.getElementById('image-modal');
            const preview = document.getElementById('image-modal-preview');
            if (!modal || !preview) return;

            preview.src = imageUrl;
            preview.alt = imageAlt || 'Preview gambar PPDB';
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal(event) {
            const modal = document.getElementById('image-modal');
            const preview = document.getElementById('image-modal-preview');
            if (!modal || !preview) return;

            if (event && event.target && event.target.id !== 'image-modal' && !event.target.classList.contains(
                    'image-modal-close')) {
                return;
            }

            modal.classList.remove('active');
            preview.src = '';
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
@endsection
