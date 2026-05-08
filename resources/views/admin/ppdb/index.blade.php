@extends('layouts.admin')

@section('title', 'Info PPDB')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span style="color: var(--text)">Info PPDB</span>
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Informasi PPDB</h1>
        <p style="color: var(--muted); margin-top: 0.25rem;">Kelola pengumuman dan banner promosi PPDB SMK Telkom Bandung.</p>
    </div>
    <a href="{{ route('admin.ppdb.create') }}" class="btn btn-primary">
        <i data-lucide="plus" style="width: 16px; height: 16px"></i> Tambah Informasi
    </a>
</div>

<div class="table-container">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Judul Informasi</th>
                <th>Periode Aktif</th>
                <th>Dibuat Oleh</th>
                <th style="text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ppdbs as $ppdb)
            <tr>
                <td>
                    <div style="font-weight: 700; color: var(--text);">{{ $ppdb->judul }}</div>
                    <div style="font-size: 0.75rem; color: var(--muted); margin-top: 0.25rem; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">{{ Str::limit($ppdb->konten, 80) }}</div>
                </td>
                <td>
                    <div style="font-size: 0.8125rem; font-weight: 500;">{{ $ppdb->tanggal_mulai->format('d M Y') }} - {{ $ppdb->tanggal_selesai->format('d M Y') }}</div>
                </td>
                <td>
                    <span class="pill" style="background: var(--bg); color: var(--secondary);">{{ $ppdb->admin->name ?? 'Admin' }}</span>
                </td>
                <td style="text-align: right;">
                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                        <a href="{{ route('admin.ppdb.edit', $ppdb->ppdb_id) }}" class="btn btn-sm" style="padding: 6px;">
                            <i data-lucide="edit-3" style="width: 14px; height: 14px; color: var(--secondary);"></i>
                        </a>
                        <form action="{{ route('admin.ppdb.destroy', $ppdb->ppdb_id) }}" method="POST" onsubmit="return confirm('Hapus informasi ini?')" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="padding: 6px; color: #ef4444;">
                                <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="padding: 4rem 1.5rem; text-align: center; color: var(--muted);">
                    <i data-lucide="graduation-cap" style="width: 48px; height: 48px; margin-bottom: 1rem; opacity: 0.2;"></i>
                    <div>Belum ada informasi PPDB.</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($ppdbs->hasPages())
    <div style="padding: 1.5rem; border-top: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; background: #fff;">
        <div style="font-size: 0.875rem; color: var(--muted)">
            Menampilkan {{ $ppdbs->firstItem() }} sampai {{ $ppdbs->lastItem() }} dari {{ $ppdbs->total() }} data
        </div>
        <div>
            {{ $ppdbs->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
