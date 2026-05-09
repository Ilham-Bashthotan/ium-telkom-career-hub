@extends('layouts.user')

@section('title', 'Profil Saya — Telkom Career Hub')

@section('styles')
<style>
    .profile-header {
        background: linear-gradient(to right, var(--primary), #a31c17);
        height: 160px;
        border-radius: var(--radius-lg);
        margin-bottom: 4rem;
        position: relative;
    }
    .profile-avatar-container {
        position: absolute;
        bottom: 0;
        left: 2.5rem;
        display: flex;
        align-items: flex-end;
        gap: 1.5rem;
        width: calc(100% - 5rem);
        transform: translateY(40px); /* Keeps avatar overlapping bottom */
    }
    .profile-avatar {
        width: 120px;
        height: 120px;
        background: white;
        border-radius: 0; /* Match the "square" request */
        border: 4px solid white;
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 800;
        color: var(--primary);
        flex-shrink: 0;
    }
    .profile-info-basic {
        padding-bottom: 50px; /* Position text inside the red box */
        color: white;
    }
    .detail-row {
        display: flex;
        padding: 1rem 0;
        border-bottom: 1px solid var(--line);
    }
    .detail-row:last-child {
        border-bottom: none;
    }
</style>
@endsection

@section('content')
<div class="page-container">
    
    <div class="profile-header">
        <div class="profile-avatar-container">
            <div class="profile-avatar">{{ substr($user->nama_lengkap, 0, 2) }}</div>
            <div class="profile-info-basic">
                <h1 style="font-size: 1.75rem; font-weight: 800; color: white; margin-bottom: 0.25rem;">{{ $user->nama_lengkap }}</h1>
                <p style="color: rgba(255,255,255,0.8); font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-lucide="mail" style="width: 14px; height: 14px"></i> {{ $user->email }}
                </p>
            </div>
        </div>
    </div>



    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem;">
        <div class="card" style="padding: 2.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="font-size: 1.25rem; font-weight: 700;">Data Pribadi</h2>
                <button class="btn" onclick="document.getElementById('modal-edit').classList.add('active')">
                    <i data-lucide="edit-3" style="width: 16px; height: 16px"></i> Perbarui
                </button>
            </div>
            
            <div class="detail-row">
                <span style="width: 180px; font-weight: 600; color: var(--muted); font-size: 0.875rem;">Nama Lengkap</span>
                <span style="font-weight: 500;">{{ $user->nama_lengkap }}</span>
            </div>
            <div class="detail-row">
                <span style="width: 180px; font-weight: 600; color: var(--muted); font-size: 0.875rem;">No. HP</span>
                <span style="font-weight: 500;">{{ $user->no_hp ?: '-' }}</span>
            </div>
            <div class="detail-row">
                <span style="width: 180px; font-weight: 600; color: var(--muted); font-size: 0.875rem;">Status Alumni</span>
                <span style="font-weight: 500;">{!! $user->is_alumni ? '<span class="pill">Alumni SMK Telkom</span>' : 'Umum' !!}</span>
            </div>
            <div class="detail-row">
                <span style="width: 180px; font-weight: 600; color: var(--muted); font-size: 0.875rem;">Status Pekerjaan</span>
                <span style="font-weight: 500;">{{ str_replace('_', ' ', ucfirst($user->status_pekerjaan)) }}</span>
            </div>
            <div class="detail-row">
                <span style="width: 180px; font-weight: 600; color: var(--muted); font-size: 0.875rem;">Tempat Kerja</span>
                <span style="font-weight: 500;">{{ $user->tempat_kerja ?: '-' }}</span>
            </div>
        </div>

        <div class="card" style="padding: 2.5rem; margin-top: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 2rem;">Lowongan Tersimpan</h2>
            
            @forelse($savedJobs as $saved)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid var(--line); border-radius: var(--radius-sm); margin-bottom: 1rem;">
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <div style="width: 40px; height: 40px; background: var(--bg); border-radius: 4px; display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--primary); font-size: 0.75rem;">
                            {{ substr($saved->lowongan->perusahaan->nama_perusahaan, 0, 2) }}
                        </div>
                        <div>
                            <div style="font-weight: 700; font-size: 0.875rem;">{{ $saved->lowongan->judul }}</div>
                            <div style="font-size: 0.75rem; color: var(--muted);">{{ $saved->lowongan->perusahaan->nama_perusahaan }}</div>
                        </div>
                    </div>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('user.lowongan.show', $saved->lowongan_id) }}" class="btn" style="font-size: 0.75rem; padding: 0.4rem 0.8rem;">Lihat</a>
                        <form action="{{ route('user.lowongan.save', $saved->lowongan_id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn" style="font-size: 0.75rem; padding: 0.4rem 0.8rem; color: #ef4444; border-color: #fca5a5;">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 2rem; color: var(--muted); font-size: 0.875rem;">
                    Belum ada lowongan yang disimpan.
                </div>
            @endforelse
        </div>

        <aside>
            <div class="card" style="text-align: center;">
                <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1.5rem;">Pengaturan Akun</h3>
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirmLogout(event)">
                    @csrf
                    <button type="submit" class="btn btn-block" style="color: var(--primary); border-color: var(--primary);">
                        <i data-lucide="log-out" style="width: 16px; height: 16px"></i> Keluar dari Akun
                    </button>
                </form>
            </div>
        </aside>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal-overlay" id="modal-edit">
    <div class="modal-box">
        <form action="{{ route('user.profil.update') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h2 class="modal-title">Edit Profil</h2>
                <span class="modal-close" onclick="this.closest('.modal-overlay').classList.remove('active')">✕</span>
            </div>
            <div class="modal-body">
                <div style="margin-bottom: 1.25rem;">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-input" value="{{ $user->nama_lengkap }}" required>
                </div>
                <div style="margin-bottom: 1.25rem;">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="no_hp" class="form-input" value="{{ $user->no_hp }}">
                </div>
                <div style="margin-bottom: 1.25rem;">
                    <label class="form-label">Status Pekerjaan</label>
                    <select name="status_pekerjaan" class="form-select">
                        <option value="belum_bekerja" {{ $user->status_pekerjaan == 'belum_bekerja' ? 'selected' : '' }}>Belum Bekerja</option>
                        <option value="sedang_bekerja" {{ $user->status_pekerjaan == 'sedang_bekerja' ? 'selected' : '' }}>Sedang Bekerja</option>
                        <option value="wirausaha" {{ $user->status_pekerjaan == 'wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                    </select>
                </div>
                <div style="margin-bottom: 0.5rem;">
                    <label class="form-label">Tempat Kerja</label>
                    <input type="text" name="tempat_kerja" class="form-input" value="{{ $user->tempat_kerja }}" placeholder="Nama perusahaan atau '-' jika tidak ada">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" style="flex:1" onclick="this.closest('.modal-overlay').classList.remove('active')">Batal</button>
                <button type="submit" class="btn btn-primary" style="flex:2">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
