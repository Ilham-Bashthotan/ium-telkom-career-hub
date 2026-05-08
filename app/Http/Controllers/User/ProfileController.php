<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('user.profil', compact('user'));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'is_alumni' => 'boolean',
            'status_pekerjaan' => 'nullable|in:belum_bekerja,sedang_bekerja,wirausaha',
            'tempat_kerja' => 'nullable|string|max:255'
        ]);

        $user->update([
            'nama_lengkap' => $validated['nama_lengkap'],
            'no_hp' => $validated['no_hp'],
            'is_alumni' => $request->has('is_alumni'),
            'status_pekerjaan' => $validated['status_pekerjaan'],
            'tempat_kerja' => $validated['tempat_kerja'],
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
