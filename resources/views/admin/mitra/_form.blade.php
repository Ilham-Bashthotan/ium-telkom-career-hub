<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div>
            <label class="form-label">Nama Perusahaan <span style="color: var(--primary)">*</span></label>
            <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan', $perusahaan->nama_perusahaan ?? '') }}" required placeholder="Contoh: PT Telkom Indonesia" class="form-input">
        </div>

        <div>
            <label class="form-label">Sektor Industri</label>
            <input type="text" name="sektor_industri" value="{{ old('sektor_industri', $perusahaan->sektor_industri ?? '') }}" placeholder="Contoh: Teknologi, Telekomunikasi" class="form-input">
        </div>

        <div>
            <label class="form-label">Website</label>
            <input type="url" name="website" value="{{ old('website', $perusahaan->website ?? '') }}" placeholder="https://contoh-perusahaan.com" class="form-input">
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div>
            <label class="form-label">Status Mitra</label>
            <div style="display: flex; gap: 1.5rem; margin-top: 0.5rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.875rem; font-weight: 500;">
                    <input type="radio" name="is_mitra" value="1" {{ old('is_mitra', $perusahaan->is_mitra ?? '1') == '1' ? 'checked' : '' }} style="accent-color: var(--primary)"> Official Partner
                </label>
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.875rem; font-weight: 500;">
                    <input type="radio" name="is_mitra" value="0" {{ old('is_mitra', $perusahaan->is_mitra ?? '') == '0' ? 'checked' : '' }} style="accent-color: var(--primary)"> Umum
                </label>
            </div>
        </div>

        <div>
            <label class="form-label">Logo Perusahaan <span style="font-size: 0.75rem; color: var(--muted); font-weight: 400;">(Maks. 2MB)</span></label>
            <div class="upload-zone" id="drop-zone" onclick="document.getElementById('logo-input').click()">
                <input type="file" name="logo" id="logo-input" accept="image/*" style="display: none;">
                
                @php
                    $hasLogo = isset($perusahaan) && $perusahaan->logo;
                @endphp

                <div class="upload-content" id="upload-content" style="{{ $hasLogo ? 'display: none;' : '' }}">
                    <i data-lucide="image" style="width: 40px; height: 40px; color: var(--muted); margin-bottom: 0.75rem;"></i>
                    <p style="font-weight: 600; color: var(--text); font-size: 0.875rem;">Klik atau seret logo ke sini</p>
                    <p style="font-size: 0.75rem; color: var(--muted); margin-top: 0.25rem;">PNG, JPG, JPEG atau SVG</p>
                </div>

                <div id="preview-container" style="{{ $hasLogo ? 'display: flex;' : 'display: none;' }} flex-direction: column; align-items: center; gap: 0.5rem;">
                    <img id="logo-preview" src="{{ $hasLogo ? asset('storage/' . $perusahaan->logo) : '' }}" style="max-height: 120px; border-radius: 8px; border: 1px solid var(--line);">
                    <p id="filename-display" style="font-size: 0.75rem; color: var(--muted); font-weight: 500;">{{ $hasLogo ? 'Logo Tersimpan' : '' }}</p>
                    <button type="button" id="remove-logo" style="background: none; border: none; color: var(--primary); font-size: 0.75rem; font-weight: 700; cursor: pointer; text-decoration: underline;">Ganti Logo</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="margin-top: 1.5rem;">
    <label class="form-label">Deskripsi Perusahaan</label>
    <textarea name="deskripsi" rows="6" placeholder="Tuliskan ringkasan tentang perusahaan, pengalaman kerja sama, dan nilai utamanya." class="form-input" style="font-family: inherit; resize: vertical;">{{ old('deskripsi', $perusahaan->deskripsi ?? '') }}</textarea>
</div>

@include('admin.mitra._scripts')
