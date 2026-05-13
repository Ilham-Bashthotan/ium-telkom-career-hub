<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('user.login');
    }

    public function showForgetPassword()
    {
        return view('user.forget-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with('success', 'Link reset password telah dikirim ke email Anda!')
                    : back()->withErrors(['email' => 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.']);
    }

    public function showResetPassword(Request $request, $token)
    {
        return view('user.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login dengan password baru.')
                    : back()->withErrors(['email' => ['Token reset password tidak valid atau kadaluarsa.']]);
    }

    public function showAdminLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Selamat datang kembali, ' . Auth::user()->nama_lengkap . '!');
        }

        return back()->with('error', 'Email atau password salah.')->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard')->with('success', 'Login Admin berhasil!');
        }

        return back()->with('error', 'Kredensial admin tidak valid.')->withErrors([
            'email' => 'Kredensial admin tidak valid.',
        ])->withInput($request->only('email'));
    }

    public function showRegister()
    {
        return view('user.register');
    }

    public function validateStep(Request $request)
    {
        $step = $request->step;
        $rules = [];

        if ($step == 1) {
            $rules = [
                'nama_lengkap' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'no_hp' => 'required|string|max:20',
            ];
        } elseif ($step == 2) {
            $rules = [
                'is_alumni' => 'required|boolean',
                'status_pekerjaan' => 'required|string',
            ];
        } elseif ($step == 3) {
            $rules = [
                'password' => 'required|string|min:8|confirmed',
            ];
        }

        $request->validate($rules);

        return response()->json(['success' => true]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_hp' => 'required|string|max:20',
            'is_alumni' => 'required|boolean',
            'status_pekerjaan' => 'nullable|string',
            'tempat_kerja' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'no_hp' => $validated['no_hp'],
            'is_alumni' => $validated['is_alumni'],
            'status_pekerjaan' => $validated['status_pekerjaan'] ?? 'belum_bekerja',
            'tempat_kerja' => $validated['tempat_kerja'] ?? null,
        ]);

        Auth::guard('web')->login($user);

        return redirect('/')->with('success', 'Registrasi berhasil! Selamat bergabung di Telkom Career Hub.');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }
}
