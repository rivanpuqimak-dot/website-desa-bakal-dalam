@extends('layouts.public')

@section('title', $news->judul ?? 'Detail Berita')

@php
    $publishedDate = filled($news?->published_at)
        ? \Illuminate\Support\Carbon::parse($news->published_at)
        : \Illuminate\Support\Carbon::parse($news->created_at);

    $imageUrl = filled($news?->gambar)
        ? asset('storage/' . ltrim($news->gambar, '/'))
        : null;

    $category = filled($news?->kategori)
        ? $news->kategori
        : 'Berita Desa';

    $author = filled($news?->penulis)
        ? $news->penulis
        : 'Pemerintah Desa';

    $excerpt = filled($news?->excerpt)
        ? $news->excerpt
        : null;

    $articleBody = filled($news?->isi)
        ? $news->isi
        : 'Isi berita belum tersedia.';

    $shareUrl = urlencode(request()->fullUrl());
    $shareTitle = urlencode($news->judul ?? 'Berita Desa');
@endphp

@push('styles')
<style>
    :root {
        --news-detail-green: #16834f;
        --news-detail-green-dark: #0d6139;
        --news-detail-green-deep: #09472b;
        --news-detail-green-soft: #eef7f2;
        --news-detail-navy: #12251c;
        --news-detail-text: #34463c;
        --news-detail-muted: #6e7d74;
        --news-detail-border: #dfe9e3;
        --news-detail-bg: #f5f8f6;
        --news-detail-white: #ffffff;
    }

    .news-detail-page,
    .news-detail-page * {
        box-sizing: border-box;
    }

    .news-detail-page {
        min-height: 70vh;
        overflow-x: hidden;
        color: var(--news-detail-text);
        background: var(--news-detail-bg);
    }

    .news-detail-container {
        width: min(1180px, calc(100% - 48px));
        margin-inline: auto;
    }

    /* =====================================================
       HEADER ARTIKEL
    ===================================================== */

    .news-detail-header {
        padding: 36px 0 30px;
        background:
            radial-gradient(
                circle at 88% 10%,
                rgba(22, 131, 79, 0.10),
                transparent 30%
            ),
            linear-gradient(
                180deg,
                #ffffff 0%,
                #f7faf8 100%
            );
        border-bottom: 1px solid var(--news-detail-border);
    }

    .news-detail-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 39px;
        padding: 8px 12px;
        color: var(--news-detail-green-dark);
        background: var(--news-detail-white);
        border: 1px solid var(--news-detail-border);
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

    .news-detail-back:hover {
        color: #ffffff;
        background: var(--news-detail-green);
        border-color: var(--news-detail-green);
        transform: translateX(-2px);
    }

    .news-detail-heading {
        max-width: 980px;
        margin-top: 24px;
    }

    .news-detail-category {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 11px;
        color: var(--news-detail-green-dark);
        background: var(--news-detail-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.17);
        border-radius: 999px;
        font-size: 10px;
        font-weight: 850;
        line-height: 1;
        text-transform: uppercase;
        letter-spacing: 0.07em;
    }

    .news-detail-title {
        max-width: 1000px;
        margin: 16px 0 0;
        color: var(--news-detail-navy);
        font-size: clamp(32px, 4.5vw, 58px);
        font-weight: 900;
        line-height: 1.09;
        letter-spacing: -0.045em;
        overflow-wrap: anywhere;
    }

    .news-detail-excerpt {
        max-width: 850px;
        margin: 16px 0 0;
        color: var(--news-detail-muted);
        font-size: clamp(15px, 1.4vw, 18px);
        line-height: 1.75;
    }

    .news-detail-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 9px 18px;
        margin-top: 20px;
        color: var(--news-detail-muted);
        font-size: 12px;
        font-weight: 700;
    }

    .news-detail-meta-item {
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .news-detail-meta-item i {
        color: var(--news-detail-green);
        font-size: 13px;
    }

    /* =====================================================
       FOTO UTAMA
    ===================================================== */

    .news-detail-featured-section {
        padding-top: 30px;
    }

    .news-detail-featured {
        position: relative;
        width: 100%;
        overflow: hidden;
        background: var(--news-detail-green-soft);
        border: 1px solid var(--news-detail-border);
        border-radius: 22px;
        box-shadow: 0 18px 42px rgba(19, 69, 43, 0.10);
    }

    .news-detail-featured img {
        width: 100%;
        max-height: 620px;
        aspect-ratio: 16 / 8.5;
        display: block;
        object-fit: cover;
        object-position: center;
    }

    .news-detail-image-placeholder {
        min-height: 420px;
        display: grid;
        place-items: center;
        padding: 36px;
        text-align: center;
        color: var(--news-detail-green-dark);
        background:
            radial-gradient(
                circle at center,
                rgba(22, 131, 79, 0.12),
                transparent 38%
            ),
            var(--news-detail-green-soft);
    }

    .news-detail-image-placeholder i {
        display: grid;
        place-items: center;
        width: 76px;
        height: 76px;
        margin: 0 auto 13px;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--news-detail-green-dark),
            var(--news-detail-green)
        );
        border-radius: 21px;
        font-size: 31px;
        box-shadow: 0 14px 30px rgba(22, 131, 79, 0.18);
    }

    .news-detail-image-placeholder strong {
        color: var(--news-detail-navy);
        font-size: 17px;
        font-weight: 850;
    }

    /* =====================================================
       KONTEN ARTIKEL
    ===================================================== */

    .news-detail-content-section {
        padding: 30px 0 72px;
    }

    .news-detail-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 260px;
        align-items: start;
        gap: 26px;
    }

    .news-detail-article {
        min-width: 0;
        padding: clamp(24px, 4vw, 46px);
        background: var(--news-detail-white);
        border: 1px solid var(--news-detail-border);
        border-radius: 20px;
        box-shadow: 0 12px 34px rgba(19, 69, 43, 0.06);
    }

    .news-detail-article-label {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 22px;
        color: var(--news-detail-green-dark);
        font-size: 11px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .news-detail-article-label::before {
        width: 35px;
        height: 4px;
        content: "";
        border-radius: 999px;
        background: var(--news-detail-green);
    }

    .news-detail-body {
        color: var(--news-detail-text);
        font-size: 16px;
        line-height: 1.95;
        overflow-wrap: anywhere;
    }

    .news-detail-body p {
        margin: 0 0 1.35em;
    }

    .news-detail-body p:last-child {
        margin-bottom: 0;
    }

    .news-detail-author {
        display: flex;
        align-items: center;
        gap: 13px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid var(--news-detail-border);
    }

    .news-detail-author-icon {
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        display: grid;
        place-items: center;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--news-detail-green-dark),
            var(--news-detail-green)
        );
        border-radius: 13px;
        font-size: 18px;
    }

    .news-detail-author small {
        display: block;
        color: var(--news-detail-muted);
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .news-detail-author strong {
        display: block;
        margin-top: 3px;
        color: var(--news-detail-navy);
        font-size: 14px;
        font-weight: 850;
    }

    /* =====================================================
       SIDEBAR
    ===================================================== */

    .news-detail-sidebar {
        position: sticky;
        top: 104px;
        display: grid;
        gap: 15px;
    }

    .news-detail-side-card {
        padding: 19px;
        background: var(--news-detail-white);
        border: 1px solid var(--news-detail-border);
        border-radius: 17px;
        box-shadow: 0 10px 28px rgba(19, 69, 43, 0.05);
    }

    .news-detail-side-title {
        margin: 0;
        color: var(--news-detail-navy);
        font-size: 14px;
        font-weight: 850;
    }

    .news-detail-side-text {
        margin: 8px 0 0;
        color: var(--news-detail-muted);
        font-size: 11px;
        line-height: 1.65;
    }

    .news-detail-share-list {
        display: grid;
        gap: 8px;
        margin-top: 14px;
    }

    .news-detail-share {
        min-height: 39px;
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 9px 11px;
        color: var(--news-detail-green-dark);
        background: var(--news-detail-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.15);
        border-radius: 10px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 800;
        transition:
            color 0.2s ease,
            background 0.2s ease,
            transform 0.2s ease;
    }

    .news-detail-share:hover {
        color: #ffffff;
        background: var(--news-detail-green);
        transform: translateX(2px);
    }

    .news-detail-side-back {
        min-height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 13px;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--news-detail-green-deep),
            var(--news-detail-green)
        );
        border-radius: 11px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 850;
        box-shadow: 0 10px 22px rgba(22, 131, 79, 0.17);
    }

    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 900px) {
        .news-detail-layout {
            grid-template-columns: 1fr;
        }

        .news-detail-sidebar {
            position: static;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .news-detail-container {
            width: min(100% - 30px, 1180px);
        }

        .news-detail-header {
            padding: 26px 0 24px;
        }

        .news-detail-heading {
            margin-top: 18px;
        }

        .news-detail-title {
            font-size: clamp(29px, 9vw, 42px);
            line-height: 1.12;
        }

        .news-detail-featured-section {
            padding-top: 20px;
        }

        .news-detail-featured {
            border-radius: 17px;
        }

        .news-detail-featured img {
            min-height: 260px;
            aspect-ratio: 16 / 10;
        }

        .news-detail-content-section {
            padding: 20px 0 48px;
        }

        .news-detail-article {
            padding: 23px 18px;
            border-radius: 17px;
        }

        .news-detail-body {
            font-size: 15px;
            line-height: 1.85;
        }
    }

    @media (max-width: 575.98px) {
        .news-detail-meta {
            align-items: flex-start;
            flex-direction: column;
            gap: 8px;
        }

        .news-detail-sidebar {
            grid-template-columns: 1fr;
        }

        .news-detail-image-placeholder {
            min-height: 280px;
        }
    }
</style>
@endpush

@section('content')

<div class="news-detail-page">

    <header class="news-detail-header">
        <div class="news-detail-container">

            <a
                href="{{ route('public.news') }}"
                class="news-detail-back"
            >
                <i class="bi bi-arrow-left"></i>
                Kembali ke Berita
            </a>

            <div class="news-detail-heading">

                <span class="news-detail-category">
                    <i class="bi bi-tag-fill"></i>
                    {{ $category }}
                </span>

                <h1 class="news-detail-title">
                    {{ $news->judul }}
                </h1>

                @if($excerpt)
                    <p class="news-detail-excerpt">
                        {{ $excerpt }}
                    </p>
                @endif

                <div class="news-detail-meta">

                    <span class="news-detail-meta-item">
                        <i class="bi bi-calendar3"></i>

                        {{ $publishedDate
                            ->locale('id')
                            ->translatedFormat('d F Y')
                        }}
                    </span>

                    <span class="news-detail-meta-item">
                        <i class="bi bi-person-circle"></i>
                        {{ $author }}
                    </span>

                    <span class="news-detail-meta-item">
                        <i class="bi bi-eye"></i>
                        {{ number_format((int) ($news->views ?? 0)) }}
                        kali dibaca
                    </span>

                </div>

            </div>

        </div>
    </header>

    <section class="news-detail-featured-section">
        <div class="news-detail-container">

            <figure class="news-detail-featured">

                @if($imageUrl)

                    <img
                        src="{{ $imageUrl }}"
                        alt="{{ $news->judul }}"
                    >

                @else

                    <div class="news-detail-image-placeholder">
                        <div>
                            <i class="bi bi-newspaper"></i>

                            <strong>
                                Berita Desa
                            </strong>
                        </div>
                    </div>

                @endif

            </figure>

        </div>
    </section>

    <section class="news-detail-content-section">
        <div class="news-detail-container">

            <div class="news-detail-layout">

                <article class="news-detail-article">

                    <div class="news-detail-article-label">
                        Isi Berita
                    </div>

                    <div class="news-detail-body">
                        @foreach(
                            preg_split(
                                "/\r\n|\n|\r/",
                                trim($articleBody)
                            ) as $paragraph
                        )
                            @if(trim($paragraph) !== '')
                                <p>{{ $paragraph }}</p>
                            @endif
                        @endforeach
                    </div>

                    <div class="news-detail-author">

                        <div class="news-detail-author-icon">
                            <i class="bi bi-person-fill"></i>
                        </div>

                        <div>
                            <small>Ditulis oleh</small>
                            <strong>{{ $author }}</strong>
                        </div>

                    </div>

                </article>

                <aside class="news-detail-sidebar">

                    <div class="news-detail-side-card">

                        <h2 class="news-detail-side-title">
                            Bagikan Berita
                        </h2>

                        <p class="news-detail-side-text">
                            Bagikan informasi ini kepada warga lainnya.
                        </p>

                        <div class="news-detail-share-list">

                            <a
                                href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}"
                                target="_blank"
                                rel="noopener"
                                class="news-detail-share"
                            >
                                <i class="bi bi-whatsapp"></i>
                                WhatsApp
                            </a>

                            <a
                                href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                                target="_blank"
                                rel="noopener"
                                class="news-detail-share"
                            >
                                <i class="bi bi-facebook"></i>
                                Facebook
                            </a>

                        </div>

                    </div>

                    <div class="news-detail-side-card">

                        <h2 class="news-detail-side-title">
                            Berita Desa
                        </h2>

                        <p class="news-detail-side-text">
                            Lihat informasi dan kegiatan desa lainnya.
                        </p>

                        <a
                            href="{{ route('public.news') }}"
                            class="news-detail-side-back"
                        >
                            <i class="bi bi-grid"></i>
                            Lihat Semua Berita
                        </a>

                    </div>

                </aside>

            </div>

        </div>
    </section>

</div>

@endsection
