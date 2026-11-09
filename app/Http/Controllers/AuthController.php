<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login', [
            'pageTitle' => 'Masuk ke Aplikasi',
        ]);
    }

    // Proses login (Fleksibel: Email ATAU Username)
    public function login(Request $request): RedirectResponse
    {
        // Validasi input form
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required'    => 'Email atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // 1. Tentukan apakah input berupa format email atau string username
        $login = $request->input('login');
        $loginType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // 2. Susun kredensial dinamis
        $credentials = [
            $loginType => $login,
            'password'  => $request->input('password'),
        ];

        // 3. Autentikasi dengan Auth::attempt() standar Laravel
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            $nama = $user->nama_lengkap ?? $user->name ?? 'Pengguna';
            $role = is_object($user->role) ? ($user->role->nama_role ?? 'Pengguna') : ($user->role ?? 'Pengguna');

            return redirect()->intended(route('dashboard'))
                ->with('success', "Selamat datang kembali, {$nama}! Anda berhasil masuk sebagai {$role}.");
        }

        // Jika kombinasi salah
        return back()->withInput($request->only('login'))
            ->with('danger', 'Kombinasi email/username atau password tidak sesuai.');
    }

    // Logout
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Anda telah berhasil keluar dari sistem SiToko-032.');
    }
}