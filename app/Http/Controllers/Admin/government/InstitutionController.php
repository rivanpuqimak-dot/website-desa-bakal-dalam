<?php

namespace App\Http\Controllers\Admin\Government;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstitutionController extends Controller
{
    public function index()
    {
        $institutions = Institution::orderBy('sort_order')->get();

        return view('admin.government.lembaga', compact('institutions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ], [
            'nama.required' => 'Nama lembaga wajib diisi.',
            'nama.string' => 'Nama lembaga harus berupa teks.',
            'nama.max' => 'Nama lembaga tidak boleh lebih dari 255 karakter.',
            'jabatan.required' => 'Jabatan/Ketua wajib diisi.',
            'jabatan.string' => 'Jabatan/Ketua harus berupa teks.',
            'jabatan.max' => 'Jabatan/Ketua tidak boleh lebih dari 255 karakter.',
            'foto.image' => 'Foto harus berupa file gambar.',
            'foto.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
            'sort_order.integer' => 'Urutan harus berupa angka.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus Aktif atau Tidak Aktif.',
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('institutions', 'public');
        }

        Institution::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'deskripsi' => $request->deskripsi,
            'foto' => $foto,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(Institution $institution)
    {
        $institutions = Institution::orderBy('sort_order')->get();

        return view('admin.government.lembaga', compact('institutions', 'institution'));
    }

    public function update(Request $request, Institution $institution)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ], [
            'nama.required' => 'Nama lembaga wajib diisi.',
            'nama.string' => 'Nama lembaga harus berupa teks.',
            'nama.max' => 'Nama lembaga tidak boleh lebih dari 255 karakter.',
            'jabatan.required' => 'Jabatan/Ketua wajib diisi.',
            'jabatan.string' => 'Jabatan/Ketua harus berupa teks.',
            'jabatan.max' => 'Jabatan/Ketua tidak boleh lebih dari 255 karakter.',
            'foto.image' => 'Foto harus berupa file gambar.',
            'foto.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
            'sort_order.integer' => 'Urutan harus berupa angka.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus Aktif atau Tidak Aktif.',
        ]);

        if ($request->hasFile('foto')) {
            if ($institution->foto && Storage::disk('public')->exists($institution->foto)) {
                Storage::disk('public')->delete($institution->foto);
            }

            $institution->foto = $request->file('foto')->store('institutions', 'public');
        }

        $institution->nama = $request->nama;
        $institution->jabatan = $request->jabatan;
        $institution->deskripsi = $request->deskripsi;
        $institution->sort_order = $request->sort_order ?? 0;
        $institution->status = $request->status;

        $institution->save();

        return redirect()->route('admin.lembaga')
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Institution $institution)
    {
        if ($institution->foto && Storage::disk('public')->exists($institution->foto)) {
            Storage::disk('public')->delete($institution->foto);
        }

        $institution->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}