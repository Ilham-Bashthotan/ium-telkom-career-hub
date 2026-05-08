<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lowongan;

class CrawlController extends Controller
{
    public function index()
    {
        // Menampilkan lowongan hasil crawl yang butuh validasi
        $crawledLowongans = Lowongan::where('sumber', 'crawl')
                                    ->where('status', 'draft')
                                    ->latest('tanggal_posting')
                                    ->paginate(15);
                                    
        return view('admin.crawl.index', compact('crawledLowongans'));
    }
    
    public function process(Request $request)
    {
        // Logika trigger crawler otomatis
        // TODO: Panggil script auto crawler / background job
        
        return redirect()->route('admin.crawl.index')->with('success', 'Proses crawling sedang berjalan di background.');
    }
    
    public function approve($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $lowongan->update(['status' => 'aktif']);
        
        return redirect()->route('admin.crawl.index')->with('success', 'Lowongan hasil crawl berhasil disetujui.');
    }
}
