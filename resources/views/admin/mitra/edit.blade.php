@extends('layouts.admin')

@section('title', 'Edit Mitra')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span>Mitra Industri</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span style="color: var(--text)">Edit</span>
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Edit Mitra Industri</h1>
        <p style="color: var(--muted); margin-top: 0.25rem;">Perbarui informasi mitra perusahaan.</p>
    </div>
    <a href="{{ route('admin.mitra.index') }}" class="btn">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px"></i> Kembali
    </a>
</div>

<div class="card" style="max-width: 900px; padding: 2.5rem;">
    <form action="{{ route('admin.mitra.update', $perusahaan->perusahaan_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div>
                    <label class="form-label">Nama Perusahaan <span style="color: var(--primary)">*</span></label>
                    <input type="text" name="nama_perusahaan" value="{{ $perusahaan->nama_perusahaan }}" required class="form-input">
                </div>

                <div>
                    <label class="form-label">Sektor Industri</label>
                    <input type="text" name="sektor_industri" value="{{ $perusahaan->sektor_industri }}" class="form-input" placeholder="Contoh: Teknologi, Telekomunikasi">
                </div>

                <div>
                    <label class="form-label">Website</label>
                    <input type="url" name="website" value="{{ $perusahaan->website }}" class="form-input" placeholder="https://contoh-perusahaan.com">
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div>
                    <label class="form-label">Status Mitra</label>
                    <div style="display: flex; gap: 1.5rem; margin-top: 0.5rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.875rem; font-weight: 500;">
                            <input type="radio" name="is_mitra" value="1" {{ $perusahaan->is_mitra ? 'checked' : '' }} style="accent-color: var(--primary)"> Official Partner
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.875rem; font-weight: 500;">
                            <input type="radio" name="is_mitra" value="0" {{ !$perusahaan->is_mitra ? 'checked' : '' }} style="accent-color: var(--primary)"> Umum
                        </label>
                    </div>
                </div>

                <div>
                    <label class="form-label">Logo Perusahaan</label>
                    <input type="file" name="logo" accept="image/*" class="form-input">
                    @if($perusahaan->logo)
                        <p style="margin-top: 0.5rem; font-size: 0.85rem; color: var(--muted);">Logo saat ini: <strong>{{ basename($perusahaan->logo) }}</strong></p>
                    @endif
                </div>
            </div>
        </div>

        <div style="margin-top: 1.5rem;">
            <label class="form-label">Deskripsi Perusahaan</label>
            <textarea name="deskripsi" rows="6" class="form-input" style="font-family: inherit; resize: vertical;" placeholder="Tuliskan ringkasan tentang perusahaan, pengalaman kerja sama, dan nilai utamanya.">{{ $perusahaan->deskripsi }}</textarea>
        </div>

        <div style="margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid var(--line); display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('admin.mitra.index') }}" class="btn">Batalkan</a>
            <button type="submit" class="btn btn-primary" style="padding-left: 2.5rem; padding-right: 2.5rem;">Perbarui Mitra</button>
        </div>
    </form>
</div>
@endsection
