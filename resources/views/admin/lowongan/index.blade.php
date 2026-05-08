@extends('layouts.admin')

@section('title', 'Manajemen Lowongan')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <span>/</span>
    <span style="color: var(--text); font-weight: 600;">Lowongan Kerja</span>
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

<div class="card" style="padding: 0; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid var(--line); display: flex; gap: 1rem; align-items: center; background: #fcfcfc;">
        <div style="position: relative; flex: 1;">
            <i data-lucide="search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--muted);"></i>
            <input type="text" placeholder="Cari judul lowongan, perusahaan, atau jurusan..." style="width: 100%; padding: 0.625rem 1rem 0.625rem 2.5rem; border: 1px solid var(--line); border-radius: 8px; font-size: 0.875rem; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--line)'">
        </div>
        <button class="btn">
            <i data-lucide="filter" style="width: 16px; height: 16px"></i> Filter
        </button>
    </div>

    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 1px solid var(--line);">
                <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Lowongan</th>
                <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Perusahaan</th>
                <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Tipe</th>
                <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Status</th>
                <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lowongans as $lowongan)
            <tr style="border-bottom: 1px solid var(--line); transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                <td style="padding: 1.25rem 1.5rem;">
                    <div style="font-weight: 700; color: var(--text);">{{ $lowongan->judul }}</div>
                    <div style="font-size: 0.75rem; color: var(--muted); margin-top: 0.25rem;">{{ $lowongan->jurusan->nama_jurusan }}</div>
                </td>
                <td style="padding: 1.25rem 1.5rem;">
                    <div style="font-size: 0.875rem; font-weight: 500;">{{ $lowongan->perusahaan->nama_perusahaan }}</div>
                </td>
                <td style="padding: 1.25rem 1.5rem;">
                    <span class="job-tag">{{ $lowongan->tipe_pekerjaan }}</span>
                </td>
                <td style="padding: 1.25rem 1.5rem;">
                    @if($lowongan->status == 'aktif')
                        <span class="pill" style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem;">Aktif</span>
                    @else
                        <span class="pill" style="background: #fee2e2; color: #991b1b; padding: 0.25rem 0.75rem;">Nonaktif</span>
                    @endif
                </td>
                <td style="padding: 1.25rem 1.5rem;">
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.lowongan.edit', $lowongan->lowongan_id) }}" class="btn" style="padding: 0.4rem; border-radius: 6px;">
                            <i data-lucide="edit-3" style="width: 16px; height: 16px; color: var(--secondary);"></i>
                        </a>
                        <form action="{{ route('admin.lowongan.destroy', $lowongan->lowongan_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="padding: 0.4rem; border-radius: 6px; color: #ef4444;">
                                <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i>
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
    <div style="padding: 1.5rem; border-top: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center;">
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
