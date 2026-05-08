@extends('layouts.admin')

@section('title', 'Edit Lowongan')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <span>/</span>
    <span>Lowongan</span>
    <span>/</span>
    <span style="color: var(--text); font-weight: 600;">Edit</span>
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Edit Lowongan</h1>
        <p style="color: var(--muted); margin-top: 0.25rem;">Perbarui informasi lowongan kerja atau magang.</p>
    </div>
    <a href="{{ route('admin.lowongan.index') }}" class="btn">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px"></i> Kembali
    </a>
</div>

<div class="card" style="max-width: 900px;">
    <form action="{{ route('admin.lowongan.update', $lowongan->lowongan_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <!-- Left Column -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Judul Lowongan <span style="color: var(--primary)">*</span></label>
                    <input type="text" name="judul" value="{{ $lowongan->judul }}" required placeholder="Contoh: Senior Web Developer" style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 8px; outline: none;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Perusahaan <span style="color: var(--primary)">*</span></label>
                    <select name="perusahaan_id" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 8px; outline: none; background: #fff;">
                        <option value="">Pilih Perusahaan</option>
                        @foreach($perusahaans as $p)
                            <option value="{{ $p->perusahaan_id }}" {{ $lowongan->perusahaan_id == $p->perusahaan_id ? 'selected' : '' }}>{{ $p->nama_perusahaan }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Jurusan Terkait</label>
                    <select name="jurusan_id" style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 8px; outline: none; background: #fff;">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->jurusan_id }}" {{ $lowongan->jurusan_id == $j->jurusan_id ? 'selected' : '' }}>{{ $j->nama_jurusan }} ({{ $j->kode_jurusan }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Lokasi</label>
                    <input type="text" name="lokasi" value="{{ $lowongan->lokasi }}" placeholder="Contoh: Bandung, Jawa Barat (Remote)" style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 8px; outline: none;">
                </div>
            </div>

            <!-- Right Column -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Tipe Pekerjaan</label>
                    <select name="tipe_pekerjaan" style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 8px; outline: none; background: #fff;">
                        <option value="Full-time" {{ $lowongan->tipe_pekerjaan == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="Part-time" {{ $lowongan->tipe_pekerjaan == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="Internship" {{ $lowongan->tipe_pekerjaan == 'Internship' ? 'selected' : '' }}>Internship</option>
                        <option value="Contract" {{ $lowongan->tipe_pekerjaan == 'Contract' ? 'selected' : '' }}>Contract</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Gaji (Opsional)</label>
                    <input type="text" name="gaji" value="{{ $lowongan->gaji }}" placeholder="Contoh: Rp 5.000.000 - Rp 8.000.000" style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 8px; outline: none;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Batas Pendaftaran</label>
                    <input type="date" name="tanggal_expired" value="{{ $lowongan->tanggal_expired ? $lowongan->tanggal_expired->format('Y-m-d') : '' }}" style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 8px; outline: none;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Status Publikasi</label>
                    <div style="display: flex; gap: 1.5rem; margin-top: 0.5rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="radio" name="status" value="aktif" {{ $lowongan->status == 'aktif' ? 'checked' : '' }} style="accent-color: var(--primary)"> Aktif
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="radio" name="status" value="draft" {{ $lowongan->status == 'draft' ? 'checked' : '' }} style="accent-color: var(--primary)"> Draft
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="radio" name="status" value="nonaktif" {{ $lowongan->status == 'nonaktif' ? 'checked' : '' }} style="accent-color: var(--primary)"> Nonaktif
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Deskripsi Pekerjaan <span style="color: var(--primary)">*</span></label>
            <textarea name="deskripsi" rows="8" required placeholder="Tuliskan kualifikasi, tanggung jawab, dan detail pekerjaan lainnya..." style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 8px; outline: none; font-family: inherit; resize: vertical;">{{ $lowongan->deskripsi }}</textarea>
        </div>

        <div style="margin-top: 2rem;">
            <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Link Pendaftaran (External)</label>
            <input type="url" name="link_apply" value="{{ $lowongan->link_apply }}" placeholder="https://perusahaan.com/karir/apply" style="width: 100%; padding: 0.75rem; border: 1px solid var(--line); border-radius: 8px; outline: none;">
        </div>

        <div style="margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid var(--line); display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('admin.lowongan.index') }}" class="btn">Batalkan</a>
            <button type="submit" class="btn btn-primary" style="padding-left: 2.5rem; padding-right: 2.5rem;">Perbarui Lowongan</button>
        </div>
    </form>
</div>
@endsection
