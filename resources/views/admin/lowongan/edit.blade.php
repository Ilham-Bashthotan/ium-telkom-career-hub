@extends('layouts.admin')

@section('title', 'Edit Lowongan')

@section('content')
<div class="breadcrumb">
    <span>Admin</span>
    <span>/</span>
    <span>Lowongan</span>
    <span>/</span>
    <span style="color: var(--text); font-weight: 600;">Edit</span>
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Edit Lowongan</h1>
        <p style="color: var(--muted); margin-top: 0.25rem;">Perbarui informasi lowongan kerja atau magang.</p>
    </div>
    <a href="{{ route('admin.lowongan.index') }}" class="btn">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px"></i> Kembali
    </a>
</div>

<div class="card" style="max-width: 900px;">
    <form action="{{ route('admin.lowongan.update', $lowongan->lowongan_id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.lowongan._form')

        <div style="margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid var(--line); display: flex; justify-content: flex-end; gap: 1rem;">
            <a href="{{ route('admin.lowongan.index') }}" class="btn">Batalkan</a>
            <button type="submit" class="btn btn-primary" style="padding-left: 2.5rem; padding-right: 2.5rem;">Perbarui Lowongan</button>
        </div>
    </form>
</div>
@endsection
