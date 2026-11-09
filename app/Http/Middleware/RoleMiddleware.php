<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('danger', 'Silakan masuk terlebih dahulu untuk mengakses halaman tersebut.');
        }

        $user = Auth::user();
        $userRole = $user->role->nama_role ?? '';

        if (!empty($roles) && !in_array($userRole, $roles, true)) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status'  => 'error',
                    'code'    => 403,
                    'message' => 'Akses ditolak. Level akun (' . $userRole . ') tidak memiliki izin untuk operasi ini.',
                ], 403);
            }

            return response()->view('errors.403', [
                'userRole' => $userRole,
            ], 403);
        }

        return $next($request);
    }
}
