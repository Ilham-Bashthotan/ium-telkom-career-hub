@extends('layouts.user')

@section('title', 'Cari Lowongan Kerja — Telkom Career Hub')

@section('content')
<div class="page-container">
    <div style="margin-bottom: 2.5rem;">
        <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Eksplorasi Karir</h1>
        <p style="color: var(--muted)">Temukan peluang terbaik yang sesuai dengan kompetensi dan passion kamu.</p>
    </div>

    <div class="loker-grid">
        <!-- Sidebar Filter -->
        <aside>
            <div class="sidebar-box">
                <form action="{{ route('user.lowongan.index') }}" method="GET">
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 700; margin-bottom: 0.5rem;">Cari Posisi / Perusahaan</label>
                        <div style="position: relative;">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Contoh: UI Designer..." style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; border: 1px solid var(--line); border-radius: var(--radius-sm); font-size: 0.875rem;">
                            <i data-lucide="search" style="position: absolute; left: 0.875rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--muted)"></i>
                        </div>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 700; margin-bottom: 0.5rem;">Jurusan</label>
                        <select name="jurusan" style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: var(--radius-sm); font-size: 0.875rem; background: white;">
                            <option value="">Semua Jurusan</option>
                            @foreach($jurusans as $j)
                                <option value="{{ $j->kode_jurusan }}" {{ request('jurusan') == $j->kode_jurusan ? 'selected' : '' }}>
                                    {{ $j->kode_jurusan }} - {{ $j->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 700; margin-bottom: 0.5rem;">Tipe Pekerjaan</label>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            @foreach(['Full-time', 'Internship', 'Freelance', 'Contract'] as $type)
                            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; cursor: pointer;">
                                <input type="radio" name="tipe" value="{{ $type }}" {{ request('tipe') == $type ? 'selected' : '' }}> {{ $type }}
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 700; margin-bottom: 0.5rem;">Lokasi</label>
                        <input type="text" name="lokasi" value="{{ request('lokasi') }}" placeholder="Contoh: Bandung, Jakarta..." style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: var(--radius-sm); font-size: 0.875rem;">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Terapkan Filter</button>
                    @if(request()->anyFilled(['search', 'jurusan', 'tipe', 'lokasi']))
                        <a href="{{ route('user.lowongan.index') }}" style="display: block; text-align: center; margin-top: 1rem; font-size: 0.875rem; color: var(--secondary)">Reset Filter</a>
                    @endif
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div>
            @if($lowongans->isEmpty())
                <div style="text-align: center; padding: 4rem 2rem; background: white; border-radius: var(--radius-md); border: 1px solid var(--line);">
                    <i data-lucide="inbox" style="width: 48px; height: 48px; color: var(--line); margin-bottom: 1rem;"></i>
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">Lowongan Tidak Ditemukan</h3>
                    <p style="color: var(--muted)">Coba ubah filter atau kata kunci pencarian Anda.</p>
                </div>
            @else
                <div style="margin-bottom: 1rem; font-size: 0.875rem; color: var(--muted)">
                    Menampilkan <strong>{{ $lowongans->total() }}</strong> lowongan tersedia
                </div>
                
                @foreach($lowongans as $job)
                <div class="job-card" onclick="window.location.href='{{ route('user.lowongan.show', $job->lowongan_id) }}'">
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
                        <span class="job-tag"><i data-lucide="banknote" style="width:12px;height:12px;margin-right:4px"></i> {{ $job->gaji }}</span>
                    </div>
                    <p style="font-size: 0.875rem; color: var(--muted); margin-bottom: 1rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $job->deskripsi }}
                    </p>
                    <div style="display: flex; justify-content: flex-end; align-items: center; padding-top: 1rem; border-top: 1px solid var(--line);">
                        <span style="font-size: 0.75rem; color: var(--muted)">{{ $job->tanggal_posting ? $job->tanggal_posting->diffForHumans() : '-' }}</span>
                    </div>
                </div>
                @endforeach

                <div style="margin-top: 2rem;">
                    {{ $lowongans->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    @guest
        // Auto trigger modal if guest visits via direct URL
        window.onload = () => {
            const modal = document.getElementById('modal-auth-required');
            if (modal) modal.classList.add('active');
        };
    @endguest
</script>
@endsection
