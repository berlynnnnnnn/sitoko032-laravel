<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiToken;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * GET /api/identitas
     * Endpoint identitas mahasiswa sesuai spesifikasi wajib UTS
     */
    public function getIdentitas(): JsonResponse
    {
        return response()->json([
            'nim'      => '25.K1.0032',
            'nama'     => 'Berlynda Vanetta',
            'foto'     => asset('uploads/profil/0032.jpg'),
            'aplikasi' => 'SiToko-032',
        ], 200, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * POST /api/login
     * Endpoint autentikasi menghasilkan auth_token (Bearer Token) di t032_api_tokens
     */
    public function login(Request $request): JsonResponse
    {
        $loginInput = $request->input('username') ?? $request->input('login') ?? $request->input('email');

        $validator = Validator::make([
            'login'    => $loginInput,
            'password' => $request->input('password'),
        ], [
            'login'    => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required'    => 'Username atau email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'code'    => 400,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 400);
        }

        // Cari user berdasarkan username ATAU email
        $user = User::with('role')
            ->where('username', $loginInput)
            ->orWhere('email', $loginInput)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => 'error',
                'code'    => 401,
                'message' => 'Kredensial login tidak valid. Username/email atau password salah.',
            ], 401);
        }

        // Generate token baru 64 karakter hex
        $token = bin2hex(random_bytes(32));
        $expiresAt = now()->addDays(30);

        ApiToken::create([
            'id_user'    => $user->id_user,
            'token'      => $token,
            'expires_at' => $expiresAt,
        ]);

        return response()->json([
            'status'  => 'success',
            'code'    => 200,
            'message' => 'Login API berhasil.',
            'data'    => [
                'auth_token' => $token,
                'token_type' => 'Bearer',
                'expires_at' => $expiresAt->toDateTimeString(),
                'user'       => [
                    'id_user'      => $user->id_user,
                    'username'     => $user->username,
                    'nama_lengkap' => $user->nama_lengkap,
                    'role'         => $user->role->nama_role ?? '',
                    'foto_profil'  => asset($user->foto_profil),
                    'aplikasi'     => 'SiToko-032',
                ],
            ],
        ], 200, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
