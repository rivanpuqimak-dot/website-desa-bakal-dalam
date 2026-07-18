<?php

namespace App\Http\Controllers\Admin\news;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::query();

        if ($request->filled('filter') && in_array($request->filter, ['Draft', 'Publik'])) {
            $query->where('status', $request->filter);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%'.$request->search.'%')
                  ->orWhere('excerpt', 'like', '%'.$request->search.'%')
                  ->orWhere('isi', 'like', '%'.$request->search.'%');
            });
        }

        $news = $query->orderBy('published_at', 'desc')->paginate(12);

        return view('admin.news.index', compact('news'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'penulis' => 'required|string|max:100',
            'excerpt' => 'required|string',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:Draft,Publik',
            'published_at' => 'nullable|date',
            'featured' => 'nullable|boolean',
        ], [
            'judul.required' => 'Judul berita wajib diisi.',
            'judul.string' => 'Judul berita harus berupa teks.',
            'judul.max' => 'Judul berita tidak boleh lebih dari 255 karakter.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'kategori.string' => 'Kategori harus berupa teks.',
            'kategori.max' => 'Kategori tidak boleh lebih dari 100 karakter.',
            'penulis.required' => 'Penulis wajib diisi.',
            'penulis.string' => 'Penulis harus berupa teks.',
            'penulis.max' => 'Penulis tidak boleh lebih dari 100 karakter.',
            'excerpt.required' => 'Ringkasan berita wajib diisi.',
            'excerpt.string' => 'Ringkasan berita harus berupa teks.',
            'isi.required' => 'Isi berita wajib diisi.',
            'isi.string' => 'Isi berita harus berupa teks.',
            'gambar.image' => 'Gambar utama harus berupa file gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus Draft atau Publik.',
            'published_at.date' => 'Tanggal publikasi harus format tanggal yang valid.',
            'featured.boolean' => 'Tampilkan di Beranda harus bernilai benar atau salah.',
        ]);

        $gambar = null;

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('news', 'public');
        }

        News::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'excerpt' => $request->excerpt,
            'isi' => $request->isi,
            'gambar' => $gambar,
            'kategori' => $request->kategori,
            'penulis' => $request->penulis,
            'published_at' => $request->published_at,
            'status' => $request->status,
            'featured' => $request->has('featured'),
        ]);

        return back()->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $news)
    {
        $newsList = News::orderBy('published_at', 'desc')->paginate(12);

        return view('admin.news.index', [
            'news' => $newsList,
            'editNews' => $news,
        ]);
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'penulis' => 'required|string|max:100',
            'excerpt' => 'required|string',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:Draft,Publik',
            'published_at' => 'nullable|date',
            'featured' => 'nullable|boolean',
        ], [
            'judul.required' => 'Judul berita wajib diisi.',
            'judul.string' => 'Judul berita harus berupa teks.',
            'judul.max' => 'Judul berita tidak boleh lebih dari 255 karakter.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'kategori.string' => 'Kategori harus berupa teks.',
            'kategori.max' => 'Kategori tidak boleh lebih dari 100 karakter.',
            'penulis.required' => 'Penulis wajib diisi.',
            'penulis.string' => 'Penulis harus berupa teks.',
            'penulis.max' => 'Penulis tidak boleh lebih dari 100 karakter.',
            'excerpt.required' => 'Ringkasan berita wajib diisi.',
            'excerpt.string' => 'Ringkasan berita harus berupa teks.',
            'isi.required' => 'Isi berita wajib diisi.',
            'isi.string' => 'Isi berita harus berupa teks.',
            'gambar.image' => 'Gambar utama harus berupa file gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus Draft atau Publik.',
            'published_at.date' => 'Tanggal publikasi harus format tanggal yang valid.',
            'featured.boolean' => 'Tampilkan di Beranda harus bernilai benar atau salah.',
        ]);

        if ($request->hasFile('gambar')) {
            if ($news->gambar && Storage::disk('public')->exists($news->gambar)) {
                Storage::disk('public')->delete($news->gambar);
            }

            $news->gambar = $request->file('gambar')->store('news', 'public');
        }

        $news->judul = $request->judul;
        $news->slug = Str::slug($request->judul);
        $news->excerpt = $request->excerpt;
        $news->isi = $request->isi;
        $news->kategori = $request->kategori;
        $news->penulis = $request->penulis;
        $news->published_at = $request->published_at;
        $news->status = $request->status;
        $news->featured = $request->has('featured');

        $news->save();

        return redirect()->route('admin.berita')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        if ($news->gambar && Storage::disk('public')->exists($news->gambar)) {
            Storage::disk('public')->delete($news->gambar);
        }

        $news->delete();

        return back()->with('success', 'Berita berhasil dihapus.');
    }
}