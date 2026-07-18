<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Membatasi halaman berdasarkan role akun yang sedang login.
     *
     * Contoh:
     * ->middleware('role:Super Admin')
     * ->middleware('role:Super Admin,Admin')
     */
    public function handle(
        Request $request,
        Closure $next,
        string ...$allowedRoles
    ): Response {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!in_array($user->role, $allowedRoles, true)) {
            abort(
                403,
                'Akun Anda tidak memiliki izin untuk membuka halaman ini.'
            );
        }

        return $next($request);
    }
}
