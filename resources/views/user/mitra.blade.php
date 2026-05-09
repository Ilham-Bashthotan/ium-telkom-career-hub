@extends('layouts.user')

@section('title', 'Mitra Industri — Telkom Career Hub')

@section('styles')
<style>
    .mitra-card {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius-md);
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .mitra-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
    }
    .mitra-logo {
        width: 80px;
        height: 80px;
        background: var(--bg);
        border-radius: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-weight: 800;
        font-size: 1.25rem;
        color: var(--secondary);
        border: 1px solid var(--line);
    }
</style>
@endsection

@section('content')
<div class="page-container">
    <div style="margin-bottom: 3rem; text-align: center;">
        <h1 style="font-size: 2.5rem; font-weight: 800; letter-spacing: -0.025em; margin-bottom: 0.5rem;">Mitra Industri</h1>
        <p style="color: var(--muted); max-width: 600px; margin: 0 auto;">Kami bekerja sama dengan ratusan perusahaan terkemuka untuk memastikan lulusan SMK Telkom Bandung mendapatkan peluang karir terbaik.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
        @foreach($mitras as $mitra)
        <div class="mitra-card" 
             @auth
                onclick="window.location.href='{{ route('user.mitra.show', $mitra->perusahaan_id) }}'"
             @else
                onclick="return guardNav(event, '{{ route('user.mitra.show', $mitra->perusahaan_id) }}')"
             @endauth>
            <div class="mitra-logo">
                @if($mitra->logo)
                    <img src="{{ asset('storage/' . $mitra->logo) }}" alt="{{ $mitra->nama_perusahaan }}" style="max-width: 100%; max-height: 100%;">
                @else
                    {{ substr($mitra->nama_perusahaan, 0, 2) }}
                @endif
            </div>
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $mitra->nama_perusahaan }}</h3>
            <p style="font-size: 0.875rem; color: var(--muted); margin-bottom: 1.5rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                {{ $mitra->deskripsi }}
            </p>
            <div style="display: flex; justify-content: center; gap: 0.5rem; flex-wrap: wrap;">
                <span class="job-tag">{{ $mitra->sektor_industri }}</span>
                @if($mitra->is_mitra)
                    <span class="pill" style="font-size: 0.625rem;">Mitra Resmi</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <div style="margin-top: 3rem;">
        {{ $mitras->links() }}
    </div>
</div>
@endsection
