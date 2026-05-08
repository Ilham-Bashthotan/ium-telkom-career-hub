<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Perusahaan;

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

        return view('index', compact('latestLowongans', 'mitraCount'));
    }
}
