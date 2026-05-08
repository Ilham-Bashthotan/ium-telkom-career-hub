<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Jurusan;

class LowonganController extends Controller
{
    public function index(Request $request)
    {
        $query = Lowongan::with(['perusahaan', 'jurusan'])
                ->where('status', 'aktif');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhereHas('perusahaan', function($sq) use ($request) {
                      $sq->where('nama_perusahaan', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->filled('jurusan')) {
            $query->whereHas('jurusan', function($q) use ($request) {
                $q->where('kode_jurusan', $request->jurusan);
            });
        }

        if ($request->filled('tipe')) {
            $query->where('tipe_pekerjaan', $request->tipe);
        }

        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        $lowongans = $query->latest('tanggal_posting')->paginate(10);
        $jurusans = Jurusan::all();
        
        return view('user.lowongan', compact('lowongans', 'jurusans'));
    }

    public function show($id)
    {
        $lowongan = Lowongan::with(['perusahaan', 'jurusan'])->findOrFail($id);
        return view('user.detail-lowongan', compact('lowongan'));
    }
}
