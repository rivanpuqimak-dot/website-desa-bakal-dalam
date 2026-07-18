<?php

namespace App\Http\Controllers\Admin\gallery;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Gallery::query();

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));

            $query->where(function ($builder) use ($search): void {
                $builder
                    ->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where(
                'kategori',
                $request->input('kategori')
            );
        }

        if ($request->filled('tahun')) {
            $query->whereYear(
                'tanggal_kegiatan',
                (int) $request->input('tahun')
            );
        }

        $galleries = $query
            ->orderByDesc('tanggal_kegiatan')
            ->orderBy('kategori')
            ->orderByDesc('featured')
            ->latest('created_at')
            ->paginate(24)
            ->withQueryString();

        $years = Gallery::query()
            ->whereNotNull('tanggal_kegiatan')
            ->selectRaw('YEAR(tanggal_kegiatan) AS year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $databaseCategories = Gallery::query()
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view(
            'admin.gallery.index',
            compact(
                'galleries',
                'years',
                'databaseCategories'
            )
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'judul' => [
                    'nullable',
                    'string',
                    'max:255',
                ],
                'kategori' => [
                    'required',
                    'string',
                    'max:100',
                ],
                'tanggal_kegiatan' => [
                    'required',
                    'date',
                ],
                'description' => [
                    'nullable',
                    'string',
                ],
                'gambar' => [
                    'required',
                    'array',
                    'min:1',
                ],
                'gambar.*' => [
                    'required',
                    'file',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:5120',
                ],
                'status' => [
                    'required',
                    'in:Draft,Publik',
                ],
                'featured' => [
                    'nullable',
                    'boolean',
                ],
            ],
            $this->messages()
        );

        $files = $request->file('gambar', []);
        $storedPaths = [];
        $createdCount = 0;

        $baseTitle = trim(
            (string) ($validated['judul'] ?? '')
        );

        $description = filled(
            $validated['description'] ?? null
        )
            ? trim((string) $validated['description'])
            : null;

        $featured = $request->boolean('featured');
        $fileCount = count($files);

        try {
            DB::transaction(function () use (
                $files,
                $baseTitle,
                $validated,
                $description,
                $featured,
                $fileCount,
                &$storedPaths,
                &$createdCount
            ): void {
                foreach ($files as $index => $file) {
                    if (!$file || !$file->isValid()) {
                        throw new \RuntimeException(
                            'Salah satu file gambar tidak valid.'
                        );
                    }

                    $path = $file->store(
                        'gallery',
                        'public'
                    );

                    if (!$path) {
                        throw new \RuntimeException(
                            'Foto gagal disimpan ke penyimpanan.'
                        );
                    }

                    $storedPaths[] = $path;

                    Gallery::create([
                        'judul' => $this->generateTitle(
                            $baseTitle,
                            $file->getClientOriginalName(),
                            $index,
                            $fileCount
                        ),
                        'kategori' => $validated['kategori'],
                        'tanggal_kegiatan' =>
                            $validated['tanggal_kegiatan'],
                        'description' => $description,
                        'gambar' => $path,
                        'status' => $validated['status'],
                        'featured' => $featured,
                    ]);

                    $createdCount++;
                }
            });

            return redirect()
                ->route('admin.galeri')
                ->with(
                    'success',
                    "Berhasil mengunggah {$createdCount} foto ke galeri."
                );
        } catch (Throwable $exception) {
            foreach ($storedPaths as $path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }

            report($exception);

            return back()
                ->withInput($request->except('gambar'))
                ->with(
                    'error',
                    'Gagal mengunggah galeri. ' .
                    $exception->getMessage()
                );
        }
    }

    public function edit(
        Request $request,
        Gallery $gallery
    ): View {
        $query = Gallery::query();

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));

            $query->where(function ($builder) use ($search): void {
                $builder
                    ->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where(
                'kategori',
                $request->input('kategori')
            );
        }

        if ($request->filled('tahun')) {
            $query->whereYear(
                'tanggal_kegiatan',
                (int) $request->input('tahun')
            );
        }

        $galleries = $query
            ->orderByDesc('tanggal_kegiatan')
            ->orderBy('kategori')
            ->latest('created_at')
            ->paginate(24)
            ->withQueryString();

        $years = Gallery::query()
            ->whereNotNull('tanggal_kegiatan')
            ->selectRaw('YEAR(tanggal_kegiatan) AS year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $databaseCategories = Gallery::query()
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view(
            'admin.gallery.index',
            compact(
                'galleries',
                'gallery',
                'years',
                'databaseCategories'
            )
        );
    }

    public function update(
        Request $request,
        Gallery $gallery
    ): RedirectResponse {
        $validated = $request->validate(
            [
                'judul' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'kategori' => [
                    'required',
                    'string',
                    'max:100',
                ],
                'tanggal_kegiatan' => [
                    'required',
                    'date',
                ],
                'description' => [
                    'nullable',
                    'string',
                ],
                'gambar' => [
                    'nullable',
                    'array',
                    'max:1',
                ],
                'gambar.*' => [
                    'nullable',
                    'file',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:5120',
                ],
                'status' => [
                    'required',
                    'in:Draft,Publik',
                ],
                'featured' => [
                    'nullable',
                    'boolean',
                ],
            ],
            $this->messages()
        );

        $oldPath = $gallery->gambar;
        $newPath = null;

        $uploadedFiles = $request->file('gambar', []);

        $newFile = is_array($uploadedFiles)
            ? ($uploadedFiles[0] ?? null)
            : $uploadedFiles;

        try {
            if ($newFile) {
                if (!$newFile->isValid()) {
                    throw new \RuntimeException(
                        'Foto pengganti tidak valid.'
                    );
                }

                $newPath = $newFile->store(
                    'gallery',
                    'public'
                );

                if (!$newPath) {
                    throw new \RuntimeException(
                        'Foto pengganti gagal disimpan.'
                    );
                }
            }

            DB::transaction(function () use (
                $gallery,
                $validated,
                $request,
                $newPath
            ): void {
                $gallery->judul = trim(
                    (string) $validated['judul']
                );

                $gallery->kategori =
                    $validated['kategori'];

                $gallery->tanggal_kegiatan =
                    $validated['tanggal_kegiatan'];

                $gallery->description = filled(
                    $validated['description'] ?? null
                )
                    ? trim((string) $validated['description'])
                    : null;

                $gallery->status =
                    $validated['status'];

                $gallery->featured =
                    $request->boolean('featured');

                if ($newPath) {
                    $gallery->gambar = $newPath;
                }

                $gallery->save();
            });

            if (
                $newPath &&
                $oldPath &&
                $oldPath !== $newPath &&
                Storage::disk('public')->exists($oldPath)
            ) {
                Storage::disk('public')->delete($oldPath);
            }

            return redirect()
                ->route('admin.galeri')
                ->with(
                    'success',
                    'Foto galeri berhasil diperbarui.'
                );
        } catch (Throwable $exception) {
            if (
                $newPath &&
                Storage::disk('public')->exists($newPath)
            ) {
                Storage::disk('public')->delete($newPath);
            }

            report($exception);

            return back()
                ->withInput($request->except('gambar'))
                ->with(
                    'error',
                    'Foto gagal diperbarui. ' .
                    $exception->getMessage()
                );
        }
    }

    public function destroy(
        Gallery $gallery
    ): RedirectResponse {
        $imagePath = $gallery->gambar;

        try {
            DB::transaction(function () use ($gallery): void {
                $gallery->delete();
            });

            if (
                $imagePath &&
                Storage::disk('public')->exists($imagePath)
            ) {
                Storage::disk('public')->delete($imagePath);
            }

            return redirect()
                ->route('admin.galeri')
                ->with(
                    'success',
                    'Foto berhasil dihapus.'
                );
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('admin.galeri')
                ->with(
                    'error',
                    'Foto gagal dihapus. ' .
                    $exception->getMessage()
                );
        }
    }

    private function messages(): array
    {
        return [
            'judul.required' =>
                'Judul foto wajib diisi.',
            'judul.string' =>
                'Judul foto harus berupa teks.',
            'judul.max' =>
                'Judul foto maksimal 255 karakter.',

            'kategori.required' =>
                'Kategori wajib dipilih.',
            'kategori.max' =>
                'Kategori maksimal 100 karakter.',

            'tanggal_kegiatan.required' =>
                'Tanggal kegiatan wajib diisi.',
            'tanggal_kegiatan.date' =>
                'Tanggal kegiatan tidak valid.',

            'description.string' =>
                'Deskripsi harus berupa teks.',

            'gambar.required' =>
                'Foto wajib dipilih.',
            'gambar.array' =>
                'Format unggahan foto tidak sesuai.',
            'gambar.min' =>
                'Minimal pilih satu foto.',
            'gambar.max' =>
                'Saat mengedit, pilih maksimal satu foto.',

            'gambar.*.required' =>
                'Salah satu foto belum dipilih.',
            'gambar.*.file' =>
                'Salah satu unggahan bukan file yang valid.',
            'gambar.*.image' =>
                'Salah satu file bukan gambar.',
            'gambar.*.mimes' =>
                'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'gambar.*.max' =>
                'Ukuran setiap foto maksimal 5 MB.',
            'gambar.*.uploaded' =>
                'Foto gagal diunggah. Pastikan ukurannya maksimal 5 MB.',

            'status.required' =>
                'Status wajib dipilih.',
            'status.in' =>
                'Status harus Draft atau Publik.',
        ];
    }

    private function generateTitle(
        string $baseTitle,
        string $originalFilename,
        int $index,
        int $fileCount
    ): string {
        if ($baseTitle !== '') {
            return $fileCount > 1
                ? $baseTitle . ' - Foto ' . ($index + 1)
                : $baseTitle;
        }

        $filename = pathinfo(
            $originalFilename,
            PATHINFO_FILENAME
        );

        $generatedTitle = trim(
            ucwords(
                strtolower(
                    str_replace(
                        ['-', '_'],
                        ' ',
                        $filename
                    )
                )
            )
        );

        if ($generatedTitle !== '') {
            return $generatedTitle;
        }

        return 'Foto Galeri ' .
            now()->format('YmdHis') .
            '-' .
            ($index + 1);
    }
}
