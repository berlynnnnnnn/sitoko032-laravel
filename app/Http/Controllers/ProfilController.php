<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfilController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        return view('profil.index', [
            'pageTitle'  => 'Profil Pengguna',
            'activeMenu' => 'profil',
            'user'       => $user,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap'  => 'required|string|max:100',
            'email'         => 'nullable|email|max:100',
            'password_baru' => 'nullable|string|min:6',
            'foto_profil'   => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // Maksimal 2 MB, JPG/PNG
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.email'           => 'Format alamat email tidak valid.',
            'password_baru.min'     => 'Password baru minimal 6 karakter.',
            'foto_profil.image'     => 'Berkas yang diunggah harus berupa gambar.',
            'foto_profil.mimes'     => 'Format foto harus JPG, JPEG, atau PNG.',
            'foto_profil.max'       => 'Ukuran foto profil maksimal 2 MB.',
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email        = $request->email;

        if (!empty($request->password_baru)) {
            $user->password = Hash::make($request->password_baru);
        }

        // Upload Foto Profil
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');

            $uploadDir = public_path('uploads/profil');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Jika Super Admin (25.K1.0032), simpan sebagai 0032.jpg sesuai aturan spesifikasi
            if ($user->username === '25.K1.0032') {
                $targetFileName = '0032.jpg';
            } else {
                $targetFileName = 'user_' . $user->id_user . '_' . time() . '.' . $file->getClientOriginalExtension();
            }

            $file->move($uploadDir, $targetFileName);
            $user->foto_profil = 'uploads/profil/' . $targetFileName;
        }

        $user->save();

        return redirect()->route('profil.index')
            ->with('success', 'Profil dan foto Anda berhasil diperbarui!');
    }
}
