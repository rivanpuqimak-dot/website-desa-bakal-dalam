<?php

namespace App\Http\Controllers\Admin\settings;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class SettingController extends Controller
{
    public function index(): View
    {
        $setting = Setting::first();

        return view(
            'admin.settings.index',
            compact('setting')
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'nama_website' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'slogan' => [
                    'nullable',
                    'string',
                    'max:255',
                ],
                'logo' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:5120',
                ],
                'favicon' => [
                    'nullable',
                    'file',
                    'mimes:jpg,jpeg,png,webp,ico',
                    'max:5120',
                ],
                'footer' => [
                    'nullable',
                    'string',
                ],
                'meta_title' => [
                    'nullable',
                    'string',
                    'max:255',
                ],
                'meta_description' => [
                    'nullable',
                    'string',
                ],
                'meta_keywords' => [
                    'nullable',
                    'string',
                ],
                'maintenance_mode' => [
                    'nullable',
                    'boolean',
                ],
            ],
            [
                'nama_website.required' =>
                    'Nama website wajib diisi.',
                'nama_website.string' =>
                    'Nama website harus berupa teks.',
                'nama_website.max' =>
                    'Nama website maksimal 255 karakter.',

                'slogan.string' =>
                    'Slogan harus berupa teks.',
                'slogan.max' =>
                    'Slogan maksimal 255 karakter.',

                'logo.image' =>
                    'Logo harus berupa file gambar.',
                'logo.mimes' =>
                    'Format logo harus JPG, JPEG, PNG, atau WEBP.',
                'logo.max' =>
                    'Ukuran logo maksimal 5 MB.',

                'favicon.file' =>
                    'Favicon harus berupa file.',
                'favicon.mimes' =>
                    'Format favicon boleh JPG, JPEG, PNG, WEBP, atau ICO.',
                'favicon.max' =>
                    'Ukuran favicon maksimal 5 MB.',

                'footer.string' =>
                    'Footer harus berupa teks.',
                'meta_title.string' =>
                    'Meta title harus berupa teks.',
                'meta_title.max' =>
                    'Meta title maksimal 255 karakter.',
                'meta_description.string' =>
                    'Meta description harus berupa teks.',
                'meta_keywords.string' =>
                    'Meta keywords harus berupa teks.',
                'maintenance_mode.boolean' =>
                    'Mode maintenance harus bernilai benar atau salah.',
            ]
        );

        $setting = Setting::first() ?? new Setting();

        $oldLogo = $setting->logo;
        $oldFavicon = $setting->favicon;
        $newLogo = null;
        $newFavicon = null;

        try {
            if ($request->hasFile('logo')) {
                $newLogo = $request->file('logo')->store(
                    'settings',
                    'public'
                );

                if (!$newLogo) {
                    throw new \RuntimeException(
                        'Logo gagal disimpan.'
                    );
                }

                $setting->logo = $newLogo;
            }

            if ($request->hasFile('favicon')) {
                $newFavicon = $request->file('favicon')->store(
                    'settings',
                    'public'
                );

                if (!$newFavicon) {
                    throw new \RuntimeException(
                        'Favicon gagal disimpan.'
                    );
                }

                $setting->favicon = $newFavicon;
            }

            $setting->nama_website = trim(
                $validated['nama_website']
            );

            $setting->slogan = filled(
                $validated['slogan'] ?? null
            )
                ? trim($validated['slogan'])
                : null;

            $setting->footer = filled(
                $validated['footer'] ?? null
            )
                ? trim($validated['footer'])
                : null;

            $setting->meta_title = filled(
                $validated['meta_title'] ?? null
            )
                ? trim($validated['meta_title'])
                : null;

            $setting->meta_description = filled(
                $validated['meta_description'] ?? null
            )
                ? trim($validated['meta_description'])
                : null;

            $setting->meta_keywords = filled(
                $validated['meta_keywords'] ?? null
            )
                ? collect(
                    explode(
                        ',',
                        $validated['meta_keywords']
                    )
                )
                    ->map(
                        fn ($keyword) => trim($keyword)
                    )
                    ->filter()
                    ->unique()
                    ->implode(', ')
                : null;
            $setting->maintenance_mode =
                $request->boolean('maintenance_mode');

            $setting->save();

            if (
                $newLogo &&
                $oldLogo &&
                $oldLogo !== $newLogo &&
                Storage::disk('public')->exists($oldLogo)
            ) {
                Storage::disk('public')->delete($oldLogo);
            }

            if (
                $newFavicon &&
                $oldFavicon &&
                $oldFavicon !== $newFavicon &&
                Storage::disk('public')->exists($oldFavicon)
            ) {
                Storage::disk('public')->delete($oldFavicon);
            }

            return back()->with(
                'success',
                'Pengaturan berhasil disimpan. Favicon baru mungkin perlu Ctrl + F5 agar terlihat.'
            );
        } catch (Throwable $exception) {
            if (
                $newLogo &&
                Storage::disk('public')->exists($newLogo)
            ) {
                Storage::disk('public')->delete($newLogo);
            }

            if (
                $newFavicon &&
                Storage::disk('public')->exists($newFavicon)
            ) {
                Storage::disk('public')->delete($newFavicon);
            }

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Pengaturan gagal disimpan. ' .
                    $exception->getMessage()
                );
        }
    }
}
