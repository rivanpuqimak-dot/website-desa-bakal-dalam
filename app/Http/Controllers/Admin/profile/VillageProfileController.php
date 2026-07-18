<?php

namespace App\Http\Controllers\Admin\profile;

use App\Http\Controllers\Controller;
use App\Models\VillageProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VillageProfileController extends Controller
{
    public function index()
    {
        $profile = VillageProfile::first();

        return view('admin.profile.identitas', compact('profile'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_desa' => 'required|string|max:255',
            'village_slogan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:20',

            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',

            'hero_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'cover_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'office_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'struktur_organisasi' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'struktur_bpd' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $profile = VillageProfile::firstOrNew([]);

        $profile->fill([
            'nama_desa' => $validated['nama_desa'],
            'village_slogan' => $validated['village_slogan'] ?? null,
            'kecamatan' => $validated['kecamatan'] ?? null,
            'kabupaten' => $validated['kabupaten'] ?? null,
            'provinsi' => $validated['provinsi'] ?? null,
            'kode_pos' => $validated['kode_pos'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
        ]);

        $this->replaceUploadedImage(
            $request,
            $profile,
            'hero_image',
            'village-hero'
        );

        $this->replaceUploadedImage(
            $request,
            $profile,
            'cover_image',
            'village-cover'
        );

        $this->replaceUploadedImage(
            $request,
            $profile,
            'office_photo',
            'village-office'
        );

        $this->replaceUploadedImage(
            $request,
            $profile,
            'logo',
            'logo-desa'
        );

        $this->replaceUploadedImage(
            $request,
            $profile,
            'struktur_organisasi',
            'struktur-organisasi'
        );

        $this->replaceUploadedImage(
            $request,
            $profile,
            'struktur_bpd',
            'struktur-bpd'
        );

        $profile->save();

        return back()->with(
            'success',
            'Data identitas desa berhasil disimpan.'
        );
    }

    private function replaceUploadedImage(
        Request $request,
        VillageProfile $profile,
        string $field,
        string $folder
    ): void {
        if (!$request->hasFile($field)) {
            return;
        }

        $oldFile = $profile->{$field};

        if (
            filled($oldFile) &&
            Storage::disk('public')->exists($oldFile)
        ) {
            Storage::disk('public')->delete($oldFile);
        }

        $profile->{$field} = $request
            ->file($field)
            ->store($folder, 'public');
    }
}