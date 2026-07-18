<?php

namespace App\Http\Controllers\Admin\announcement;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::query();

        if ($request->filled('filter') && in_array($request->filter, ['Draft', 'Publik'])) {
            $query->where('status', $request->filter);
        }

        if ($request->filled('search')) {
            $query->where(function ($sub) use ($request) {
                $sub->where('judul', 'like', '%'.$request->search.'%')
                    ->orWhere('ringkasan', 'like', '%'.$request->search.'%')
                    ->orWhere('isi', 'like', '%'.$request->search.'%');
            });
        }

        $announcements = $query->orderBy('published_at', 'desc')->paginate(12);

        return view('admin.announcement.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'required|string',
            'isi' => 'required|string',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar|max:5120',
            'published_at' => 'nullable|date',
            'status' => 'required|in:Draft,Publik',
            'featured' => 'nullable|boolean',
        ], [
            'judul.required' => 'Judul pengumuman wajib diisi.',
            'judul.string' => 'Judul harus berupa teks.',
            'judul.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'ringkasan.required' => 'Ringkasan wajib diisi.',
            'ringkasan.string' => 'Ringkasan harus berupa teks.',
            'isi.required' => 'Isi pengumuman wajib diisi.',
            'isi.string' => 'Isi pengumuman harus berupa teks.',
            'lampiran.file' => 'Lampiran harus berupa berkas.',
            'lampiran.mimes' => 'Format lampiran hanya PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, RAR.',
            'lampiran.max' => 'Ukuran lampiran maksimal 5 MB.',
            'published_at.date' => 'Tanggal publikasi harus format tanggal yang valid.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus Draft atau Publik.',
            'featured.boolean' => 'Tampilkan di Beranda harus bernilai benar atau salah.',
        ]);

        $lampiran = null;
        if ($request->hasFile('lampiran')) {
            $lampiran = $request->file('lampiran')->store('announcements', 'public');
        }

        Announcement::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'ringkasan' => $request->ringkasan,
            'isi' => $request->isi,
            'lampiran' => $lampiran,
            'published_at' => $request->published_at,
            'status' => $request->status,
            'featured' => $request->has('featured'),
        ]);

        return back()->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Announcement $announcement)
    {
        $announcements = Announcement::orderBy('published_at', 'desc')->paginate(12);

        return view('admin.announcement.index', compact('announcements', 'announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'required|string',
            'isi' => 'required|string',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar|max:5120',
            'published_at' => 'nullable|date',
            'status' => 'required|in:Draft,Publik',
            'featured' => 'nullable|boolean',
        ], [
            'judul.required' => 'Judul pengumuman wajib diisi.',
            'judul.string' => 'Judul harus berupa teks.',
            'judul.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'ringkasan.required' => 'Ringkasan wajib diisi.',
            'ringkasan.string' => 'Ringkasan harus berupa teks.',
            'isi.required' => 'Isi pengumuman wajib diisi.',
            'isi.string' => 'Isi pengumuman harus berupa teks.',
            'lampiran.file' => 'Lampiran harus berupa berkas.',
            'lampiran.mimes' => 'Format lampiran hanya PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, RAR.',
            'lampiran.max' => 'Ukuran lampiran maksimal 5 MB.',
            'published_at.date' => 'Tanggal publikasi harus format tanggal yang valid.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus Draft atau Publik.',
            'featured.boolean' => 'Tampilkan di Beranda harus bernilai benar atau salah.',
        ]);

        if ($request->hasFile('lampiran')) {
            if ($announcement->lampiran && Storage::disk('public')->exists($announcement->lampiran)) {
                Storage::disk('public')->delete($announcement->lampiran);
            }
            $announcement->lampiran = $request->file('lampiran')->store('announcements', 'public');
        }

        $announcement->judul = $request->judul;
        $announcement->slug = Str::slug($request->judul);
        $announcement->ringkasan = $request->ringkasan;
        $announcement->isi = $request->isi;
        $announcement->published_at = $request->published_at;
        $announcement->status = $request->status;
        $announcement->featured = $request->has('featured');
        $announcement->save();

        return redirect()->route('admin.pengumuman')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        if ($announcement->lampiran && Storage::disk('public')->exists($announcement->lampiran)) {
            Storage::disk('public')->delete($announcement->lampiran);
        }
        $announcement->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}
