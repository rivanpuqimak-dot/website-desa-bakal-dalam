<?php

namespace App\Http\Controllers\Admin\agenda;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::query();

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%'.$request->search.'%');
        }

        $agendas = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('admin.agenda.index', compact('agendas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu' => 'nullable|string|max:100',
            'lokasi' => 'required|string|max:255',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:Draft,Publik',
            'featured' => 'nullable|boolean',
        ], [
            'judul.required' => 'Judul agenda wajib diisi.',
            'judul.string' => 'Judul agenda harus berupa teks.',
            'judul.max' => 'Judul agenda tidak boleh lebih dari 255 karakter.',
            'deskripsi.required' => 'Deskripsi agenda wajib diisi.',
            'deskripsi.string' => 'Deskripsi agenda harus berupa teks.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.date' => 'Tanggal mulai harus format tanggal yang valid.',
            'tanggal_selesai.date' => 'Tanggal selesai harus format tanggal yang valid.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
            'waktu.string' => 'Waktu harus berupa teks.',
            'waktu.max' => 'Waktu tidak boleh lebih dari 100 karakter.',
            'lokasi.required' => 'Lokasi wajib diisi.',
            'lokasi.string' => 'Lokasi harus berupa teks.',
            'lokasi.max' => 'Lokasi tidak boleh lebih dari 255 karakter.',
            'poster.image' => 'Poster harus berupa file gambar.',
            'poster.mimes' => 'Format poster harus JPG, JPEG, PNG, atau WEBP.',
            'poster.max' => 'Ukuran poster maksimal 2 MB.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus Draft atau Publik.',
            'featured.boolean' => 'Tampilkan pada halaman utama harus bernilai benar atau salah.',
        ]);

        $poster = null;
        if ($request->hasFile('poster')) {
            $poster = $request->file('poster')->store('agenda', 'public');
        }

        Agenda::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'deskripsi' => $request->deskripsi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'waktu' => $request->waktu,
            'lokasi' => $request->lokasi,
            'poster' => $poster,
            'status' => $request->status,
            'featured' => $request->has('featured'),
        ]);

        return back()->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Agenda $agenda)
    {
        $agendas = Agenda::orderBy('created_at', 'desc')->paginate(12);

        return view('admin.agenda.index', compact('agendas', 'agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu' => 'nullable|string|max:100',
            'lokasi' => 'required|string|max:255',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:Draft,Publik',
            'featured' => 'nullable|boolean',
        ], [
            'judul.required' => 'Judul agenda wajib diisi.',
            'judul.string' => 'Judul agenda harus berupa teks.',
            'judul.max' => 'Judul agenda tidak boleh lebih dari 255 karakter.',
            'deskripsi.required' => 'Deskripsi agenda wajib diisi.',
            'deskripsi.string' => 'Deskripsi agenda harus berupa teks.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.date' => 'Tanggal mulai harus format tanggal yang valid.',
            'tanggal_selesai.date' => 'Tanggal selesai harus format tanggal yang valid.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
            'waktu.string' => 'Waktu harus berupa teks.',
            'waktu.max' => 'Waktu tidak boleh lebih dari 100 karakter.',
            'lokasi.required' => 'Lokasi wajib diisi.',
            'lokasi.string' => 'Lokasi harus berupa teks.',
            'lokasi.max' => 'Lokasi tidak boleh lebih dari 255 karakter.',
            'poster.image' => 'Poster harus berupa file gambar.',
            'poster.mimes' => 'Format poster harus JPG, JPEG, PNG, atau WEBP.',
            'poster.max' => 'Ukuran poster maksimal 2 MB.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus Draft atau Publik.',
            'featured.boolean' => 'Tampilkan pada halaman utama harus bernilai benar atau salah.',
        ]);

        if ($request->hasFile('poster')) {
            if ($agenda->poster && Storage::disk('public')->exists($agenda->poster)) {
                Storage::disk('public')->delete($agenda->poster);
            }
            $agenda->poster = $request->file('poster')->store('agenda', 'public');
        }

        $agenda->judul = $request->judul;
        $agenda->slug = Str::slug($request->judul);
        $agenda->deskripsi = $request->deskripsi;
        $agenda->tanggal_mulai = $request->tanggal_mulai;
        $agenda->tanggal_selesai = $request->tanggal_selesai;
        $agenda->waktu = $request->waktu;
        $agenda->lokasi = $request->lokasi;
        $agenda->status = $request->status;
        $agenda->featured = $request->has('featured');
        $agenda->save();

        return redirect()->route('admin.agenda')
            ->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda)
    {
        if ($agenda->poster && Storage::disk('public')->exists($agenda->poster)) {
            Storage::disk('public')->delete($agenda->poster);
        }
        $agenda->delete();

        return back()->with('success', 'Agenda berhasil dihapus.');
    }
}
