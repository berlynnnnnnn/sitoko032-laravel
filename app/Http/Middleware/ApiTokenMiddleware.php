<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenMiddleware
{
    /**
     * Handle an incoming request for API token verification.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Ekstraksi token dari header Authorization atau query parameter
        $token = $request->bearerToken();

        if (empty($token)) {
            $token = $request->query('token') ?: $request->query('api_token');
        }

        if (empty($token)) {
            return response()->json([
                'status'  => 'error',
                'code'    => 401,
                'message' => 'Autentikasi gagal. Header Authorization Bearer Token diperlukan.',
            ], 401, ['Content-Type' => 'application/json']);
        }

        // 2. Cari token di database t032_api_tokens dengan relasi user & role
        $apiToken = ApiToken::with(['user.role'])->where('token', $token)->first();

        if (!$apiToken) {
            return response()->json([
                'status'  => 'error',
                'code'    => 401,
                'message' => 'Token autentikasi tidak valid atau telah dicabut.',
            ], 401, ['Content-Type' => 'application/json']);
        }

        // 3. Cek masa kedaluwarsa token
        if ($apiToken->isExpired()) {
            return response()->json([
                'status'  => 'error',
                'code'    => 401,
                'message' => 'Token autentikasi telah kedaluwarsa. Silakan login kembali.',
            ], 401, ['Content-Type' => 'application/json']);
        }

        $user = $apiToken->user;
        $userRole = $user->role->nama_role ?? '';

        // 4. Cek Hak Akses Role jika didefinisikan pada route
        if (!empty($roles) && !in_array($userRole, $roles, true)) {
            return response()->json([
                'status'  => 'error',
                'code'    => 403,
                'message' => 'Akses ditolak. Level akun (' . $userRole . ') tidak memiliki izin untuk operasi ini.',
            ], 403, ['Content-Type' => 'application/json']);
        }

        // Simpan instance user terotentikasi ke attributes request
        $request->attributes->set('api_user', $user);

        return $next($request);
    }
}
