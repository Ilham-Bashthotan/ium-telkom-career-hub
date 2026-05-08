<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perusahaan;

class PerusahaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Perusahaan::query();

        if ($request->has('search')) {
            $query->where('nama_perusahaan', 'like', '%' . $request->search . '%');
        }

        $mitras = $query->paginate(12);
        return view('user.mitra', compact('mitras'));
    }

    public function show($id)
    {
        $mitra = Perusahaan::with(['lowongans' => function($q) {
            $q->where('status', 'aktif')->latest('tanggal_posting');
        }])->findOrFail($id);
        
        return view('user.detail-mitra', compact('mitra'));
    }
}
