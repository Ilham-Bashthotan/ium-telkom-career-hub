<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\PPDB;

class HomeController extends Controller
{
    public function index()
    {
        $latestLowongans = Lowongan::with('perusahaan')
            ->where('status', 'aktif')
            ->latest('tanggal_posting')
            ->take(5)
            ->get();
            
        $activePPDB = PPDB::where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->first();

        return view('user.home', compact('latestLowongans', 'activePPDB'));
    }
}
