<?php

namespace App\Http\Controllers\Admin\government;

use App\Http\Controllers\Controller;
use App\Models\Official;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OfficialController extends Controller
{
    public function index(): View
    {
        $officials = Official::query()
            ->orderBy('sort_order')
            ->orderBy('nama')
            ->get();

        return view(
            'admin.government.aparat',
            compact('officials')
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateOfficial($request);

        $validated['sort_order'] =
            $validated['sort_order'] ?? 0;

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request
                ->file('foto')
                ->store('officials', 'public');
        }

        Official::create($validated);

        return redirect()
            ->route('admin.aparat')
            ->with(
                'success',
                'Data aparat desa berhasil ditambahkan.'
            );
    }

    public function edit(Official $official): View
    {
        $officials = Official::query()
            ->orderBy('sort_order')
            ->orderBy('nama')
            ->get();

        return view(
            'admin.government.aparat',
            compact('official', 'officials')
        );
    }

    public function update(
        Request $request,
        Official $official
    ): RedirectResponse {
        $validated = $this->validateOfficial($request);

        $validated['sort_order'] =
            $validated['sort_order'] ?? 0;

        if ($request->hasFile('foto')) {
            $newPhoto = $request
                ->file('foto')
                ->store('officials', 'public');

            $oldPhoto = $official->foto;

            $validated['foto'] = $newPhoto;

            $official->update($validated);

            if (
                $oldPhoto &&
                $oldPhoto !== $newPhoto &&
                Storage::disk('public')->exists($oldPhoto)
            ) {
                Storage::disk('public')->delete($oldPhoto);
            }
        } else {
            $official->update($validated);
        }

        return redirect()
            ->route('admin.aparat')
            ->with(
                'success',
                'Data aparat desa berhasil diperbarui.'
            );
    }

    public function destroy(
        Official $official
    ): RedirectResponse {
        $photo = $official->foto;

        $official->delete();

        if (
            $photo &&
            Storage::disk('public')->exists($photo)
        ) {
            Storage::disk('public')->delete($photo);
        }

        return redirect()
            ->route('admin.aparat')
            ->with(
                'success',
                'Data aparat desa berhasil dihapus.'
            );
    }

    private function validateOfficial(
        Request $request
    ): array {
        return $request->validate(
            [
                'nama' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'nip' => [
                    'nullable',
                    'string',
                    'max:100',
                ],
                'jabatan' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'deskripsi' => [
                    'nullable',
                    'string',
                ],
                'kata_sambutan' => [
                    'nullable',
                    'string',
                ],
                'sort_order' => [
                    'nullable',
                    'integer',
                    'min:0',
                ],
                'status' => [
                    'required',
                    'in:Aktif,Tidak Aktif',
                ],
                'foto' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:2048',
                ],
            ],
            [
                'nama.required' =>
                    'Nama lengkap aparat desa wajib diisi.',
                'nama.max' =>
                    'Nama lengkap maksimal 255 karakter.',
                'nip.max' =>
                    'NIP maksimal 100 karakter.',
                'jabatan.required' =>
                    'Jabatan wajib diisi.',
                'jabatan.max' =>
                    'Jabatan maksimal 255 karakter.',
                'deskripsi.string' =>
                    'Deskripsi harus berupa teks.',
                'kata_sambutan.string' =>
                    'Kata sambutan harus berupa teks.',
                'sort_order.integer' =>
                    'Urutan harus berupa angka.',
                'sort_order.min' =>
                    'Urutan tidak boleh kurang dari nol.',
                'status.required' =>
                    'Status wajib dipilih.',
                'status.in' =>
                    'Status harus Aktif atau Tidak Aktif.',
                'foto.image' =>
                    'Foto harus berupa file gambar.',
                'foto.mimes' =>
                    'Format foto harus JPG, JPEG, PNG, atau WEBP.',
                'foto.max' =>
                    'Ukuran foto maksimal 2 MB.',
            ]
        );
    }
}
