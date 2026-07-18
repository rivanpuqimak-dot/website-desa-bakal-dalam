<?php

namespace App\Http\Controllers\Admin\service;

use App\Http\Controllers\Controller;
use App\Models\VillageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VillageServiceController extends Controller
{
    public function index(Request $request): View
    {
        $query = VillageService::query();

        if ($request->filled('search')) {
            $search = trim(
                (string) $request->input('search')
            );

            $query->where(
                function ($subQuery) use ($search): void {
                    $subQuery
                        ->where(
                            'title',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'description',
                            'like',
                            '%' . $search . '%'
                        );
                }
            );
        }

        if (
            $request->filled('status') &&
            in_array(
                $request->input('status'),
                ['Draft', 'Publik'],
                true
            )
        ) {
            $query->where(
                'status',
                $request->input('status')
            );
        }

        $services = $query
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(12)
            ->withQueryString();

        return view(
            'admin.service.index',
            compact('services')
        );
    }

    public function store(
        Request $request
    ): RedirectResponse {
        $validated = $this->validateService($request);

        VillageService::create(
            $this->prepareData($validated)
        );

        return redirect()
            ->route('admin.layanan')
            ->with(
                'success',
                'Layanan desa berhasil ditambahkan.'
            );
    }

    public function edit(
        VillageService $service
    ): View {
        $services = VillageService::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(12)
            ->withQueryString();

        return view(
            'admin.service.index',
            compact('services', 'service')
        );
    }

    public function update(
        Request $request,
        VillageService $service
    ): RedirectResponse {
        $validated = $this->validateService($request);

        $service->update(
            $this->prepareData($validated)
        );

        return redirect()
            ->route('admin.layanan')
            ->with(
                'success',
                'Layanan desa berhasil diperbarui.'
            );
    }

    public function destroy(
        VillageService $service
    ): RedirectResponse {
        $service->delete();

        return redirect()
            ->route('admin.layanan')
            ->with(
                'success',
                'Layanan desa berhasil dihapus.'
            );
    }

    private function validateService(
        Request $request
    ): array {
        return $request->validate(
            [
                'title' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'icon' => [
                    'nullable',
                    'string',
                    'max:100',
                    'regex:/^bi-[a-z0-9-]+$/',
                ],
                'description' => [
                    'required',
                    'string',
                    'max:3000',
                ],
                'requirements_text' => [
                    'required',
                    'string',
                    'max:5000',
                ],
                'processing_time' => [
                    'nullable',
                    'string',
                    'max:100',
                ],
                'cost' => [
                    'nullable',
                    'string',
                    'max:100',
                ],
                'sort_order' => [
                    'required',
                    'integer',
                    'min:0',
                    'max:9999',
                ],
                'status' => [
                    'required',
                    'in:Draft,Publik',
                ],
            ],
            [
                'title.required' =>
                    'Nama layanan wajib diisi.',
                'title.max' =>
                    'Nama layanan maksimal 255 karakter.',
                'icon.regex' =>
                    'Ikon harus memakai format Bootstrap Icon, misalnya bi-file-text.',
                'description.required' =>
                    'Deskripsi layanan wajib diisi.',
                'description.max' =>
                    'Deskripsi maksimal 3.000 karakter.',
                'requirements_text.required' =>
                    'Minimal satu persyaratan wajib diisi.',
                'requirements_text.max' =>
                    'Daftar persyaratan terlalu panjang.',
                'processing_time.max' =>
                    'Estimasi proses maksimal 100 karakter.',
                'cost.max' =>
                    'Keterangan biaya maksimal 100 karakter.',
                'sort_order.required' =>
                    'Urutan layanan wajib diisi.',
                'sort_order.integer' =>
                    'Urutan harus berupa angka.',
                'status.required' =>
                    'Status layanan wajib dipilih.',
                'status.in' =>
                    'Status harus Draft atau Publik.',
            ]
        );
    }

    private function prepareData(array $validated): array
    {
        $requirements = collect(
            preg_split(
                '/\r\n|\r|\n/',
                $validated['requirements_text']
            )
        )
            ->map(
                fn ($item) => trim((string) $item)
            )
            ->filter()
            ->unique()
            ->values()
            ->all();

        return [
            'title' => trim($validated['title']),
            'icon' => filled($validated['icon'] ?? null)
                ? trim($validated['icon'])
                : 'bi-file-earmark-text',
            'description' => trim(
                $validated['description']
            ),
            'requirements' => $requirements,
            'processing_time' => filled(
                $validated['processing_time'] ?? null
            )
                ? trim($validated['processing_time'])
                : null,
            'cost' => filled(
                $validated['cost'] ?? null
            )
                ? trim($validated['cost'])
                : null,
            'sort_order' => (int) $validated['sort_order'],
            'status' => $validated['status'],
        ];
    }
}
