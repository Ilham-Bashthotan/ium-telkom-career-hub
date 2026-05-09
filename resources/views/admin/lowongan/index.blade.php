@extends('layouts.admin')

@section('title', 'Manajemen Lowongan')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span style="color: var(--text)">Lowongan Kerja</span>
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Daftar Lowongan</h1>
        <p style="color: var(--muted); margin-top: 0.25rem;">Kelola semua postingan lowongan kerja dan magang.</p>
    </div>
    <a href="{{ route('admin.lowongan.create') }}" class="btn btn-primary">
        <i data-lucide="plus" style="width: 16px; height: 16px"></i> Tambah Lowongan
    </a>
</div>

<div class="table-container">
    <div style="padding: 1.5rem; border-bottom: 1px solid var(--line); display: flex; gap: 1rem; align-items: center; background: #fff; flex-wrap: wrap;">
        <div style="position: relative; flex: 1; min-width: 250px;">
            <i data-lucide="search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--muted);"></i>
            <input type="text" id="search-input" placeholder="Cari judul lowongan, perusahaan, atau jurusan..." class="form-input" style="padding-left: 2.5rem;" value="{{ request('search') }}">
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
                <th>Lowongan</th>
                <th>Perusahaan</th>
                <th>Tipe</th>
                <th>Status</th>
                <th style="text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lowongans as $lowongan)
            <tr>
                <td>
                    <div style="font-weight: 700; color: var(--text);">{{ $lowongan->judul }}</div>
                    <div style="font-size: 0.75rem; color: var(--muted); margin-top: 0.25rem;">{{ $lowongan->jurusan->nama_jurusan }}</div>
                </td>
                <td>
                    <div style="font-size: 0.875rem; font-weight: 500;">{{ $lowongan->perusahaan->nama_perusahaan }}</div>
                </td>
                <td>
                    <span class="job-tag">{{ $lowongan->tipe_pekerjaan }}</span>
                </td>
                <td>
                    @if($lowongan->status == 'aktif')
                        <span class="pill" style="background: #dcfce7; color: #166534;">Aktif</span>
                    @else
                        <span class="pill" style="background: #fee2e2; color: #991b1b;">Nonaktif</span>
                    @endif
                </td>
                <td style="text-align: right;">
                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                        <a href="{{ route('admin.lowongan.edit', $lowongan->lowongan_id) }}" class="btn btn-sm" style="padding: 6px;">
                            <i data-lucide="edit-3" style="width: 14px; height: 14px; color: var(--secondary);"></i>
                        </a>
                        <form action="{{ route('admin.lowongan.destroy', $lowongan->lowongan_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')" style="display: inline;">
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
                    <i data-lucide="inbox" style="width: 48px; height: 48px; margin-bottom: 1rem; opacity: 0.2;"></i>
                    <div>Belum ada data lowongan.</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($lowongans->hasPages())
    <div style="padding: 1.5rem; border-top: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; background: #fff;">
        <div style="font-size: 0.875rem; color: var(--muted)">
            Menampilkan {{ $lowongans->firstItem() }} sampai {{ $lowongans->lastItem() }} dari {{ $lowongans->total() }} data
        </div>
        <div>
            {{ $lowongans->links() }}
        </div>
    </div>
    @endif
</div>

<!-- Filter Modal -->
<div id="filter-modal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div class="modal-content" style="background: white; border-radius: 12px; padding: 2rem; width: 90%; max-width: 500px; max-height: 80vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text);">Filter Lowongan</h3>
            <button id="close-modal" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--muted);">&times;</button>
        </div>

        <form id="filter-form">
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text);">Status Lowongan</label>
                <select name="status" class="form-input" style="width: 100%;">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text);">Tipe Pekerjaan</label>
                <select name="tipe_pekerjaan" class="form-input" style="width: 100%;">
                    <option value="">Semua Tipe</option>
                    <option value="Full-time" {{ request('tipe_pekerjaan') === 'Full-time' ? 'selected' : '' }}>Full-time</option>
                    <option value="Part-time" {{ request('tipe_pekerjaan') === 'Part-time' ? 'selected' : '' }}>Part-time</option>
                    <option value="Internship" {{ request('tipe_pekerjaan') === 'Internship' ? 'selected' : '' }}>Internship</option>
                    <option value="Contract" {{ request('tipe_pekerjaan') === 'Contract' ? 'selected' : '' }}>Contract</option>
                </select>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text);">Lokasi</label>
                <input type="text" name="lokasi" placeholder="Masukkan lokasi kerja..." class="form-input" style="width: 100%;" value="{{ request('lokasi') }}">
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text);">Perusahaan</label>
                <input type="text" name="perusahaan" placeholder="Masukkan nama perusahaan..." class="form-input" style="width: 100%;" value="{{ request('perusahaan') }}">
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

    const url = '{{ route("admin.lowongan.index") }}' + (params.toString() ? '?' + params.toString() : '');
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

    const url = '{{ route("admin.lowongan.index") }}' + (params.toString() ? '?' + params.toString() : '');
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
    window.location.href = '{{ route("admin.lowongan.index") }}';
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
