@extends('layouts.public')

@section('title', 'Pemerintahan Desa')

@push('styles')
<style>
    :root {
        --government-green: #16834f;
        --government-green-dark: #0f633c;
        --government-green-soft: #f1f7f3;
        --government-navy: #14251c;
        --government-text: #33443a;
        --government-muted: #6b786f;
        --government-border: #dfe9e3;
        --government-white: #ffffff;
    }

    .public-government,
    .public-government * {
        box-sizing: border-box;
    }

    .public-government {
        width: 100%;
        overflow-x: hidden;
        color: var(--government-text);
        background: var(--government-white);
    }

    .government-container {
        width: min(1400px, calc(100% - 48px));
        margin: 0 auto;
    }


    /* =====================================================
       DUA BAGAN STRUKTUR
    ===================================================== */

    .government-structure-dual-section {
        padding: 46px 0 66px;
        background: var(--government-white);
    }

    .government-structure-heading {
        margin-bottom: 26px;
    }

    .government-structure-title {
        margin: 0;
        color: var(--government-navy);
        font-size: clamp(26px, 2.5vw, 35px);
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -0.03em;
    }

    .government-structure-desc {
        margin: 9px 0 0;
        color: var(--government-muted);
        font-size: 14px;
        line-height: 1.65;
    }

    .government-structure-dual-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 24px;
    }

    .government-structure-dual-card {
        min-width: 0;
        overflow: hidden;
        padding: 14px;
        background: var(--government-white);
        border: 1px solid var(--government-border);
        border-radius: 18px;
        box-shadow: 0 12px 32px rgba(18, 63, 40, 0.07);
    }

    .government-structure-dual-card-title {
        min-height: 52px;
        display: flex;
        align-items: center;
        padding: 4px 4px 14px;
        color: var(--government-navy);
        font-size: 16px;
        font-weight: 800;
        line-height: 1.45;
    }

    .government-structure-dual-link {
        display: block;
        overflow: hidden;
        background: #f8fbf9;
        border: 1px solid var(--government-border);
        border-radius: 13px;
        text-decoration: none;
        cursor: zoom-in;
    }

    .government-structure-dual-link img {
        width: 100%;
        height: 350px;
        display: block;
        object-fit: contain;
        object-position: center;
        transition: transform 0.3s ease;
    }

    .government-structure-dual-link:hover img {
        transform: scale(1.015);
    }

    .government-structure-dual-placeholder {
        min-height: 350px;
        display: grid;
        place-items: center;
        padding: 24px;
        color: var(--government-muted);
        text-align: center;
        background: var(--government-green-soft);
        border: 1px dashed #cbdcd2;
        border-radius: 13px;
        font-size: 14px;
    }

    .government-structure-modal .modal-content {
        overflow: hidden;
        border: 0;
        border-radius: 18px;
    }

    .government-structure-modal .modal-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--government-border);
    }

    .government-structure-modal .modal-title {
        color: var(--government-navy);
        font-size: 17px;
        font-weight: 800;
    }

    .government-structure-modal .modal-body {
        padding: 16px;
        background: #f8fbf9;
    }

    .government-structure-modal img {
        width: 100%;
        max-height: 76vh;
        display: block;
        object-fit: contain;
        border-radius: 12px;
    }

    /* =====================================================
       JUDUL SECTION
    ===================================================== */

    .government-section-heading {
        margin-bottom: 30px;
    }

    .government-section-title {
        margin: 0;
        color: var(--government-navy);
        font-size: clamp(28px, 2.7vw, 38px);
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -0.035em;
    }

    .government-accent {
        width: 50px;
        height: 5px;
        margin-top: 13px;
        border-radius: 999px;
        background: linear-gradient(
            90deg,
            var(--government-green),
            #55bc7d
        );
    }

    .government-section-description {
        max-width: 780px;
        margin: 16px 0 0;
        color: var(--government-muted);
        font-size: 14px;
        line-height: 1.65;
    }

    /* =====================================================
       APARAT PEMERINTAH DESA
    ===================================================== */

    .government-officials-section {
        padding: 58px 0 76px;
        background: var(--government-green-soft);
        border-top: 1px solid var(--government-border);
    }

    /* =====================================================
       BADAN PERMUSYAWARATAN DESA
    ===================================================== */

    .government-bpd-section {
        padding: 58px 0 76px;
        background: var(--government-white);
        border-top: 1px solid var(--government-border);
    }

    /* =====================================================
       GRID DAN KARTU BERSAMA
    ===================================================== */

    .government-people-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        align-items: stretch;
        gap: 18px;
        width: 100%;
    }

    .government-person-card {
        min-width: 0;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: var(--government-white);
        border: 1px solid var(--government-border);
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(19, 69, 43, 0.05);
        transition:
            transform 0.25s ease,
            box-shadow 0.25s ease,
            border-color 0.25s ease;
    }

    .government-person-card:hover {
        transform: translateY(-4px);
        border-color: rgba(22, 131, 79, 0.28);
        box-shadow: 0 16px 34px rgba(19, 69, 43, 0.11);
    }

    .government-person-photo {
        width: 100%;
        height: 100%;
        display: block;
        overflow: hidden;
        background: #edf5f0;
    }

    .government-person-photo img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        object-position: center top;
        transition: transform 0.35s ease;
    }

    .government-person-card:hover
    .government-person-photo img {
        transform: scale(1.025);
    }

    .government-person-placeholder {
        display: grid;
        place-items: center;
        color: var(--government-green);
        background:
            radial-gradient(
                circle at center,
                rgba(22, 131, 79, 0.12),
                transparent 48%
            ),
            #edf5f0;
        font-size: 72px;
    }

    .government-person-caption {
        min-height: 126px;
        flex: 1 1 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 13px 12px;
        text-align: center;
        color: var(--government-white);
        background: linear-gradient(
            135deg,
            var(--government-green-dark),
            var(--government-green)
        );
    }

    .government-person-name {
        color: var(--government-white);
        font-size: 16px;
        font-weight: 800;
        line-height: 1.3;
        overflow-wrap: anywhere;
    }

    .government-person-role {
        margin-top: 5px;
        color: rgba(255, 255, 255, 0.9);
        font-size: 13px;
        font-weight: 600;
        line-height: 1.4;
        overflow-wrap: anywhere;
    }

    .government-person-photo-button {
        position: relative;
        width: 100%;
        aspect-ratio: 4 / 4.5;
        flex: 0 0 auto;
        display: block;
        padding: 0;
        overflow: hidden;
        background: #edf5f0;
        border: 0;
        cursor: pointer;
        text-align: inherit;
    }

    .government-person-photo-button:focus-visible {
        outline: 4px solid rgba(22, 131, 79, 0.26);
        outline-offset: 3px;
    }

    .government-person-photo-overlay {
        position: absolute;
        inset: auto 12px 12px;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 36px;
        padding: 8px 11px;
        color: #ffffff;
        background: rgba(9, 71, 43, 0.87);
        border: 1px solid rgba(255, 255, 255, 0.24);
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(6, 42, 25, 0.22);
        backdrop-filter: blur(6px);
        font-size: 10px;
        font-weight: 850;
        opacity: 0;
        transform: translateY(7px);
        transition:
            opacity 0.22s ease,
            transform 0.22s ease;
        pointer-events: none;
    }

    .government-person-photo-button:hover
    .government-person-photo-overlay,
    .government-person-photo-button:focus-visible
    .government-person-photo-overlay {
        opacity: 1;
        transform: translateY(0);
    }

    .government-person-hint {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 7px;
        color: rgba(255, 255, 255, 0.79);
        font-size: 9px;
        font-weight: 650;
    }

    /* =====================================================
       MODAL PROFIL APARAT
    ===================================================== */

    .government-profile-modal .modal-dialog {
        max-width: 760px;
    }

    .government-profile-modal .modal-content {
        overflow: hidden;
        background: #ffffff;
        border: 0;
        border-radius: 22px;
        box-shadow: 0 30px 90px rgba(8, 51, 30, 0.28);
    }

    .government-profile-modal .modal-header {
        padding: 17px 20px;
        background: #ffffff;
        border-bottom: 1px solid var(--government-border);
    }

    .government-profile-modal .modal-title {
        color: var(--government-navy);
        font-size: 16px;
        font-weight: 850;
    }

    .government-profile-modal .modal-body {
        padding: 0;
    }

    .government-profile-layout {
        display: grid;
        grid-template-columns: minmax(245px, 0.8fr) minmax(0, 1.2fr);
        min-height: 410px;
    }

    .government-profile-visual {
        min-height: 410px;
        display: grid;
        place-items: center;
        overflow: hidden;
        color: var(--government-green);
        background:
            radial-gradient(
                circle at center,
                rgba(22, 131, 79, 0.13),
                transparent 48%
            ),
            #edf5f0;
        font-size: 80px;
    }

    .government-profile-visual img {
        width: 100%;
        height: 100%;
        min-height: 410px;
        display: block;
        object-fit: cover;
        object-position: center top;
    }

    .government-profile-content {
        min-width: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 32px;
    }

    .government-profile-label {
        display: inline-flex;
        align-items: center;
        align-self: flex-start;
        gap: 7px;
        padding: 7px 10px;
        color: var(--government-green-dark);
        background: var(--government-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 999px;
        font-size: 9px;
        font-weight: 850;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .government-profile-name {
        margin: 15px 0 0;
        color: var(--government-navy);
        font-size: clamp(24px, 3vw, 34px);
        font-weight: 900;
        line-height: 1.18;
        letter-spacing: -0.035em;
        overflow-wrap: anywhere;
    }

    .government-profile-role {
        margin-top: 7px;
        color: var(--government-green-dark);
        font-size: 14px;
        font-weight: 800;
        line-height: 1.45;
    }

    .government-profile-nip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        align-self: flex-start;
        margin-top: 13px;
        padding: 8px 10px;
        color: var(--government-text);
        background: #f7faf8;
        border: 1px solid var(--government-border);
        border-radius: 9px;
        font-size: 10px;
        font-weight: 750;
    }

    .government-profile-description-title {
        display: block;
        margin-top: 23px;
        color: var(--government-navy);
        font-size: 11px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .government-profile-description {
        margin: 8px 0 0;
        color: var(--government-muted);
        font-size: 13px;
        line-height: 1.78;
        white-space: pre-line;
    }

    .government-profile-description.empty {
        font-style: italic;
    }

    @media (max-width: 700px) {
        .government-person-photo-overlay {
            opacity: 1;
            transform: none;
        }

        .government-profile-modal .modal-dialog {
            margin: 14px;
        }

        .government-profile-layout {
            grid-template-columns: 1fr;
        }

        .government-profile-visual,
        .government-profile-visual img {
            min-height: 300px;
            max-height: 390px;
        }

        .government-profile-content {
            padding: 23px 20px 27px;
        }
    }

    .government-empty {
        padding: 34px 24px;
        text-align: center;
        color: var(--government-muted);
        background: var(--government-white);
        border: 1px dashed #cddbd2;
        border-radius: 16px;
    }

    .government-bpd-section .government-empty {
        background: var(--government-green-soft);
    }

    /* =====================================================
       RESPONSIVE
    ===================================================== */

    /* =====================================================
   RESPONSIVE
===================================================== */

/* Laptop dan desktop tetap 5 kartu */
@media (max-width: 1199px) {
    .government-people-grid {
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 16px;
    }

    .government-person-caption {
        padding: 12px 8px;
    }

    .government-person-name {
        font-size: 14px;
    }

    .government-person-role {
        font-size: 12px;
    }

    .government-structure-dual-link img,
    .government-structure-dual-placeholder {
        height: 300px;
        min-height: 300px;
    }
}

/* Tablet: 3 kartu */
@media (max-width: 991px) {
    .government-people-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }
}

/* HP dan tablet kecil: 2 kartu */
@media (max-width: 768px) {
    .government-container {
        width: min(100% - 30px, 1400px);
    }

    .government-structure-dual-section {
        padding: 44px 0 52px;
    }

    .government-structure-dual-grid {
        grid-template-columns: 1fr;
        gap: 18px;
    }

    .government-structure-dual-link img,
    .government-structure-dual-placeholder {
        height: 340px;
        min-height: 340px;
    }

    .government-officials-section,
    .government-bpd-section {
        padding: 48px 0 62px;
    }

    .government-people-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .government-person-caption {
        min-height: 116px;
        padding: 11px 8px;
    }

    .government-person-name {
        font-size: 14px;
    }

    .government-person-role {
        font-size: 12px;
    }
}

/* HP sangat kecil tetap 2 kartu */
@media (max-width: 480px) {
    .government-container {
        width: calc(100% - 20px);
    }

    .government-structure-title,
    .government-section-title {
        font-size: 25px;
    }

    .government-structure-dual-link img,
    .government-structure-dual-placeholder {
        height: 240px;
        min-height: 240px;
    }

    .government-people-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .government-person-card {
        border-radius: 12px;
    }

    .government-person-photo-button {
        aspect-ratio: 4 / 4.5;
    }

    .government-person-caption {
        min-height: 108px;
        padding: 9px 6px;
    }

    .government-person-name {
        font-size: 12px;
        line-height: 1.25;
    }

    .government-person-role {
        margin-top: 4px;
        font-size: 10px;
        line-height: 1.3;
    }

    .government-person-placeholder {
        font-size: 48px;
    }
}
</style>

<style>
    .government-institutions-section {
        padding: 58px 0 76px;
        background: var(--government-green-soft);
        border-top: 1px solid var(--government-border);
    }

    .government-institution-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .government-institution-card {
        display: grid;
        grid-template-columns: 86px minmax(0, 1fr);
        gap: 14px;
        align-items: center;
        min-width: 0;
        padding: 15px;
        background: #ffffff;
        border: 1px solid var(--government-border);
        border-radius: 17px;
        box-shadow: 0 9px 26px rgba(19, 69, 43, 0.06);
    }

    .government-institution-photo {
        width: 86px;
        height: 86px;
        display: grid;
        place-items: center;
        overflow: hidden;
        color: var(--government-green);
        background: var(--government-green-soft);
        border-radius: 14px;
        font-size: 28px;
        font-weight: 900;
    }

    .government-institution-photo img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .government-institution-card h3 {
        margin: 0;
        color: var(--government-navy);
        font-size: 15px;
        font-weight: 850;
        line-height: 1.4;
    }

    .government-institution-role {
        display: block;
        margin-top: 4px;
        color: var(--government-green-dark);
        font-size: 10px;
        font-weight: 800;
    }

    .government-institution-description {
        display: -webkit-box;
        margin: 8px 0 0;
        overflow: hidden;
        color: var(--government-muted);
        font-size: 10px;
        line-height: 1.55;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    @media (max-width: 991.98px) {
        .government-institution-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 575.98px) {
        .government-institution-grid {
            grid-template-columns: 1fr;
        }
    }
</style>


<style>
    .government-institution-structure-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .government-institution-structure-card {
        min-width: 0;
        overflow: hidden;
        padding: 14px;
        background: #ffffff;
        border: 1px solid var(--government-border);
        border-radius: 18px;
        box-shadow: 0 11px 30px rgba(18, 63, 40, 0.07);
    }

    .government-institution-structure-title {
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 50px;
        padding: 2px 3px 13px;
        color: var(--government-navy);
        font-size: 16px;
        font-weight: 850;
    }

    .government-institution-structure-title i {
        width: 37px;
        height: 37px;
        flex: 0 0 37px;
        display: grid;
        place-items: center;
        color: var(--government-green);
        background: var(--government-green-soft);
        border-radius: 11px;
    }

    .government-institution-structure-link {
        position: relative;
        display: block;
        overflow: hidden;
        background: #f8fbf9;
        border: 1px solid var(--government-border);
        border-radius: 13px;
        text-decoration: none;
        cursor: zoom-in;
    }

    .government-institution-structure-link img {
        width: 100%;
        height: 360px;
        display: block;
        object-fit: contain;
        padding: 8px;
        background: #ffffff;
        transition: transform 0.3s ease;
    }

    .government-institution-structure-link:hover img {
        transform: scale(1.015);
    }

    .government-institution-structure-zoom {
        position: absolute;
        right: 12px;
        bottom: 12px;
        width: 39px;
        height: 39px;
        display: grid;
        place-items: center;
        color: #ffffff;
        background: rgba(13, 97, 57, 0.9);
        border-radius: 11px;
        font-size: 15px;
        backdrop-filter: blur(7px);
    }

    .government-institution-structure-empty {
        min-height: 330px;
        display: grid;
        place-items: center;
        padding: 26px;
        color: var(--government-muted);
        text-align: center;
        background: var(--government-green-soft);
        border: 1px dashed #cbdcd2;
        border-radius: 13px;
    }

    .government-institution-structure-empty i {
        display: block;
        margin-bottom: 10px;
        color: var(--government-green);
        font-size: 30px;
    }

    @media (max-width: 767.98px) {
        .government-institution-structure-grid {
            grid-template-columns: 1fr;
        }

        .government-institution-structure-link img {
            height: 290px;
        }
    }
</style>

@endpush

@section('content')

@php
    $villageProfile = $profile ?? null;
    $officialList = $officials ?? collect();
    $bpdList = $bpds ?? collect();
    $institutionList = $institutions ?? collect();

    $strukturPemerintah = data_get(
        $villageProfile,
        'struktur_organisasi'
    );

    $strukturPemerintahUrl = filled($strukturPemerintah)
        ? asset(
            'storage/' .
            ltrim($strukturPemerintah, '/')
        )
        : null;

    $strukturBpd = data_get(
        $villageProfile,
        'struktur_bpd'
    );

    $strukturBpdUrl = filled($strukturBpd)
        ? asset(
            'storage/' .
            ltrim($strukturBpd, '/')
        )
        : (
            file_exists(
                public_path(
                    'images/struktur/struktur-bpd.jpg'
                )
            )
                ? asset(
                    'images/struktur/struktur-bpd.jpg'
                )
                : null
        );
@endphp

<div id="government" class="public-government">

    {{-- BAGAN STRUKTUR --}}
    <section class="government-structure-dual-section">
        <div class="government-container">

            <div class="government-structure-heading">

                <h1 class="government-structure-title">
                    Aparatur Pemerintah Desa dan BPD
                </h1>

                <div class="government-accent"></div>

                <p class="government-structure-desc">
                    Struktur organisasi serta daftar aparatur Pemerintah Desa
                    dan anggota Badan Permusyawaratan Desa Bakal Dalam.
                </p>

            </div>

            <div class="government-structure-dual-grid">

                {{-- BAGAN PEMERINTAH DESA --}}
                <article class="government-structure-dual-card">

                    <div class="government-structure-dual-card-title">
                        Bagan Struktur Pemerintah Desa Bakal Dalam
                    </div>

                    @if($strukturPemerintahUrl)

                        <a
                            href="#"
                            class="government-structure-dual-link"
                            data-bs-toggle="modal"
                            data-bs-target="#structureModalPemerintah"
                        >
                            <img
                                src="{{ $strukturPemerintahUrl }}"
                                alt="Bagan Struktur Pemerintah Desa Bakal Dalam"
                                loading="lazy"
                            >
                        </a>

                    @else

                        <div class="government-structure-dual-placeholder">
                            Bagan struktur Pemerintah Desa belum tersedia.
                        </div>

                    @endif

                </article>

                {{-- BAGAN BPD --}}
                <article class="government-structure-dual-card">

                    <div class="government-structure-dual-card-title">
                        Bagan Struktur Badan Permusyawaratan Desa
                    </div>

                    @if($strukturBpdUrl)

                        <a
                            href="#"
                            class="government-structure-dual-link"
                            data-bs-toggle="modal"
                            data-bs-target="#structureModalBpd"
                        >
                            <img
                                src="{{ $strukturBpdUrl }}"
                                alt="Bagan Struktur Badan Permusyawaratan Desa"
                                loading="lazy"
                            >
                        </a>

                    @else

                        <div class="government-structure-dual-placeholder">
                            Bagan struktur BPD belum tersedia.
                        </div>

                    @endif

                </article>

            </div>

        </div>
    </section>

    {{-- APARAT PEMERINTAH DESA --}}
    <section class="government-officials-section">
        <div class="government-container">

            <div class="government-section-heading">

                <h2 class="government-section-title">
                    APARAT PEMERINTAH DESA
                </h2>

                <div class="government-accent"></div>

                <p class="government-section-description">
                    Daftar perangkat yang menjalankan pemerintahan dan
                    pelayanan masyarakat Desa Bakal Dalam.
                </p>

            </div>

            @if($officialList->isEmpty())

                <div class="government-empty">
                    Data aparat desa belum tersedia.
                </div>

            @else

                <div class="government-people-grid">

                    @foreach($officialList as $official)

                        @php
                            $fotoOfficial = filled($official->foto)
                                ? asset(
                                    'storage/' .
                                    ltrim($official->foto, '/')
                                )
                                : null;
                        @endphp

                        <article class="government-person-card">

                            <button
                                type="button"
                                class="government-person-photo-button"
                                data-bs-toggle="modal"
                                data-bs-target="#officialProfileModal{{ $official->id }}"
                                aria-label="Lihat profil {{ $official->nama }}"
                            >
                                <span
                                    class="government-person-photo
                                    {{ !$fotoOfficial
                                        ? 'government-person-placeholder'
                                        : '' }}"
                                >

                                    @if($fotoOfficial)

                                        <img
                                            src="{{ $fotoOfficial }}"
                                            alt="{{ $official->nama }}"
                                            loading="lazy"
                                        >

                                    @else

                                        <i class="bi bi-person-fill"></i>

                                    @endif

                                </span>

                                <span class="government-person-photo-overlay">
                                    <i class="bi bi-info-circle"></i>
                                    Lihat Keterangan
                                </span>
                            </button>

                            <div class="government-person-caption">

                                <div class="government-person-name">
                                    {{ $official->nama }}
                                </div>

                                <div class="government-person-role">
                                    {{ $official->jabatan }}
                                </div>

                                <span class="government-person-hint">
                                    <i class="bi bi-hand-index-thumb"></i>
                                    Klik foto untuk melihat profil
                                </span>

                            </div>

                        </article>

                    @endforeach

                </div>

            @endif

            @foreach($officialList as $official)

                @php
                    $officialModalPhoto = filled($official->foto)
                        ? asset(
                            'storage/' .
                            ltrim($official->foto, '/')
                        )
                        : null;
                @endphp

                <div
                    class="modal fade government-profile-modal"
                    id="officialProfileModal{{ $official->id }}"
                    tabindex="-1"
                    aria-labelledby="officialProfileTitle{{ $official->id }}"
                    aria-hidden="true"
                >
                    <div
                        class="
                            modal-dialog
                            modal-dialog-centered
                            modal-dialog-scrollable
                        "
                    >
                        <div class="modal-content">

                            <div class="modal-header">

                                <h2
                                    class="modal-title"
                                    id="officialProfileTitle{{ $official->id }}"
                                >
                                    Profil Aparat Desa
                                </h2>

                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Tutup"
                                ></button>

                            </div>

                            <div class="modal-body">

                                <div class="government-profile-layout">

                                    <div class="government-profile-visual">

                                        @if($officialModalPhoto)
                                            <img
                                                src="{{ $officialModalPhoto }}"
                                                alt="{{ $official->nama }}"
                                                loading="lazy"
                                            >
                                        @else
                                            <i class="bi bi-person-fill"></i>
                                        @endif

                                    </div>

                                    <div class="government-profile-content">

                                        <span class="government-profile-label">
                                            <i class="bi bi-person-badge"></i>
                                            Aparat Pemerintah Desa
                                        </span>

                                        <h3 class="government-profile-name">
                                            {{ $official->nama }}
                                        </h3>

                                        <div class="government-profile-role">
                                            {{ $official->jabatan }}
                                        </div>

                                        @if(filled($official->nip))
                                            <span class="government-profile-nip">
                                                <i class="bi bi-card-text"></i>
                                                NIP: {{ $official->nip }}
                                            </span>
                                        @endif

                                        <strong
                                            class="
                                                government-profile-description-title
                                            "
                                        >
                                            Deskripsi
                                        </strong>

                                        <p
                                            class="
                                                government-profile-description
                                                {{ filled($official->deskripsi)
                                                    ? ''
                                                    : 'empty'
                                                }}
                                            "
                                        >
                                            {{ filled($official->deskripsi)
                                                ? $official->deskripsi
                                                : 'Deskripsi aparat belum tersedia.'
                                            }}
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            @endforeach

        </div>
    </section>

    {{-- BADAN PERMUSYAWARATAN DESA --}}
    <section class="government-bpd-section">
        <div class="government-container">

            <div class="government-section-heading">

                <h2 class="government-section-title">
                    BADAN PERMUSYAWARATAN DESA
                </h2>

                <div class="government-accent"></div>

                <p class="government-section-description">
                    Daftar anggota Badan Permusyawaratan Desa yang
                    menampung aspirasi masyarakat dan menjalankan fungsi
                    pengawasan di Desa Bakal Dalam.
                </p>

            </div>

            @if($bpdList->isEmpty())

                <div class="government-empty">
                    Data anggota Badan Permusyawaratan Desa belum tersedia.
                </div>

            @else

                <div class="government-people-grid">

                    @foreach($bpdList as $bpd)

                        @php
                            $fotoBpd = filled($bpd->foto)
                                ? asset(
                                    'storage/' .
                                    ltrim($bpd->foto, '/')
                                )
                                : null;
                        @endphp

                        <article class="government-person-card">

                            <div
                                class="government-person-photo
                                {{ !$fotoBpd
                                    ? 'government-person-placeholder'
                                    : '' }}"
                            >

                                @if($fotoBpd)

                                    <img
                                        src="{{ $fotoBpd }}"
                                        alt="{{ $bpd->nama }}"
                                        loading="lazy"
                                    >

                                @else

                                    <i class="bi bi-person-fill"></i>

                                @endif

                            </div>

                            <div class="government-person-caption">

                                <div class="government-person-name">
                                    {{ $bpd->nama }}
                                </div>

                                <div class="government-person-role">
                                    {{ $bpd->jabatan }}
                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>

            @endif

        </div>
    </section>


    {{-- STRUKTUR KELEMBAGAAN DESA --}}
    <section class="government-institutions-section">
        <div class="government-container">

            <div class="government-section-heading">

                <h2 class="government-section-title">
                    STRUKTUR KELEMBAGAAN DESA
                </h2>

                <div class="government-accent"></div>

                <p class="government-section-description">
                    Bagan struktur PKK, Posyandu, Karang Taruna,
                    dan Lembaga Pemberdayaan Masyarakat.
                </p>

            </div>

            @php
                $institutionStructures = [
                    [
                        'name' => 'PKK',
                        'title' => 'Struktur PKK',
                        'icon' => 'bi-people-fill',
                        'aliases' => [
                            'pkk',
                            'pemberdayaan kesejahteraan keluarga',
                        ],
                    ],
                    [
                        'name' => 'Posyandu',
                        'title' => 'Struktur Posyandu',
                        'icon' => 'bi-heart-pulse-fill',
                        'aliases' => [
                            'posyandu',
                        ],
                    ],
                    [
                        'name' => 'Karang Taruna',
                        'title' => 'Struktur Karang Taruna',
                        'icon' => 'bi-person-arms-up',
                        'aliases' => [
                            'karang taruna',
                        ],
                    ],
                    [
                        'name' => 'LPM',
                        'title' => 'Struktur LPM',
                        'icon' => 'bi-diagram-3-fill',
                        'aliases' => [
                            'lpm',
                            'lembaga pemberdayaan masyarakat',
                            'lembaga pemberdayaan masyarakat (lpm)',
                        ],
                    ],
                ];

                foreach (
                    $institutionStructures as $index => $structure
                ) {
                    $aliases = collect($structure['aliases']);

                    $institutionStructures[$index]['record'] =
                        $institutionList->first(
                            function ($item) use ($aliases) {
                                return $aliases->contains(
                                    mb_strtolower(
                                        trim($item->nama ?? '')
                                    )
                                );
                            }
                        );
                }
            @endphp

            <div class="government-institution-structure-grid">

                @foreach($institutionStructures as $structure)

                    @php
                        $record = $structure['record'];

                        $structureImage =
                            $record && filled($record->foto)
                                ? asset(
                                    'storage/' .
                                    ltrim($record->foto, '/')
                                )
                                : null;
                    @endphp

                    <article
                        class="government-institution-structure-card"
                    >

                        <div
                            class="government-institution-structure-title"
                        >
                            <i class="bi {{ $structure['icon'] }}"></i>
                            {{ $structure['title'] }}
                        </div>

                        @if($structureImage)

                            <a
                                href="{{ $structureImage }}"
                                target="_blank"
                                rel="noopener"
                                class="
                                    government-institution-structure-link
                                "
                                title="Buka gambar ukuran penuh"
                            >
                                <img
                                    src="{{ $structureImage }}"
                                    alt="{{ $structure['title'] }}"
                                    loading="lazy"
                                >

                                <span
                                    class="
                                        government-institution-structure-zoom
                                    "
                                >
                                    <i class="bi bi-arrows-fullscreen"></i>
                                </span>
                            </a>

                        @else

                            <div
                                class="
                                    government-institution-structure-empty
                                "
                            >
                                <div>
                                    <i class="bi bi-image"></i>

                                    Foto {{ $structure['title'] }}
                                    belum tersedia.
                                </div>
                            </div>

                        @endif

                    </article>

                @endforeach

            </div>

        </div>
    </section>

    {{-- MODAL BAGAN PEMERINTAH DESA --}}
    @if($strukturPemerintahUrl)

        <div
            class="modal fade government-structure-modal"
            id="structureModalPemerintah"
            tabindex="-1"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered modal-xl">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Bagan Struktur Pemerintah Desa Bakal Dalam
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Tutup"
                        ></button>

                    </div>

                    <div class="modal-body">

                        <img
                            src="{{ $strukturPemerintahUrl }}"
                            alt="Bagan Struktur Pemerintah Desa Bakal Dalam"
                        >

                    </div>

                </div>

            </div>
        </div>

    @endif

    {{-- MODAL BAGAN BPD --}}
    @if($strukturBpdUrl)

        <div
            class="modal fade government-structure-modal"
            id="structureModalBpd"
            tabindex="-1"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered modal-xl">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Bagan Struktur Badan Permusyawaratan Desa
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Tutup"
                        ></button>

                    </div>

                    <div class="modal-body">

                        <img
                            src="{{ $strukturBpdUrl }}"
                            alt="Bagan Struktur Badan Permusyawaratan Desa"
                        >

                    </div>

                </div>

            </div>
        </div>

    @endif

</div>

@endsection