<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Perusahaan;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Auth;

class LowonganController extends Controller
{
    public function index(Request $request)
    {
        $query = Lowongan::with(['perusahaan', 'jurusan']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->orWhereHas('perusahaan', function($subQ) use ($search) {
                      $subQ->where('nama_perusahaan', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('jurusan', function($subQ) use ($search) {
                      $subQ->where('nama_jurusan', 'like', '%' . $search . '%');
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by tipe pekerjaan
        if ($request->has('tipe_pekerjaan') && !empty($request->tipe_pekerjaan)) {
            $query->where('tipe_pekerjaan', $request->tipe_pekerjaan);
        }

        // Filter by lokasi
        if ($request->has('lokasi') && !empty($request->lokasi)) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        // Filter by perusahaan
        if ($request->has('perusahaan') && !empty($request->perusahaan)) {
            $query->whereHas('perusahaan', function($subQ) use ($request) {
                $subQ->where('nama_perusahaan', 'like', '%' . $request->perusahaan . '%');
            });
        }

        $lowongans = $query->latest('tanggal_posting')->paginate(10)->appends($request->query());
        return view('admin.lowongan.index', compact('lowongans'));
    }

    public function create()
    {
        $perusahaans = Perusahaan::all();
        $jurusans = Jurusan::all();
        return view('admin.lowongan.create', compact('perusahaans', 'jurusans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'link_apply' => 'nullable|url',
            'perusahaan_id' => 'required|exists:perusahaans,perusahaan_id',
            'jurusan_id' => 'nullable|exists:jurusans,jurusan_id',
            'lokasi' => 'nullable|string|max:255',
            'tipe_pekerjaan' => 'nullable|in:Full-time,Part-time,Internship,Contract',
            'gaji' => 'nullable|string|max:255',
            'tanggal_expired' => 'nullable|date',
            'status' => 'required|in:draft,aktif,nonaktif',
        ]);

        $validated['admin_id'] = Auth::guard('admin')->id();
        $validated['sumber'] = 'manual';
        $validated['tanggal_posting'] = now();

        Lowongan::create($validated);

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil ditambahkan');
    }

    public function show($id)
    {
        $lowongan = Lowongan::with(['perusahaan', 'jurusan', 'admin'])->findOrFail($id);
        return view('admin.lowongan.show', compact('lowongan'));
    }

    public function edit($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $perusahaans = Perusahaan::all();
        $jurusans = Jurusan::all();
        return view('admin.lowongan.edit', compact('lowongan', 'perusahaans', 'jurusans'));
    }

    public function update(Request $request, $id)
    {
        $lowongan = Lowongan::findOrFail($id);
        
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'link_apply' => 'nullable|url',
            'perusahaan_id' => 'required|exists:perusahaans,perusahaan_id',
            'jurusan_id' => 'nullable|exists:jurusans,jurusan_id',
            'lokasi' => 'nullable|string|max:255',
            'tipe_pekerjaan' => 'nullable|in:Full-time,Part-time,Internship,Contract',
            'gaji' => 'nullable|string|max:255',
            'tanggal_expired' => 'nullable|date',
            'status' => 'required|in:draft,aktif,nonaktif',
        ]);

        $lowongan->update($validated);

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $lowongan->delete();

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil dihapus');
    }
}
