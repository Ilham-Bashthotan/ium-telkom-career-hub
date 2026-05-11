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
                    <label class="form-label">Banner PPDB <span style="font-size: 0.75rem; color: var(--muted); font-weight: 400;">(Maks. 2MB)</span></label>
                    <div class="upload-zone" id="drop-zone" onclick="document.getElementById('banner-input').click()">
                        <input type="file" name="banner_url" id="banner-input" accept="image/*" style="display: none;">
                        
                        <div class="upload-content" id="upload-content">
                            <i data-lucide="image" style="width: 40px; height: 40px; color: var(--muted); margin-bottom: 0.75rem;"></i>
                            <p style="font-weight: 600; color: var(--text); font-size: 0.875rem;">Klik atau seret banner ke sini</p>
                            <p style="font-size: 0.75rem; color: var(--muted); margin-top: 0.25rem;">PNG, JPG, JPEG atau SVG</p>
                        </div>

                        <div id="preview-container" style="display: none; flex-direction: column; align-items: center; gap: 0.5rem;">
                            <img id="banner-preview" src="" style="max-height: 120px; border-radius: 8px; border: 1px solid var(--line);">
                            <p id="filename-display" style="font-size: 0.75rem; color: var(--muted); font-weight: 500;"></p>
                            <button type="button" id="remove-banner" style="background: none; border: none; color: var(--primary); font-size: 0.75rem; font-weight: 700; cursor: pointer; text-decoration: underline;">Ganti Banner</button>
                        </div>
                    </div>
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

@include('admin.ppdb._scripts')
@endsection
