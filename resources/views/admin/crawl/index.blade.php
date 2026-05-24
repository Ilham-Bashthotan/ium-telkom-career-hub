@extends('layouts.admin')

@section('title', 'Web Crawler')

@section('content')
    <div class="breadcrumb">
        <span>Admin</span>
        <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
        <span style="color: var(--text)">Web Crawler</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Crawler Validasi</h1>
            <p style="color: var(--muted); margin-top: 0.25rem;">Crawler gratis dan terbatas untuk memasukkan hasil temuan ke
                database sebagai draft.</p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <span id="crawl-status-pill" class="pill"
                style="background: #eff6ff; color: #2563eb;">{{ strtoupper($crawlSummary['status'] ?? 'idle') }}</span>
            <span class="pill" style="background: #fff7ed; color: #ea580c;">{{ $pendingCount }} Pending</span>
        </div>
    </div>

    @if (session('success'))
        <div class="card" style="margin-bottom: 1rem; background: #f0fdf4; border-color: #bbf7d0; color: #166534;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="card" style="margin-bottom: 1rem; background: #fef2f2; border-color: #fecaca; color: #991b1b;">
            {{ session('error') }}
        </div>
    @endif

    <div class="admin-stat-grid" style="margin-bottom: 1.5rem;">
        <div class="card stat-card">
            <div class="stat-icon" style="background: #fff7ed; color: #ea580c;">
                <i data-lucide="search"></i>
            </div>
            <div>
                <div class="stat-label">Pending Validasi</div>
                <div id="crawl-pending-count" class="stat-value">{{ $pendingCount }}</div>
            </div>
        </div>

        <div class="card stat-card">
            <div class="stat-icon" style="background: #eff6ff; color: #2563eb;">
                <i data-lucide="clock-3"></i>
            </div>
            <div>
                <div class="stat-label">Run Hari Ini</div>
                <div id="crawl-daily-runs" class="stat-value">{{ $dailyRuns }}</div>
            </div>
        </div>

        <div class="card stat-card">
            <div class="stat-icon" style="background: #f0fdf4; color: #16a34a;">
                <i data-lucide="check-circle-2"></i>
            </div>
            <div>
                <div class="stat-label">Dibuat</div>
                <div id="crawl-created-count" class="stat-value">{{ $crawlSummary['created'] ?? 0 }}</div>
            </div>
        </div>

        <div class="card stat-card">
            <div class="stat-icon" style="background: #fee2e2; color: #b91c1c;">
                <i data-lucide="ban"></i>
            </div>
            <div>
                <div class="stat-label">Cooldown</div>
                <div id="crawl-cooldown-value" class="stat-value">
                    {{ $cooldownRemaining > 0 ? $cooldownRemaining . 'm' : 'Siap' }}</div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 1.5rem; align-items: start;">
        <div class="card">
            <div
                style="display: flex; justify-content: space-between; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
                <div>
                    <h3 style="margin: 0; font-size: 1.125rem; font-weight: 700;">Jalankan Crawler</h3>
                    <p style="margin-top: 0.25rem; color: var(--muted); font-size: 0.875rem;">Masukkan URL sumber yang
                        diizinkan. Maksimal {{ config('crawl.max_urls_per_run', 5) }} URL per run.</p>
                </div>
            </div>

            <form id="crawl-form" action="{{ route('admin.crawl.process') }}" method="POST">
                @csrf
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text);">Source
                        URLs</label>
                    <textarea name="source_urls" class="form-input" rows="8"
                        placeholder="https://careers.example.com/job/123&#10;https://jobs.example.com/vacancy/456">{{ old('source_urls') }}</textarea>
                    @error('source_urls')
                        <div style="margin-top: 0.5rem; color: #b91c1c; font-size: 0.8125rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div
                    style="margin-bottom: 1rem; padding: 1rem; border-radius: 10px; background: #f8fafc; border: 1px solid var(--line);">
                    <div style="font-size: 0.875rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text);">Domain
                        yang diizinkan</div>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        @foreach (config('crawl.allowed_hosts', []) as $host)
                            <span class="pill"
                                style="background: #fff; color: var(--muted); border: 1px solid var(--line);">{{ $host }}</span>
                        @endforeach
                    </div>
                </div>

                <div style="display: flex; gap: 0.75rem; justify-content: flex-end; flex-wrap: wrap; align-items: center;">
                    <span id="crawl-live-note" style="font-size: 0.8125rem; color: var(--muted);"></span>
                    <button id="crawl-submit-button" type="submit" class="btn btn-primary"
                        {{ $cooldownRemaining > 0 || (int) $dailyRuns >= (int) config('crawl.daily_limit', 3) ? 'disabled' : '' }}>
                        <i id="crawl-submit-icon" data-lucide="play" style="width: 16px; height: 16px"></i>
                        <span id="crawl-submit-label">Jalankan Crawler</span>
                    </button>
                </div>
            </form>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div class="card">
                <h3 style="margin: 0 0 1rem; font-size: 1.125rem; font-weight: 700;">Ringkasan Terakhir</h3>
                <div style="display: flex; flex-direction: column; gap: 0.85rem; font-size: 0.875rem;">
                    <div style="display: flex; justify-content: space-between; gap: 1rem;">
                        <span style="color: var(--muted);">Sumber diproses</span>
                        <strong id="crawl-source-count">{{ $crawlSummary['source_count'] ?? 0 }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; gap: 1rem;">
                        <span style="color: var(--muted);">Dibuat</span>
                        <strong id="crawl-summary-created">{{ $crawlSummary['created'] ?? 0 }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; gap: 1rem;">
                        <span style="color: var(--muted);">Dilewati</span>
                        <strong id="crawl-summary-skipped">{{ $crawlSummary['skipped'] ?? 0 }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; gap: 1rem;">
                        <span style="color: var(--muted);">Gagal</span>
                        <strong id="crawl-summary-failed">{{ $crawlSummary['failed'] ?? 0 }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; gap: 1rem;">
                        <span style="color: var(--muted);">Mulai</span>
                        <strong
                            id="crawl-summary-started">{{ $crawlSummary['started_at'] ? \Carbon\Carbon::parse($crawlSummary['started_at'])->diffForHumans() : '-' }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; gap: 1rem;">
                        <span style="color: var(--muted);">Selesai</span>
                        <strong
                            id="crawl-summary-finished">{{ $crawlSummary['finished_at'] ? \Carbon\Carbon::parse($crawlSummary['finished_at'])->diffForHumans() : '-' }}</strong>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3 style="margin: 0 0 1rem; font-size: 1.125rem; font-weight: 700;">Log Crawl Terbaru</h3>
                <div id="crawl-recent-logs" style="display: flex; flex-direction: column; gap: 1rem;">
                    @forelse($recentLogs as $log)
                        <div>
                            <div style="font-size: 0.875rem; font-weight: 600; color: var(--text);">{{ $log->aksi }}
                            </div>
                            <div style="font-size: 0.75rem; color: var(--muted);">{{ $log->created_at->diffForHumans() }}
                                •
                                {{ $log->admin->nama ?? 'Admin' }}</div>
                            @if ($log->detail)
                                <div style="font-size: 0.75rem; color: var(--muted); margin-top: 0.35rem;">
                                    {{ $log->detail }}</div>
                            @endif
                        </div>
                    @empty
                        <div style="color: var(--muted); font-size: 0.875rem;">Belum ada log crawling.</div>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <h3 style="margin: 0 0 1rem; font-size: 1.125rem; font-weight: 700;">Hasil Crawl Terakhir</h3>
                <div id="crawl-run-results" style="display: flex; flex-direction: column; gap: 0.85rem;">
                    @forelse($crawlResults as $result)
                        <div style="padding: 0.75rem 0; border-bottom: 1px solid var(--line);">
                            <div style="display: flex; justify-content: space-between; gap: 1rem; align-items: center;">
                                <strong style="font-size: 0.875rem;">{{ $result['status'] ?? 'unknown' }}</strong>
                                <span
                                    style="font-size: 0.75rem; color: var(--muted);">{{ $result['source_url'] ?? '-' }}</span>
                            </div>
                            <div style="font-size: 0.8125rem; color: var(--muted); margin-top: 0.35rem;">
                                {{ $result['title'] ?? ($result['message'] ?? '-') }}
                            </div>
                        </div>
                    @empty
                        <div style="color: var(--muted); font-size: 0.875rem;">Belum ada hasil crawl terbaru.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 0; overflow: hidden; margin-top: 1.5rem;">
        <div
            style="padding: 1.5rem; border-bottom: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; background: #fff; gap: 1rem;">
            <div>
                <h3 style="margin: 0; font-size: 1.125rem; font-weight: 700;">Lowongan Hasil Crawl</h3>
                <p style="margin-top: 0.25rem; color: var(--muted); font-size: 0.875rem;">Semua data di bawah ini masih
                    menunggu validasi admin.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm" style="font-size: 0.75rem;">Buka
                Dashboard</a>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Perusahaan</th>
                    <th>Tanggal</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($crawledLowongans as $lowongan)
                    <tr>
                        <td>
                            <div style="font-weight: 700; color: var(--text);">{{ $lowongan->judul }}</div>
                            <div style="font-size: 0.75rem; color: var(--muted); margin-top: 0.25rem;">
                                {{ $lowongan->jurusan->nama_jurusan ?? 'Semua Jurusan' }}</div>
                        </td>
                        <td>{{ $lowongan->perusahaan->nama_perusahaan ?? '-' }}</td>
                        <td style="color: var(--muted); font-size: 0.8125rem;">
                            {{ $lowongan->created_at->diffForHumans() }}</td>
                        <td style="text-align: right;">
                            <form action="{{ route('admin.crawl.approve', $lowongan->lowongan_id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm"
                                    style="padding: 4px; color: #166534; background: #dcfce7; border-color: #bbf7d0;">
                                    <i data-lucide="check" style="width: 14px; height: 14px;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 3rem 1.5rem; text-align: center; color: var(--muted);">
                            Belum ada lowongan hasil crawl yang menunggu validasi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($crawledLowongans->hasPages())
            <div
                style="padding: 1.5rem; border-top: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; background: #fff;">
                <div style="font-size: 0.875rem; color: var(--muted)">
                    Menampilkan {{ $crawledLowongans->firstItem() }} sampai {{ $crawledLowongans->lastItem() }} dari
                    {{ $crawledLowongans->total() }} data
                </div>
                <div>
                    {{ $crawledLowongans->links() }}
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusUrl = @json(route('admin.crawl.status'));
            const initialStatus = @json($crawlSummary['status'] ?? 'idle');
            const canRunInitially = @json(!($cooldownRemaining > 0 || (int) $dailyRuns >= (int) config('crawl.daily_limit', 3)));
            const button = document.getElementById('crawl-submit-button');
            const label = document.getElementById('crawl-submit-label');
            const icon = document.getElementById('crawl-submit-icon');
            const liveNote = document.getElementById('crawl-live-note');
            const statusPill = document.getElementById('crawl-status-pill');
            const pendingCount = document.getElementById('crawl-pending-count');
            const dailyRuns = document.getElementById('crawl-daily-runs');
            const createdCount = document.getElementById('crawl-created-count');
            const cooldownValue = document.getElementById('crawl-cooldown-value');
            const summaryCreated = document.getElementById('crawl-summary-created');
            const summarySkipped = document.getElementById('crawl-summary-skipped');
            const summaryFailed = document.getElementById('crawl-summary-failed');
            const summaryStarted = document.getElementById('crawl-summary-started');
            const summaryFinished = document.getElementById('crawl-summary-finished');
            const recentLogs = document.getElementById('crawl-recent-logs');
            const runResults = document.getElementById('crawl-run-results');

            let pollTimer = null;

            function setButtonLoading(isLoading) {
                if (!button || !label || !icon) {
                    return;
                }

                if (isLoading) {
                    button.disabled = true;
                    label.textContent = 'Menjalankan...';
                    icon.setAttribute('data-lucide', 'loader-2');
                    icon.classList.add('animate-spin');
                    liveNote.textContent = 'Crawler sedang berjalan di latar belakang.';
                    if (window.lucide) {
                        window.lucide.createIcons();
                    }
                }
            }

            function renderLogs(logs) {
                if (!recentLogs) return;

                if (!logs || !logs.length) {
                    recentLogs.innerHTML =
                        '<div style="color: var(--muted); font-size: 0.875rem;">Belum ada log crawling.</div>';
                    return;
                }

                recentLogs.innerHTML = logs.map(function(log) {
                    return `<div><div style="font-size: 0.875rem; font-weight: 600; color: var(--text);">${log.aksi}</div><div style="font-size: 0.75rem; color: var(--muted);">${log.created_at} • ${log.admin}</div>${log.detail ? `<div style="font-size: 0.75rem; color: var(--muted); margin-top: 0.35rem;">${log.detail}</div>` : ''}</div>`;
                }).join('');
            }

            function renderResults(results) {
                if (!runResults) return;

                if (!results || !results.length) {
                    runResults.innerHTML =
                        '<div style="color: var(--muted); font-size: 0.875rem;">Belum ada hasil crawl terbaru.</div>';
                    return;
                }

                runResults.innerHTML = results.map(function(result) {
                    const statusColor = result.status === 'created' ? '#166534' : (result.status ===
                        'skipped' ? '#ea580c' : '#991b1b');
                    return `<div style="padding: 0.75rem 0; border-bottom: 1px solid var(--line);"><div style="display: flex; justify-content: space-between; gap: 1rem; align-items: center;"><strong style="font-size: 0.875rem; color: ${statusColor};">${result.status}</strong><span style="font-size: 0.75rem; color: var(--muted);">${result.source_url}</span></div><div style="font-size: 0.8125rem; color: var(--muted); margin-top: 0.35rem;">${result.title ?? result.message ?? '-'}</div></div>`;
                }).join('');
            }

            function updateUI(payload) {
                if (!payload) return;

                if (statusPill) {
                    statusPill.textContent = String(payload.status || 'idle').toUpperCase();
                }

                if (pendingCount) pendingCount.textContent = payload.pending_count ?? 0;
                if (dailyRuns) dailyRuns.textContent = payload.daily_runs ?? 0;
                if (createdCount) createdCount.textContent = payload.summary?.created ?? 0;
                if (cooldownValue) cooldownValue.textContent = payload.cooldown_remaining > 0 ?
                    `${payload.cooldown_remaining}m` : 'Siap';
                if (summaryCreated) summaryCreated.textContent = payload.summary?.created ?? 0;
                if (summarySkipped) summarySkipped.textContent = payload.summary?.skipped ?? 0;
                if (summaryFailed) summaryFailed.textContent = payload.summary?.failed ?? 0;
                if (summaryStarted) summaryStarted.textContent = payload.summary?.started_at || '-';
                if (summaryFinished) summaryFinished.textContent = payload.summary?.finished_at || '-';

                renderLogs(payload.recent_logs || []);
                renderResults(payload.results || []);

                if (liveNote && (payload.status === 'running' || payload.status === 'queued')) {
                    liveNote.textContent = 'Crawler masih memproses. Halaman akan diperbarui otomatis.';
                }

                if (payload.status === 'finished') {
                    liveNote.textContent = 'Crawler selesai. Hasil terbaru sudah ditampilkan.';
                    if (button && canRunInitially) {
                        button.disabled = false;
                        label.textContent = 'Jalankan Crawler';
                        icon.setAttribute('data-lucide', 'play');
                        icon.classList.remove('animate-spin');
                        if (window.lucide) {
                            window.lucide.createIcons();
                        }
                    }
                }
            }

            async function pollStatus() {
                try {
                    const response = await fetch(statusUrl, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    if (!response.ok) return;
                    const payload = await response.json();
                    updateUI(payload);

                    if (payload.status === 'running' || payload.status === 'queued') {
                        pollTimer = window.setTimeout(pollStatus, 2000);
                    }
                } catch (error) {
                    pollTimer = window.setTimeout(pollStatus, 3000);
                }
            }

            const form = document.getElementById('crawl-form');
            if (form && button) {
                form.addEventListener('submit', function() {
                    setButtonLoading(true);
                });
            }

            if (initialStatus === 'queued' || initialStatus === 'running') {
                liveNote.textContent = 'Crawler masih berjalan. Status akan diperbarui otomatis.';
                pollStatus();
            }
        });
    </script>
@endsection
