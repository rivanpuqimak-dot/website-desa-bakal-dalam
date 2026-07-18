@extends('layouts.public')

@section('title', 'Kontak Desa')

@push('styles')
<style>
    :root {
        --contact-green: #16834f;
        --contact-green-dark: #0d6139;
        --contact-green-soft: #eef7f2;
        --contact-navy: #12251c;
        --contact-text: #35463c;
        --contact-muted: #6d7b73;
        --contact-border: #dfe9e3;
        --contact-white: #ffffff;
    }

    .contact-page {
        width: 100%;
        overflow-x: hidden;
        color: var(--contact-text);
        background: var(--contact-white);
    }

    .contact-container {
        width: min(1400px, calc(100% - 48px));
        margin-inline: auto;
    }

    /* =====================================================
       SECTION KONTAK
    ===================================================== */

    .contact-main-section {
        padding: 48px 0 76px;
        background: #ffffff;
    }

    .contact-section-heading {
        margin-bottom: 28px;
    }

    .contact-section-title {
        margin: 0;
        color: var(--contact-navy);
        font-size: clamp(26px, 2.5vw, 36px);
        line-height: 1.2;
        font-weight: 850;
        letter-spacing: -0.03em;
    }

    .contact-title-line {
        width: 48px;
        height: 5px;
        margin-top: 12px;
        border-radius: 999px;
        background: linear-gradient(
            90deg,
            var(--contact-green),
            #57bd80
        );
    }

    .contact-section-description {
        max-width: 720px;
        margin: 14px 0 0;
        color: var(--contact-muted);
        font-size: 14px;
        line-height: 1.65;
    }

    .contact-layout {
        display: grid;
        grid-template-columns: minmax(0, 0.9fr) minmax(0, 1.35fr);
        gap: 24px;
        align-items: stretch;
    }

    /* =====================================================
       KARTU INFORMASI
    ===================================================== */

    .contact-info-card {
        position: relative;
        overflow: hidden;
        padding: 30px;
        background: var(--contact-white);
        border: 1px solid var(--contact-border);
        border-radius: 20px;
        box-shadow: 0 12px 34px rgba(19, 69, 43, 0.07);
    }

    .contact-info-card::before {
        content: "";
        position: absolute;
        top: -90px;
        right: -90px;
        width: 190px;
        height: 190px;
        border-radius: 50%;
        background: rgba(22, 131, 79, 0.05);
    }

    .contact-info-header {
        position: relative;
        z-index: 2;
        margin-bottom: 24px;
    }

    .contact-info-header h2 {
        margin: 0;
        color: var(--contact-navy);
        font-size: 25px;
        font-weight: 850;
        letter-spacing: -0.025em;
    }

    .contact-info-header p {
        margin: 8px 0 0;
        color: var(--contact-muted);
        font-size: 14px;
        line-height: 1.65;
    }

    .contact-list {
        position: relative;
        z-index: 2;
        display: grid;
        gap: 13px;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        padding: 14px;
        color: inherit;
        background: #f8fbf9;
        border: 1px solid #e6eee9;
        border-radius: 14px;
        text-decoration: none;
        transition:
            transform 0.22s ease,
            border-color 0.22s ease,
            background 0.22s ease;
    }

    a.contact-item:hover {
        color: inherit;
        background: var(--contact-green-soft);
        border-color: rgba(22, 131, 79, 0.28);
        transform: translateX(3px);
    }

    .contact-item-icon {
        width: 40px;
        height: 40px;
        flex: 0 0 40px;
        display: grid;
        place-items: center;
        color: var(--contact-green);
        background: var(--contact-white);
        border: 1px solid rgba(22, 131, 79, 0.14);
        border-radius: 12px;
        font-size: 17px;
    }

    .contact-item-content {
        min-width: 0;
        padding-top: 1px;
    }

    .contact-item-label {
        display: block;
        margin-bottom: 3px;
        color: var(--contact-muted);
        font-size: 11px;
        line-height: 1.3;
        font-weight: 800;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .contact-item-value {
        display: block;
        color: var(--contact-navy);
        font-size: 14px;
        line-height: 1.6;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .contact-actions {
        position: relative;
        z-index: 2;
        display: flex;
        flex-wrap: wrap;
        gap: 11px;
        margin-top: 23px;
    }

    .contact-action-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 44px;
        padding: 11px 16px;
        border-radius: 12px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 800;
        transition:
            transform 0.22s ease,
            background 0.22s ease,
            color 0.22s ease,
            border-color 0.22s ease;
    }

    .contact-action-primary {
        color: #ffffff;
        background: var(--contact-green);
        border: 1px solid var(--contact-green);
    }

    .contact-action-primary:hover {
        color: #ffffff;
        background: var(--contact-green-dark);
        border-color: var(--contact-green-dark);
        transform: translateY(-2px);
    }

    .contact-action-secondary {
        color: var(--contact-green-dark);
        background: var(--contact-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.17);
    }

    .contact-action-secondary:hover {
        color: #ffffff;
        background: var(--contact-green);
        border-color: var(--contact-green);
        transform: translateY(-2px);
    }

    /* =====================================================
       PETA
    ===================================================== */

    .contact-map-card {
        position: relative;
        min-height: 520px;
        overflow: hidden;
        background: var(--contact-green-soft);
        border: 1px solid var(--contact-border);
        border-radius: 20px;
        box-shadow: 0 12px 34px rgba(19, 69, 43, 0.07);
    }

    .contact-map-card iframe {
        width: 100% !important;
        height: 100% !important;
        min-height: 520px;
        display: block;
        border: 0 !important;
    }

    .contact-map-empty {
        min-height: 520px;
        display: grid;
        place-items: center;
        padding: 32px;
        text-align: center;
        background:
            radial-gradient(
                circle at center,
                rgba(22, 131, 79, 0.09),
                transparent 46%
            ),
            var(--contact-green-soft);
    }

    .contact-map-empty-icon {
        width: 66px;
        height: 66px;
        display: grid;
        place-items: center;
        margin: 0 auto 15px;
        color: var(--contact-green);
        background: #ffffff;
        border-radius: 18px;
        font-size: 28px;
        box-shadow: 0 10px 25px rgba(19, 69, 43, 0.08);
    }

    .contact-map-empty h3 {
        margin: 0;
        color: var(--contact-navy);
        font-size: 20px;
        font-weight: 800;
    }

    .contact-map-empty p {
        margin: 8px 0 0;
        color: var(--contact-muted);
        font-size: 14px;
    }

    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 991px) {
        .contact-layout {
            grid-template-columns: 1fr;
        }

        .contact-map-card,
        .contact-map-card iframe,
        .contact-map-empty {
            min-height: 430px;
        }
    }

    @media (max-width: 768px) {
        .contact-container {
            width: min(100% - 30px, 1400px);
        }

        .contact-main-section {
            padding: 42px 0 62px;
        }

        .contact-section-title {
            font-size: 31px;
        }

        .contact-info-card {
            padding: 23px;
            border-radius: 17px;
        }

        .contact-map-card {
            border-radius: 17px;
        }
    }

    @media (max-width: 520px) {
        .contact-container {
            width: calc(100% - 24px);
        }

        .contact-main-section {
            padding-top: 36px;
        }

        .contact-section-title {
            font-size: 27px;
        }

        .contact-info-card {
            padding: 18px;
        }

        .contact-item {
            padding: 12px;
        }

        .contact-item-icon {
            width: 37px;
            height: 37px;
            flex-basis: 37px;
            border-radius: 10px;
        }

        .contact-actions {
            display: grid;
            grid-template-columns: 1fr;
        }

        .contact-action-button {
            width: 100%;
        }

        .contact-map-card,
        .contact-map-card iframe,
        .contact-map-empty {
            min-height: 350px;
        }
    }
</style>

<style>
    .contact-social-section {
        padding: 0 0 76px;
        background: #ffffff;
    }

    .contact-social-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 22px;
        padding: 24px 26px;
        background: var(--contact-green-soft);
        border: 1px solid var(--contact-border);
        border-radius: 18px;
    }

    .contact-social-card h2 {
        margin: 0;
        color: var(--contact-navy);
        font-size: 21px;
        font-weight: 850;
    }

    .contact-social-card p {
        margin: 6px 0 0;
        color: var(--contact-muted);
        font-size: 12px;
        line-height: 1.6;
    }

    .contact-social-links {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
    }

    .contact-social-link {
        min-width: 43px;
        height: 43px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 0 12px;
        color: var(--contact-green-dark);
        background: #ffffff;
        border: 1px solid rgba(22, 131, 79, 0.18);
        border-radius: 12px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 800;
        transition:
            color 0.2s ease,
            background 0.2s ease,
            transform 0.2s ease;
    }

    .contact-social-link:hover {
        color: #ffffff;
        background: var(--contact-green);
        transform: translateY(-2px);
    }

    @media (max-width: 767.98px) {
        .contact-social-card {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

@endpush

@section('content')

@php
    $alamat = $contact?->alamat ?? null;
    $telepon = $contact?->telepon ?? null;
    $whatsapp = $contact?->whatsapp ?? null;
    $email = $contact?->email ?? null;
    $website = $contact?->website ?? null;
    $jamOperasional = $contact?->jam_operasional ?? null;

    /*
     * Peta dapat diisi dari menu Kontak Desa atau Wilayah Desa.
     * Data Kontak diprioritaskan; bila kosong, gunakan data Wilayah.
     */
    $googleMaps = $contact?->google_maps
        ?: ($region?->google_maps ?? null);

    $googleMapsEmbed = $contact?->google_maps_embed
        ?: ($region?->google_maps_embed ?? null);

    $socialLinks = collect([
        [
            'label' => 'Facebook',
            'icon' => 'bi-facebook',
            'url' => $contact?->facebook,
        ],
        [
            'label' => 'Instagram',
            'icon' => 'bi-instagram',
            'url' => $contact?->instagram,
        ],
        [
            'label' => 'YouTube',
            'icon' => 'bi-youtube',
            'url' => $contact?->youtube,
        ],
        [
            'label' => 'TikTok',
            'icon' => 'bi-tiktok',
            'url' => $contact?->tiktok,
        ],
    ])->filter(
        fn ($social) => filled($social['url'])
    );

    $teleponLink = filled($telepon)
        ? preg_replace('/[^0-9+]/', '', $telepon)
        : null;

    $whatsappLink = filled($whatsapp)
        ? preg_replace('/\D+/', '', $whatsapp)
        : null;

    if (filled($whatsappLink) && str_starts_with($whatsappLink, '0')) {
        $whatsappLink = '62' . substr($whatsappLink, 1);
    }
@endphp

<div class="contact-page">

    {{-- INFORMASI KONTAK DAN PETA --}}
    <section class="contact-main-section">
        <div class="contact-container">

            <div class="contact-section-heading">

                <h1 class="contact-section-title">
                    Kontak dan Lokasi Kantor Desa Bakal Dalam
                </h1>

                <div class="contact-title-line"></div>

                <p class="contact-section-description">
                    Informasi alamat, nomor kontak, jam pelayanan, dan lokasi
                    Kantor Pemerintah Desa Bakal Dalam untuk kebutuhan masyarakat.
                </p>

            </div>

            <div class="contact-layout">

                {{-- INFORMASI KONTAK --}}
                <article class="contact-info-card">

                    <div class="contact-info-header">
                        <h2>Informasi Kontak</h2>

                        <p>
                            Gunakan informasi berikut untuk menghubungi
                            Pemerintah Desa Bakal Dalam.
                        </p>
                    </div>

                    <div class="contact-list">

                        <div class="contact-item">
                            <span class="contact-item-icon">
                                <i class="bi bi-geo-alt-fill"></i>
                            </span>

                            <span class="contact-item-content">
                                <span class="contact-item-label">
                                    Alamat Kantor
                                </span>

                                <span class="contact-item-value">
                                    {{ $alamat ?: 'Alamat belum tersedia' }}
                                </span>
                            </span>
                        </div>

                        @if(filled($telepon))
                            <a
                                href="tel:{{ $teleponLink }}"
                                class="contact-item"
                            >
                                <span class="contact-item-icon">
                                    <i class="bi bi-telephone-fill"></i>
                                </span>

                                <span class="contact-item-content">
                                    <span class="contact-item-label">
                                        Telepon
                                    </span>

                                    <span class="contact-item-value">
                                        {{ $telepon }}
                                    </span>
                                </span>
                            </a>
                        @else
                            <div class="contact-item">
                                <span class="contact-item-icon">
                                    <i class="bi bi-telephone-fill"></i>
                                </span>

                                <span class="contact-item-content">
                                    <span class="contact-item-label">
                                        Telepon
                                    </span>

                                    <span class="contact-item-value">-</span>
                                </span>
                            </div>
                        @endif

                        @if(filled($whatsapp))
                            <a
                                href="https://wa.me/{{ $whatsappLink }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="contact-item"
                            >
                                <span class="contact-item-icon">
                                    <i class="bi bi-whatsapp"></i>
                                </span>

                                <span class="contact-item-content">
                                    <span class="contact-item-label">
                                        WhatsApp
                                    </span>

                                    <span class="contact-item-value">
                                        {{ $whatsapp }}
                                    </span>
                                </span>
                            </a>
                        @else
                            <div class="contact-item">
                                <span class="contact-item-icon">
                                    <i class="bi bi-whatsapp"></i>
                                </span>

                                <span class="contact-item-content">
                                    <span class="contact-item-label">
                                        WhatsApp
                                    </span>

                                    <span class="contact-item-value">-</span>
                                </span>
                            </div>
                        @endif

                        @if(filled($email))
                            <a
                                href="mailto:{{ $email }}"
                                class="contact-item"
                            >
                                <span class="contact-item-icon">
                                    <i class="bi bi-envelope-fill"></i>
                                </span>

                                <span class="contact-item-content">
                                    <span class="contact-item-label">
                                        Email
                                    </span>

                                    <span class="contact-item-value">
                                        {{ $email }}
                                    </span>
                                </span>
                            </a>
                        @else
                            <div class="contact-item">
                                <span class="contact-item-icon">
                                    <i class="bi bi-envelope-fill"></i>
                                </span>

                                <span class="contact-item-content">
                                    <span class="contact-item-label">
                                        Email
                                    </span>

                                    <span class="contact-item-value">-</span>
                                </span>
                            </div>
                        @endif


                        @if(filled($website))
                            <a
                                href="{{ $website }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="contact-item"
                            >
                                <span class="contact-item-icon">
                                    <i class="bi bi-globe2"></i>
                                </span>

                                <span class="contact-item-content">
                                    <span class="contact-item-label">
                                        Website
                                    </span>

                                    <span class="contact-item-value">
                                        {{ $website }}
                                    </span>
                                </span>
                            </a>
                        @endif

                        <div class="contact-item">
                            <span class="contact-item-icon">
                                <i class="bi bi-clock-fill"></i>
                            </span>

                            <span class="contact-item-content">
                                <span class="contact-item-label">
                                    Jam Pelayanan
                                </span>

                                <span class="contact-item-value">
                                    {{ $jamOperasional ?: 'Belum tersedia' }}
                                </span>
                            </span>
                        </div>

                    </div>

                    <div class="contact-actions">

                        @if(filled($googleMaps))
                            <a
                                href="{{ $googleMaps }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="contact-action-button contact-action-primary"
                            >
                                <i class="bi bi-map-fill"></i>
                                Buka Google Maps
                            </a>
                        @endif

                        @if(filled($whatsappLink))
                            <a
                                href="https://wa.me/{{ $whatsappLink }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="contact-action-button contact-action-secondary"
                            >
                                <i class="bi bi-whatsapp"></i>
                                Hubungi WhatsApp
                            </a>
                        @endif

                    </div>

                </article>

                {{-- PETA --}}
                <div class="contact-map-card">

                    @if(filled($googleMapsEmbed))

                        {!! $googleMapsEmbed !!}

                    @else

                        <div class="contact-map-empty">

                            <div>
                                <div class="contact-map-empty-icon">
                                    <i class="bi bi-map"></i>
                                </div>

                                <h3>Peta belum tersedia</h3>

                                <p>
                                    Lokasi kantor desa akan ditampilkan setelah
                                    ditambahkan melalui dashboard admin.
                                </p>
                            </div>

                        </div>

                    @endif

                </div>

            </div>

        </div>
    </section>

    @if($socialLinks->isNotEmpty())
        <section class="contact-social-section">
            <div class="contact-container">

                <div class="contact-social-card">

                    <div>
                        <h2>Media Sosial Desa</h2>

                        <p>
                            Ikuti informasi dan kegiatan terbaru melalui
                            kanal resmi pemerintah desa.
                        </p>
                    </div>

                    <div class="contact-social-links">

                        @foreach($socialLinks as $social)
                            <a
                                href="{{ $social['url'] }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="contact-social-link"
                            >
                                <i class="bi {{ $social['icon'] }}"></i>
                                {{ $social['label'] }}
                            </a>
                        @endforeach

                    </div>

                </div>

            </div>
        </section>
    @endif


</div>

@endsection