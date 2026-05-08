@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <a href="{{ route('admin.users.index') }}">Manajemen User</a>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span style="color: var(--text)">Detail Profil</span>
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Profil {{ $user->nama_lengkap }}</h1>
        <p style="color: var(--muted); margin-top: 0.25rem;">Informasi detail mengenai akun pengguna.</p>
    </div>
    <div style="display: flex; gap: 1rem;">
        <a href="{{ route('admin.users.index') }}" class="btn">
            <i data-lucide="arrow-left" style="width: 16px; height: 16px"></i> Kembali
        </a>
        <form action="{{ route('admin.users.destroy', $user->user_id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn" style="color: #ef4444; border-color: #fecaca;">
                <i data-lucide="trash-2" style="width: 16px; height: 16px"></i> Hapus User
            </button>
        </form>
    </div>
</div>

<div style="grid-template-columns: 300px 1fr; display: grid; gap: 2rem; align-items: start;">
    <div class="card" style="text-align: center; padding: 3rem 2rem;">
        <div style="width: 120px; height: 120px; border-radius: 30px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: 900; margin: 0 auto 1.5rem; box-shadow: 0 10px 25px rgba(238, 45, 36, 0.1);">
            {{ substr($user->nama_lengkap, 0, 2) }}
        </div>
        <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 0.5rem;">{{ $user->nama_lengkap }}</h3>
        <p style="color: var(--muted); font-size: 0.875rem; margin-bottom: 1.5rem;">{{ $user->email }}</p>
        <span class="pill" style="background: #eff6ff; color: #3b82f6;">Alumni</span>
    </div>

    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div class="card">
            <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                <i data-lucide="info" style="width: 20px; height: 20px; color: var(--primary);"></i>
                Informasi Akun
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 0.5rem;">Nama Lengkap</label>
                    <div style="font-weight: 600;">{{ $user->nama_lengkap }}</div>
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 0.5rem;">Email Address</label>
                    <div style="font-weight: 600;">{{ $user->email }}</div>
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 0.5rem;">Role Sistem</label>
                    <div style="font-weight: 600;">User / Alumni</div>
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 0.5rem;">Bergabung Sejak</label>
                    <div style="font-weight: 600;">{{ $user->created_at->format('d F Y, H:i') }}</div>
                </div>
            </div>
        </div>

        <div class="card" style="border-style: dashed; background: var(--bg);">
            <div style="text-align: center; padding: 2rem; color: var(--muted);">
                <i data-lucide="lock" style="width: 32px; height: 32px; margin-bottom: 1rem; opacity: 0.3;"></i>
                <p style="font-size: 0.875rem;">Data profil tambahan (alamat, telepon, portofolio) belum dilengkapi oleh pengguna.</p>
            </div>
        </div>
    </div>
</div>
@endsection
