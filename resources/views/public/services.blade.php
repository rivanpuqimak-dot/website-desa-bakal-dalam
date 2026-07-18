@extends('layouts.public')

@section('title', 'Layanan Desa')

@php
    $villageName = $profile?->nama_desa
        ?? 'Desa Bakal Dalam';

    $phone = $contact?->telepon;
    $email = $contact?->email;
    $officeHours = $contact?->jam_operasional
        ?: 'Silakan konfirmasi jam pelayanan melalui kontak desa.';

    $whatsappNumber = preg_replace(
        '/\D+/',
        '',
        (string) ($contact?->whatsapp ?: $phone)
    );

    if (
        filled($whatsappNumber) &&
        str_starts_with($whatsappNumber, '0')
    ) {
        $whatsappNumber =
            '62' . substr($whatsappNumber, 1);
    }

    $whatsappUrl = filled($whatsappNumber)
        ? 'https://wa.me/' . $whatsappNumber .
            '?text=' . urlencode(
                'Halo, saya ingin menanyakan layanan administrasi ' .
                $villageName . '.'
            )
        : null;
@endphp

@push('styles')
<style>
    :root {
        --service-green: #16834f;
        --service-green-dark: #0d6139;
        --service-green-soft: #eef7f2;
        --service-navy: #12251c;
        --service-text: #34463c;
        --service-muted: #6e7d74;
        --service-border: #dfe9e3;
        --service-bg: #f5f8f6;
        --service-white: #ffffff;
    }

    .service-page,
    .service-page * {
        box-sizing: border-box;
    }

    .service-page {
        min-height: 70vh;
        color: var(--service-text);
        background: var(--service-bg);
    }

    .service-container {
        width: min(1180px, calc(100% - 48px));
        margin-inline: auto;
    }

    .service-hero {
        padding: 54px 0 46px;
        color: #ffffff;
        background:
            radial-gradient(
                circle at 88% 15%,
                rgba(255, 255, 255, 0.14),
                transparent 25%
            ),
            linear-gradient(
                135deg,
                #09472b,
                #16834f
            );
    }

    .service-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 0.09em;
        text-transform: uppercase;
    }

    .service-eyebrow::before {
        width: 27px;
        height: 3px;
        content: "";
        background: #ffffff;
        border-radius: 999px;
    }

    .service-hero h1 {
        max-width: 820px;
        margin: 11px 0 0;
        color: #ffffff;
        font-size: clamp(34px, 5vw, 58px);
        font-weight: 900;
        line-height: 1.06;
        letter-spacing: -0.05em;
    }

    .service-hero p {
        max-width: 760px;
        margin: 16px 0 0;
        color: rgba(255, 255, 255, 0.84);
        font-size: 15px;
        line-height: 1.75;
    }

    .service-main {
        padding: 42px 0 78px;
    }

    .service-notice {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        margin-bottom: 25px;
        padding: 15px 17px;
        color: #684f0b;
        background: #fff8dc;
        border: 1px solid #eadb98;
        border-radius: 14px;
        font-size: 12px;
        line-height: 1.65;
    }

    .service-notice i {
        margin-top: 2px;
        color: #b18400;
        font-size: 16px;
    }

    .service-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 19px;
    }

    .service-card {
        min-width: 0;
        padding: 23px;
        background: #ffffff;
        border: 1px solid var(--service-border);
        border-radius: 18px;
        box-shadow: 0 11px 31px rgba(18, 69, 43, 0.05);
        transition:
            transform 0.22s ease,
            border-color 0.22s ease,
            box-shadow 0.22s ease;
    }

    .service-card:hover {
        transform: translateY(-4px);
        border-color: rgba(22, 131, 79, 0.3);
        box-shadow: 0 18px 39px rgba(18, 69, 43, 0.09);
    }

    .service-card-icon {
        width: 52px;
        height: 52px;
        display: grid;
        place-items: center;
        color: var(--service-green);
        background: var(--service-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.15);
        border-radius: 15px;
        font-size: 21px;
    }

    .service-card h2 {
        margin: 16px 0 0;
        color: var(--service-navy);
        font-size: 20px;
        font-weight: 900;
        line-height: 1.3;
        letter-spacing: -0.025em;
    }

    .service-card-description {
        margin: 9px 0 0;
        color: var(--service-muted);
        font-size: 13px;
        line-height: 1.7;
    }

    .service-documents-title {
        display: block;
        margin-top: 17px;
        color: var(--service-navy);
        font-size: 11px;
        font-weight: 850;
    }

    .service-documents {
        display: grid;
        gap: 8px;
        margin: 10px 0 0;
        padding: 0;
        list-style: none;
    }

    .service-documents li {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        color: var(--service-text);
        font-size: 11px;
        line-height: 1.55;
    }

    .service-documents i {
        margin-top: 2px;
        color: var(--service-green);
    }

    .service-card-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin: 13px 0 0;
    }

    .service-card-meta span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 9px;
        color: var(--service-green-dark);
        background: var(--service-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.14);
        border-radius: 8px;
        font-size: 9px;
        font-weight: 780;
    }

    .service-empty {
        grid-column: 1 / -1;
        padding: 42px 20px;
        color: var(--service-muted);
        background: #ffffff;
        border: 1px dashed #c9d9d0;
        border-radius: 17px;
        text-align: center;
        font-size: 12px;
        line-height: 1.7;
    }

    .service-empty i {
        display: block;
        margin-bottom: 9px;
        color: var(--service-green);
        font-size: 28px;
    }

    .service-contact-card {
        display: grid;
        grid-template-columns: minmax(0, 1.25fr) minmax(280px, 0.75fr);
        gap: 22px;
        margin-top: 28px;
        padding: 27px;
        color: #ffffff;
        background:
            radial-gradient(
                circle at 90% 10%,
                rgba(255, 255, 255, 0.13),
                transparent 28%
            ),
            #0d6139;
        border-radius: 20px;
        box-shadow: 0 18px 45px rgba(13, 97, 57, 0.16);
    }

    .service-contact-card h2 {
        margin: 0;
        color: #ffffff;
        font-size: 27px;
        font-weight: 900;
        letter-spacing: -0.035em;
    }

    .service-contact-card p {
        margin: 10px 0 0;
        color: rgba(255, 255, 255, 0.82);
        font-size: 13px;
        line-height: 1.7;
    }

    .service-contact-details {
        display: grid;
        gap: 9px;
        align-content: center;
    }

    .service-contact-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 11px 12px;
        color: #ffffff;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.13);
        border-radius: 11px;
        font-size: 11px;
        line-height: 1.55;
    }

    .service-contact-item i {
        margin-top: 2px;
    }

    .service-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 20px;
    }

    .service-button {
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 15px;
        border-radius: 11px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 850;
    }

    .service-button.primary {
        color: var(--service-green-dark);
        background: #ffffff;
    }

    .service-button.secondary {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.22);
    }

    @media (max-width: 950px) {
        .service-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .service-contact-card {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 620px) {
        .service-container {
            width: min(100% - 28px, 1180px);
        }

        .service-hero {
            padding: 40px 0 34px;
        }

        .service-main {
            padding: 30px 0 58px;
        }

        .service-grid {
            grid-template-columns: 1fr;
        }

        .service-card,
        .service-contact-card {
            padding: 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="service-page">

    <section class="service-hero">
        <div class="service-container">

            <span class="service-eyebrow">
                Pelayanan Masyarakat
            </span>

            <h1>
                Informasi Layanan {{ $villageName }}
            </h1>

            <p>
                Lihat jenis layanan yang dapat ditanyakan kepada pemerintah
                desa serta dokumen dasar yang biasanya perlu disiapkan.
            </p>

        </div>
    </section>

    <section class="service-main">
        <div class="service-container">

            <div class="service-notice">
                <i class="bi bi-info-circle-fill"></i>

                <div>
                    Persyaratan dapat berbeda sesuai tujuan penggunaan surat
                    dan ketentuan yang berlaku. Konfirmasikan terlebih dahulu
                    kepada petugas desa sebelum datang membawa berkas.
                </div>
            </div>

            <div class="service-grid">

                @forelse($services as $service)

                    <article class="service-card">

                        <span class="service-card-icon">
                            <i class="bi {{ $service->icon }}"></i>
                        </span>

                        <h2>{{ $service->title }}</h2>

                        <p class="service-card-description">
                            {{ $service->description }}
                        </p>

                        @if(
                            filled($service->processing_time) ||
                            filled($service->cost)
                        )
                            <div class="service-card-meta">

                                @if(filled($service->processing_time))
                                    <span>
                                        <i class="bi bi-clock"></i>
                                        {{ $service->processing_time }}
                                    </span>
                                @endif

                                @if(filled($service->cost))
                                    <span>
                                        <i class="bi bi-cash-coin"></i>
                                        {{ $service->cost }}
                                    </span>
                                @endif

                            </div>
                        @endif

                        @if(count($service->requirements ?? []) > 0)

                            <strong class="service-documents-title">
                                Dokumen awal yang biasanya disiapkan:
                            </strong>

                            <ul class="service-documents">
                                @foreach(
                                    $service->requirements
                                    as $requirement
                                )
                                    <li>
                                        <i class="bi bi-check2-circle"></i>
                                        <span>{{ $requirement }}</span>
                                    </li>
                                @endforeach
                            </ul>

                        @endif

                    </article>

                @empty

                    <div class="service-empty">
                        <i class="bi bi-info-circle"></i>

                        Informasi layanan desa belum tersedia.
                        Silakan menghubungi petugas melalui halaman kontak.
                    </div>

                @endforelse

            </div>

            <section class="service-contact-card">

                <div>
                    <h2>Konfirmasi kepada Petugas Desa</h2>

                    <p>
                        Hubungi petugas untuk memastikan persyaratan,
                        jadwal pelayanan, serta proses pengajuan sebelum
                        datang ke kantor desa.
                    </p>

                    <div class="service-actions">

                        @if($whatsappUrl)
                            <a
                                href="{{ $whatsappUrl }}"
                                target="_blank"
                                rel="noopener"
                                class="service-button primary"
                            >
                                <i class="bi bi-whatsapp"></i>
                                Tanya lewat WhatsApp
                            </a>
                        @endif

                        <a
                            href="{{ route('public.contact') }}"
                            class="service-button secondary"
                        >
                            <i class="bi bi-geo-alt"></i>
                            Lihat Kontak Desa
                        </a>

                    </div>
                </div>

                <div class="service-contact-details">

                    <div class="service-contact-item">
                        <i class="bi bi-clock"></i>
                        <span>{{ $officeHours }}</span>
                    </div>

                    @if($phone)
                        <div class="service-contact-item">
                            <i class="bi bi-telephone"></i>
                            <span>{{ $phone }}</span>
                        </div>
                    @endif

                    @if($email)
                        <div class="service-contact-item">
                            <i class="bi bi-envelope"></i>
                            <span>{{ $email }}</span>
                        </div>
                    @endif

                </div>

            </section>

        </div>
    </section>

</div>
@endsection
