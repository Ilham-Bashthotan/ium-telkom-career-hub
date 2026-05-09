@extends('layouts.admin')

@section('title', 'Edit Informasi PPDB')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span>Info PPDB</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span style="color: var(--text)">Edit</span>
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Edit Informasi PPDB</h1>
        <p style="color: var(--muted); margin-top: 0.25rem;">Perbarui judul, jadwal, atau konten pengumuman PPDB.</p>
    </div>
    <a href="{{ route('admin.ppdb.index') }}" class="btn">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px"></i> Kembali
    </a>
</div>

<div class="card" style="max-width: 900px; padding: 2.5rem;">
    <form action="{{ route('admin.ppdb.update', $ppdb->ppdb_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div>
                    <label class="form-label">Judul Informasi <span style="color: var(--primary)">*</span></label>
                    <input type="text" name="judul" value="{{ $ppdb->judul }}" required class="form-input">
                </div>

                <div>
                    <label class="form-label">Tanggal Mulai <span style="color: var(--primary)">*</span></label>
                    <input type="date" name="tanggal_mulai" value="{{ $ppdb->tanggal_mulai?->format('Y-m-d') }}" required class="form-input">
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div>
                    <label class="form-label">Banner PPDB</label>
                    <input type="file" name="banner_url" accept="image/*" class="form-input">
                    @if($ppdb->banner_url)
                        <p style="margin-top: 0.5rem; font-size: 0.85rem; color: var(--muted);">Banner saat ini: <strong>{{ basename($ppdb->banner_url) }}</strong></p>
                    @endif
                </div>

                <div>
                    <label class="form-label">Tanggal Selesai <span style="color: var(--primary)">*</span></label>
                    <input type="date" name="tanggal_selesai" value="{{ $ppdb->tanggal_selesai?->format('Y-m-d') }}" required class="form-input">
                </div>
            </div>
        </div>

        <div style="margin-top: 1.5rem;">
            <label class="form-label">Isi Informasi <span style="color: var(--primary)">*</span></label>
            <textarea name="konten" rows="8" required class="form-input" style="font-family: inherit; resize: vertical;">{{ $ppdb->konten }}</textarea>
        </div>

        <div style="margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid var(--line); display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('admin.ppdb.index') }}" class="btn">Batalkan</a>
            <button type="submit" class="btn btn-primary" style="padding-left: 2.5rem; padding-right: 2.5rem;">Perbarui Info PPDB</button>
        </div>
    </form>
</div>
@endsection
