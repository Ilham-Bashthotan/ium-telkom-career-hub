<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'nullable|in:admin,user'
        ]);

        $role = $request->role ?? 'user';

        if ($role === 'admin') {
            $user = Admin::where('email', $request->email)->first();
            $tokenAbility = 'role:admin';
        } else {
            $user = User::where('email', $request->email)->first();
            $tokenAbility = 'role:user';
        }

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah.'
            ], 401);
        }

        $token = $user->createToken('auth_token', [$tokenAbility])->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'role' => $role
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_hp' => 'nullable|string|max:20',
            'is_alumni' => 'boolean',
        ]);

        $user = User::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'no_hp' => $validated['no_hp'] ?? null,
            'is_alumni' => $request->has('is_alumni') ? true : false,
            'status_pekerjaan' => 'belum_bekerja',
        ]);

        $token = $user->createToken('auth_token', ['role:user'])->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'role' => 'user'
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'role' => in_array('role:admin', $request->user()->currentAccessToken()->abilities) ? 'admin' : 'user'
        ]);
    }
}
