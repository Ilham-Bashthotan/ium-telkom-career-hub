<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Perusahaan;

class PerusahaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Perusahaan::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_perusahaan', 'like', '%' . $search . '%')
                  ->orWhere('sektor_industri', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        // Filter by is_mitra
        if ($request->has('is_mitra') && $request->is_mitra !== '') {
            $query->where('is_mitra', $request->is_mitra);
        }

        // Filter by sektor_industri
        if ($request->has('sektor_industri') && !empty($request->sektor_industri)) {
            $query->where('sektor_industri', 'like', '%' . $request->sektor_industri . '%');
        }

        // Filter by website
        if ($request->has('website') && !empty($request->website)) {
            $query->where('website', 'like', '%' . $request->website . '%');
        }

        $perusahaans = $query->latest()->paginate(10)->appends($request->query());
        return view('admin.mitra.index', compact('perusahaans'));
    }

    public function create()
    {
        return view('admin.mitra.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'sektor_industri' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_mitra' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Perusahaan::create($validated);
        return redirect()->route('admin.mitra.index')->with('success', 'Perusahaan berhasil ditambahkan');
    }

    public function show($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        return view('admin.mitra.show', compact('perusahaan'));
    }

    public function edit($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        return view('admin.mitra.edit', compact('perusahaan'));
    }

    public function update(Request $request, $id)
    {
        $perusahaan = Perusahaan::findOrFail($id);

        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'sektor_industri' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_mitra' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            if ($perusahaan->logo) {
                Storage::disk('public')->delete($perusahaan->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

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
