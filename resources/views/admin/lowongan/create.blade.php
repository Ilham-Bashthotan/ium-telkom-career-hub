@extends('layouts.admin')

@section('title', 'Tambah Lowongan')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span>Lowongan Kerja</span>
    <i data-lucide="chevron-right" style="width: 12px; height: 12px"></i>
    <span style="color: var(--text)">Tambah Baru</span>
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Lowongan Baru</h1>
        <p style="color: var(--muted); margin-top: 0.25rem;">Masukkan informasi detail mengenai lowongan yang akan dipublikasikan.</p>
    </div>
    <a href="{{ route('admin.lowongan.index') }}" class="btn">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px"></i> Kembali
    </a>
</div>

<div class="card" style="max-width: 900px; padding: 2.5rem;">
    <form action="{{ route('admin.lowongan.store') }}" method="POST">
        @csrf
        @include('admin.lowongan._form')

        <div style="margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid var(--line); display: flex; justify-content: flex-end; gap: 1rem;">
            <button type="reset" class="btn">Reset Form</button>
            <button type="submit" class="btn btn-primary" style="padding-left: 2.5rem; padding-right: 2.5rem;">Simpan Lowongan</button>
        </div>
    </form>
@endsection
