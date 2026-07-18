@extends('layouts.public')

@section('title', 'Pencarian Informasi Desa')

@php
    $resultCount = $results->count();
@endphp

@push('styles')
<style>
    :root {
        --search-green: #16834f;
        --search-green-dark: #0d6139;
        --search-green-soft: #eef7f2;
        --search-navy: #12251c;
        --search-text: #34463c;
        --search-muted: #6e7d74;
        --search-border: #dfe9e3;
        --search-bg: #f5f8f6;
        --search-white: #ffffff;
    }

    .search-page,
    .search-page * {
        box-sizing: border-box;
    }

    .search-page {
        min-height: 68vh;
        color: var(--search-text);
        background: var(--search-bg);
    }

    .search-container {
        width: min(1120px, calc(100% - 48px));
        margin-inline: auto;
    }

    .search-hero {
        padding: 48px 0 38px;
        background:
            radial-gradient(
                circle at 88% 15%,
                rgba(22, 131, 79, 0.13),
                transparent 28%
            ),
            linear-gradient(
                180deg,
                #ffffff,
                #f7faf8
            );
        border-bottom: 1px solid var(--search-border);
    }

    .search-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--search-green);
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 0.09em;
        text-transform: uppercase;
    }

    .search-eyebrow::before {
        width: 28px;
        height: 3px;
        content: "";
        background: var(--search-green);
        border-radius: 999px;
    }

    .search-title {
        max-width: 760px;
        margin: 10px 0 0;
        color: var(--search-navy);
        font-size: clamp(31px, 5vw, 52px);
        font-weight: 900;
        line-height: 1.08;
        letter-spacing: -0.045em;
    }

    .search-description {
        max-width: 720px;
        margin: 14px 0 0;
        color: var(--search-muted);
        font-size: 15px;
        line-height: 1.75;
    }

    .search-form-card {
        margin-top: 28px;
        padding: 15px;
        background: #ffffff;
        border: 1px solid var(--search-border);
        border-radius: 17px;
        box-shadow: 0 16px 40px rgba(19, 69, 43, 0.08);
    }

    .search-form {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 205px auto;
        gap: 10px;
    }

    .search-input-wrap {
        position: relative;
    }

    .search-input-wrap i {
        position: absolute;
        top: 50%;
        left: 15px;
        color: var(--search-green);
        transform: translateY(-50%);
    }

    .search-input,
    .search-select {
        width: 100%;
        min-height: 50px;
        color: var(--search-text);
        background: #f8fbf9;
        border: 1px solid var(--search-border);
        border-radius: 12px;
        outline: none;
        font-size: 13px;
    }

    .search-input {
        padding: 0 14px 0 43px;
    }

    .search-select {
        padding: 0 12px;
    }

    .search-input:focus,
    .search-select:focus {
        background: #ffffff;
        border-color: rgba(22, 131, 79, 0.62);
        box-shadow: 0 0 0 4px rgba(22, 131, 79, 0.09);
    }

    .search-submit {
        min-height: 50px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0 20px;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--search-green-dark),
            var(--search-green)
        );
        border: 0;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 850;
        cursor: pointer;
    }

    .search-content {
        padding: 38px 0 78px;
    }

    .search-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 20px;
        padding: 14px 16px;
        color: #8e261f;
        background: #fff1f0;
        border: 1px solid #f1cbc8;
        border-radius: 13px;
        font-size: 13px;
        line-height: 1.6;
    }

    .search-summary {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 20px;
    }

    .search-summary h2 {
        margin: 0;
        color: var(--search-navy);
        font-size: clamp(23px, 3vw, 31px);
        font-weight: 900;
        letter-spacing: -0.03em;
    }

    .search-summary p {
        margin: 6px 0 0;
        color: var(--search-muted);
        font-size: 13px;
    }

    .search-count {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 12px;
        color: var(--search-green-dark);
        background: var(--search-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.15);
        border-radius: 999px;
        font-size: 11px;
        font-weight: 850;
        white-space: nowrap;
    }

    .search-results {
        display: grid;
        gap: 14px;
    }

    .search-result-card {
        min-width: 0;
        display: grid;
        grid-template-columns: 160px minmax(0, 1fr) auto;
        align-items: stretch;
        overflow: hidden;
        color: inherit;
        background: #ffffff;
        border: 1px solid var(--search-border);
        border-radius: 17px;
        text-decoration: none;
        box-shadow: 0 10px 28px rgba(19, 69, 43, 0.05);
        transition:
            transform 0.22s ease,
            border-color 0.22s ease,
            box-shadow 0.22s ease;
    }

    .search-result-card:hover {
        transform: translateY(-3px);
        border-color: rgba(22, 131, 79, 0.31);
        box-shadow: 0 17px 37px rgba(19, 69, 43, 0.09);
    }

    .search-result-image {
        min-height: 150px;
        overflow: hidden;
        background: var(--search-green-soft);
    }

    .search-result-image img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .search-result-placeholder {
        width: 100%;
        height: 100%;
        min-height: 150px;
        display: grid;
        place-items: center;
        color: var(--search-green);
        background:
            radial-gradient(
                circle,
                rgba(22, 131, 79, 0.16),
                transparent 48%
            ),
            var(--search-green-soft);
        font-size: 33px;
    }

    .search-result-body {
        min-width: 0;
        padding: 20px;
    }

    .search-result-top {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px 12px;
    }

    .search-type {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 9px;
        color: var(--search-green-dark);
        background: var(--search-green-soft);
        border-radius: 999px;
        font-size: 9px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .search-date {
        color: var(--search-muted);
        font-size: 10px;
        font-weight: 700;
    }

    .search-result-title {
        margin: 11px 0 0;
        color: var(--search-navy);
        font-size: 20px;
        font-weight: 900;
        line-height: 1.3;
        letter-spacing: -0.025em;
    }

    .search-result-excerpt {
        margin: 8px 0 0;
        color: var(--search-muted);
        font-size: 13px;
        line-height: 1.7;
    }

    .search-result-meta {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-top: 12px;
        color: var(--search-text);
        font-size: 10px;
        font-weight: 750;
    }

    .search-result-meta i {
        color: var(--search-green);
    }

    .search-result-arrow {
        width: 56px;
        display: grid;
        place-items: center;
        color: var(--search-green);
        background: #fbfdfc;
        border-left: 1px solid var(--search-border);
        font-size: 17px;
    }

    .search-empty,
    .search-start {
        display: grid;
        place-items: center;
        min-height: 290px;
        padding: 36px 22px;
        color: var(--search-muted);
        background: #ffffff;
        border: 1px dashed #cbdcd2;
        border-radius: 19px;
        text-align: center;
    }

    .search-state-icon {
        width: 70px;
        height: 70px;
        display: grid;
        place-items: center;
        margin: 0 auto 15px;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--search-green-dark),
            var(--search-green)
        );
        border-radius: 20px;
        font-size: 29px;
        box-shadow: 0 14px 28px rgba(22, 131, 79, 0.18);
    }

    .search-empty h2,
    .search-start h2 {
        margin: 0;
        color: var(--search-navy);
        font-size: 23px;
        font-weight: 900;
    }

    .search-empty p,
    .search-start p {
        max-width: 520px;
        margin: 9px auto 0;
        font-size: 13px;
        line-height: 1.7;
    }

    @media (max-width: 820px) {
        .search-form {
            grid-template-columns: 1fr;
        }

        .search-result-card {
            grid-template-columns: 115px minmax(0, 1fr);
        }

        .search-result-arrow {
            display: none;
        }
    }

    @media (max-width: 560px) {
        .search-container {
            width: min(100% - 28px, 1120px);
        }

        .search-hero {
            padding: 35px 0 28px;
        }

        .search-form-card {
            padding: 11px;
        }

        .search-content {
            padding: 28px 0 58px;
        }

        .search-summary {
            align-items: flex-start;
            flex-direction: column;
        }

        .search-result-card {
            grid-template-columns: 1fr;
        }

        .search-result-image,
        .search-result-placeholder {
            min-height: 185px;
        }

        .search-result-body {
            padding: 17px;
        }
    }
</style>
@endpush

@section('content')
<div class="search-page">

    <section class="search-hero">
        <div class="search-container">

            <span class="search-eyebrow">
                Pencarian Publik
            </span>

            <h1 class="search-title">
                Temukan Informasi Desa dengan Cepat
            </h1>

            <p class="search-description">
                Cari berita, potensi desa, agenda, dan pengumuman resmi
                yang telah dipublikasikan.
            </p>

            <div class="search-form-card">
                <form
                    action="{{ route('public.search') }}"
                    method="GET"
                    class="search-form"
                    role="search"
                >
                    <div class="search-input-wrap">
                        <i class="bi bi-search"></i>

                        <input
                            type="search"
                            name="q"
                            value="{{ $keyword }}"
                            class="search-input"
                            placeholder="Contoh: embung, bantuan, rapat..."
                            minlength="2"
                            maxlength="100"
                            required
                        >
                    </div>

                    <select
                        name="type"
                        class="search-select"
                        aria-label="Jenis informasi"
                    >
                        @foreach($resultTypes as $typeKey => $typeLabel)
                            <option
                                value="{{ $typeKey }}"
                                {{ $type === $typeKey ? 'selected' : '' }}
                            >
                                {{ $typeLabel }}
                            </option>
                        @endforeach
                    </select>

                    <button
                        type="submit"
                        class="search-submit"
                    >
                        <i class="bi bi-search"></i>
                        Cari
                    </button>
                </form>
            </div>

        </div>
    </section>

    <section class="search-content">
        <div class="search-container">

            @if($searchError)
                <div class="search-alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>{{ $searchError }}</span>
                </div>
            @endif

            @if(!$searchPerformed)

                <div class="search-start">
                    <div>
                        <span class="search-state-icon">
                            <i class="bi bi-search"></i>
                        </span>

                        <h2>Mulai Pencarian</h2>

                        <p>
                            Masukkan sedikitnya dua karakter. Sistem hanya
                            menampilkan informasi yang berstatus publik.
                        </p>
                    </div>
                </div>

            @elseif($results->isEmpty())

                <div class="search-empty">
                    <div>
                        <span class="search-state-icon">
                            <i class="bi bi-folder2-open"></i>
                        </span>

                        <h2>Informasi Belum Ditemukan</h2>

                        <p>
                            Tidak ada hasil untuk kata kunci
                            <strong>“{{ $keyword }}”</strong>.
                            Coba gunakan kata yang lebih singkat atau pilih
                            jenis informasi lain.
                        </p>
                    </div>
                </div>

            @else

                <div class="search-summary">
                    <div>
                        <h2>Hasil Pencarian</h2>

                        <p>
                            Kata kunci:
                            <strong>“{{ $keyword }}”</strong>
                        </p>
                    </div>

                    <span class="search-count">
                        <i class="bi bi-check2-circle"></i>
                        {{ $resultCount }} hasil
                    </span>
                </div>

                <div class="search-results">

                    @foreach($results as $result)

                        <a
                            href="{{ $result['url'] }}"
                            class="search-result-card"
                        >
                            <div class="search-result-image">

                                @if($result['image'])
                                    <img
                                        src="{{ $result['image'] }}"
                                        alt="{{ $result['title'] }}"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="search-result-placeholder">
                                        <i class="bi {{ $result['icon'] }}"></i>
                                    </div>
                                @endif

                            </div>

                            <div class="search-result-body">

                                <div class="search-result-top">
                                    <span class="search-type">
                                        <i class="bi {{ $result['icon'] }}"></i>
                                        {{ $result['type_label'] }}
                                    </span>

                                    @if($result['date'])
                                        <span class="search-date">
                                            {{ $result['date']
                                                ->locale('id')
                                                ->translatedFormat('d M Y')
                                            }}
                                        </span>
                                    @endif
                                </div>

                                <h3 class="search-result-title">
                                    {{ $result['title'] }}
                                </h3>

                                <p class="search-result-excerpt">
                                    {{ $result['excerpt'] }}
                                </p>

                                @if($result['meta'])
                                    <span class="search-result-meta">
                                        <i class="bi bi-geo-alt"></i>
                                        {{ $result['meta'] }}
                                    </span>
                                @endif

                            </div>

                            <span class="search-result-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </span>
                        </a>

                    @endforeach

                </div>

            @endif

        </div>
    </section>

</div>
@endsection
