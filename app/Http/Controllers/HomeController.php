<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Perusahaan;
use App\Models\PPDB;

class HomeController extends Controller
{
    public function index()
    {
        $latestLowongans = Lowongan::with('perusahaan')
            ->where('status', 'aktif')
            ->latest('tanggal_posting')
            ->take(6)
            ->get();
            
        $mitraCount = Perusahaan::where('is_mitra', true)->count();
        $partners = Perusahaan::where('is_mitra', true)->latest()->take(8)->get();
        $ppdbs = PPDB::latest()->get();

        return view('index', compact('latestLowongans', 'mitraCount', 'partners', 'ppdbs'));
    }
}
