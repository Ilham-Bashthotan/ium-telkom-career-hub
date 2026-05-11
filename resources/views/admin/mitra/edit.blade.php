@extends('layouts.admin')

@section('title', 'Edit Mitra')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span>Mitra Industri</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span style="color: var(--text)">Edit</span>
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Edit Mitra Industri</h1>
        <p style="color: var(--muted); margin-top: 0.25rem;">Perbarui informasi mitra perusahaan.</p>
    </div>
    <a href="{{ route('admin.mitra.index') }}" class="btn">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px"></i> Kembali
    </a>
</div>

<div class="card" style="max-width: 900px; padding: 2.5rem;">
    <form action="{{ route('admin.mitra.update', $perusahaan->perusahaan_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        @include('admin.mitra._form')

        <div style="margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid var(--line); display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('admin.mitra.index') }}" class="btn">Batalkan</a>
            <button type="submit" class="btn btn-primary" style="padding-left: 2.5rem; padding-right: 2.5rem;">Perbarui Mitra</button>
        </div>
    </form>
</div>
@endsection
