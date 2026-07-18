@extends('layouts.public')

@section('title', 'Berita Desa')

@push('styles')
<style>
    :root {
        --news-green: #16834f;
        --news-green-dark: #0d6139;
        --news-green-soft: #eef7f2;
        --news-blue: #2478e8;
        --news-navy: #12251c;
        --news-text: #34463c;
        --news-muted: #6e7d74;
        --news-border: #dfe9e3;
        --news-white: #ffffff;
    }

    .news-page {
        width: 100%;
        overflow-x: hidden;
        color: var(--news-text);
        background: var(--news-white);
    }

    .news-container {
        width: min(1400px, calc(100% - 48px));
        margin-inline: auto;
    }

    /* =====================================================
       DAFTAR BERITA
    ===================================================== */

    .news-list-section {
        padding: 48px 0 78px;
        background: var(--news-white);
    }

    .news-section-heading {
        margin-bottom: 30px;
    }

    .news-section-heading h1 {
        margin: 0;
        color: var(--news-navy);
        font-size: clamp(26px, 2.5vw, 36px);
        line-height: 1.2;
        font-weight: 850;
        letter-spacing: -0.03em;
    }

    .news-title-line {
        width: 48px;
        height: 5px;
        margin-top: 12px;
        border-radius: 999px;
        background: linear-gradient(
            90deg,
            var(--news-green),
            #57bd80
        );
    }

    .news-section-heading p {
        max-width: 720px;
        margin: 14px 0 0;
        color: var(--news-muted);
        font-size: 14px;
        line-height: 1.65;
    }

    .news-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
    }

    /* =====================================================
       KARTU BERITA
    ===================================================== */

    .news-card {
        min-width: 0;
        overflow: hidden;
        background: var(--news-white);
        border: 1px solid var(--news-border);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(19, 69, 43, 0.06);
        transition:
            transform 0.25s ease,
            box-shadow 0.25s ease,
            border-color 0.25s ease;
    }

    .news-card:hover {
        transform: translateY(-5px);
        border-color: rgba(22, 131, 79, 0.3);
        box-shadow: 0 20px 42px rgba(19, 69, 43, 0.12);
    }

    .news-image-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 16 / 10;
        overflow: hidden;
        background: var(--news-green-soft);
    }

    .news-image-wrapper img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .news-card:hover .news-image-wrapper img {
        transform: scale(1.04);
    }

    .news-date-badge {
        position: absolute;
        left: 16px;
        bottom: 16px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        max-width: calc(100% - 32px);
        padding: 8px 12px;
        color: #ffffff;
        background: rgba(13, 97, 57, 0.92);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        line-height: 1.2;
        backdrop-filter: blur(8px);
    }

    .news-card-body {
        display: flex;
        flex-direction: column;
        min-height: 250px;
        padding: 21px;
    }

    .news-card-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        align-self: flex-start;
        margin-bottom: 11px;
        color: var(--news-green);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .news-card-title {
        display: -webkit-box;
        margin: 0;
        overflow: hidden;
        color: var(--news-navy);
        font-size: 21px;
        line-height: 1.35;
        font-weight: 800;
        letter-spacing: -0.02em;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .news-card-description {
        display: -webkit-box;
        margin: 12px 0 20px;
        overflow: hidden;
        color: var(--news-muted);
        font-size: 14px;
        line-height: 1.7;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .news-detail-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        align-self: flex-start;
        margin-top: auto;
        padding: 10px 14px;
        color: var(--news-green-dark);
        background: var(--news-green-soft);
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

    .news-detail-link:hover {
        color: #ffffff;
        background: var(--news-green);
        transform: translateX(3px);
    }

    .news-detail-link i {
        font-size: 12px;
    }

    /* =====================================================
       DATA KOSONG
    ===================================================== */

    .news-empty {
        display: grid;
        place-items: center;
        min-height: 260px;
        padding: 35px;
        text-align: center;
        background: var(--news-green-soft);
        border: 1px dashed #cbdcd2;
        border-radius: 20px;
    }

    .news-empty-icon {
        width: 64px;
        height: 64px;
        display: grid;
        place-items: center;
        margin: 0 auto 15px;
        color: var(--news-green);
        background: #ffffff;
        border-radius: 18px;
        font-size: 27px;
        box-shadow: 0 10px 25px rgba(19, 69, 43, 0.08);
    }

    .news-empty h3 {
        margin: 0;
        color: var(--news-navy);
        font-size: 20px;
        font-weight: 800;
    }

    .news-empty p {
        margin: 8px 0 0;
        color: var(--news-muted);
        font-size: 14px;
    }

    /* =====================================================
       PAGINATION
    ===================================================== */

    .news-pagination {
        display: flex;
        justify-content: center;
        margin-top: 42px;
    }

    .news-pagination .pagination {
        gap: 7px;
        margin: 0;
    }

    .news-pagination .page-link {
        min-width: 40px;
        height: 40px;
        display: grid;
        place-items: center;
        padding: 0 11px;
        color: var(--news-green-dark);
        background: #ffffff;
        border: 1px solid var(--news-border);
        border-radius: 10px !important;
        box-shadow: none;
    }

    .news-pagination .page-item.active .page-link {
        color: #ffffff;
        background: var(--news-green);
        border-color: var(--news-green);
    }

    .news-pagination .page-link:hover {
        color: #ffffff;
        background: var(--news-green);
        border-color: var(--news-green);
    }

    .news-pagination .page-item.disabled .page-link {
        color: #a6b0aa;
        background: #f7f9f8;
    }

    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 1050px) {
        .news-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .news-container {
            width: min(100% - 30px, 1400px);
        }

        .news-list-section {
            padding: 42px 0 62px;
        }

        .news-section-heading h1 {
            font-size: 31px;
        }

        .news-grid {
            gap: 18px;
        }

        .news-card-body {
            min-height: 235px;
            padding: 18px;
        }

        .news-card-title {
            font-size: 19px;
        }
    }

    @media (max-width: 560px) {
        .news-container {
            width: calc(100% - 24px);
        }

        .news-section-heading h1 {
            font-size: 27px;
        }

        .news-grid {
            grid-template-columns: 1fr;
        }

        .news-image-wrapper {
            aspect-ratio: 16 / 9;
        }

        .news-card-body {
            min-height: auto;
        }
    }
</style>

<style>
    .news-card-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin: -3px 0 11px;
    }

    .news-card-meta span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: var(--news-muted);
        font-size: 10px;
        font-weight: 700;
    }

    .news-featured-label {
        color: #94600c !important;
    }
</style>

@endpush

@section('content')

@php
    $newsList = $news ?? collect();
@endphp

<div class="news-page">

    {{-- DAFTAR BERITA --}}
    <section class="news-list-section">
        <div class="news-container">

            <div class="news-section-heading">

                <h1>Berita dan Informasi Desa Bakal Dalam</h1>

                <div class="news-title-line"></div>

                <p>
                    Ikuti perkembangan kegiatan, pembangunan, pelayanan publik,
                    serta berbagai informasi terbaru dari Desa Bakal Dalam.
                </p>

            </div>

            @if($newsList->isEmpty())

                <div class="news-empty">

                    <div>
                        <div class="news-empty-icon">
                            <i class="bi bi-newspaper"></i>
                        </div>

                        <h3>Belum ada berita</h3>

                        <p>
                            Berita desa akan ditampilkan setelah dipublikasikan
                            melalui dashboard admin.
                        </p>
                    </div>

                </div>

            @else

                <div class="news-grid">

                    @foreach($newsList as $item)

                        @php
                            $gambar = filled($item->gambar)
                                ? asset(
                                    'storage/' .
                                    ltrim($item->gambar, '/')
                                )
                                : asset('images/transparent.png');

                            $isiBerita = data_get($item, 'isi')
                                ?? data_get($item, 'content')
                                ?? data_get($item, 'deskripsi');

                            $ringkasan = filled($item->excerpt)
                                ? $item->excerpt
                                : (
                                    filled($isiBerita)
                                        ? \Illuminate\Support\Str::limit(
                                            strip_tags($isiBerita),
                                            150
                                        )
                                        : 'Baca informasi selengkapnya pada halaman detail berita.'
                                );

                            $tanggalBerita = filled($item->published_at)
                                ? \Illuminate\Support\Carbon::parse(
                                    $item->published_at
                                )
                                    ->locale('id')
                                    ->translatedFormat('d F Y')
                                : 'Tanggal belum tersedia';
                        @endphp

                        <article class="news-card">

                            <div class="news-image-wrapper">

                                <img
                                    src="{{ $gambar }}"
                                    alt="{{ $item->judul }}"
                                    loading="lazy"
                                >

                                <span class="news-date-badge">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $tanggalBerita }}
                                </span>

                            </div>

                            <div class="news-card-body">

                                <span class="news-card-label">
                                    <i class="bi bi-tag-fill"></i>
                                    {{ $item->kategori ?: 'Berita Desa' }}
                                </span>

                                <div class="news-card-meta">

                                    @if(filled($item->penulis))
                                        <span>
                                            <i class="bi bi-person"></i>
                                            {{ $item->penulis }}
                                        </span>
                                    @endif

                                    <span>
                                        <i class="bi bi-eye"></i>
                                        {{ number_format(
                                            $item->views ?? 0,
                                            0,
                                            ',',
                                            '.'
                                        ) }}
                                        dilihat
                                    </span>

                                    @if($item->featured)
                                        <span class="news-featured-label">
                                            <i class="bi bi-star-fill"></i>
                                            Unggulan
                                        </span>
                                    @endif

                                </div>

                                <h3 class="news-card-title">
                                    {{ $item->judul }}
                                </h3>

                                <p class="news-card-description">
                                    {{ $ringkasan }}
                                </p>

                                <a
                                    href="{{ route(
                                        'public.news.show',
                                        $item
                                    ) }}"
                                    class="news-detail-link"
                                >
                                    Baca Selengkapnya
                                    <i class="bi bi-arrow-right"></i>
                                </a>

                            </div>

                        </article>

                    @endforeach

                </div>

                @if(method_exists($newsList, 'links'))

                    <div class="news-pagination">
                        {{ $newsList->links() }}
                    </div>

                @endif

            @endif

        </div>
    </section>

</div>

@endsection