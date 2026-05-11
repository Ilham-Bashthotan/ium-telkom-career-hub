@extends('layouts.admin')

@section('title', 'Tambah Mitra')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span>Mitra Industri</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span style="color: var(--text)">Tambah Baru</span>
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Mitra Industri Baru</h1>
        <p style="color: var(--muted); margin-top: 0.25rem;">Masukkan data perusahaan mitra yang akan ditampilkan di halaman mitra.</p>
    </div>
    <a href="{{ route('admin.mitra.index') }}" class="btn">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px"></i> Kembali
    </a>
</div>

<div class="card" style="max-width: 900px; padding: 2.5rem;">
    <form action="{{ route('admin.mitra.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @include('admin.mitra._form')

        <div style="margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid var(--line); display: flex; justify-content: flex-end; gap: 1rem;">
            <button type="reset" class="btn">Reset Form</button>
            <button type="submit" class="btn btn-primary" style="padding-left: 2.5rem; padding-right: 2.5rem;">Simpan Mitra</button>
        </div>
    </form>
</div>
@endsection
