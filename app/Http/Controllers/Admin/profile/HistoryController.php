<?php

namespace App\Http\Controllers\Admin\profile;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HistoryController extends Controller
{
    public function index()
    {
        $history = History::first();

        return view('admin.profile.sejarah', compact('history'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'year_established' => 'nullable|string|max:50',
            'excerpt' => 'nullable|string',
            'sejarah' => 'nullable',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ], [
            'judul.required' => 'Judul sejarah desa wajib diisi.',
            'judul.string' => 'Judul sejarah desa harus berupa teks.',
            'judul.max' => 'Judul sejarah desa tidak boleh lebih dari 255 karakter.',
            'year_established.string' => 'Tahun berdiri desa harus berupa teks.',
            'year_established.max' => 'Tahun berdiri desa tidak boleh lebih dari 50 karakter.',
            'excerpt.string' => 'Ringkasan sejarah harus berupa teks.',
            'gambar.image' => 'Foto sejarah harus berupa file gambar.',
            'gambar.mimes' => 'Format foto sejarah harus JPG, JPEG, PNG, atau WEBP.',
            'gambar.max' => 'Ukuran foto sejarah maksimal 2 MB.',
        ]);

        $history = History::first() ?? new History();

        $history->judul = $request->judul;
        $history->year_established = $request->year_established;
        $history->excerpt = $request->excerpt;
        $history->sejarah = $request->sejarah;

        if ($request->hasFile('gambar')) {
            if ($history->gambar && Storage::disk('public')->exists($history->gambar)) {
                Storage::disk('public')->delete($history->gambar);
            }
            $history->gambar = $request->file('gambar')->store('history', 'public');
        }

        $history->save();

        return back()->with('success', 'Sejarah berhasil disimpan');
    }
}