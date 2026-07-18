@extends('admin.layouts.app')

@section('title', 'Galeri Desa')

@section('content')

@php
    $isEditing = isset($gallery);

    $fixedCategories = collect([
        'Kegiatan Desa',
        'Pembangunan',
        'Pemerintahan',
        'Wisata',
        'UMKM',
        'Budaya',
        'Pendidikan',
        'Kesehatan',
        'Keagamaan',
        'Olahraga',
        'Lainnya',
    ]);

    $categories = $fixedCategories
        ->merge($databaseCategories ?? collect())
        ->filter()
        ->unique()
        ->sort()
        ->values();

    $galleryImage = $isEditing && filled($gallery->gambar)
        ? asset(
            'storage/' .
            ltrim($gallery->gambar, '/')
        ) . '?v=' . (
            $gallery->updated_at?->timestamp
            ?? time()
        )
        : null;

    $pageCollection = collect(
        method_exists($galleries, 'getCollection')
            ? $galleries->getCollection()
            : $galleries
    );

    $groupedAdmin = $pageCollection
        ->groupBy(function ($item) {
            return $item->tanggal_kegiatan
                ? $item->tanggal_kegiatan->format('Y')
                : $item->created_at->format('Y');
        })
        ->map(function ($yearItems) {
            return $yearItems->groupBy(
                fn ($item) => $item->kategori ?: 'Lainnya'
            );
        });
@endphp

@push('styles')
<style>
    .gallery-admin-page {
        --ga-green: #16834f;
        --ga-green-dark: #0d6139;
        --ga-green-soft: #eef7f2;
        --ga-navy: #12251c;
        --ga-text: #34463c;
        --ga-muted: #6e7d74;
        --ga-border: #dfe9e3;
        --ga-bg: #f5f8f6;
    }

    .gallery-admin-page,
    .gallery-admin-page * {
        box-sizing: border-box;
    }

    .ga-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 20px;
    }

    .ga-header h1 {
        margin: 0;
        color: var(--ga-navy);
        font-size: 27px;
        font-weight: 900;
        letter-spacing: -0.04em;
    }

    .ga-header p {
        margin: 6px 0 0;
        color: var(--ga-muted);
        font-size: 12px;
        line-height: 1.6;
    }

    .ga-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 11px;
        color: var(--ga-green-dark);
        background: var(--ga-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 999px;
        font-size: 10px;
        font-weight: 850;
        white-space: nowrap;
    }

    .ga-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 16px;
        padding: 13px 15px;
        border-radius: 13px;
        font-size: 11px;
        line-height: 1.55;
    }

    .ga-alert.success {
        color: #0c6339;
        background: #edf9f2;
        border: 1px solid #ccebd9;
    }

    .ga-alert.danger {
        color: #842029;
        background: #fff1f2;
        border: 1px solid #f2c8cc;
    }

    .ga-alert ul {
        margin: 6px 0 0;
        padding-left: 18px;
    }

    .ga-layout {
        display: grid;
        grid-template-columns: minmax(320px, 0.72fr) minmax(0, 1.28fr);
        gap: 18px;
        align-items: start;
    }

    .ga-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--ga-border);
        border-radius: 19px;
        box-shadow: 0 12px 34px rgba(18, 69, 43, 0.055);
    }

    .ga-form-card {
        position: sticky;
        top: 88px;
    }

    .ga-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 17px 19px;
        border-bottom: 1px solid var(--ga-border);
    }

    .ga-card-heading {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .ga-icon {
        width: 39px;
        height: 39px;
        display: grid;
        place-items: center;
        color: var(--ga-green);
        background: var(--ga-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.15);
        border-radius: 11px;
        font-size: 15px;
    }

    .ga-card-header h2 {
        margin: 0;
        color: var(--ga-navy);
        font-size: 15px;
        font-weight: 850;
    }

    .ga-card-header p {
        margin: 3px 0 0;
        color: var(--ga-muted);
        font-size: 9px;
        line-height: 1.5;
    }

    .ga-card-body {
        padding: 19px;
    }

    .ga-fields {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px 15px;
    }

    .ga-field.full {
        grid-column: 1 / -1;
    }

    .ga-field label {
        display: block;
        margin-bottom: 7px;
        color: var(--ga-navy);
        font-size: 10px;
        font-weight: 850;
    }

    .ga-field input,
    .ga-field select,
    .ga-field textarea {
        width: 100%;
        color: var(--ga-text);
        background: #ffffff;
        border: 1px solid var(--ga-border);
        border-radius: 10px;
        outline: none;
        font-size: 11px;
    }

    .ga-field input,
    .ga-field select {
        min-height: 43px;
        padding: 0 12px;
    }

    .ga-field textarea {
        min-height: 94px;
        padding: 11px 12px;
        resize: vertical;
    }

    .ga-field input:focus,
    .ga-field select:focus,
    .ga-field textarea:focus {
        border-color: rgba(22, 131, 79, 0.58);
        box-shadow: 0 0 0 4px rgba(22, 131, 79, 0.08);
    }

    .ga-field input[type="file"] {
        min-height: 46px;
        padding: 7px;
    }

    .ga-field input[type="file"]::file-selector-button {
        height: 31px;
        margin-right: 9px;
        padding: 0 11px;
        color: var(--ga-green-dark);
        background: var(--ga-green-soft);
        border: 0;
        border-radius: 8px;
        font-size: 9px;
        font-weight: 850;
        cursor: pointer;
    }

    .ga-help,
    .ga-error {
        display: block;
        margin-top: 6px;
        font-size: 8px;
        line-height: 1.5;
    }

    .ga-help {
        color: var(--ga-muted);
    }

    .ga-error {
        color: #bd3028;
        font-weight: 700;
    }

    .ga-check {
        min-height: 43px;
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 9px 11px;
        background: var(--ga-bg);
        border: 1px solid var(--ga-border);
        border-radius: 10px;
    }

    .ga-check input {
        width: 16px;
        height: 16px;
        min-height: auto;
        accent-color: var(--ga-green);
    }

    .ga-check label {
        margin: 0;
        font-size: 9px;
    }

    .ga-preview {
        min-height: 190px;
        display: grid;
        place-items: center;
        overflow: hidden;
        margin-top: 15px;
        color: var(--ga-green);
        background: var(--ga-green-soft);
        border: 1px dashed rgba(22, 131, 79, 0.28);
        border-radius: 13px;
        font-size: 28px;
    }

    .ga-preview img {
        width: 100%;
        height: 230px;
        display: block;
        object-fit: cover;
    }

    .ga-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 15px;
    }

    .ga-button {
        min-height: 41px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 9px 13px;
        border: 0;
        border-radius: 10px;
        text-decoration: none;
        font-size: 10px;
        font-weight: 850;
        cursor: pointer;
    }

    .ga-button.primary {
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--ga-green-dark),
            var(--ga-green)
        );
    }

    .ga-button.secondary {
        color: var(--ga-green-dark);
        background: var(--ga-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
    }

    .ga-filters {
        display: grid;
        grid-template-columns: minmax(170px, 1fr) 150px 120px auto;
        gap: 9px;
        margin-bottom: 18px;
    }

    .ga-filters input,
    .ga-filters select {
        width: 100%;
        min-height: 40px;
        padding: 0 11px;
        color: var(--ga-text);
        background: #ffffff;
        border: 1px solid var(--ga-border);
        border-radius: 9px;
        outline: none;
        font-size: 10px;
    }

    .ga-year-section + .ga-year-section {
        margin-top: 28px;
        padding-top: 26px;
        border-top: 1px solid var(--ga-border);
    }

    .ga-year-heading {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 17px;
    }

    .ga-year-number {
        min-width: 72px;
        padding: 9px 13px;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--ga-green-dark),
            var(--ga-green)
        );
        border-radius: 11px;
        font-size: 17px;
        font-weight: 900;
        text-align: center;
    }

    .ga-year-heading span {
        color: var(--ga-muted);
        font-size: 10px;
    }

    .ga-category-section + .ga-category-section {
        margin-top: 21px;
    }

    .ga-category-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 11px;
    }

    .ga-category-heading h3 {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        color: var(--ga-navy);
        font-size: 13px;
        font-weight: 850;
    }

    .ga-category-heading span {
        color: var(--ga-muted);
        font-size: 9px;
    }

    .ga-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    .ga-item {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--ga-border);
        border-radius: 13px;
    }

    .ga-item-image {
        position: relative;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        background: var(--ga-green-soft);
    }

    .ga-item-image img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .ga-item-date {
        position: absolute;
        right: 8px;
        bottom: 8px;
        padding: 5px 7px;
        color: #ffffff;
        background: rgba(9, 71, 43, 0.86);
        border-radius: 7px;
        font-size: 8px;
        font-weight: 800;
    }

    .ga-item-body {
        padding: 11px;
    }

    .ga-item-title {
        margin: 0;
        color: var(--ga-navy);
        font-size: 11px;
        font-weight: 850;
        line-height: 1.45;
    }

    .ga-item-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 8px;
    }

    .ga-pill {
        padding: 5px 7px;
        color: var(--ga-green-dark);
        background: var(--ga-green-soft);
        border-radius: 999px;
        font-size: 8px;
        font-weight: 800;
    }

    .ga-item-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 7px;
        margin-top: 10px;
    }

    .ga-item-actions a,
    .ga-item-actions button {
        min-height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 7px;
        border-radius: 8px;
        font-size: 9px;
        font-weight: 850;
        text-decoration: none;
        cursor: pointer;
    }

    .ga-edit {
        color: var(--ga-green-dark);
        background: var(--ga-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.17);
    }

    .ga-delete {
        color: #a02720;
        background: #fff1f0;
        border: 1px solid #f3cbc7;
    }

    .ga-empty {
        padding: 45px 20px;
        color: var(--ga-muted);
        background: var(--ga-bg);
        border: 1px dashed var(--ga-border);
        border-radius: 14px;
        text-align: center;
        font-size: 11px;
    }

    .ga-pagination {
        display: flex;
        justify-content: center;
        gap: 6px;
        margin-top: 22px;
    }

    .ga-page {
        min-width: 36px;
        height: 36px;
        display: grid;
        place-items: center;
        padding: 0 10px;
        color: var(--ga-green-dark);
        background: #ffffff;
        border: 1px solid var(--ga-border);
        border-radius: 9px;
        text-decoration: none;
        font-size: 10px;
        font-weight: 800;
    }

    .ga-page.active {
        color: #ffffff;
        background: var(--ga-green);
        border-color: var(--ga-green);
    }

    .ga-page.disabled {
        color: #aab5af;
        background: #f4f7f5;
        pointer-events: none;
    }

    @media (max-width: 1150px) {
        .ga-layout {
            grid-template-columns: 1fr;
        }

        .ga-form-card {
            position: static;
        }
    }

    @media (max-width: 820px) {
        .ga-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .ga-filters {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 560px) {
        .ga-header {
            flex-direction: column;
        }

        .ga-fields,
        .ga-grid,
        .ga-filters {
            grid-template-columns: 1fr;
        }

        .ga-card-body {
            padding: 15px;
        }
    }
</style>
@endpush

<div class="gallery-admin-page">

    <div class="ga-header">
        <div>
            <h1>Galeri Desa</h1>
            <p>
                Dokumentasi disusun berdasarkan tahun kegiatan dan kategori.
            </p>
        </div>

        <span class="ga-badge">
            <i class="bi bi-calendar3"></i>
            Arsip Tahunan
        </span>
    </div>

    @if(session('success'))
        <div class="ga-alert success">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="ga-alert danger">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div class="ga-alert danger">
            <i class="bi bi-exclamation-triangle-fill"></i>

            <div>
                <strong>Data belum dapat disimpan.</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="ga-layout">

        <section class="ga-card ga-form-card">

            <div class="ga-card-header">
                <div class="ga-card-heading">
                    <span class="ga-icon">
                        <i class="bi bi-images"></i>
                    </span>

                    <div>
                        <h2>
                            {{ $isEditing
                                ? 'Perbarui Dokumentasi'
                                : 'Tambah Dokumentasi'
                            }}
                        </h2>

                        <p>
                            Satu unggahan dapat berisi beberapa foto kegiatan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="ga-card-body">

                <form
                    action="{{ $isEditing
                        ? route('admin.galeri.update', $gallery)
                        : route('admin.galeri.store')
                    }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf

                    @if($isEditing)
                        @method('PUT')
                    @endif

                    <div class="ga-fields">

                        <div class="ga-field full">
                            <label for="judul">Judul Kegiatan/Foto</label>

                            <input
                                id="judul"
                                type="text"
                                name="judul"
                                value="{{ old(
                                    'judul',
                                    $gallery->judul ?? ''
                                ) }}"
                                placeholder="Contoh: Gotong Royong Masjid"
                                class="@error('judul') is-invalid @enderror"
                                {{ $isEditing ? 'required' : '' }}
                            >

                            <small class="ga-help">
                                Saat mengunggah banyak foto, judul akan diberi
                                nomor otomatis.
                            </small>
                        </div>

                        <div class="ga-field">
                            <label for="tanggal_kegiatan">
                                Tanggal Kegiatan
                            </label>

                            <input
                                id="tanggal_kegiatan"
                                type="date"
                                name="tanggal_kegiatan"
                                value="{{ old(
                                    'tanggal_kegiatan',
                                    $isEditing
                                        ? optional(
                                            $gallery->tanggal_kegiatan
                                        )->format('Y-m-d')
                                        : now()->format('Y-m-d')
                                ) }}"
                                required
                            >

                            @error('tanggal_kegiatan')
                                <span class="ga-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="ga-field">
                            <label for="kategori">Kategori</label>

                            <select
                                id="kategori"
                                name="kategori"
                                required
                            >
                                @foreach($categories as $category)
                                    <option
                                        value="{{ $category }}"
                                        {{ old(
                                            'kategori',
                                            $gallery->kategori
                                                ?? 'Kegiatan Desa'
                                        ) === $category
                                            ? 'selected'
                                            : ''
                                        }}
                                    >
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="ga-field full">
                            <label for="description">Deskripsi</label>

                            <textarea
                                id="description"
                                name="description"
                                placeholder="Jelaskan kegiatan atau dokumentasi ini..."
                            >{{ old(
                                'description',
                                $gallery->description ?? ''
                            ) }}</textarea>
                        </div>

                        <div class="ga-field full">
                            <label for="gambar">
                                {{ $isEditing
                                    ? 'Ganti Foto'
                                    : 'Foto Galeri'
                                }}
                            </label>

                            <input
                                id="gambar"
                                type="file"
                                name="gambar[]"
                                accept="image/jpeg,image/png,image/webp"
                                @if(!$isEditing)
                                    multiple
                                    required
                                @endif
                            >

                            <small class="ga-help">
                                Maksimal 5 MB per foto.
                                {{ $isEditing
                                    ? 'Pilih satu foto baru atau kosongkan bila tidak ingin mengganti.'
                                    : 'Anda dapat memilih beberapa foto sekaligus.'
                                }}
                            </small>

                            @error('gambar')
                                <span class="ga-error">
                                    {{ $message }}
                                </span>
                            @enderror

                            @error('gambar.*')
                                <span class="ga-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="ga-field">
                            <label for="status">Status</label>

                            <select
                                id="status"
                                name="status"
                                required
                            >
                                @foreach(['Draft', 'Publik'] as $status)
                                    <option
                                        value="{{ $status }}"
                                        {{ old(
                                            'status',
                                            $gallery->status ?? 'Publik'
                                        ) === $status
                                            ? 'selected'
                                            : ''
                                        }}
                                    >
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="ga-field">
                            <label>Penayangan</label>

                            <div class="ga-check">
                                <input
                                    id="featured"
                                    type="checkbox"
                                    name="featured"
                                    value="1"
                                    {{ old(
                                        'featured',
                                        $gallery->featured ?? false
                                    ) ? 'checked' : '' }}
                                >

                                <label for="featured">
                                    Tampilkan sebagai unggulan
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="ga-preview" id="gallery-preview">
                        @if($galleryImage)
                            <img
                                src="{{ $galleryImage }}"
                                alt="Foto galeri"
                            >
                        @else
                            <i class="bi bi-images"></i>
                        @endif
                    </div>

                    <div class="ga-actions">
                        <button
                            type="submit"
                            class="ga-button primary"
                        >
                            <i class="bi bi-check-circle"></i>

                            {{ $isEditing
                                ? 'Simpan Perubahan'
                                : 'Unggah Dokumentasi'
                            }}
                        </button>

                        @if($isEditing)
                            <a
                                href="{{ route('admin.galeri') }}"
                                class="ga-button secondary"
                            >
                                Batal
                            </a>
                        @endif
                    </div>

                </form>

            </div>

        </section>

        <section class="ga-card">

            <div class="ga-card-header">
                <div class="ga-card-heading">
                    <span class="ga-icon">
                        <i class="bi bi-archive"></i>
                    </span>

                    <div>
                        <h2>Arsip Galeri</h2>
                        <p>
                            Foto dikelompokkan per tahun lalu per kategori.
                        </p>
                    </div>
                </div>
            </div>

            <div class="ga-card-body">

                <form
                    action="{{ route('admin.galeri') }}"
                    method="GET"
                    class="ga-filters"
                >
                    <input
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari judul atau kategori..."
                    >

                    <select name="kategori">
                        <option value="">Semua kategori</option>

                        @foreach($categories as $category)
                            <option
                                value="{{ $category }}"
                                {{ request('kategori') === $category
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>

                    <select name="tahun">
                        <option value="">Semua tahun</option>

                        @foreach($years ?? collect() as $year)
                            <option
                                value="{{ $year }}"
                                {{ (string) request('tahun') ===
                                    (string) $year
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>

                    <button
                        type="submit"
                        class="ga-button primary"
                    >
                        <i class="bi bi-funnel"></i>
                        Filter
                    </button>
                </form>

                @if($pageCollection->isEmpty())

                    <div class="ga-empty">
                        Belum ada dokumentasi yang sesuai dengan filter.
                    </div>

                @else

                    @foreach($groupedAdmin as $year => $categoriesGroup)

                        <section class="ga-year-section">

                            <div class="ga-year-heading">
                                <strong class="ga-year-number">
                                    {{ $year }}
                                </strong>

                                <span>
                                    {{ $categoriesGroup
                                        ->flatten(1)
                                        ->count()
                                    }}
                                    foto dokumentasi
                                </span>
                            </div>

                            @foreach($categoriesGroup as $categoryName => $items)

                                <section class="ga-category-section">

                                    <div class="ga-category-heading">
                                        <h3>
                                            <i class="bi bi-folder2-open"></i>
                                            {{ $categoryName }}
                                        </h3>

                                        <span>
                                            {{ $items->count() }} foto
                                        </span>
                                    </div>

                                    <div class="ga-grid">

                                        @foreach($items as $item)

                                            @php
                                                $itemDate =
                                                    $item->tanggal_kegiatan
                                                    ?? $item->created_at;

                                                $itemImage = asset(
                                                    'storage/' .
                                                    ltrim(
                                                        $item->gambar,
                                                        '/'
                                                    )
                                                ) . '?v=' . (
                                                    $item->updated_at
                                                        ?->timestamp
                                                    ?? time()
                                                );
                                            @endphp

                                            <article class="ga-item">

                                                <div class="ga-item-image">
                                                    <img
                                                        src="{{ $itemImage }}"
                                                        alt="{{ $item->judul }}"
                                                        loading="lazy"
                                                    >

                                                    <span class="ga-item-date">
                                                        {{ $itemDate
                                                            ->locale('id')
                                                            ->translatedFormat(
                                                                'd M Y'
                                                            )
                                                        }}
                                                    </span>
                                                </div>

                                                <div class="ga-item-body">

                                                    <h4 class="ga-item-title">
                                                        {{ $item->judul }}
                                                    </h4>

                                                    <div class="ga-item-meta">
                                                        <span class="ga-pill">
                                                            {{ $item->status }}
                                                        </span>

                                                        @if($item->featured)
                                                            <span class="ga-pill">
                                                                Unggulan
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="ga-item-actions">

                                                        <a
                                                            href="{{ route(
                                                                'admin.galeri.edit',
                                                                $item
                                                            ) }}"
                                                            class="ga-edit"
                                                        >
                                                            <i class="bi bi-pencil"></i>
                                                            Edit
                                                        </a>

                                                        <form
                                                            action="{{ route(
                                                                'admin.galeri.destroy',
                                                                $item
                                                            ) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Hapus foto ini?')"
                                                        >
                                                            @csrf
                                                            @method('DELETE')

                                                            <button
                                                                type="submit"
                                                                class="ga-delete"
                                                            >
                                                                <i class="bi bi-trash"></i>
                                                                Hapus
                                                            </button>
                                                        </form>

                                                    </div>

                                                </div>

                                            </article>

                                        @endforeach

                                    </div>

                                </section>

                            @endforeach

                        </section>

                    @endforeach

                    @if($galleries->hasPages())
                        @php
                            $paginationPages = range(
                                max(
                                    1,
                                    $galleries->currentPage() - 2
                                ),
                                min(
                                    $galleries->lastPage(),
                                    $galleries->currentPage() + 2
                                )
                            );
                        @endphp

                        <nav class="ga-pagination">

                            <a
                                href="{{ $galleries->previousPageUrl() ?: '#' }}"
                                class="ga-page {{ $galleries->onFirstPage()
                                    ? 'disabled'
                                    : ''
                                }}"
                            >
                                <i class="bi bi-chevron-left"></i>
                            </a>

                            @foreach($paginationPages as $page)
                                <a
                                    href="{{ $galleries->url($page) }}"
                                    class="ga-page {{ $page ===
                                        $galleries->currentPage()
                                        ? 'active'
                                        : ''
                                    }}"
                                >
                                    {{ $page }}
                                </a>
                            @endforeach

                            <a
                                href="{{ $galleries->nextPageUrl() ?: '#' }}"
                                class="ga-page {{ $galleries->hasMorePages()
                                    ? ''
                                    : 'disabled'
                                }}"
                            >
                                <i class="bi bi-chevron-right"></i>
                            </a>

                        </nav>
                    @endif

                @endif

            </div>

        </section>

    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('gambar');
    const preview = document.getElementById('gallery-preview');

    input?.addEventListener('change', function () {
        const file = this.files?.[0];

        if (!file || !preview) {
            return;
        }

        const url = URL.createObjectURL(file);
        const image = document.createElement('img');

        image.src = url;
        image.alt = 'Pratinjau foto galeri';

        image.addEventListener('load', function () {
            URL.revokeObjectURL(url);
        });

        preview.innerHTML = '';
        preview.appendChild(image);
    });
});
</script>
@endpush

@endsection
