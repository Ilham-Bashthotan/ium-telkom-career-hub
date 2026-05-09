<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('status_pekerjaan', 'like', '%' . $search . '%')
                  ->orWhere('tempat_kerja', 'like', '%' . $search . '%');
            });
        }

        // Filter functionality
        if ($request->has('is_alumni') && $request->is_alumni !== '') {
            $query->where('is_alumni', $request->is_alumni);
        }

        if ($request->has('status_pekerjaan') && !empty($request->status_pekerjaan)) {
            $query->where('status_pekerjaan', 'like', '%' . $request->status_pekerjaan . '%');
        }

        if ($request->has('tempat_kerja') && !empty($request->tempat_kerja)) {
            $query->where('tempat_kerja', 'like', '%' . $request->tempat_kerja . '%');
        }

        $users = $query->latest()->paginate(15)->appends($request->query());
        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }
}
