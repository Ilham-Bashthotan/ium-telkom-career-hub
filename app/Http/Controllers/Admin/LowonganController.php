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
    public function index()
    {
        $lowongans = Lowongan::with(['perusahaan', 'jurusan'])->latest('tanggal_posting')->paginate(10);
        return view('admin.lowongan', compact('lowongans'));
    }

    public function create()
    {
        $perusahaans = Perusahaan::all();
        $jurusans = Jurusan::all();
        return view('admin.lowongan-tambah', compact('perusahaans', 'jurusans'));
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
        return view('admin.lowongan-detail', compact('lowongan'));
    }

    public function edit($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $perusahaans = Perusahaan::all();
        $jurusans = Jurusan::all();
        return view('admin.lowongan-edit', compact('lowongan', 'perusahaans', 'jurusans'));
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
