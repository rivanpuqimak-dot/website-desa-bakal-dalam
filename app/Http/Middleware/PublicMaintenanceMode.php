<?php

namespace App\Http\Middleware;

use App\Models\Contact;
use App\Models\Setting;
use App\Models\VillageProfile;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PublicMaintenanceMode
{
    /**
     * Menutup halaman publik saat maintenance mode diaktifkan.
     *
     * Pengguna yang sudah login ke dashboard tetap dapat membuka
     * website publik untuk memeriksa hasil perubahan.
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $setting = Setting::query()->first();

        if (
            !$setting?->maintenance_mode ||
            $request->user()
        ) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json(
                [
                    'message' =>
                        'Website sedang dalam pemeliharaan.',
                ],
                503
            );
        }

        return response()
            ->view(
                'errors.maintenance',
                [
                    'settings' => $setting,
                    'profile' =>
                        VillageProfile::query()->first(),
                    'contact' =>
                        Contact::query()->first(),
                ],
                503
            )
            ->header('Retry-After', '3600');
    }
}
