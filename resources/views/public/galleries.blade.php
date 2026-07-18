@extends('layouts.public')

@section('title', 'Galeri Desa')

@php
    $galleryCollection = collect($galleries ?? []);

    $groupedGalleries = $galleryCollection
        ->groupBy(function ($item) {
            $date = $item->tanggal_kegiatan
                ?? $item->created_at;

            return $date->format('Y');
        })
        ->map(function ($yearItems) {
            return $yearItems->groupBy(
                fn ($item) => $item->kategori ?: 'Lainnya'
            );
        });

    $selectedYear = request('tahun');
    $selectedCategory = request('kategori');
@endphp

@push('styles')
<style>
    .gallery-archive-page {
        --gp-green: #16834f;
        --gp-green-dark: #0d6139;
        --gp-green-soft: #eef7f2;
        --gp-navy: #12251c;
        --gp-text: #34463c;
        --gp-muted: #6e7d74;
        --gp-border: #dfe9e3;
        --gp-bg: #f5f8f6;
        --gp-white: #ffffff;
        min-height: 70vh;
        color: var(--gp-text);
        background: var(--gp-bg);
    }

    .gallery-archive-page,
    .gallery-archive-page * {
        box-sizing: border-box;
    }

    .gp-container {
        width: min(1280px, calc(100% - 48px));
        margin-inline: auto;
    }

    .gp-hero {
        padding: 48px 0 34px;
        background:
            radial-gradient(
                circle at 87% 10%,
                rgba(22, 131, 79, 0.11),
                transparent 31%
            ),
            #ffffff;
        border-bottom: 1px solid var(--gp-border);
    }

    .gp-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--gp-green-dark);
        font-size: 10px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .gp-kicker::before {
        width: 31px;
        height: 4px;
        content: "";
        background: var(--gp-green);
        border-radius: 999px;
    }

    .gp-title {
        max-width: 850px;
        margin: 13px 0 0;
        color: var(--gp-navy);
        font-size: clamp(32px, 4vw, 52px);
        font-weight: 900;
        line-height: 1.08;
        letter-spacing: -0.045em;
    }

    .gp-description {
        max-width: 760px;
        margin: 15px 0 0;
        color: var(--gp-muted);
        font-size: 14px;
        line-height: 1.75;
    }

    .gp-summary {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 20px;
    }

    .gp-summary span {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 11px;
        color: var(--gp-green-dark);
        background: var(--gp-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.15);
        border-radius: 999px;
        font-size: 10px;
        font-weight: 800;
    }

    .gp-filter-section {
        padding: 22px 0;
        background: #ffffff;
        border-bottom: 1px solid var(--gp-border);
    }

    .gp-filter {
        display: grid;
        grid-template-columns: 180px minmax(210px, 1fr) auto auto;
        gap: 10px;
        align-items: center;
    }

    .gp-filter select {
        width: 100%;
        min-height: 43px;
        padding: 0 12px;
        color: var(--gp-text);
        background: #ffffff;
        border: 1px solid var(--gp-border);
        border-radius: 10px;
        outline: none;
        font-size: 11px;
    }

    .gp-filter-button {
        min-height: 43px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 10px 15px;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--gp-green-dark),
            var(--gp-green)
        );
        border: 0;
        border-radius: 10px;
        text-decoration: none;
        font-size: 10px;
        font-weight: 850;
        cursor: pointer;
    }

    .gp-filter-reset {
        color: var(--gp-green-dark);
        background: var(--gp-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
    }

    .gp-content {
        padding: 36px 0 76px;
    }

    .gp-year + .gp-year {
        margin-top: 54px;
        padding-top: 50px;
        border-top: 1px solid var(--gp-border);
    }

    .gp-year-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 25px;
    }

    .gp-year-title-wrap {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .gp-year-number {
        min-width: 104px;
        padding: 13px 18px;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--gp-green-dark),
            var(--gp-green)
        );
        border-radius: 15px;
        box-shadow: 0 12px 26px rgba(22, 131, 79, 0.18);
        font-size: 25px;
        font-weight: 900;
        line-height: 1;
        text-align: center;
    }

    .gp-year-header h2 {
        margin: 0;
        color: var(--gp-navy);
        font-size: 21px;
        font-weight: 900;
    }

    .gp-year-header p {
        margin: 5px 0 0;
        color: var(--gp-muted);
        font-size: 11px;
    }

    .gp-category + .gp-category {
        margin-top: 34px;
    }

    .gp-category-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 14px;
    }

    .gp-category-header h3 {
        display: flex;
        align-items: center;
        gap: 9px;
        margin: 0;
        color: var(--gp-navy);
        font-size: 16px;
        font-weight: 850;
    }

    .gp-category-header h3 i {
        width: 34px;
        height: 34px;
        display: grid;
        place-items: center;
        color: var(--gp-green);
        background: var(--gp-green-soft);
        border-radius: 10px;
        font-size: 13px;
    }

    .gp-category-count {
        color: var(--gp-muted);
        font-size: 10px;
        font-weight: 750;
    }

    .gp-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 10px;
    }

    .gp-card {
        min-width: 0;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--gp-border);
        border-radius: 12px;
        box-shadow: 0 7px 20px rgba(18, 69, 43, 0.055);
        transition:
            transform 0.22s ease,
            box-shadow 0.22s ease;
    }

    .gp-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 34px rgba(18, 69, 43, 0.11);
    }

    .gp-image-button {
        position: relative;
        width: 100%;
        display: block;
        padding: 0;
        overflow: hidden;
        aspect-ratio: 4 / 3;
        background: var(--gp-green-soft);
        border: 0;
        cursor: zoom-in;
    }

    .gp-image-button img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        transition: transform 0.35s ease;
    }

    .gp-card:hover .gp-image-button img {
        transform: scale(1.055);
    }

    .gp-date-badge,
    .gp-featured-badge {
        position: absolute;
        top: 10px;
        padding: 6px 8px;
        color: #ffffff;
        border-radius: 8px;
        font-size: 8px;
        font-weight: 850;
    }

    .gp-date-badge {
        left: 10px;
        background: rgba(9, 71, 43, 0.88);
    }

    .gp-featured-badge {
        right: 10px;
        color: #5e4700;
        background: #ffe17b;
    }

    .gp-zoom-icon {
        position: absolute;
        right: 11px;
        bottom: 11px;
        width: 34px;
        height: 34px;
        display: grid;
        place-items: center;
        color: var(--gp-green-dark);
        background: rgba(255, 255, 255, 0.94);
        border-radius: 10px;
        font-size: 14px;
        opacity: 0;
        transform: translateY(5px);
        transition:
            opacity 0.2s ease,
            transform 0.2s ease;
    }

    .gp-card:hover .gp-zoom-icon,
    .gp-image-button:focus-visible .gp-zoom-icon {
        opacity: 1;
        transform: translateY(0);
    }

    .gp-empty {
        padding: 60px 24px;
        color: var(--gp-muted);
        background: #ffffff;
        border: 1px dashed var(--gp-border);
        border-radius: 17px;
        text-align: center;
    }

    .gp-empty i {
        display: block;
        margin-bottom: 12px;
        color: var(--gp-green);
        font-size: 34px;
    }

    .gp-lightbox {
        position: fixed;
        inset: 0;
        z-index: 20000;
        display: grid;
        place-items: center;
        visibility: hidden;
        opacity: 0;
        padding: 24px;
        background: rgba(5, 23, 14, 0.92);
        transition:
            opacity 0.2s ease,
            visibility 0.2s ease;
    }

    .gp-lightbox.open {
        visibility: visible;
        opacity: 1;
    }

    .gp-lightbox-content {
        width: min(100%, 1180px);
        max-height: calc(100vh - 48px);
        display: grid;
        grid-template-columns:
            minmax(0, 1fr)
            minmax(280px, 350px);
        overflow: hidden;
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 28px 90px rgba(0, 0, 0, 0.3);
    }

    .gp-lightbox-image-wrap {
        min-height: 0;
        display: grid;
        place-items: center;
        background: #071a10;
    }

    .gp-lightbox img {
        max-width: 100%;
        max-height: calc(100vh - 48px);
        display: block;
        object-fit: contain;
    }

    .gp-lightbox-caption {
        min-width: 0;
        overflow-y: auto;
        padding: 27px 24px;
        color: var(--gp-text);
        background: #ffffff;
        border-left: 1px solid var(--gp-border);
    }

    .gp-lightbox-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 10px;
        color: var(--gp-green-dark);
        background: var(--gp-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 999px;
        font-size: 9px;
        font-weight: 850;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .gp-lightbox-title {
        margin: 15px 0 0;
        color: var(--gp-navy);
        font-size: 22px;
        font-weight: 900;
        line-height: 1.25;
        letter-spacing: -0.025em;
        overflow-wrap: anywhere;
    }

    .gp-lightbox-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin-top: 14px;
    }

    .gp-lightbox-meta span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 9px;
        color: var(--gp-green-dark);
        background: var(--gp-green-soft);
        border-radius: 8px;
        font-size: 9px;
        font-weight: 780;
    }

    .gp-lightbox-description-title {
        display: block;
        margin-top: 22px;
        color: var(--gp-navy);
        font-size: 10px;
        font-weight: 850;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .gp-lightbox-description {
        margin: 8px 0 0;
        color: var(--gp-muted);
        font-size: 12px;
        line-height: 1.75;
        white-space: pre-line;
    }

    .gp-lightbox-featured[hidden] {
        display: none;
    }

    .gp-lightbox-close {
        position: fixed;
        top: 18px;
        right: 18px;
        z-index: 20001;
        width: 43px;
        height: 43px;
        display: grid;
        place-items: center;
        color: #ffffff;
        background: rgba(255, 255, 255, 0.13);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        font-size: 17px;
        cursor: pointer;
    }

    @media (max-width: 1050px) {
        .gp-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    @media (max-width: 790px) {
        .gp-container {
            width: min(100% - 24px, 1280px);
        }

        .gp-filter {
            grid-template-columns: 1fr 1fr;
        }

        .gp-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 8px;
        }

        .gp-lightbox {
            padding: 12px;
        }

        .gp-lightbox-content {
            max-height: calc(100vh - 24px);
            grid-template-columns: 1fr;
            grid-template-rows: minmax(250px, 56vh) auto;
            overflow-y: auto;
        }

        .gp-lightbox-image-wrap {
            min-height: 250px;
        }

        .gp-lightbox img {
            max-height: 56vh;
        }

        .gp-lightbox-caption {
            overflow: visible;
            padding: 20px 17px 24px;
            border-top: 1px solid var(--gp-border);
            border-left: 0;
        }

        .gp-lightbox-close {
            top: 15px;
            right: 15px;
        }
    }

    @media (max-width: 520px) {
        .gp-hero {
            padding: 32px 0 27px;
        }

        .gp-filter {
            grid-template-columns: 1fr;
        }

        .gp-year-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .gp-year-number {
            min-width: 84px;
            padding: 11px 14px;
            font-size: 19px;
        }

        .gp-category-header {
            margin-bottom: 10px;
        }

        .gp-category-header h3 {
            font-size: 14px;
        }

        .gp-category-header h3 i {
            width: 30px;
            height: 30px;
        }

        .gp-image-button {
            aspect-ratio: 1 / 1;
        }

        .gp-zoom-icon {
            right: 6px;
            bottom: 6px;
            width: 28px;
            height: 28px;
            font-size: 11px;
            opacity: 1;
            transform: none;
        }

        .gp-content {
            padding-top: 27px;
        }
    }
</style>
@endpush

@section('content')

<div class="gallery-archive-page">

    <header class="gp-hero">
        <div class="gp-container">

            <span class="gp-kicker">
                Dokumentasi Desa
            </span>

            <h1 class="gp-title">
                Galeri Kegiatan Desa Bakal Dalam
            </h1>

            <p class="gp-description">
                Dokumentasi kegiatan disusun berdasarkan tahun dan kategori
                agar riwayat kegiatan desa lebih mudah ditemukan.
            </p>

            <div class="gp-summary">
                <span>
                    <i class="bi bi-images"></i>
                    {{ $galleryCollection->count() }} foto ditampilkan
                </span>

                <span>
                    <i class="bi bi-calendar3"></i>
                    {{ $groupedGalleries->count() }} tahun dokumentasi
                </span>

                <span>
                    <i class="bi bi-folder2"></i>
                    {{ $galleryCategories?->count() ?? 0 }} kategori
                </span>
            </div>

        </div>
    </header>

    <section class="gp-filter-section">
        <div class="gp-container">

            <form
                action="{{ route('public.galleries') }}"
                method="GET"
                class="gp-filter"
            >

                <select name="tahun">
                    <option value="">Semua tahun</option>

                    @foreach($galleryYears ?? collect() as $year)
                        <option
                            value="{{ $year }}"
                            {{ (string) $selectedYear ===
                                (string) $year
                                ? 'selected'
                                : ''
                            }}
                        >
                            Tahun {{ $year }}
                        </option>
                    @endforeach
                </select>

                <select name="kategori">
                    <option value="">Semua kategori</option>

                    @foreach(($galleryCategories ?? collect()) as $category)
                        <option
                            value="{{ $category }}"
                            {{ $selectedCategory === $category
                                ? 'selected'
                                : ''
                            }}
                        >
                            {{ $category }}
                        </option>
                    @endforeach
                </select>

                <button
                    type="submit"
                    class="gp-filter-button"
                >
                    <i class="bi bi-funnel"></i>
                    Tampilkan
                </button>

                <a
                    href="{{ route('public.galleries') }}"
                    class="gp-filter-button gp-filter-reset"
                >
                    Reset
                </a>

            </form>

        </div>
    </section>

    <main class="gp-content">
        <div class="gp-container">

            @if($galleryCollection->isEmpty())

                <div class="gp-empty">
                    <i class="bi bi-images"></i>

                    Belum ada dokumentasi yang sesuai dengan
                    tahun atau kategori yang dipilih.
                </div>

            @else

                @foreach($groupedGalleries as $year => $categoriesGroup)

                    <section class="gp-year">

                        <header class="gp-year-header">

                            <div class="gp-year-title-wrap">

                                <strong class="gp-year-number">
                                    {{ $year }}
                                </strong>

                            </div>

                        </header>

                        @foreach($categoriesGroup as $categoryName => $items)

                            <section class="gp-category">

                                <header class="gp-category-header">

                                    <h3>
                                        <i class="bi bi-folder2-open"></i>
                                        {{ $categoryName }}
                                    </h3>


                                </header>

                                <div class="gp-grid">

                                    @foreach($items as $gallery)

                                        @php
                                            $date =
                                                $gallery->tanggal_kegiatan
                                                ?? $gallery->created_at;

                                            $image = asset(
                                                'storage/' .
                                                ltrim(
                                                    $gallery->gambar,
                                                    '/'
                                                )
                                            ) . '?v=' . (
                                                $gallery->updated_at
                                                    ?->timestamp
                                                ?? time()
                                            );
                                        @endphp

                                        <article class="gp-card">

                                            <button
                                                type="button"
                                                class="gp-image-button"
                                                data-gallery-image="{{ $image }}"
                                                data-gallery-title="{{ $gallery->judul }}"
                                                data-gallery-date="{{ $date
                                                    ->locale('id')
                                                    ->translatedFormat('d F Y')
                                                }}"
                                                data-gallery-year="{{ $year }}"
                                                data-gallery-category="{{ $categoryName }}"
                                                data-gallery-description="{{ $gallery->description ?? '' }}"
                                                data-gallery-featured="{{ $gallery->featured ? '1' : '0' }}"
                                                aria-label="Lihat keterangan {{ $gallery->judul }}"
                                            >
                                                <img
                                                    src="{{ $image }}"
                                                    alt="{{ $gallery->judul }}"
                                                    loading="lazy"
                                                >

                                                <span class="gp-zoom-icon">
                                                    <i class="bi bi-zoom-in"></i>
                                                </span>
                                            </button>

                                        </article>

                                    @endforeach

                                </div>

                            </section>

                        @endforeach

                    </section>

                @endforeach

            @endif

        </div>
    </main>

    <div
        class="gp-lightbox"
        id="gallery-lightbox"
        aria-hidden="true"
    >
        <button
            type="button"
            class="gp-lightbox-close"
            id="gallery-lightbox-close"
            aria-label="Tutup foto"
        >
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="gp-lightbox-content">
            <div class="gp-lightbox-image-wrap">
                <img
                    id="gallery-lightbox-image"
                    src=""
                    alt=""
                >
            </div>

            <aside class="gp-lightbox-caption">

                <span class="gp-lightbox-label">
                    <i class="bi bi-image"></i>
                    Keterangan Foto
                </span>

                <h2
                    class="gp-lightbox-title"
                    id="gallery-lightbox-title"
                ></h2>

                <div class="gp-lightbox-meta">

                    <span>
                        <i class="bi bi-calendar3"></i>
                        <span id="gallery-lightbox-date"></span>
                    </span>

                    <span>
                        <i class="bi bi-folder2-open"></i>
                        <span id="gallery-lightbox-category"></span>
                    </span>

                    <span
                        class="gp-lightbox-featured"
                        id="gallery-lightbox-featured"
                        hidden
                    >
                        <i class="bi bi-star-fill"></i>
                        Unggulan
                    </span>

                </div>

                <strong class="gp-lightbox-description-title">
                    Deskripsi
                </strong>

                <p
                    class="gp-lightbox-description"
                    id="gallery-lightbox-description"
                ></p>

            </aside>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const lightbox = document.getElementById(
        'gallery-lightbox'
    );
    const image = document.getElementById(
        'gallery-lightbox-image'
    );
    const title = document.getElementById(
        'gallery-lightbox-title'
    );
    const date = document.getElementById(
        'gallery-lightbox-date'
    );
    const category = document.getElementById(
        'gallery-lightbox-category'
    );
    const description = document.getElementById(
        'gallery-lightbox-description'
    );
    const featured = document.getElementById(
        'gallery-lightbox-featured'
    );
    const closeButton = document.getElementById(
        'gallery-lightbox-close'
    );

    function closeLightbox() {
        lightbox?.classList.remove('open');
        lightbox?.setAttribute('aria-hidden', 'true');

        if (image) {
            image.src = '';
        }

        document.body.style.overflow = '';
    }

    document
        .querySelectorAll('[data-gallery-image]')
        .forEach(function (button) {
            button.addEventListener('click', function () {
                if (
                    !lightbox ||
                    !image ||
                    !title ||
                    !date ||
                    !category ||
                    !description ||
                    !featured
                ) {
                    return;
                }

                const galleryTitle =
                    this.dataset.galleryTitle ||
                    'Dokumentasi Desa';

                image.src = this.dataset.galleryImage || '';
                image.alt = galleryTitle;

                title.textContent = galleryTitle;
                date.textContent =
                    this.dataset.galleryDate || '-';
                category.textContent =
                    this.dataset.galleryCategory || 'Lainnya';
                description.textContent =
                    this.dataset.galleryDescription ||
                    'Belum ada deskripsi untuk dokumentasi ini.';

                featured.hidden =
                    this.dataset.galleryFeatured !== '1';

                lightbox.classList.add('open');
                lightbox.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            });
        });

    closeButton?.addEventListener('click', closeLightbox);

    lightbox?.addEventListener('click', function (event) {
        if (event.target === lightbox) {
            closeLightbox();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeLightbox();
        }
    });
});
</script>
@endpush
