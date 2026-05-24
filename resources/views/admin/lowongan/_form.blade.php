<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
    <!-- Left Column -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div>
            <label class="form-label">Judul Lowongan <span style="color: var(--primary)">*</span></label>
            <input type="text" name="judul" value="{{ old('judul', $lowongan->judul ?? '') }}" required placeholder="Contoh: Senior Web Developer" class="form-input">
        </div>

        <div>
            <label class="form-label">Perusahaan <span style="color: var(--primary)">*</span></label>
            <select name="perusahaan_id" id="select-perusahaan" required class="form-select">
                <option value="">Pilih Perusahaan</option>
                @foreach($perusahaans as $p)
                    <option value="{{ $p->perusahaan_id }}" {{ old('perusahaan_id', $lowongan->perusahaan_id ?? '') == $p->perusahaan_id ? 'selected' : '' }}>
                        {{ $p->nama_perusahaan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="form-label">Jurusan Terkait <span style="color: var(--primary)">*</span></label>
            <select name="jurusan_id" class="form-select" required>
                <option value="" disabled {{ !old('jurusan_id', $lowongan->jurusan_id ?? '') ? 'selected' : '' }}>Pilih Jurusan</option>
                @foreach($jurusans as $j)
                    <option value="{{ $j->jurusan_id }}" {{ old('jurusan_id', $lowongan->jurusan_id ?? '') == $j->jurusan_id ? 'selected' : '' }}>
                        {{ $j->nama_jurusan }} ({{ $j->kode_jurusan }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="form-label">Lokasi <span style="color: var(--primary)">*</span></label>
            <input type="text" name="lokasi" id="input-lokasi" value="{{ old('lokasi', $lowongan->lokasi ?? '') }}" required placeholder="Contoh: Bandung, Jawa Barat (Remote)" class="form-input">
        </div>
    </div>

    <!-- Right Column -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div>
            <label class="form-label">Tipe Pekerjaan <span style="color: var(--primary)">*</span></label>
            <select name="tipe_pekerjaan" class="form-select" required>
                <option value="" disabled {{ !old('tipe_pekerjaan', $lowongan->tipe_pekerjaan ?? '') ? 'selected' : '' }}>Pilih Tipe Pekerjaan</option>
                @foreach(['Full-time', 'Part-time', 'Internship', 'Contract'] as $type)
                    <option value="{{ $type }}" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan ?? '') == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="form-label">Gaji (Opsional)</label>
            <input type="text" name="gaji" id="input-gaji" value="{{ old('gaji', $lowongan->gaji ?? '') }}" placeholder="Contoh: 5000000" class="form-input">
        </div>

        <div>
            <label class="form-label">Batas Pendaftaran <span style="color: var(--primary)">*</span></label>
            <input type="text" name="tanggal_expired" id="tanggal_expired" value="{{ old('tanggal_expired', isset($lowongan) && $lowongan->tanggal_expired ? $lowongan->tanggal_expired->format('Y-m-d') : '') }}" required class="form-input" placeholder="dd / mm / yyyy">
        </div>

        <div>
            <label class="form-label">Status Publikasi</label>
            <div style="display: flex; gap: 1.5rem; margin-top: 0.5rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.875rem; font-weight: 500;">
                    <input type="radio" name="status" id="status-aktif" value="aktif" {{ old('status', $lowongan->status ?? 'aktif') == 'aktif' ? 'checked' : '' }} style="accent-color: var(--primary)"> Aktif
                </label>
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.875rem; font-weight: 500;">
                    <input type="radio" name="status" id="status-draft" value="draft" {{ old('status', $lowongan->status ?? '') == 'draft' ? 'checked' : '' }} style="accent-color: var(--primary)"> Draft
                </label>
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.875rem; font-weight: 500;">
                    <input type="radio" name="status" id="status-nonaktif" value="nonaktif" {{ old('status', $lowongan->status ?? '') == 'nonaktif' ? 'checked' : '' }} style="accent-color: var(--primary)"> Nonaktif
                </label>
            </div>
        </div>
    </div>
</div>

<div style="margin-top: 1.5rem;">
    <label class="form-label" style="display: block; margin-bottom: 0.5rem;">Deskripsi Pekerjaan <span style="color: var(--primary)">*</span></label>
    <x-rich-text-editor name="deskripsi" :value="old('deskripsi', $lowongan->deskripsi ?? '')" placeholder="Tuliskan kualifikasi, tanggung jawab, dan detail pekerjaan lainnya..." />
</div>

<div style="margin-top: 1.5rem;">
    <label class="form-label">Link Pendaftaran (External) <span style="color: var(--primary)">*</span></label>
    <input type="url" name="link_apply" id="input-link-apply" value="{{ old('link_apply', $lowongan->link_apply ?? '') }}" required placeholder="https://perusahaan.com/karir/apply" class="form-input">
</div>

@include('admin.lowongan._scripts')
