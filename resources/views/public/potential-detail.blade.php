@extends('layouts.public')

@section(
    'title',
    ($potential->nama ?? 'Detail Potensi') . ' | Potensi Desa'
)

@php
    $potentialName = filled($potential?->nama)
        ? $potential->nama
        : 'Potensi Desa';

    $category = filled($potential?->kategori)
        ? $potential->kategori
        : 'Potensi Desa';

    $location = filled($potential?->lokasi)
        ? $potential->lokasi
        : 'Desa Bakal Dalam';

    $excerpt = filled($potential?->excerpt)
        ? $potential->excerpt
        : null;

    $description = filled($potential?->deskripsi)
        ? $potential->deskripsi
        : 'Deskripsi potensi desa belum tersedia.';

    $imageUrl = filled($potential?->gambar)
        ? asset(
            'storage/' .
            ltrim($potential->gambar, '/')
        )
        : null;

    $contactData = isset($contact) && $contact
        ? $contact
        : \App\Models\Contact::query()->first();

    $whatsappNumber = filled($contactData?->whatsapp)
        ? preg_replace(
            '/[^0-9]/',
            '',
            $contactData->whatsapp
        )
        : null;

    if (
        filled($whatsappNumber) &&
        str_starts_with($whatsappNumber, '0')
    ) {
        $whatsappNumber =
            '62' .
            substr($whatsappNumber, 1);
    }

    $whatsappMessage = rawurlencode(
        'Halo, saya ingin mendapatkan informasi mengenai potensi desa: ' .
        $potentialName
    );

    $shareUrl = rawurlencode(request()->fullUrl());
    $shareTitle = rawurlencode($potentialName);
@endphp

@push('styles')
<style>
    :root {
        --potential-detail-green: #16834f;
        --potential-detail-green-dark: #0d6139;
        --potential-detail-green-deep: #09472b;
        --potential-detail-green-soft: #eef7f2;
        --potential-detail-navy: #12251c;
        --potential-detail-text: #34463c;
        --potential-detail-muted: #6e7d74;
        --potential-detail-border: #dfe9e3;
        --potential-detail-bg: #f5f8f6;
        --potential-detail-white: #ffffff;
    }

    .potential-detail-page,
    .potential-detail-page * {
        box-sizing: border-box;
    }

    .potential-detail-page {
        min-height: 70vh;
        overflow-x: hidden;
        color: var(--potential-detail-text);
        background: var(--potential-detail-bg);
    }

    .potential-detail-container {
        width: min(1180px, calc(100% - 48px));
        margin-inline: auto;
    }

    /* =====================================================
       BAGIAN PEMBUKA
    ===================================================== */

    .potential-detail-hero {
        padding: 38px 0 30px;
        background:
            radial-gradient(
                circle at 89% 15%,
                rgba(22, 131, 79, 0.11),
                transparent 30%
            ),
            linear-gradient(
                180deg,
                #ffffff 0%,
                #f7faf8 100%
            );
        border-bottom: 1px solid var(--potential-detail-border);
    }

    .potential-detail-back {
        min-height: 40px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        color: var(--potential-detail-green-dark);
        background: var(--potential-detail-white);
        border: 1px solid var(--potential-detail-border);
        border-radius: 10px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 800;
        box-shadow: 0 7px 18px rgba(19, 69, 43, 0.05);
        transition:
            color 0.2s ease,
            background 0.2s ease,
            border-color 0.2s ease,
            transform 0.2s ease;
    }

    .potential-detail-back:hover {
        color: #ffffff;
        background: var(--potential-detail-green);
        border-color: var(--potential-detail-green);
        transform: translateX(-2px);
    }

    .potential-detail-heading {
        max-width: 900px;
        margin-top: 24px;
    }

    .potential-detail-category {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 11px;
        color: var(--potential-detail-green-dark);
        background: var(--potential-detail-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 999px;
        font-size: 10px;
        font-weight: 850;
        line-height: 1;
        text-transform: uppercase;
        letter-spacing: 0.07em;
    }

    .potential-detail-title {
        max-width: 950px;
        margin: 16px 0 0;
        color: var(--potential-detail-navy);
        font-size: clamp(34px, 4.7vw, 60px);
        font-weight: 900;
        line-height: 1.07;
        letter-spacing: -0.05em;
        overflow-wrap: anywhere;
    }

    .potential-detail-excerpt {
        max-width: 780px;
        margin: 16px 0 0;
        color: var(--potential-detail-muted);
        font-size: clamp(15px, 1.4vw, 18px);
        line-height: 1.75;
    }

    .potential-detail-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 9px 18px;
        margin-top: 20px;
        color: var(--potential-detail-muted);
        font-size: 12px;
        font-weight: 700;
    }

    .potential-detail-meta-item {
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .potential-detail-meta-item i {
        color: var(--potential-detail-green);
        font-size: 13px;
    }

    /* =====================================================
       FOTO UTAMA
    ===================================================== */

    .potential-detail-image-section {
        padding-top: 30px;
    }

    .potential-detail-image {
        position: relative;
        width: 100%;
        overflow: hidden;
        background: var(--potential-detail-green-soft);
        border: 1px solid var(--potential-detail-border);
        border-radius: 22px;
        box-shadow: 0 18px 42px rgba(19, 69, 43, 0.10);
    }

    .potential-detail-image img {
        width: 100%;
        max-height: 610px;
        aspect-ratio: 16 / 8.5;
        display: block;
        object-fit: cover;
        object-position: center;
    }

    .potential-detail-image-placeholder {
        min-height: 430px;
        display: grid;
        place-items: center;
        padding: 36px;
        text-align: center;
        color: var(--potential-detail-green-dark);
        background:
            radial-gradient(
                circle at center,
                rgba(22, 131, 79, 0.13),
                transparent 40%
            ),
            var(--potential-detail-green-soft);
    }

    .potential-detail-image-placeholder i {
        width: 76px;
        height: 76px;
        display: grid;
        place-items: center;
        margin: 0 auto 14px;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--potential-detail-green-dark),
            var(--potential-detail-green)
        );
        border-radius: 21px;
        font-size: 31px;
        box-shadow: 0 14px 30px rgba(22, 131, 79, 0.18);
    }

    .potential-detail-image-placeholder strong {
        display: block;
        color: var(--potential-detail-navy);
        font-size: 17px;
        font-weight: 850;
    }

    /* =====================================================
       ISI POTENSI
    ===================================================== */

    .potential-detail-content-section {
        padding: 30px 0 72px;
    }

    .potential-detail-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 280px;
        align-items: start;
        gap: 26px;
    }

    .potential-detail-article {
        min-width: 0;
        padding: clamp(24px, 4vw, 46px);
        background: var(--potential-detail-white);
        border: 1px solid var(--potential-detail-border);
        border-radius: 20px;
        box-shadow: 0 12px 34px rgba(19, 69, 43, 0.06);
    }

    .potential-detail-section-label {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 23px;
        color: var(--potential-detail-green-dark);
        font-size: 11px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .potential-detail-section-label::before {
        width: 35px;
        height: 4px;
        content: "";
        border-radius: 999px;
        background: var(--potential-detail-green);
    }

    .potential-detail-body {
        color: var(--potential-detail-text);
        font-size: 16px;
        line-height: 1.95;
        overflow-wrap: anywhere;
    }

    .potential-detail-body p {
        margin: 0 0 1.35em;
    }

    .potential-detail-body p:last-child {
        margin-bottom: 0;
    }

    .potential-detail-highlight {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        margin-top: 30px;
        padding: 17px;
        color: var(--potential-detail-green-dark);
        background: var(--potential-detail-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 14px;
    }

    .potential-detail-highlight i {
        width: 39px;
        height: 39px;
        flex: 0 0 39px;
        display: grid;
        place-items: center;
        color: #ffffff;
        background: var(--potential-detail-green);
        border-radius: 10px;
        font-size: 15px;
    }

    .potential-detail-highlight strong {
        display: block;
        color: var(--potential-detail-navy);
        font-size: 13px;
        font-weight: 850;
    }

    .potential-detail-highlight span {
        display: block;
        margin-top: 4px;
        color: var(--potential-detail-muted);
        font-size: 11px;
        line-height: 1.65;
    }

    /* =====================================================
       SIDEBAR INFORMASI
    ===================================================== */

    .potential-detail-sidebar {
        position: sticky;
        top: 105px;
        display: grid;
        gap: 15px;
    }

    .potential-detail-side-card {
        padding: 19px;
        background: var(--potential-detail-white);
        border: 1px solid var(--potential-detail-border);
        border-radius: 17px;
        box-shadow: 0 10px 28px rgba(19, 69, 43, 0.05);
    }

    .potential-detail-side-title {
        margin: 0;
        color: var(--potential-detail-navy);
        font-size: 14px;
        font-weight: 850;
    }

    .potential-detail-side-description {
        margin: 8px 0 0;
        color: var(--potential-detail-muted);
        font-size: 11px;
        line-height: 1.65;
    }

    .potential-detail-info-list {
        display: grid;
        gap: 10px;
        margin-top: 15px;
    }

    .potential-detail-info-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 11px;
        background: var(--potential-detail-bg);
        border: 1px solid var(--potential-detail-border);
        border-radius: 11px;
    }

    .potential-detail-info-icon {
        width: 33px;
        height: 33px;
        flex: 0 0 33px;
        display: grid;
        place-items: center;
        color: var(--potential-detail-green);
        background: #ffffff;
        border-radius: 9px;
        font-size: 13px;
    }

    .potential-detail-info-item small {
        display: block;
        color: var(--potential-detail-muted);
        font-size: 8px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: 0.07em;
    }

    .potential-detail-info-item strong {
        display: block;
        margin-top: 3px;
        color: var(--potential-detail-navy);
        font-size: 11px;
        font-weight: 800;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .potential-detail-actions {
        display: grid;
        gap: 8px;
        margin-top: 15px;
    }

    .potential-detail-action {
        min-height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 13px;
        border-radius: 11px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 850;
        transition:
            transform 0.2s ease,
            filter 0.2s ease;
    }

    .potential-detail-action.primary {
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--potential-detail-green-deep),
            var(--potential-detail-green)
        );
        box-shadow: 0 10px 22px rgba(22, 131, 79, 0.17);
    }

    .potential-detail-action.secondary {
        color: var(--potential-detail-green-dark);
        background: var(--potential-detail-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
    }

    .potential-detail-action:hover {
        filter: brightness(1.03);
        transform: translateY(-1px);
    }

    .potential-detail-share-list {
        display: grid;
        gap: 8px;
        margin-top: 14px;
    }

    .potential-detail-share {
        min-height: 39px;
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 9px 11px;
        color: var(--potential-detail-green-dark);
        background: var(--potential-detail-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.15);
        border-radius: 10px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 800;
    }

    .potential-detail-share:hover {
        color: #ffffff;
        background: var(--potential-detail-green);
    }

    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 900px) {
        .potential-detail-layout {
            grid-template-columns: 1fr;
        }

        .potential-detail-sidebar {
            position: static;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .potential-detail-container {
            width: min(100% - 30px, 1180px);
        }

        .potential-detail-hero {
            padding: 26px 0 24px;
        }

        .potential-detail-heading {
            margin-top: 18px;
        }

        .potential-detail-title {
            font-size: clamp(30px, 9vw, 43px);
            line-height: 1.11;
        }

        .potential-detail-image-section {
            padding-top: 20px;
        }

        .potential-detail-image {
            border-radius: 17px;
        }

        .potential-detail-image img {
            min-height: 260px;
            aspect-ratio: 16 / 10;
        }

        .potential-detail-content-section {
            padding: 20px 0 48px;
        }

        .potential-detail-article {
            padding: 23px 18px;
            border-radius: 17px;
        }

        .potential-detail-body {
            font-size: 15px;
            line-height: 1.85;
        }
    }

    @media (max-width: 575.98px) {
        .potential-detail-meta {
            align-items: flex-start;
            flex-direction: column;
            gap: 8px;
        }

        .potential-detail-sidebar {
            grid-template-columns: 1fr;
        }

        .potential-detail-image-placeholder {
            min-height: 280px;
        }
    }
</style>
@endpush

@section('content')

<div class="potential-detail-page">

    <header class="potential-detail-hero">
        <div class="potential-detail-container">

            <a
                href="{{ route('public.potentials') }}"
                class="potential-detail-back"
            >
                <i class="bi bi-arrow-left"></i>
                Kembali ke Potensi Desa
            </a>

            <div class="potential-detail-heading">

                <span class="potential-detail-category">
                    <i class="bi bi-grid-fill"></i>
                    {{ $category }}
                </span>

                <h1 class="potential-detail-title">
                    {{ $potentialName }}
                </h1>

                @if($excerpt)
                    <p class="potential-detail-excerpt">
                        {{ $excerpt }}
                    </p>
                @endif

                <div class="potential-detail-meta">

                    <span class="potential-detail-meta-item">
                        <i class="bi bi-geo-alt-fill"></i>
                        {{ $location }}
                    </span>

                    <span class="potential-detail-meta-item">
                        <i class="bi bi-building"></i>
                        Potensi Desa Bakal Dalam
                    </span>

                </div>

            </div>

        </div>
    </header>

    <section class="potential-detail-image-section">
        <div class="potential-detail-container">

            <figure class="potential-detail-image">

                @if($imageUrl)

                    <img
                        src="{{ $imageUrl }}"
                        alt="{{ $potentialName }}"
                    >

                @else

                    <div class="potential-detail-image-placeholder">
                        <div>
                            <i class="bi bi-image"></i>

                            <strong>
                                Foto potensi belum tersedia
                            </strong>
                        </div>
                    </div>

                @endif

            </figure>

        </div>
    </section>

    <section class="potential-detail-content-section">
        <div class="potential-detail-container">

            <div class="potential-detail-layout">

                <article class="potential-detail-article">

                    <div class="potential-detail-section-label">
                        Tentang Potensi
                    </div>

                    <div class="potential-detail-body">

                        @foreach(
                            preg_split(
                                "/\r\n|\n|\r/",
                                trim($description)
                            ) as $paragraph
                        )

                            @if(trim($paragraph) !== '')
                                <p>{{ $paragraph }}</p>
                            @endif

                        @endforeach

                    </div>

                    <div class="potential-detail-highlight">

                        <i class="bi bi-lightbulb-fill"></i>

                        <div>
                            <strong>
                                Potensi Unggulan Desa
                            </strong>

                            <span>
                                Informasi ini merupakan bagian dari
                                pendataan potensi dan pengembangan
                                ekonomi Desa Bakal Dalam.
                            </span>
                        </div>

                    </div>

                </article>

                <aside class="potential-detail-sidebar">

                    <div class="potential-detail-side-card">

                        <h2 class="potential-detail-side-title">
                            Informasi Potensi
                        </h2>

                        <p class="potential-detail-side-description">
                            Ringkasan informasi mengenai potensi desa ini.
                        </p>

                        <div class="potential-detail-info-list">

                            <div class="potential-detail-info-item">

                                <span class="potential-detail-info-icon">
                                    <i class="bi bi-tag-fill"></i>
                                </span>

                                <div>
                                    <small>Kategori</small>

                                    <strong>
                                        {{ $category }}
                                    </strong>
                                </div>

                            </div>

                            <div class="potential-detail-info-item">

                                <span class="potential-detail-info-icon">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </span>

                                <div>
                                    <small>Lokasi</small>

                                    <strong>
                                        {{ $location }}
                                    </strong>
                                </div>

                            </div>

                            <div class="potential-detail-info-item">

                                <span class="potential-detail-info-icon">
                                    <i class="bi bi-check-circle-fill"></i>
                                </span>

                                <div>
                                    <small>Status Informasi</small>

                                    <strong>
                                        Dipublikasikan
                                    </strong>
                                </div>

                            </div>

                        </div>

                        <div class="potential-detail-actions">

                            @if($whatsappNumber)
                                <a
                                    href="https://wa.me/{{ $whatsappNumber }}?text={{ $whatsappMessage }}"
                                    target="_blank"
                                    rel="noopener"
                                    class="potential-detail-action primary"
                                >
                                    <i class="bi bi-whatsapp"></i>
                                    Hubungi Pemerintah Desa
                                </a>
                            @endif

                            <a
                                href="{{ route('public.potentials') }}"
                                class="potential-detail-action secondary"
                            >
                                <i class="bi bi-grid"></i>
                                Lihat Potensi Lainnya
                            </a>

                        </div>

                    </div>

                    <div class="potential-detail-side-card">

                        <h2 class="potential-detail-side-title">
                            Bagikan Informasi
                        </h2>

                        <p class="potential-detail-side-description">
                            Bagikan potensi Desa Bakal Dalam kepada
                            masyarakat lainnya.
                        </p>

                        <div class="potential-detail-share-list">

                            <a
                                href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}"
                                target="_blank"
                                rel="noopener"
                                class="potential-detail-share"
                            >
                                <i class="bi bi-whatsapp"></i>
                                WhatsApp
                            </a>

                            <a
                                href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                                target="_blank"
                                rel="noopener"
                                class="potential-detail-share"
                            >
                                <i class="bi bi-facebook"></i>
                                Facebook
                            </a>

                        </div>

                    </div>

                </aside>

            </div>

        </div>
    </section>

</div>

@endsection
