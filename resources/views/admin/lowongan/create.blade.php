@extends('layouts.admin')

@section('title', 'Tambah Lowongan')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <span>/</span>
    <span>Lowongan</span>
    <span>/</span>
    <span style="color: var(--text); font-weight: 600;">Tambah Baru</span>
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Lowongan Baru</h1>
        <p style="color: var(--muted); margin-top: 0.25rem;">Masukkan informasi detail mengenai lowongan yang akan dipublikasikan.</p>
    </div>
    <a href="{{ route('admin.lowongan.index') }}" class="btn">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px"></i> Kembali
    </a>
</div>

<div class="card" style="max-width: 900px;">
    <form action="{{ route('admin.lowongan.store') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <!-- Left Column -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Judul Lowongan <span style="color: var(--primary)">*</span></label>
                    <input type="text" name="judul" required placeholder="Contoh: Senior Web Developer" style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 8px; outline: none;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Perusahaan <span style="color: var(--primary)">*</span></label>
                    <select name="perusahaan_id" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 8px; outline: none; background: #fff;">
                        <option value="">Pilih Perusahaan</option>
                        @foreach($perusahaans as $p)
                            <option value="{{ $p->perusahaan_id }}">{{ $p->nama_perusahaan }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Jurusan Terkait</label>
                    <select name="jurusan_id" style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 8px; outline: none; background: #fff;">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->jurusan_id }}">{{ $j->nama_jurusan }} ({{ $j->kode_jurusan }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Lokasi</label>
                    <input type="text" name="lokasi" placeholder="Contoh: Bandung, Jawa Barat (Remote)" style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 8px; outline: none;">
                </div>
            </div>

            <!-- Right Column -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Tipe Pekerjaan</label>
                    <select name="tipe_pekerjaan" style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 8px; outline: none; background: #fff;">
                        <option value="Full-time">Full-time</option>
                        <option value="Part-time">Part-time</option>
                        <option value="Internship">Internship</option>
                        <option value="Contract">Contract</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Gaji (Opsional)</label>
                    <input type="text" name="gaji" placeholder="Contoh: Rp 5.000.000 - Rp 8.000.000" style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 8px; outline: none;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Batas Pendaftaran</label>
                    <input type="date" name="tanggal_expired" style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 8px; outline: none;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Status Publikasi</label>
                    <div style="display: flex; gap: 1.5rem; margin-top: 0.5rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="radio" name="status" value="aktif" checked style="accent-color: var(--primary)"> Aktif
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="radio" name="status" value="draft" style="accent-color: var(--primary)"> Draft
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Deskripsi Pekerjaan <span style="color: var(--primary)">*</span></label>
            <textarea name="deskripsi" rows="8" required placeholder="Tuliskan kualifikasi, tanggung jawab, dan detail pekerjaan lainnya..." style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 8px; outline: none; font-family: inherit; resize: vertical;"></textarea>
        </div>

        <div style="margin-top: 2rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Link Pendaftaran (External)</label>
            <input type="url" name="link_apply" placeholder="https://perusahaan.com/karir/apply" style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 8px; outline: none;">
        </div>

        <div style="margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid var(--line); display: flex; justify-content: flex-end; gap: 1rem;">
            <button type="reset" class="btn">Reset Form</button>
            <button type="submit" class="btn btn-primary" style="padding-left: 2.5rem; padding-right: 2.5rem;">Simpan Lowongan</button>
        </div>
    </form>
</div>
@endsection
