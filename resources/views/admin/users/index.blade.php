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
            <input type="text" id="search-input" placeholder="Cari nama, email, atau status..." class="form-input" style="padding-left: 2.5rem;" value="{{ request('search') }}">
        </div>
        <button id="filter-btn" class="btn">
            <i data-lucide="filter" style="width: 16px; height: 16px"></i> Filter
        </button>
        <button id="clear-filters" class="btn" style="min-width: auto;">
            <i data-lucide="x" style="width: 16px; height: 16px"></i> Clear
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
                    @if($user->is_alumni)
                        <span class="pill" style="background: var(--primary-light); color: var(--primary);">Alumni</span>
                    @else
                        <span class="pill" style="background: #e0f2fe; color: #0369a1;">Siswa</span>
                    @endif
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

<!-- Filter Modal -->
<div id="filter-modal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div class="modal-content" style="background: white; border-radius: 12px; padding: 2rem; width: 90%; max-width: 500px; max-height: 80vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text);">Filter Pengguna</h3>
            <button id="close-modal" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--muted);">&times;</button>
        </div>

        <form id="filter-form">
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text);">Status Alumni</label>
                <select name="is_alumni" class="form-input" style="width: 100%;">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_alumni') === '1' ? 'selected' : '' }}>Alumni</option>
                    <option value="0" {{ request('is_alumni') === '0' ? 'selected' : '' }}>Bukan Alumni</option>
                </select>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text);">Status Pekerjaan</label>
                <input type="text" name="status_pekerjaan" placeholder="Masukkan status pekerjaan..." class="form-input" style="width: 100%;" value="{{ request('status_pekerjaan') }}">
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text);">Tempat Kerja</label>
                <input type="text" name="tempat_kerja" placeholder="Masukkan tempat kerja..." class="form-input" style="width: 100%;" value="{{ request('tempat_kerja') }}">
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" id="reset-filter" class="btn">Reset</button>
                <button type="submit" class="btn btn-primary">Terapkan Filter</button>
            </div>
        </form>
    </div>
</div>

<script>
let debounceTimer;
let isSearchActive = false;

function debounceSearch() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        performSearch();
    }, 500); // 500ms debounce
}

function performSearch() {
    const search = document.getElementById('search-input').value;
    isSearchActive = true;

    const params = new URLSearchParams();

    // Preserve existing filter parameters
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.forEach((value, key) => {
        if (key !== 'search' && key !== 'page') {
            params.append(key, value);
        }
    });

    if (search) params.append('search', search);

    const url = '{{ route("admin.users.index") }}' + (params.toString() ? '?' + params.toString() : '');
    window.location.href = url;
}

function applyFilters(formData) {
    const params = new URLSearchParams();

    // Add search if exists
    const searchInput = document.getElementById('search-input');
    if (searchInput && searchInput.value) {
        params.append('search', searchInput.value);
    }

    // Add filter parameters
    formData.forEach((value, key) => {
        if (value && value.trim() !== '') {
            params.append(key, value);
        }
    });

    const url = '{{ route("admin.users.index") }}' + (params.toString() ? '?' + params.toString() : '');
    window.location.href = url;
}

// Modal functionality
document.getElementById('filter-btn').addEventListener('click', function() {
    document.getElementById('filter-modal').style.display = 'flex';
});

document.getElementById('close-modal').addEventListener('click', function() {
    document.getElementById('filter-modal').style.display = 'none';
});

// Close modal when clicking outside
document.getElementById('filter-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.style.display = 'none';
    }
});

// Filter form submission
document.getElementById('filter-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    applyFilters(formData);
    document.getElementById('filter-modal').style.display = 'none';
});

// Reset filter
document.getElementById('reset-filter').addEventListener('click', function() {
    document.querySelectorAll('#filter-form input, #filter-form select').forEach(element => {
        element.value = '';
    });
});

// Search input with improved UX
document.getElementById('search-input').addEventListener('input', function() {
    debounceSearch();
});

// Clear all filters
document.getElementById('clear-filters').addEventListener('click', function() {
    window.location.href = '{{ route("admin.users.index") }}';
});

// Improved UX: Keep focus on search input after page load if there was a search
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.has('search') && urlParams.get('search').trim() !== '') {
        // Focus on search input and place cursor at the end
        searchInput.focus();
        searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
    }
});
</script>
@endsection
