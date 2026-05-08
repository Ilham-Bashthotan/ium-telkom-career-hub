<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\User;
use App\Models\Perusahaan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLowongan = Lowongan::count();
        $activeLowongan = Lowongan::where('status', 'aktif')->count();
        $totalUsers = User::count();
        $totalMitra = Perusahaan::count();
        
        return view('admin.dashboard', compact(
            'totalLowongan', 'activeLowongan', 'totalUsers', 'totalMitra'
        ));
    }
}
