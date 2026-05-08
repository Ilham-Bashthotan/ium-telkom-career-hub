@extends('layouts.admin')

@section('title', 'Manajemen Mitra Industri')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <span>/</span>
    <span style="color: var(--text); font-weight: 600;">Mitra Industri</span>
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Daftar Mitra Industri</h1>
        <p style="color: var(--muted); margin-top: 0.25rem;">Kelola data perusahaan yang bekerja sama dengan SMK Telkom Bandung.</p>
    </div>
    <a href="{{ route('admin.mitra.create') }}" class="btn btn-primary">
        <i data-lucide="plus" style="width: 16px; height: 16px"></i> Tambah Mitra
    </a>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid var(--line); display: flex; gap: 1rem; align-items: center; background: #fcfcfc;">
        <div style="position: relative; flex: 1;">
            <i data-lucide="search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--muted);"></i>
            <input type="text" placeholder="Cari nama perusahaan atau sektor industri..." style="width: 100%; padding: 0.625rem 1rem 0.625rem 2.5rem; border: 1px solid var(--line); border-radius: 8px; font-size: 0.875rem; outline: none;">
        </div>
    </div>

    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 1px solid var(--line);">
                <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Nama Perusahaan</th>
                <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Sektor Industri</th>
                <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Website</th>
                <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Status Mitra</th>
                <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perusahaans as $mitra)
            <tr style="border-bottom: 1px solid var(--line); transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                <td style="padding: 1.25rem 1.5rem;">
                    <div style="font-weight: 700; color: var(--text);">{{ $mitra->nama_perusahaan }}</div>
                </td>
                <td style="padding: 1.25rem 1.5rem; font-size: 0.875rem;">
                    {{ $mitra->sektor_industri ?? '-' }}
                </td>
                <td style="padding: 1.25rem 1.5rem; font-size: 0.875rem; color: var(--primary);">
                    @if($mitra->website)
                        <a href="{{ $mitra->website }}" target="_blank" style="display: flex; align-items: center; gap: 0.25rem;">
                            {{ Str::limit($mitra->website, 20) }} <i data-lucide="external-link" style="width: 12px; height: 12px"></i>
                        </a>
                    @else
                        -
                    @endif
                </td>
                <td style="padding: 1.25rem 1.5rem;">
                    @if($mitra->is_mitra)
                        <span class="pill" style="background: #e0f2fe; color: #0369a1; padding: 0.25rem 0.75rem;">Official Partner</span>
                    @else
                        <span class="pill" style="background: #f1f5f9; color: #475569; padding: 0.25rem 0.75rem;">Umum</span>
                    @endif
                </td>
                <td style="padding: 1.25rem 1.5rem;">
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.mitra.edit', $mitra->perusahaan_id) }}" class="btn" style="padding: 0.4rem; border-radius: 6px;">
                            <i data-lucide="edit-3" style="width: 16px; height: 16px; color: var(--secondary);"></i>
                        </a>
                        <form action="{{ route('admin.mitra.destroy', $mitra->perusahaan_id) }}" method="POST" onsubmit="return confirm('Hapus mitra ini?')">
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
                    <div>Belum ada data mitra industri.</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
