@extends('layouts.admin')

@push('styles')
<style>
    .filter-pill {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.375rem 0.75rem;
        background: #f8fafc;
        border: 1px solid var(--line);
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text);
    }
    .filter-pill a {
        color: var(--muted);
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 16px;
        height: 16px;
        border-radius: 4px;
        transition: all 0.2s;
    }
    .filter-pill a:hover {
        background: var(--primary-light);
        color: var(--primary);
    }
</style>
@endpush

@section('title', 'Manajemen Mitra Industri')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span style="color: var(--text); font-weight: 600;">Mitra Industri</span>
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Daftar Mitra Industri</h1>
        <p style="color: var(--muted); margin-top: 0.25rem;">Kelola data perusahaan yang bekerja sama dengan SMK Telkom Bandung.</p>
    </div>
    <a href="{{ route('admin.mitra.create') }}" class="btn btn-primary">
        <i data-lucide="plus" style="width: 16px; height: 16px"></i> Tambah Mitra
    </a>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <div style="padding: 1.5rem; border-bottom: 1px solid var(--line); display: flex; gap: 1rem; align-items: center; background: #fcfcfc; flex-wrap: wrap;">
        <div style="position: relative; flex: 1; min-width: 250px;">
            <i data-lucide="search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--muted);"></i>
            <input type="text" id="search-input" placeholder="Cari nama perusahaan atau sektor industri..." style="width: 100%; padding: 0.625rem 1rem 0.625rem 2.5rem; border: 1px solid var(--line); border-radius: 8px; font-size: 0.875rem; outline: none;" value="{{ request('search') }}">
        </div>
        <button id="filter-btn" style="padding: 0.625rem 1rem; border: 1px solid var(--line); border-radius: 8px; font-size: 0.875rem; background: #fff; cursor: pointer;">
            <i data-lucide="filter" style="width: 16px; height: 16px; margin-right: 0.5rem;"></i> Filter
        </button>
        <button id="clear-filters" style="padding: 0.625rem 1rem; border: 1px solid var(--line); border-radius: 8px; font-size: 0.875rem; background: #fff; cursor: pointer; min-width: auto;">
            <i data-lucide="x" style="width: 16px; height: 16px"></i> Clear
        </button>
    </div>

    @if(request()->anyFilled(['search', 'is_mitra', 'sektor_industri', 'website']))
    <div style="padding: 1.25rem 1.5rem 1rem; display: flex; gap: 0.75rem; flex-wrap: wrap; background: #fcfcfc; border-bottom: 1px solid var(--line);">
        <div style="font-size: 0.75rem; color: var(--muted); font-weight: 700; display: flex; align-items: center; gap: 0.5rem; margin-right: 0.25rem;">
            <i data-lucide="list-filter" style="width: 14px; height: 14px"></i>
            FILTER AKTIF:
        </div>
        
        @if(request('search'))
            <div class="filter-pill">
                <span>"{{ request('search') }}"</span>
                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}"><i data-lucide="x" style="width: 12px; height: 12px"></i></a>
            </div>
        @endif

        @if(request('is_mitra') !== null && request('is_mitra') !== '')
            <div class="filter-pill">
                <span>Status: {{ request('is_mitra') == '1' ? 'Official Partner' : 'Umum' }}</span>
                <a href="{{ request()->fullUrlWithQuery(['is_mitra' => null]) }}"><i data-lucide="x" style="width: 12px; height: 12px"></i></a>
            </div>
        @endif

        @if(request('sektor_industri'))
            <div class="filter-pill">
                <span>Sektor: {{ request('sektor_industri') }}</span>
                <a href="{{ request()->fullUrlWithQuery(['sektor_industri' => null]) }}"><i data-lucide="x" style="width: 12px; height: 12px"></i></a>
            </div>
        @endif

        @if(request('website'))
            <div class="filter-pill">
                <span>Website: {{ request('website') }}</span>
                <a href="{{ request()->fullUrlWithQuery(['website' => null]) }}"><i data-lucide="x" style="width: 12px; height: 12px"></i></a>
            </div>
        @endif
    </div>
    @endif

    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 1px solid var(--line);">
                <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Nama Perusahaan</th>
                <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Sektor Industri</th>
                <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Website</th>
                <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Status Mitra</th>
                <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perusahaans as $mitra)
            <tr style="border-bottom: 1px solid var(--line); transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                <td style="padding: 1.25rem 1.5rem;">
                    <div style="font-weight: 700; color: var(--text);">{{ $mitra->nama_perusahaan }}</div>
                </td>
                <td style="padding: 1.25rem 1.5rem; font-size: 0.875rem;">
                    {{ $mitra->sektor_industri ?? '-' }}
                </td>
                <td style="padding: 1.25rem 1.5rem; font-size: 0.875rem; color: var(--primary);">
                    @if($mitra->website)
                        <a href="{{ $mitra->website }}" target="_blank" style="display: flex; align-items: center; gap: 0.25rem;">
                            {{ Str::limit($mitra->website, 20) }} <i data-lucide="external-link" style="width: 12px; height: 12px"></i>
                        </a>
                    @else
                        -
                    @endif
                </td>
                <td style="padding: 1.25rem 1.5rem;">
                    @if($mitra->is_mitra)
                        <span class="pill" style="background: #e0f2fe; color: #0369a1; padding: 0.25rem 0.75rem;">Official Partner</span>
                    @else
                        <span class="pill" style="background: #f1f5f9; color: #475569; padding: 0.25rem 0.75rem;">Umum</span>
                    @endif
                </td>
                <td style="padding: 1.25rem 1.5rem;">
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.mitra.edit', $mitra->perusahaan_id) }}" class="btn" style="padding: 0.4rem; border-radius: 6px;">
                            <i data-lucide="edit-3" style="width: 16px; height: 16px; color: var(--secondary);"></i>
                        </a>
                        <form action="{{ route('admin.mitra.destroy', $mitra->perusahaan_id) }}" method="POST" onsubmit="return confirmDelete(event, '{{ route('admin.mitra.destroy', $mitra->perusahaan_id) }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="padding: 0.4rem; border-radius: 6px; color: #ef4444;">
                                <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 4rem 1.5rem; text-align: center; color: var(--muted);">
                    <div>Belum ada data mitra industri.</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Filter Modal -->
<div id="filter-modal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div class="modal-content" style="background: white; border-radius: 12px; padding: 2rem; width: 90%; max-width: 500px; max-height: 80vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text);">Filter Mitra Industri</h3>
            <button id="close-modal" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--muted);">&times;</button>
        </div>

        <form id="filter-form">
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text);">Status Mitra</label>
                <select name="is_mitra" style="width: 100%; padding: 0.625rem 1rem; border: 1px solid var(--line); border-radius: 8px; font-size: 0.875rem; outline: none;">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_mitra') === '1' ? 'selected' : '' }}>Official Partner</option>
                    <option value="0" {{ request('is_mitra') === '0' ? 'selected' : '' }}>Umum</option>
                </select>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text);">Sektor Industri</label>
                <input type="text" name="sektor_industri" placeholder="Masukkan sektor industri..." style="width: 100%; padding: 0.625rem 1rem; border: 1px solid var(--line); border-radius: 8px; font-size: 0.875rem; outline: none;" value="{{ request('sektor_industri') }}">
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text);">Website</label>
                <input type="text" name="website" placeholder="Masukkan domain website..." style="width: 100%; padding: 0.625rem 1rem; border: 1px solid var(--line); border-radius: 8px; font-size: 0.875rem; outline: none;" value="{{ request('website') }}">
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" id="reset-filter" style="padding: 0.625rem 1rem; border: 1px solid var(--line); border-radius: 8px; font-size: 0.875rem; background: #fff; cursor: pointer;">Reset</button>
                <button type="submit" style="padding: 0.625rem 1rem; border: none; border-radius: 8px; font-size: 0.875rem; background: var(--primary); color: white; cursor: pointer;">Terapkan Filter</button>
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

    const url = '{{ route("admin.mitra.index") }}' + (params.toString() ? '?' + params.toString() : '');
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

    const url = '{{ route("admin.mitra.index") }}' + (params.toString() ? '?' + params.toString() : '');
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
    window.location.href = '{{ route("admin.mitra.index") }}';
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
