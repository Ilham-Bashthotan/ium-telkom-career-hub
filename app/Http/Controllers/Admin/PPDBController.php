<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PPDB;
use Illuminate\Support\Facades\Auth;

class PPDBController extends Controller
{
    public function index()
    {
        $ppdbs = PPDB::latest()->paginate(10);
        return view('admin.ppdb.index', compact('ppdbs'));
    }

    public function create()
    {
        return view('admin.ppdb.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'banner_url' => 'nullable|url',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $validated['admin_id'] = Auth::guard('admin')->id();

        PPDB::create($validated);
        return redirect()->route('admin.ppdb.index')->with('success', 'Info PPDB berhasil ditambahkan');
    }

    public function show($id)
    {
        $ppdb = PPDB::findOrFail($id);
        return view('admin.ppdb.show', compact('ppdb'));
    }

    public function edit($id)
    {
        $ppdb = PPDB::findOrFail($id);
        return view('admin.ppdb.edit', compact('ppdb'));
    }

    public function update(Request $request, $id)
    {
        $ppdb = PPDB::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'banner_url' => 'nullable|url',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $ppdb->update($validated);
        return redirect()->route('admin.ppdb.index')->with('success', 'Info PPDB berhasil diperbarui');
    }

    public function destroy($id)
    {
        $ppdb = PPDB::findOrFail($id);
        $ppdb->delete();
        return redirect()->route('admin.ppdb.index')->with('success', 'Info PPDB berhasil dihapus');
    }
}
