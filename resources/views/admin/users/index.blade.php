@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span style="color: var(--text)">Manajemen User</span>
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Daftar Pengguna</h1>
        <p style="color: var(--muted); margin-top: 0.25rem;">Kelola data alumni, siswa, dan admin sistem.</p>
    </div>
    <div style="display: flex; gap: 1rem;">
        <button class="btn">
            <i data-lucide="download" style="width: 16px; height: 16px"></i> Ekspor Data
        </button>
    </div>
</div>

<div class="table-container">
    <div style="padding: 1.5rem; border-bottom: 1px solid var(--line); display: flex; gap: 1rem; align-items: center; background: #fff;">
        <div style="position: relative; flex: 1;">
            <i data-lucide="search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--muted);"></i>
            <input type="text" placeholder="Cari nama, email, atau status..." class="form-input" style="padding-left: 2.5rem;">
        </div>
        <button class="btn">
            <i data-lucide="filter" style="width: 16px; height: 16px"></i> Filter
        </button>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Status / Role</th>
                <th>Tanggal Bergabung</th>
                <th style="text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: var(--bg); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--secondary); font-size: 0.75rem;">
                            {{ substr($user->nama_lengkap, 0, 2) }}
                        </div>
                        <div style="font-weight: 700; color: var(--text);">{{ $user->nama_lengkap }}</div>
                    </div>
                </td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="pill" style="background: var(--primary-light); color: var(--primary);">Alumni</span>
                </td>
                <td style="color: var(--muted); font-size: 0.8125rem;">{{ $user->created_at->format('d M Y') }}</td>
                <td style="text-align: right;">
                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                        <a href="{{ route('admin.users.show', $user->user_id) }}" class="btn btn-sm" style="padding: 6px;">
                            <i data-lucide="eye" style="width: 14px; height: 14px; color: var(--secondary);"></i>
                        </a>
                        <form action="{{ route('admin.users.destroy', $user->user_id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="padding: 6px; color: #ef4444;">
                                <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 4rem 1.5rem; text-align: center; color: var(--muted);">
                    <i data-lucide="users" style="width: 48px; height: 48px; margin-bottom: 1rem; opacity: 0.2;"></i>
                    <div>Belum ada data user.</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($users->hasPages())
    <div style="padding: 1.5rem; border-top: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; background: #fff;">
        <div style="font-size: 0.875rem; color: var(--muted)">
            Menampilkan {{ $users->firstItem() }} sampai {{ $users->lastItem() }} dari {{ $users->total() }} data
        </div>
        <div>
            {{ $users->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
