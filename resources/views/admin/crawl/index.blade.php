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
        <p style="color: var(--muted); margin-top: 0.25rem;">Validasi lowongan yang ditemukan secara otomatis dari berbagai sumber eksternal.</p>
    </div>
    <form action="{{ route('admin.crawl.process') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">
            <i data-lucide="play" style="width: 16px; height: 16px"></i> Jalankan Crawler
        </button>
    </form>
</div>

<div class="table-container">
    <div style="padding: 1.5rem; border-bottom: 1px solid var(--line); display: flex; align-items: center; justify-content: space-between; background: #fff;">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <span class="pill" style="background: #fff7ed; color: #ea580c; border: 1px solid #ffedd5;">{{ $crawledLowongans->total() }} Menunggu Validasi</span>
        </div>
        <div style="font-size: 0.875rem; color: var(--muted)">Sumber: LinkedIn, Jobstreet, Indeed</div>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Judul Lowongan</th>
                <th>Perusahaan</th>
                <th>Tanggal Temuan</th>
                <th style="text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($crawledLowongans as $job)
            <tr>
                <td>
                    <div style="font-weight: 700; color: var(--text);">{{ $job->judul }}</div>
                    <div style="font-size: 0.75rem; color: var(--primary); margin-top: 0.25rem; font-weight: 600;">{{ $job->jurusan->kode_jurusan ?? 'Semua Jurusan' }}</div>
                </td>
                <td>{{ $job->perusahaan->nama_perusahaan ?? 'Tidak Diketahui' }}</td>
                <td style="color: var(--muted); font-size: 0.8125rem;">{{ $job->created_at->diffForHumans() }}</td>
                <td style="text-align: right;">
                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                        <a href="{{ route('admin.lowongan.show', $job->lowongan_id) }}" class="btn btn-sm" style="padding: 6px;">
                            <i data-lucide="eye" style="width: 14px; height: 14px; color: var(--secondary);"></i>
                        </a>
                        <form action="{{ route('admin.crawl.approve', $job->lowongan_id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm" style="padding: 6px; color: #166534; background: #dcfce7; border-color: #bbf7d0;">
                                <i data-lucide="check" style="width: 14px; height: 14px;"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="padding: 4rem 1.5rem; text-align: center; color: var(--muted);">
                    <i data-lucide="search-check" style="width: 48px; height: 48px; margin-bottom: 1rem; opacity: 0.2;"></i>
                    <div>Tidak ada lowongan baru yang butuh validasi.</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($crawledLowongans->hasPages())
    <div style="padding: 1.5rem; border-top: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; background: #fff;">
        <div style="font-size: 0.875rem; color: var(--muted)">
            Menampilkan {{ $crawledLowongans->firstItem() }} sampai {{ $crawledLowongans->lastItem() }} dari {{ $crawledLowongans->total() }} data
        </div>
        <div>
            {{ $crawledLowongans->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
