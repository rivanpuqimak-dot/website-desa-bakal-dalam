@extends('admin.layouts.app')

@section('title', 'Wilayah Desa')

@section('content')

@php
    $mapImage = isset($region) && filled($region->map_image)
        ? asset('storage/' . ltrim($region->map_image, '/'))
        : null;
@endphp

@push('styles')
<style>
    .admin-region-page {
        --page-green: var(--admin-green, #16834f);
        --page-green-dark: var(--admin-green-dark, #0d6139);
        --page-soft: var(--admin-green-soft, #eef7f2);
        --page-navy: var(--admin-navy, #12251c);
        --page-text: var(--admin-text, #34463c);
        --page-muted: var(--admin-muted, #6e7d74);
        --page-border: var(--admin-border, #dfe9e3);
        --page-bg: var(--admin-bg, #f5f8f6);
    }

    .admin-region-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 20px;
    }

    .admin-region-header h1 {
        margin: 0;
        color: var(--page-navy);
        font-size: 27px;
        font-weight: 850;
        line-height: 1.25;
        letter-spacing: -0.035em;
    }

    .admin-region-header p {
        margin: 6px 0 0;
        color: var(--page-muted);
        font-size: 12px;
        line-height: 1.6;
    }

    .admin-region-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 11px;
        color: var(--page-green-dark);
        background: var(--page-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 999px;
        font-size: 10px;
        font-weight: 850;
    }

    .admin-region-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 16px;
        padding: 13px 15px;
        color: #0c6339;
        background: #edf9f2;
        border: 1px solid #ccebd9;
        border-radius: 13px;
        font-size: 11px;
        line-height: 1.55;
    }

    .admin-region-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--page-border);
        border-radius: 20px;
        box-shadow: 0 12px 34px rgba(18, 69, 43, 0.055);
    }

    .admin-region-card + .admin-region-card {
        margin-top: 18px;
    }

    .admin-region-card-header {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 18px 20px;
        border-bottom: 1px solid var(--page-border);
    }

    .admin-region-icon {
        width: 39px;
        height: 39px;
        display: grid;
        place-items: center;
        color: var(--page-green);
        background: var(--page-soft);
        border: 1px solid rgba(22, 131, 79, 0.15);
        border-radius: 11px;
        font-size: 15px;
    }

    .admin-region-card-header h2 {
        margin: 0;
        color: var(--page-navy);
        font-size: 15px;
        font-weight: 850;
    }

    .admin-region-card-header p {
        margin: 3px 0 0;
        color: var(--page-muted);
        font-size: 9px;
        line-height: 1.5;
    }

    .admin-region-card-body {
        padding: 20px;
    }

    .admin-region-fields {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px 18px;
    }

    .admin-region-field.full {
        grid-column: 1 / -1;
    }

    .admin-region-field label {
        display: block;
        margin-bottom: 7px;
        color: var(--page-navy);
        font-size: 11px;
        font-weight: 800;
    }

    .admin-region-field input,
    .admin-region-field textarea {
        width: 100%;
        color: var(--page-text);
        background: #ffffff;
        border: 1px solid var(--page-border);
        border-radius: 11px;
        outline: none;
        font-size: 12px;
        transition:
            border-color 0.2s ease,
            box-shadow 0.2s ease;
    }

    .admin-region-field input {
        min-height: 45px;
        padding: 0 13px;
    }

    .admin-region-field textarea {
        padding: 12px 13px;
        resize: vertical;
    }

    .admin-region-field input:focus,
    .admin-region-field textarea:focus {
        border-color: rgba(22, 131, 79, 0.55);
        box-shadow: 0 0 0 4px rgba(22, 131, 79, 0.09);
    }

    .admin-region-help {
        display: block;
        margin-top: 6px;
        color: var(--page-muted);
        font-size: 9px;
        line-height: 1.5;
    }

    .admin-region-field input[type="file"] {
        min-height: 46px;
        padding: 8px;
    }

    .admin-region-field input[type="file"]::file-selector-button {
        height: 30px;
        margin-right: 10px;
        padding: 0 11px;
        color: var(--page-green-dark);
        background: var(--page-soft);
        border: 0;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 800;
        cursor: pointer;
    }

    .admin-region-map-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 18px;
        align-items: start;
    }

    .admin-region-preview {
        width: 100%;
        min-height: 250px;
        display: grid;
        place-items: center;
        overflow: hidden;
        color: var(--page-green);
        background: var(--page-bg);
        border: 1px dashed #c9d8cf;
        border-radius: 14px;
    }

    .admin-region-preview img {
        width: 100%;
        height: 250px;
        display: block;
        object-fit: contain;
        padding: 10px;
        background: #ffffff;
    }

    .admin-region-preview i {
        font-size: 32px;
    }

    .admin-region-action {
        display: flex;
        justify-content: flex-end;
        margin-top: 18px;
    }

    .admin-region-submit {
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 17px;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--page-green-dark),
            var(--page-green)
        );
        border: 0;
        border-radius: 11px;
        box-shadow: 0 10px 22px rgba(22, 131, 79, 0.2);
        font-size: 11px;
        font-weight: 850;
        cursor: pointer;
    }

    @media (max-width: 900px) {
        .admin-region-map-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 620px) {
        .admin-region-header {
            flex-direction: column;
        }

        .admin-region-header h1 {
            font-size: 23px;
        }

        .admin-region-card-header,
        .admin-region-card-body {
            padding: 16px;
        }

        .admin-region-fields {
            grid-template-columns: 1fr;
        }

        .admin-region-field.full {
            grid-column: auto;
        }

        .admin-region-action {
            display: block;
        }

        .admin-region-submit {
            width: 100%;
        }
    }
</style>
@endpush

<div class="admin-region-page">

    <div class="admin-region-header">

        <div>
            <h1>Wilayah Desa</h1>

            <p>
                Kelola luas, batas wilayah, lokasi, dan deskripsi desa.
            </p>
        </div>

        <span class="admin-region-badge">
            <i class="bi bi-map"></i>
            Profil Desa
        </span>

    </div>

    @if(session('success'))

        <div class="admin-region-alert">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
        </div>

    @endif

    <form
        action="{{ route('admin.wilayah.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        <section class="admin-region-card">

            <div class="admin-region-card-header">

                <span class="admin-region-icon">
                    <i class="bi bi-rulers"></i>
                </span>

                <div>
                    <h2>Informasi Wilayah</h2>
                    <p>Luas wilayah dan jumlah dusun.</p>
                </div>

            </div>

            <div class="admin-region-card-body">

                <div class="admin-region-fields">

                    <div class="admin-region-field">

                        <label for="luas_wilayah">
                            Luas Wilayah
                        </label>

                        <input
                            id="luas_wilayah"
                            type="text"
                            name="luas_wilayah"
                            value="{{ old(
                                'luas_wilayah',
                                $region->luas_wilayah ?? ''
                            ) }}"
                            placeholder="Contoh: 10 km² atau 1.000 ha"
                        >

                    </div>

                    <div class="admin-region-field">

                        <label for="jumlah_dusun">
                            Jumlah Dusun
                        </label>

                        <input
                            id="jumlah_dusun"
                            type="number"
                            name="jumlah_dusun"
                            value="{{ old(
                                'jumlah_dusun',
                                $region->jumlah_dusun ?? ''
                            ) }}"
                            min="0"
                        >

                    </div>

                </div>

            </div>

        </section>

        <section class="admin-region-card">

            <div class="admin-region-card-header">

                <span class="admin-region-icon">
                    <i class="bi bi-signpost-split"></i>
                </span>

                <div>
                    <h2>Batas Wilayah</h2>
                    <p>Batas desa pada setiap arah mata angin.</p>
                </div>

            </div>

            <div class="admin-region-card-body">

                <div class="admin-region-fields">

                    @php
                        $boundaries = [
                            [
                                'name' => 'batas_utara',
                                'label' => 'Sebelah Utara',
                            ],
                            [
                                'name' => 'batas_selatan',
                                'label' => 'Sebelah Selatan',
                            ],
                            [
                                'name' => 'batas_timur',
                                'label' => 'Sebelah Timur',
                            ],
                            [
                                'name' => 'batas_barat',
                                'label' => 'Sebelah Barat',
                            ],
                        ];
                    @endphp

                    @foreach($boundaries as $boundary)

                        <div class="admin-region-field">

                            <label for="{{ $boundary['name'] }}">
                                {{ $boundary['label'] }}
                            </label>

                            <input
                                id="{{ $boundary['name'] }}"
                                type="text"
                                name="{{ $boundary['name'] }}"
                                value="{{ old(
                                    $boundary['name'],
                                    data_get(
                                        $region ?? null,
                                        $boundary['name']
                                    )
                                ) }}"
                            >

                        </div>

                    @endforeach

                </div>

            </div>

        </section>

        <section class="admin-region-card">

            <div class="admin-region-card-header">

                <span class="admin-region-icon">
                    <i class="bi bi-geo-alt"></i>
                </span>

                <div>
                    <h2>Lokasi dan Peta</h2>
                    <p>Google Maps dan gambar peta desa.</p>
                </div>

            </div>

            <div class="admin-region-card-body">

                <div class="admin-region-map-grid">

                    <div class="admin-region-fields">

                        <div class="admin-region-field full">

                            <label for="google_maps">
                                Link Google Maps
                            </label>

                            <input
                                id="google_maps"
                                type="text"
                                name="google_maps"
                                value="{{ old(
                                    'google_maps',
                                    $region->google_maps ?? ''
                                ) }}"
                                placeholder="https://maps.google.com/..."
                            >

                        </div>

                        <div class="admin-region-field full">

                            <label for="google_maps_embed">
                                Kode Embed Google Maps
                            </label>

                            <textarea
                                id="google_maps_embed"
                                name="google_maps_embed"
                                rows="6"
                            >{{ old(
                                'google_maps_embed',
                                $region->google_maps_embed ?? ''
                            ) }}</textarea>

                            <small class="admin-region-help">
                                Tempelkan kode embed dari menu Bagikan di Google Maps.
                            </small>

                        </div>

                        <div class="admin-region-field full">

                            <label for="map_image">
                                Gambar Peta
                            </label>

                            <input
                                id="map_image"
                                type="file"
                                name="map_image"
                                accept=".jpg,.jpeg,.png,.webp"
                            >

                        </div>

                    </div>

                    <div
                        class="admin-region-preview"
                        id="region-map-preview"
                    >

                        @if($mapImage)

                            <img
                                src="{{ $mapImage }}"
                                alt="Peta wilayah desa"
                            >

                        @else

                            <i class="bi bi-map"></i>

                        @endif

                    </div>

                </div>

            </div>

        </section>

        <section class="admin-region-card">

            <div class="admin-region-card-header">

                <span class="admin-region-icon">
                    <i class="bi bi-file-text"></i>
                </span>

                <div>
                    <h2>Deskripsi Wilayah</h2>
                    <p>Kondisi umum dan karakteristik wilayah desa.</p>
                </div>

            </div>

            <div class="admin-region-card-body">

                <div class="admin-region-field">

                    <label for="deskripsi">
                        Deskripsi Wilayah Desa
                    </label>

                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        rows="8"
                    >{{ old(
                        'deskripsi',
                        $region->deskripsi ?? ''
                    ) }}</textarea>

                    <small class="admin-region-help">
                        Jelaskan kondisi umum wilayah secara singkat dan jelas.
                    </small>

                </div>

            </div>

        </section>

        <div class="admin-region-action">

            <button
                type="submit"
                class="admin-region-submit"
            >
                <i class="bi bi-check-circle"></i>
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapInput = document.getElementById('map_image');
    const preview = document.getElementById(
        'region-map-preview'
    );

    mapInput?.addEventListener('change', function () {
        const file = this.files?.[0];

        if (!file || !preview) {
            return;
        }

        const imageUrl = URL.createObjectURL(file);
        const image = document.createElement('img');

        image.src = imageUrl;
        image.alt = 'Pratinjau peta wilayah';

        image.addEventListener('load', function () {
            URL.revokeObjectURL(imageUrl);
        });

        preview.innerHTML = '';
        preview.appendChild(image);
    });
});
</script>
@endpush

@endsection
