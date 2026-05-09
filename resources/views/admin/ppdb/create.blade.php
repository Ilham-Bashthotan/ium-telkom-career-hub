@extends('layouts.admin')

@section('title', 'Tambah Informasi PPDB')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span>Info PPDB</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span style="color: var(--text)">Tambah Baru</span>
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Informasi PPDB</h1>
        <p style="color: var(--muted); margin-top: 0.25rem;">Buat pengumuman baru mengenai pendaftaran PPDB dan banner promosi.</p>
    </div>
    <a href="{{ route('admin.ppdb.index') }}" class="btn">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px"></i> Kembali
    </a>
</div>

<div class="card" style="max-width: 900px; padding: 2.5rem;">
    <form action="{{ route('admin.ppdb.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div>
                    <label class="form-label">Judul Informasi <span style="color: var(--primary)">*</span></label>
                    <input type="text" name="judul" required placeholder="Contoh: PPDB Gelombang 1 Dibuka" class="form-input">
                </div>

                <div>
                    <label class="form-label">Tanggal Mulai <span style="color: var(--primary)">*</span></label>
                    <input type="date" name="tanggal_mulai" required class="form-input">
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div>
                    <label class="form-label">Banner PPDB</label>
                    <input type="file" name="banner_url" accept="image/*" class="form-input">
                </div>

                <div>
                    <label class="form-label">Tanggal Selesai <span style="color: var(--primary)">*</span></label>
                    <input type="date" name="tanggal_selesai" required class="form-input">
                </div>
            </div>
        </div>

        <div style="margin-top: 1.5rem;">
            <label class="form-label">Isi Informasi <span style="color: var(--primary)">*</span></label>
            <textarea name="konten" rows="8" required placeholder="Tuliskan detail PPDB, alur pendaftaran, dan catatan penting." class="form-input" style="font-family: inherit; resize: vertical;"></textarea>
        </div>

        <div style="margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid var(--line); display: flex; justify-content: flex-end; gap: 1rem;">
            <button type="reset" class="btn">Reset Form</button>
            <button type="submit" class="btn btn-primary" style="padding-left: 2.5rem; padding-right: 2.5rem;">Simpan Info PPDB</button>
        </div>
    </form>
</div>
@endsection
