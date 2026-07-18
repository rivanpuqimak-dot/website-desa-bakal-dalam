@extends('layouts.public')

@section('title', 'Potensi Desa')

@push('styles')
<style>
    :root {
        --potential-green: #16834f;
        --potential-green-dark: #0d6139;
        --potential-green-soft: #eef7f2;
        --potential-blue: #2478e8;
        --potential-navy: #12251c;
        --potential-text: #34463c;
        --potential-muted: #6e7d74;
        --potential-border: #dfe9e3;
        --potential-white: #ffffff;
    }

    .potential-page {
        width: 100%;
        overflow-x: hidden;
        color: var(--potential-text);
        background: #ffffff;
    }

    .potential-container {
        width: min(1400px, calc(100% - 48px));
        margin-inline: auto;
    }


    /* =====================================================
       DAFTAR POTENSI
    ===================================================== */

    .potential-list-section {
        padding: 46px 0 78px;
        background: #ffffff;
    }

    .potential-section-heading {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 30px;
    }

    .potential-section-heading h1 {
        margin: 0;
        color: var(--potential-navy);
        font-size: clamp(26px, 2.5vw, 36px);
        line-height: 1.2;
        font-weight: 850;
        letter-spacing: -0.03em;
    }

    .potential-section-heading p {
        max-width: 620px;
        margin: 8px 0 0;
        color: var(--potential-muted);
        font-size: 14px;
        line-height: 1.65;
    }

    .potential-title-line {
        width: 48px;
        height: 5px;
        margin-top: 12px;
        border-radius: 999px;
        background: linear-gradient(
            90deg,
            var(--potential-green),
            #57bd80
        );
    }

    .potential-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
    }

    /* =====================================================
       KARTU
    ===================================================== */

    .potential-card {
        min-width: 0;
        overflow: hidden;
        background: var(--potential-white);
        border: 1px solid var(--potential-border);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(19, 69, 43, 0.06);
        transition:
            transform 0.25s ease,
            box-shadow 0.25s ease,
            border-color 0.25s ease;
    }

    .potential-card:hover {
        transform: translateY(-5px);
        border-color: rgba(22, 131, 79, 0.3);
        box-shadow: 0 20px 42px rgba(19, 69, 43, 0.12);
    }

    .potential-image-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 16 / 10;
        overflow: hidden;
        background: var(--potential-green-soft);
    }

    .potential-image-wrapper img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .potential-card:hover .potential-image-wrapper img {
        transform: scale(1.04);
    }

    .potential-category {
        position: absolute;
        left: 16px;
        bottom: 16px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        max-width: calc(100% - 32px);
        padding: 7px 11px;
        color: #ffffff;
        background: rgba(13, 97, 57, 0.92);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 999px;
        font-size: 11px;
        line-height: 1.2;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        backdrop-filter: blur(8px);
    }

    .potential-card-body {
        display: flex;
        flex-direction: column;
        min-height: 230px;
        padding: 21px;
    }

    .potential-card-title {
        margin: 0;
        color: var(--potential-navy);
        font-size: 21px;
        line-height: 1.35;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .potential-card-description {
        display: -webkit-box;
        margin: 12px 0 20px;
        overflow: hidden;
        color: var(--potential-muted);
        font-size: 14px;
        line-height: 1.7;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .potential-detail-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        align-self: flex-start;
        margin-top: auto;
        padding: 10px 14px;
        color: var(--potential-green-dark);
        background: var(--potential-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 11px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 800;
        transition:
            color 0.22s ease,
            background 0.22s ease,
            transform 0.22s ease;
    }

    .potential-detail-link:hover {
        color: #ffffff;
        background: var(--potential-green);
        transform: translateX(3px);
    }

    .potential-detail-link i {
        font-size: 12px;
    }

    /* =====================================================
       DATA KOSONG
    ===================================================== */

    .potential-empty {
        display: grid;
        place-items: center;
        min-height: 260px;
        padding: 35px;
        text-align: center;
        background: var(--potential-green-soft);
        border: 1px dashed #cbdcd2;
        border-radius: 20px;
    }

    .potential-empty-icon {
        width: 64px;
        height: 64px;
        display: grid;
        place-items: center;
        margin: 0 auto 15px;
        color: var(--potential-green);
        background: #ffffff;
        border-radius: 18px;
        font-size: 27px;
        box-shadow: 0 10px 25px rgba(19, 69, 43, 0.08);
    }

    .potential-empty h3 {
        margin: 0;
        color: var(--potential-navy);
        font-size: 20px;
        font-weight: 800;
    }

    .potential-empty p {
        margin: 8px 0 0;
        color: var(--potential-muted);
        font-size: 14px;
    }

    /* =====================================================
       PAGINATION
    ===================================================== */

    .potential-pagination {
        display: flex;
        justify-content: center;
        margin-top: 42px;
    }

    .potential-pagination .pagination {
        gap: 7px;
        margin: 0;
    }

    .potential-pagination .page-link {
        min-width: 40px;
        height: 40px;
        display: grid;
        place-items: center;
        padding: 0 11px;
        color: var(--potential-green-dark);
        background: #ffffff;
        border: 1px solid var(--potential-border);
        border-radius: 10px !important;
        box-shadow: none;
    }

    .potential-pagination .page-item.active .page-link {
        color: #ffffff;
        background: var(--potential-green);
        border-color: var(--potential-green);
    }

    .potential-pagination .page-link:hover {
        color: #ffffff;
        background: var(--potential-green);
        border-color: var(--potential-green);
    }

    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 1050px) {
        .potential-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .potential-container {
            width: min(100% - 30px, 1400px);
        }

        .potential-list-section {
            padding: 50px 0 62px;
        }

        .potential-section-heading {
            align-items: flex-start;
            flex-direction: column;
            margin-bottom: 25px;
        }

        .potential-section-heading h1 {
            font-size: 30px;
        }

        .potential-grid {
            gap: 18px;
        }

        .potential-card-body {
            min-height: 215px;
            padding: 18px;
        }

        .potential-card-title {
            font-size: 19px;
        }
    }

    @media (max-width: 560px) {
        .potential-container {
            width: calc(100% - 24px);
        }

        .potential-section-heading h1 {
            font-size: 27px;
        }

        .potential-grid {
            grid-template-columns: 1fr;
        }

        .potential-image-wrapper {
            aspect-ratio: 16 / 9;
        }

        .potential-card-body {
            min-height: auto;
        }
    }
</style>

<style>
    .potential-card-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin: 10px 0 0;
    }

    .potential-card-meta span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 9px;
        color: var(--potential-green-dark);
        background: var(--potential-green-soft);
        border-radius: 999px;
        font-size: 9px;
        font-weight: 800;
    }

    .potential-featured-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 10px;
        color: #5e3c00;
        background: rgba(255, 218, 103, 0.94);
        border-radius: 999px;
        font-size: 9px;
        font-weight: 850;
        backdrop-filter: blur(8px);
    }
</style>

@endpush

@section('content')

@php
    $potentialList = $potentials ?? collect();
@endphp

<div class="potential-page">

    {{-- DAFTAR POTENSI --}}
    <section class="potential-list-section">
        <div class="potential-container">

            <div class="potential-section-heading">

                <div>
                    <h1>Potensi Unggulan Desa Bakal Dalam</h1>

                    <div class="potential-title-line"></div>

                    <p>
                        Mengenal dan menjelajahi berbagai potensi alam, ekonomi,
                        pertanian, peternakan, wisata, serta usaha masyarakat
                        yang menjadi kekuatan Desa Bakal Dalam.
                    </p>
                </div>

            </div>

            @if($potentialList->isEmpty())

                <div class="potential-empty">

                    <div>
                        <div class="potential-empty-icon">
                            <i class="bi bi-map"></i>
                        </div>

                        <h3>Potensi desa belum tersedia</h3>

                        <p>
                            Data potensi desa akan ditampilkan setelah
                            ditambahkan melalui dashboard admin.
                        </p>
                    </div>

                </div>

            @else

                <div class="potential-grid">

                    @foreach($potentialList as $potential)

                        @php
                            $gambar = filled($potential->gambar)
                                ? asset(
                                    'storage/' .
                                    ltrim($potential->gambar, '/')
                                )
                                : asset('images/transparent.png');

                            $ringkasan = filled($potential->excerpt)
                                ? $potential->excerpt
                                : (
                                    filled($potential->deskripsi)
                                        ? \Illuminate\Support\Str::limit(
                                            strip_tags($potential->deskripsi),
                                            150
                                        )
                                        : 'Informasi potensi desa selengkapnya dapat dilihat pada halaman detail.'
                                );
                        @endphp

                        <article class="potential-card">

                            <div class="potential-image-wrapper">

                                <img
                                    src="{{ $gambar }}"
                                    alt="{{ $potential->nama }}"
                                    loading="lazy"
                                >

                                @if(filled($potential->kategori))
                                    <span class="potential-category">
                                        <i class="bi bi-tag-fill"></i>
                                        {{ $potential->kategori }}
                                    </span>
                                @endif

                                @if($potential->featured)
                                    <span class="potential-featured-badge">
                                        <i class="bi bi-star-fill"></i>
                                        Unggulan
                                    </span>
                                @endif

                            </div>

                            <div class="potential-card-body">

                                <h3 class="potential-card-title">
                                    {{ $potential->nama }}
                                </h3>

                                @if(filled($potential->lokasi))
                                    <div class="potential-card-meta">
                                        <span>
                                            <i class="bi bi-geo-alt-fill"></i>
                                            {{ $potential->lokasi }}
                                        </span>
                                    </div>
                                @endif

                                <p class="potential-card-description">
                                    {{ $ringkasan }}
                                </p>

                                <a
                                    href="{{ route(
                                        'public.potentials.show',
                                        $potential
                                    ) }}"
                                    class="potential-detail-link"
                                >
                                    Lihat Detail
                                    <i class="bi bi-arrow-right"></i>
                                </a>

                            </div>

                        </article>

                    @endforeach

                </div>

                @if(method_exists($potentialList, 'links'))

                    <div class="potential-pagination">
                        {{ $potentialList->links() }}
                    </div>

                @endif

            @endif

        </div>
    </section>

</div>

@endsection