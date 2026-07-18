<?php

namespace App\Http\Controllers\Admin\government;

use App\Http\Controllers\Controller;
use App\Models\Bpd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BpdController extends Controller
{
    public function index()
    {
        $bpds = Bpd::latest()->get();

        return view('admin.government.bpd', compact('bpds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image',
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('bpd', 'public');
        }

        Bpd::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'deskripsi' => $request->deskripsi,
            'foto' => $foto,
        ]);

        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(Bpd $bpd)
    {
        $bpds = Bpd::latest()->get();

        return view('admin.government.bpd', compact('bpds', 'bpd'));
    }

    public function update(Request $request, Bpd $bpd)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image',
        ]);

        if ($request->hasFile('foto')) {

            if ($bpd->foto && Storage::disk('public')->exists($bpd->foto)) {
                Storage::disk('public')->delete($bpd->foto);
            }

            $bpd->foto = $request->file('foto')->store('bpd', 'public');
        }

        $bpd->nama = $request->nama;
        $bpd->jabatan = $request->jabatan;
        $bpd->deskripsi = $request->deskripsi;

        $bpd->save();

        return redirect()->route('admin.bpd')
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Bpd $bpd)
    {
        if ($bpd->foto && Storage::disk('public')->exists($bpd->foto)) {
            Storage::disk('public')->delete($bpd->foto);
        }

        $bpd->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}