<?php

namespace App\Http\Controllers\Admin\contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class ContactController extends Controller
{
    public function index(): View
    {
        $contact = Contact::query()
            ->orderBy('id')
            ->first();

        return view(
            'admin.contact.index',
            compact('contact')
        );
    }

    public function store(
        Request $request
    ): RedirectResponse {
        $validated = $request->validate(
            [
                'telepon' => [
                    'required',
                    'string',
                    'max:50',
                ],
                'whatsapp' => [
                    'nullable',
                    'string',
                    'max:50',
                ],
                'email' => [
                    'nullable',
                    'email',
                    'max:255',
                ],
                'website' => [
                    'nullable',
                    'url:http,https',
                    'max:255',
                ],
                'facebook' => [
                    'nullable',
                    'url:http,https',
                    'max:255',
                ],
                'instagram' => [
                    'nullable',
                    'url:http,https',
                    'max:255',
                ],
                'youtube' => [
                    'nullable',
                    'url:http,https',
                    'max:255',
                ],
                'tiktok' => [
                    'nullable',
                    'url:http,https',
                    'max:255',
                ],
                'alamat' => [
                    'required',
                    'string',
                    'max:2000',
                ],
                'jam_operasional' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],
                'google_maps' => [
                    'nullable',
                    'url:http,https',
                    'max:2000',
                ],
                'google_maps_embed' => [
                    'nullable',
                    'string',
                    'max:5000',
                ],
            ],
            [
                'telepon.required' =>
                    'Nomor telepon wajib diisi.',
                'telepon.max' =>
                    'Nomor telepon maksimal 50 karakter.',
                'whatsapp.max' =>
                    'Nomor WhatsApp maksimal 50 karakter.',
                'email.email' =>
                    'Format email tidak valid.',
                'website.url' =>
                    'Website harus memakai URL lengkap, misalnya https://contoh.id.',
                'facebook.url' =>
                    'Tautan Facebook tidak valid.',
                'instagram.url' =>
                    'Tautan Instagram tidak valid.',
                'youtube.url' =>
                    'Tautan YouTube tidak valid.',
                'tiktok.url' =>
                    'Tautan TikTok tidak valid.',
                'alamat.required' =>
                    'Alamat kantor desa wajib diisi.',
                'alamat.max' =>
                    'Alamat maksimal 2.000 karakter.',
                'jam_operasional.max' =>
                    'Jam operasional maksimal 1.000 karakter.',
                'google_maps.url' =>
                    'Tautan Google Maps tidak valid.',
                'google_maps_embed.max' =>
                    'Kode embed Google Maps terlalu panjang.',
            ]
        );

        $cleanData = [];

        foreach (
            [
                'telepon',
                'whatsapp',
                'email',
                'website',
                'facebook',
                'instagram',
                'youtube',
                'tiktok',
                'alamat',
                'jam_operasional',
                'google_maps',
                'google_maps_embed',
            ] as $field
        ) {
            $value = $validated[$field] ?? null;

            $cleanData[$field] = filled($value)
                ? trim($value)
                : null;
        }

        try {
            DB::transaction(
                function () use ($cleanData): void {
                    $contact = Contact::query()
                        ->orderBy('id')
                        ->firstOrNew();

                    $contact->fill($cleanData);
                    $contact->save();
                }
            );

            return redirect()
                ->route('admin.kontak')
                ->with(
                    'success',
                    'Kontak publik berhasil disimpan. Seluruh halaman publik sekarang memakai data dari menu ini.'
                );
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Kontak gagal disimpan. ' .
                    $exception->getMessage()
                );
        }
    }
}
