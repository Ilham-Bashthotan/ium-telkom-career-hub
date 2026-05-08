<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perusahaan;

class PerusahaanController extends Controller
{
    public function index()
    {
        $perusahaans = Perusahaan::latest()->paginate(10);
        return view('admin.mitra', compact('perusahaans'));
    }

    public function create()
    {
        return view('admin.mitra-tambah');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'sektor_industri' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'is_mitra' => 'boolean',
        ]);

        Perusahaan::create($validated);
        return redirect()->route('admin.mitra.index')->with('success', 'Perusahaan berhasil ditambahkan');
    }

    public function show($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        return view('admin.mitra-detail', compact('perusahaan'));
    }

    public function edit($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        return view('admin.mitra-edit', compact('perusahaan'));
    }

    public function update(Request $request, $id)
    {
        $perusahaan = Perusahaan::findOrFail($id);

        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'sektor_industri' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'is_mitra' => 'boolean',
        ]);

        $perusahaan->update($validated);
        return redirect()->route('admin.mitra.index')->with('success', 'Perusahaan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->delete();
        return redirect()->route('admin.mitra.index')->with('success', 'Perusahaan berhasil dihapus');
    }
}
