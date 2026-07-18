<?php

namespace App\Http\Controllers\Admin\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisionMission;

class VisionMissionController extends Controller
{
    public function index()
    {
        $visi = VisionMission::first();

        return view('admin.profile.visi', compact('visi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'visi' => 'nullable',
            'misi' => 'nullable',
            'tujuan' => 'nullable',
            'motto' => 'nullable|string|max:255',
        ], [
            'motto.string' => 'Motto Desa harus berupa teks.',
            'motto.max' => 'Motto Desa tidak boleh lebih dari 255 karakter.',
        ]);

        VisionMission::updateOrCreate(
            ['id' => 1],
            [
                'visi' => $request->visi,
                'misi' => $request->misi,
                'tujuan' => $request->tujuan,
                'motto' => $request->motto,
            ]
        );

        return redirect()->back()->with('success', 'Visi & Misi berhasil disimpan');
    }
}