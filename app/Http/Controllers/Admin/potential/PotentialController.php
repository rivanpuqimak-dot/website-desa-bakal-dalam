<?php

namespace App\Http\Controllers\Admin\potential;

use App\Http\Controllers\Controller;
use App\Models\Potential;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class PotentialController extends Controller
{
    /**
     * Menampilkan daftar potensi desa.
     */
    public function index(Request $request): View
    {
        $query = Potential::query();

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));

            $query->where(function ($builder) use ($search): void {
                $builder
                    ->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('kategori', 'like', '%' . $search . '%')
                    ->orWhere('lokasi', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where(
                'kategori',
                $request->input('kategori')
            );
        }

        $potentials = $query
            ->latest('created_at')
            ->paginate(12)
            ->withQueryString();

        return view(
            'admin.potensi.index',
            compact('potentials')
        );
    }

    /**
     * Menyimpan data potensi baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePotential(
            $request,
            true
        );

        $imagePath = null;

        try {
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');

                if (!$file || !$file->isValid()) {
                    throw new \RuntimeException(
                        'File gambar tidak valid.'
                    );
                }

                $imagePath = $file->store(
                    'potentials',
                    'public'
                );

                if (!$imagePath) {
                    throw new \RuntimeException(
                        'Gambar gagal disimpan.'
                    );
                }
            }

            DB::transaction(function () use (
                $validated,
                $request,
                $imagePath
            ): void {
                Potential::create([
                    'nama' => trim($validated['nama']),
                    'kategori' => $validated['kategori'],
                    'lokasi' => filled(
                        $validated['lokasi'] ?? null
                    )
                        ? trim($validated['lokasi'])
                        : null,
                    'excerpt' => filled(
                        $validated['excerpt'] ?? null
                    )
                        ? trim($validated['excerpt'])
                        : null,
                    'deskripsi' => filled(
                        $validated['deskripsi'] ?? null
                    )
                        ? trim($validated['deskripsi'])
                        : null,
                    'gambar' => $imagePath,
                    'status' => $validated['status'],
                    'featured' => $request->boolean('featured'),
                ]);
            });

            return redirect()
                ->route('admin.potensi')
                ->with(
                    'success',
                    'Potensi desa berhasil ditambahkan.'
                );
        } catch (Throwable $exception) {
            if (
                $imagePath &&
                Storage::disk('public')->exists($imagePath)
            ) {
                Storage::disk('public')->delete($imagePath);
            }

            report($exception);

            return back()
                ->withInput(
                    $request->except('gambar')
                )
                ->with(
                    'error',
                    'Potensi gagal disimpan. ' .
                    $exception->getMessage()
                );
        }
    }

    /**
     * Menampilkan data yang akan diedit.
     */
    public function edit(Potential $potential): View
    {
        $potentials = Potential::query()
            ->latest('created_at')
            ->paginate(12)
            ->withQueryString();

        return view(
            'admin.potensi.index',
            compact('potentials', 'potential')
        );
    }

    /**
     * Memperbarui data potensi dan mengganti gambar.
     */
    public function update(
        Request $request,
        Potential $potential
    ): RedirectResponse {
        $validated = $this->validatePotential(
            $request,
            false
        );

        $oldImagePath = $potential->gambar;
        $newImagePath = null;

        try {
            /*
             * Simpan file baru terlebih dahulu.
             * File lama belum dihapus sampai database berhasil diperbarui.
             */
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');

                if (!$file || !$file->isValid()) {
                    throw new \RuntimeException(
                        'File gambar pengganti tidak valid.'
                    );
                }

                $newImagePath = $file->store(
                    'potentials',
                    'public'
                );

                if (!$newImagePath) {
                    throw new \RuntimeException(
                        'Gambar pengganti gagal disimpan.'
                    );
                }
            }

            DB::transaction(function () use (
                $potential,
                $validated,
                $request,
                $newImagePath
            ): void {
                $potential->nama = trim(
                    $validated['nama']
                );

                $potential->kategori =
                    $validated['kategori'];

                $potential->lokasi = filled(
                    $validated['lokasi'] ?? null
                )
                    ? trim($validated['lokasi'])
                    : null;

                $potential->excerpt = filled(
                    $validated['excerpt'] ?? null
                )
                    ? trim($validated['excerpt'])
                    : null;

                $potential->deskripsi = filled(
                    $validated['deskripsi'] ?? null
                )
                    ? trim($validated['deskripsi'])
                    : null;

                $potential->status =
                    $validated['status'];

                $potential->featured =
                    $request->boolean('featured');

                if ($newImagePath) {
                    $potential->gambar = $newImagePath;
                }

                $potential->save();
            });

            /*
             * Hapus gambar lama hanya setelah data baru berhasil tersimpan.
             */
            if (
                $newImagePath &&
                $oldImagePath &&
                $oldImagePath !== $newImagePath &&
                Storage::disk('public')->exists($oldImagePath)
            ) {
                Storage::disk('public')->delete(
                    $oldImagePath
                );
            }

            return redirect()
                ->route('admin.potensi')
                ->with(
                    'success',
                    'Potensi desa dan gambarnya berhasil diperbarui.'
                );
        } catch (Throwable $exception) {
            /*
             * Bila pembaruan gagal, hapus file baru agar tidak menjadi
             * file sampah dan pertahankan gambar lama.
             */
            if (
                $newImagePath &&
                Storage::disk('public')->exists($newImagePath)
            ) {
                Storage::disk('public')->delete(
                    $newImagePath
                );
            }

            report($exception);

            return back()
                ->withInput(
                    $request->except('gambar')
                )
                ->with(
                    'error',
                    'Potensi gagal diperbarui. ' .
                    $exception->getMessage()
                );
        }
    }

    /**
     * Menghapus data potensi dan file gambarnya.
     */
    public function destroy(
        Potential $potential
    ): RedirectResponse {
        $imagePath = $potential->gambar;

        try {
            DB::transaction(function () use ($potential): void {
                $potential->delete();
            });

            if (
                $imagePath &&
                Storage::disk('public')->exists($imagePath)
            ) {
                Storage::disk('public')->delete(
                    $imagePath
                );
            }

            return redirect()
                ->route('admin.potensi')
                ->with(
                    'success',
                    'Potensi desa berhasil dihapus.'
                );
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('admin.potensi')
                ->with(
                    'error',
                    'Potensi gagal dihapus. ' .
                    $exception->getMessage()
                );
        }
    }

    /**
     * Validasi tambah dan edit potensi.
     */
    private function validatePotential(
        Request $request,
        bool $imageRequired
    ): array {
        return $request->validate(
            [
                'nama' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'kategori' => [
                    'required',
                    'string',
                    'max:100',
                ],
                'lokasi' => [
                    'nullable',
                    'string',
                    'max:255',
                ],
                'excerpt' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],
                'deskripsi' => [
                    'nullable',
                    'string',
                ],
                'gambar' => [
                    $imageRequired
                        ? 'required'
                        : 'nullable',
                    'file',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:5120',
                ],
                'status' => [
                    'required',
                    'in:Publik,Draft',
                ],
                'featured' => [
                    'nullable',
                    'boolean',
                ],
            ],
            [
                'nama.required' =>
                    'Nama potensi wajib diisi.',
                'nama.max' =>
                    'Nama potensi maksimal 255 karakter.',

                'kategori.required' =>
                    'Kategori wajib dipilih.',
                'kategori.max' =>
                    'Kategori maksimal 100 karakter.',

                'lokasi.max' =>
                    'Lokasi maksimal 255 karakter.',

                'excerpt.max' =>
                    'Ringkasan maksimal 1.000 karakter.',

                'gambar.required' =>
                    'Gambar potensi wajib dipilih.',
                'gambar.file' =>
                    'Gambar harus berupa file yang valid.',
                'gambar.image' =>
                    'File yang dipilih harus berupa gambar.',
                'gambar.mimes' =>
                    'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
                'gambar.max' =>
                    'Ukuran gambar maksimal 5 MB.',
                'gambar.uploaded' =>
                    'Gambar gagal diunggah. Pastikan ukurannya tidak lebih dari 5 MB.',

                'status.required' =>
                    'Status wajib dipilih.',
                'status.in' =>
                    'Status harus Publik atau Draft.',
            ]
        );
    }
}
