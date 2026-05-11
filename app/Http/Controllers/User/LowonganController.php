<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Jurusan;
use App\Models\SavedLowongan;

class LowonganController extends Controller
{
    public function index(Request $request)
    {
        $query = Lowongan::with(['perusahaan', 'jurusan'])
                ->where('status', 'aktif')
                ->where(function($q) {
                    $q->whereNull('tanggal_expired')
                      ->orWhere('tanggal_expired', '>=', now());
                });

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
            $query->whereIn('tipe_pekerjaan', (array)$request->tipe);
        }

        if ($request->filled('lokasi')) {
            $query->where(function($q) use ($request) {
                foreach ((array)$request->lokasi as $loc) {
                    $q->orWhere('lokasi', 'like', '%' . $loc . '%');
                }
            });
        }

        if ($request->filled('gaji')) {
            if ($request->gaji == 'under_3') {
                $query->where('gaji', 'like', '%1.%')->orWhere('gaji', 'like', '%2.%');
            } elseif ($request->gaji == '3_6') {
                $query->where('gaji', 'like', '%3.%')->orWhere('gaji', 'like', '%4.%')->orWhere('gaji', 'like', '%5.%');
            } elseif ($request->gaji == 'above_6') {
                $query->where('gaji', 'not like', '%1.%')
                      ->where('gaji', 'not like', '%2.%')
                      ->where('gaji', 'not like', '%3.%')
                      ->where('gaji', 'not like', '%4.%')
                      ->where('gaji', 'not like', '%5.%');
            }
        }

        $lowongans = $query->latest('tanggal_posting')->paginate(10);
        $jurusans = Jurusan::all();

        if ($request->anyFilled(['search', 'jurusan', 'tipe', 'lokasi', 'gaji'])) {
            session()->now('info', 'Filter berhasil diterapkan.');
        }

        if ($request->has('reset')) {
            session()->now('success', 'Filter berhasil dihapus.');
        }
        
        return view('user.lowongan', compact('lowongans', 'jurusans'));
    }

    public function show($id)
    {
        $lowongan = Lowongan::with(['perusahaan', 'jurusan'])->findOrFail($id);
        $isSaved = auth()->check() ? SavedLowongan::where('user_id', auth()->id())->where('lowongan_id', $id)->exists() : false;
        
        return view('user.detail-lowongan', compact('lowongan', 'isSaved'));
    }

    public function toggleSave($id)
    {
        $userId = auth()->id();
        $saved = SavedLowongan::where('user_id', $userId)
            ->where('lowongan_id', $id)
            ->first();

        if ($saved) {
            $saved->delete();
            return back()->with('success', 'Lowongan dihapus dari daftar simpanan.');
        } else {
            SavedLowongan::create([
                'user_id' => $userId,
                'lowongan_id' => $id
            ]);
            return back()->with('success', 'Lowongan berhasil disimpan.');
        }
    }
}
