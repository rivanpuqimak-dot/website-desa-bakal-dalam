@extends('admin.layouts.app')

@section('title', 'Struktur Kelembagaan Desa')

@section('content')

@php
    $institutionCollection = collect($institutions ?? []);

    $structureTypes = [
        [
            'key' => 'pkk',
            'name' => 'PKK',
            'title' => 'Struktur PKK',
            'description' => 'Bagan struktur organisasi PKK Desa.',
            'icon' => 'bi-people-fill',
            'sort_order' => 1,
            'aliases' => [
                'PKK',
                'Pemberdayaan Kesejahteraan Keluarga',
            ],
        ],
        [
            'key' => 'posyandu',
            'name' => 'Posyandu',
            'title' => 'Struktur Posyandu',
            'description' => 'Bagan struktur organisasi Posyandu Desa.',
            'icon' => 'bi-heart-pulse-fill',
            'sort_order' => 2,
            'aliases' => [
                'Posyandu',
            ],
        ],
        [
            'key' => 'karang-taruna',
            'name' => 'Karang Taruna',
            'title' => 'Struktur Karang Taruna',
            'description' => 'Bagan struktur organisasi Karang Taruna Desa.',
            'icon' => 'bi-person-arms-up',
            'sort_order' => 3,
            'aliases' => [
                'Karang Taruna',
            ],
        ],
        [
            'key' => 'lpm',
            'name' => 'LPM',
            'title' => 'Struktur LPM',
            'description' => 'Bagan struktur Lembaga Pemberdayaan Masyarakat.',
            'icon' => 'bi-diagram-3-fill',
            'sort_order' => 4,
            'aliases' => [
                'LPM',
                'Lembaga Pemberdayaan Masyarakat',
                'Lembaga Pemberdayaan Masyarakat (LPM)',
            ],
        ],
    ];

    foreach ($structureTypes as $index => $structure) {
        $aliases = collect($structure['aliases'])
            ->map(
                fn ($alias) => mb_strtolower(
                    trim($alias)
                )
            );

        $structureTypes[$index]['record'] =
            $institutionCollection->first(
                function ($item) use ($aliases) {
                    $name = mb_strtolower(
                        trim($item->nama ?? '')
                    );

                    return $aliases->contains($name);
                }
            );
    }
@endphp

@push('styles')
<style>
    .institution-structure-page {
        --structure-green: var(--admin-green, #16834f);
        --structure-green-dark: var(--admin-green-dark, #0d6139);
        --structure-soft: var(--admin-green-soft, #eef7f2);
        --structure-navy: var(--admin-navy, #12251c);
        --structure-text: var(--admin-text, #34463c);
        --structure-muted: var(--admin-muted, #6e7d74);
        --structure-border: var(--admin-border, #dfe9e3);
        --structure-bg: var(--admin-bg, #f5f8f6);
    }

    .institution-structure-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 20px;
    }

    .institution-structure-header h1 {
        margin: 0;
        color: var(--structure-navy);
        font-size: 27px;
        font-weight: 850;
        line-height: 1.25;
        letter-spacing: -0.035em;
    }

    .institution-structure-header p {
        max-width: 720px;
        margin: 6px 0 0;
        color: var(--structure-muted);
        font-size: 12px;
        line-height: 1.65;
    }

    .institution-structure-badge {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 11px;
        color: var(--structure-green-dark);
        background: var(--structure-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 999px;
        font-size: 10px;
        font-weight: 850;
    }

    .institution-structure-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 16px;
        padding: 13px 15px;
        border-radius: 13px;
        font-size: 11px;
        line-height: 1.55;
    }

    .institution-structure-alert.success {
        color: #0c6339;
        background: #edf9f2;
        border: 1px solid #ccebd9;
    }

    .institution-structure-alert.danger {
        color: #842029;
        background: #fff1f2;
        border: 1px solid #f2c8cc;
    }

    .institution-structure-alert ul {
        margin: 7px 0 0;
        padding-left: 18px;
    }

    .institution-structure-note {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        margin-bottom: 18px;
        padding: 15px 17px;
        color: var(--structure-text);
        background: #ffffff;
        border: 1px solid var(--structure-border);
        border-left: 4px solid var(--structure-green);
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(18, 69, 43, 0.045);
    }

    .institution-structure-note i {
        color: var(--structure-green);
        font-size: 17px;
    }

    .institution-structure-note strong {
        display: block;
        color: var(--structure-navy);
        font-size: 11px;
        font-weight: 850;
    }

    .institution-structure-note span {
        display: block;
        margin-top: 3px;
        color: var(--structure-muted);
        font-size: 10px;
        line-height: 1.55;
    }

    .institution-structure-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .institution-structure-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--structure-border);
        border-radius: 20px;
        box-shadow: 0 12px 34px rgba(18, 69, 43, 0.055);
    }

    .institution-structure-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 17px 19px;
        border-bottom: 1px solid var(--structure-border);
    }

    .institution-structure-card-heading {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 0;
    }

    .institution-structure-icon {
        width: 41px;
        height: 41px;
        flex: 0 0 41px;
        display: grid;
        place-items: center;
        color: var(--structure-green);
        background: var(--structure-soft);
        border: 1px solid rgba(22, 131, 79, 0.15);
        border-radius: 12px;
        font-size: 16px;
    }

    .institution-structure-card-header h2 {
        margin: 0;
        color: var(--structure-navy);
        font-size: 15px;
        font-weight: 850;
        line-height: 1.4;
    }

    .institution-structure-card-header p {
        margin: 3px 0 0;
        color: var(--structure-muted);
        font-size: 9px;
        line-height: 1.5;
    }

    .institution-structure-status {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 9px;
        border-radius: 999px;
        font-size: 8px;
        font-weight: 850;
    }

    .institution-structure-status.available {
        color: #0c6339;
        background: #edf9f2;
        border: 1px solid #ccebd9;
    }

    .institution-structure-status.empty {
        color: #6a756f;
        background: #f2f5f3;
        border: 1px solid #e0e7e3;
    }

    .institution-structure-card-body {
        padding: 18px;
    }

    .institution-structure-preview {
        width: 100%;
        min-height: 280px;
        display: grid;
        place-items: center;
        overflow: hidden;
        color: var(--structure-green);
        background: var(--structure-bg);
        border: 1px dashed #c8d9cf;
        border-radius: 15px;
    }

    .institution-structure-preview img {
        width: 100%;
        height: 320px;
        display: block;
        object-fit: contain;
        padding: 8px;
        background: #ffffff;
    }

    .institution-structure-preview-empty {
        padding: 32px;
        text-align: center;
    }

    .institution-structure-preview-empty i {
        display: block;
        margin-bottom: 10px;
        font-size: 32px;
    }

    .institution-structure-preview-empty strong {
        display: block;
        color: var(--structure-navy);
        font-size: 12px;
        font-weight: 850;
    }

    .institution-structure-preview-empty span {
        display: block;
        margin-top: 5px;
        color: var(--structure-muted);
        font-size: 9px;
        line-height: 1.5;
    }

    .institution-structure-upload {
        margin-top: 15px;
    }

    .institution-structure-upload label {
        display: block;
        margin-bottom: 7px;
        color: var(--structure-navy);
        font-size: 11px;
        font-weight: 800;
    }

    .institution-structure-upload input[type="file"] {
        width: 100%;
        min-height: 46px;
        padding: 8px;
        color: var(--structure-text);
        background: #ffffff;
        border: 1px solid var(--structure-border);
        border-radius: 11px;
        outline: none;
        font-size: 10px;
    }

    .institution-structure-upload
    input[type="file"]::file-selector-button {
        height: 30px;
        margin-right: 10px;
        padding: 0 11px;
        color: var(--structure-green-dark);
        background: var(--structure-soft);
        border: 0;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 800;
        cursor: pointer;
    }

    .institution-structure-help {
        display: block;
        margin-top: 6px;
        color: var(--structure-muted);
        font-size: 9px;
        line-height: 1.5;
    }

    .institution-structure-error {
        display: block;
        margin-top: 5px;
        color: #c03542;
        font-size: 9px;
        font-weight: 700;
    }

    .institution-structure-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 14px;
    }

    .institution-structure-button {
        min-height: 41px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 9px 13px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 10px;
        font-weight: 850;
        cursor: pointer;
    }

    .institution-structure-button.primary {
        flex: 1;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--structure-green-dark),
            var(--structure-green)
        );
        border: 0;
        box-shadow: 0 9px 20px rgba(22, 131, 79, 0.18);
    }

    .institution-structure-button.delete {
        color: #b9343f;
        background: #fff1f2;
        border: 1px solid #f2c8cc;
    }

    @media (max-width: 900px) {
        .institution-structure-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 620px) {
        .institution-structure-header {
            flex-direction: column;
        }

        .institution-structure-header h1 {
            font-size: 23px;
        }

        .institution-structure-card-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .institution-structure-card-body,
        .institution-structure-card-header {
            padding: 15px;
        }

        .institution-structure-preview img {
            height: 245px;
        }

        .institution-structure-actions {
            display: grid;
            grid-template-columns: 1fr;
        }

        .institution-structure-button {
            width: 100%;
        }
    }
</style>
@endpush

<div class="institution-structure-page">

    <div class="institution-structure-header">

        <div>
            <h1>Struktur Kelembagaan Desa</h1>

            <p>
                Unggah foto bagan struktur PKK, Posyandu,
                Karang Taruna, dan LPM.
            </p>
        </div>

        <span class="institution-structure-badge">
            <i class="bi bi-diagram-3"></i>
            Kelembagaan
        </span>

    </div>

    @if(session('success'))

        <div class="institution-structure-alert success">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
        </div>

    @endif

    @if($errors->any())

        <div class="institution-structure-alert danger">
            <i class="bi bi-exclamation-triangle-fill"></i>

            <div>
                <strong>Foto belum dapat disimpan.</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

    @endif

    <div class="institution-structure-note">

        <i class="bi bi-info-circle-fill"></i>

        <div>
            <strong>Tidak perlu mengisi nama ketua atau anggota satu per satu.</strong>

            <span>
                Cukup unggah foto bagan struktur. Foto yang baru diunggah
                akan menggantikan foto lama untuk lembaga yang sama.
            </span>
        </div>

    </div>

    <div class="institution-structure-grid">

        @foreach($structureTypes as $structure)

            @php
                $record = $structure['record'];

                $imageUrl = $record && filled($record->foto)
                    ? asset(
                        'storage/' .
                        ltrim($record->foto, '/')
                    )
                    : null;
            @endphp

            <article class="institution-structure-card">

                <div class="institution-structure-card-header">

                    <div class="institution-structure-card-heading">

                        <span class="institution-structure-icon">
                            <i class="bi {{ $structure['icon'] }}"></i>
                        </span>

                        <div>
                            <h2>{{ $structure['title'] }}</h2>
                            <p>{{ $structure['description'] }}</p>
                        </div>

                    </div>

                    <span
                        class="
                            institution-structure-status
                            {{ $imageUrl ? 'available' : 'empty' }}
                        "
                    >
                        <i class="bi bi-circle-fill"></i>

                        {{ $imageUrl
                            ? 'Sudah Diunggah'
                            : 'Belum Ada'
                        }}
                    </span>

                </div>

                <div class="institution-structure-card-body">

                    <div
                        class="institution-structure-preview"
                        id="preview-{{ $structure['key'] }}"
                    >

                        @if($imageUrl)

                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ $structure['title'] }}"
                            >

                        @else

                            <div class="institution-structure-preview-empty">
                                <i class="bi bi-image"></i>

                                <strong>
                                    Foto struktur belum tersedia
                                </strong>

                                <span>
                                    Pilih foto dari perangkat lalu simpan.
                                </span>
                            </div>

                        @endif

                    </div>

                    <form
                        action="{{ $record
                            ? route(
                                'admin.lembaga.update',
                                $record->id
                            )
                            : route('admin.lembaga.store')
                        }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf

                        @if($record)
                            @method('PUT')
                        @endif

                        {{-- Memakai tabel lembaga yang sudah ada --}}
                        <input
                            type="hidden"
                            name="nama"
                            value="{{ $structure['name'] }}"
                        >

                        <input
                            type="hidden"
                            name="jabatan"
                            value="Bagan Struktur Organisasi"
                        >

                        <input
                            type="hidden"
                            name="status"
                            value="Aktif"
                        >

                        <input
                            type="hidden"
                            name="sort_order"
                            value="{{ $structure['sort_order'] }}"
                        >

                        <input
                            type="hidden"
                            name="deskripsi"
                            value="{{ $structure['description'] }}"
                        >

                        <div class="institution-structure-upload">

                            <label for="foto-{{ $structure['key'] }}">
                                {{ $record
                                    ? 'Ganti Foto Struktur'
                                    : 'Unggah Foto Struktur'
                                }}
                            </label>

                            <input
                                id="foto-{{ $structure['key'] }}"
                                type="file"
                                name="foto"
                                accept=".jpg,.jpeg,.png,.webp"
                                data-preview="preview-{{ $structure['key'] }}"
                                class="@error('foto') is-invalid @enderror"
                                {{ $record ? '' : 'required' }}
                            >

                            <small class="institution-structure-help">
                                Format JPG, JPEG, PNG, atau WEBP.
                                Gunakan foto yang jelas dan tidak terpotong.
                            </small>

                            @error('foto')
                                <span class="institution-structure-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                        <div class="institution-structure-actions">

                            <button
                                type="submit"
                                class="institution-structure-button primary"
                            >
                                <i class="bi bi-cloud-arrow-up-fill"></i>

                                {{ $record
                                    ? 'Ganti Foto'
                                    : 'Simpan Foto'
                                }}
                            </button>

                        </div>

                    </form>

                    @if($record)

                        <form
                            action="{{ route(
                                'admin.lembaga.destroy',
                                $record->id
                            ) }}"
                            method="POST"
                            class="institution-structure-actions"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="institution-structure-button delete"
                                onclick="
                                    return confirm(
                                        'Hapus foto struktur ini?'
                                    )
                                "
                            >
                                <i class="bi bi-trash"></i>
                                Hapus Foto
                            </button>

                        </form>

                    @endif

                </div>

            </article>

        @endforeach

    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll(
        '[data-preview]'
    );

    inputs.forEach(function (input) {
        input.addEventListener('change', function () {
            const file = this.files?.[0];
            const previewId = this.dataset.preview;
            const preview = document.getElementById(previewId);

            if (!file || !preview) {
                return;
            }

            const imageUrl = URL.createObjectURL(file);
            const image = document.createElement('img');

            image.src = imageUrl;
            image.alt = 'Pratinjau struktur lembaga';

            image.addEventListener('load', function () {
                URL.revokeObjectURL(imageUrl);
            });

            preview.innerHTML = '';
            preview.appendChild(image);
        });
    });
});
</script>
@endpush

@endsection
