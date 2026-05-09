<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PPDB;
use Illuminate\Support\Facades\Auth;

class PPDBController extends Controller
{
    public function index(Request $request)
    {
        $query = PPDB::with('admin');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('konten', 'like', '%' . $search . '%');
            });
        }

        $ppdbs = $query->latest()->paginate(10)->appends($request->query());
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
            'banner_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        if ($request->hasFile('banner_url')) {
            $validated['banner_url'] = $request->file('banner_url')->store('ppdb-banners', 'public');
        }

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
            'banner_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        if ($request->hasFile('banner_url')) {
            if ($ppdb->banner_url) {
                Storage::disk('public')->delete($ppdb->banner_url);
            }
            $validated['banner_url'] = $request->file('banner_url')->store('ppdb-banners', 'public');
        }

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
