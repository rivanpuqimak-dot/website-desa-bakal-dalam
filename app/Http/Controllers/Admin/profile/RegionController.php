<?php

namespace App\Http\Controllers\Admin\profile;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegionController extends Controller
{
    public function index()
    {
        $region = Region::first();

        return view('admin.profile.wilayah', compact('region'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'deskripsi' => 'nullable',
            'luas_wilayah' => 'nullable|string',
            'jumlah_dusun' => 'nullable|integer',
            'batas_utara' => 'nullable|string',
            'batas_selatan' => 'nullable|string',
            'batas_timur' => 'nullable|string',
            'batas_barat' => 'nullable|string',
            'google_maps' => 'nullable|string',
            'google_maps_embed' => 'nullable',
            'map_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'jumlah_dusun.integer' => 'Jumlah dusun harus berupa angka.',
            'map_image.image' => 'Gambar peta harus berupa file gambar.',
            'map_image.mimes' => 'Format gambar peta harus JPG, JPEG, PNG, atau WEBP.',
            'map_image.max' => 'Ukuran gambar peta maksimal 2 MB.',
        ]);

        $region = Region::first() ?? new Region();

        $region->deskripsi = $request->deskripsi;
        $region->luas_wilayah = $request->luas_wilayah;

        $region->jumlah_dusun = $request->jumlah_dusun;
        $region->batas_utara = $request->batas_utara;
        $region->batas_selatan = $request->batas_selatan;

        $region->batas_timur = $request->batas_timur;
        $region->batas_barat = $request->batas_barat;
        $region->google_maps = $request->google_maps;
        $region->google_maps_embed = $request->google_maps_embed;

        if ($request->hasFile('map_image')) {
            if ($region->map_image && Storage::disk('public')->exists($region->map_image)) {
                Storage::disk('public')->delete($region->map_image);
            }
            $region->map_image = $request->file('map_image')->store('region-map', 'public');
        }

        $region->save();

        return back()->with('success', 'Data wilayah berhasil disimpan');
    }
}