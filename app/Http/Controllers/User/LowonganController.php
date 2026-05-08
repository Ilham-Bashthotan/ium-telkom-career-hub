<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lowongan;

class LowonganController extends Controller
{
    public function index(Request $request)
    {
        $query = Lowongan::with(['perusahaan', 'jurusan'])
                ->where('status', 'aktif');

        if ($request->has('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $lowongans = $query->latest('tanggal_posting')->paginate(10);
        
        return view('user.lowongan', compact('lowongans'));
    }

    public function show($id)
    {
        $lowongan = Lowongan::with(['perusahaan', 'jurusan'])->findOrFail($id);
        return view('user.detail-lowongan', compact('lowongan'));
    }
}
