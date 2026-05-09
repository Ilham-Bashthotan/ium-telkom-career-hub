@extends('layouts.admin')

@section('title', 'Tambah Mitra')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span>Mitra Industri</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span style="color: var(--text)">Tambah Baru</span>
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Mitra Industri Baru</h1>
        <p style="color: var(--muted); margin-top: 0.25rem;">Masukkan data perusahaan mitra yang akan ditampilkan di halaman mitra.</p>
    </div>
    <a href="{{ route('admin.mitra.index') }}" class="btn">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px"></i> Kembali
    </a>
</div>

<div class="card" style="max-width: 900px; padding: 2.5rem;">
    <form action="{{ route('admin.mitra.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div>
                    <label class="form-label">Nama Perusahaan <span style="color: var(--primary)">*</span></label>
                    <input type="text" name="nama_perusahaan" required placeholder="Contoh: PT Telkom Indonesia" class="form-input">
                </div>

                <div>
                    <label class="form-label">Sektor Industri</label>
                    <input type="text" name="sektor_industri" placeholder="Contoh: Teknologi, Telekomunikasi" class="form-input">
                </div>

                <div>
                    <label class="form-label">Website</label>
                    <input type="url" name="website" placeholder="https://contoh-perusahaan.com" class="form-input">
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div>
                    <label class="form-label">Status Mitra</label>
                    <div style="display: flex; gap: 1.5rem; margin-top: 0.5rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.875rem; font-weight: 500;">
                            <input type="radio" name="is_mitra" value="1" checked style="accent-color: var(--primary)"> Official Partner
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.875rem; font-weight: 500;">
                            <input type="radio" name="is_mitra" value="0" style="accent-color: var(--primary)"> Umum
                        </label>
                    </div>
                </div>

                <div>
                    <label class="form-label">Logo Perusahaan</label>
                    <input type="file" name="logo" accept="image/*" class="form-input">
                </div>
            </div>
        </div>

        <div style="margin-top: 1.5rem;">
            <label class="form-label">Deskripsi Perusahaan</label>
            <textarea name="deskripsi" rows="6" placeholder="Tuliskan ringkasan tentang perusahaan, pengalaman kerja sama, dan nilai utamanya." class="form-input" style="font-family: inherit; resize: vertical;"></textarea>
        </div>

        <div style="margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid var(--line); display: flex; justify-content: flex-end; gap: 1rem;">
            <button type="reset" class="btn">Reset Form</button>
            <button type="submit" class="btn btn-primary" style="padding-left: 2.5rem; padding-right: 2.5rem;">Simpan Mitra</button>
        </div>
    </form>
</div>
@endsection
