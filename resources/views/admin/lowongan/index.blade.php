@extends('layouts.admin')

@section('title', 'Manajemen Lowongan')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span style="color: var(--text)">Lowongan Kerja</span>
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Daftar Lowongan</h1>
        <p style="color: var(--muted); margin-top: 0.25rem;">Kelola semua postingan lowongan kerja dan magang.</p>
    </div>
    <a href="{{ route('admin.lowongan.create') }}" class="btn btn-primary">
        <i data-lucide="plus" style="width: 16px; height: 16px"></i> Tambah Lowongan
    </a>
</div>

<div class="table-container">
    <div style="padding: 1.5rem; border-bottom: 1px solid var(--line); display: flex; gap: 1rem; align-items: center; background: #fff;">
        <div style="position: relative; flex: 1;">
            <i data-lucide="search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--muted);"></i>
            <input type="text" placeholder="Cari judul lowongan, perusahaan, atau jurusan..." class="form-input" style="padding-left: 2.5rem;">
        </div>
        <button class="btn">
            <i data-lucide="filter" style="width: 16px; height: 16px"></i> Filter
        </button>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Lowongan</th>
                <th>Perusahaan</th>
                <th>Tipe</th>
                <th>Status</th>
                <th style="text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lowongans as $lowongan)
            <tr>
                <td>
                    <div style="font-weight: 700; color: var(--text);">{{ $lowongan->judul }}</div>
                    <div style="font-size: 0.75rem; color: var(--muted); margin-top: 0.25rem;">{{ $lowongan->jurusan->nama_jurusan }}</div>
                </td>
                <td>
                    <div style="font-size: 0.875rem; font-weight: 500;">{{ $lowongan->perusahaan->nama_perusahaan }}</div>
                </td>
                <td>
                    <span class="job-tag">{{ $lowongan->tipe_pekerjaan }}</span>
                </td>
                <td>
                    @if($lowongan->status == 'aktif')
                        <span class="pill" style="background: #dcfce7; color: #166534;">Aktif</span>
                    @else
                        <span class="pill" style="background: #fee2e2; color: #991b1b;">Nonaktif</span>
                    @endif
                </td>
                <td style="text-align: right;">
                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                        <a href="{{ route('admin.lowongan.edit', $lowongan->lowongan_id) }}" class="btn btn-sm" style="padding: 6px;">
                            <i data-lucide="edit-3" style="width: 14px; height: 14px; color: var(--secondary);"></i>
                        </a>
                        <form action="{{ route('admin.lowongan.destroy', $lowongan->lowongan_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')" style="display: inline;">
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
                <td colspan="5" style="padding: 4rem 1.5rem; text-align: center; color: var(--muted);">
                    <i data-lucide="inbox" style="width: 48px; height: 48px; margin-bottom: 1rem; opacity: 0.2;"></i>
                    <div>Belum ada data lowongan.</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($lowongans->hasPages())
    <div style="padding: 1.5rem; border-top: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; background: #fff;">
        <div style="font-size: 0.875rem; color: var(--muted)">
            Menampilkan {{ $lowongans->firstItem() }} sampai {{ $lowongans->lastItem() }} dari {{ $lowongans->total() }} data
        </div>
        <div>
            {{ $lowongans->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
