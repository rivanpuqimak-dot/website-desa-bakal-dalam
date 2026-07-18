@extends('layouts.public')

@section('title', 'Profil Desa')

@push('styles')
<style>
    :root {
        --profile-green: #16834f;
        --profile-green-dark: #0d6139;
        --profile-green-soft: #eef7f2;
        --profile-blue: #2478e8;
        --profile-navy: #12251c;
        --profile-text: #34463c;
        --profile-muted: #6e7d74;
        --profile-border: #dfe9e3;
        --profile-white: #ffffff;
        --profile-bg: #f7faf8;
    }

    .profile-page,
    .profile-page * {
        box-sizing: border-box;
    }

    .profile-page {
        width: 100%;
        overflow-x: hidden;
        color: var(--profile-text);
        background: var(--profile-white);
    }

    .profile-container {
        width: min(1400px, calc(100% - 48px));
        margin-inline: auto;
    }

    /* =====================================================
       HEADER PROFIL
    ===================================================== */

    .profile-header {
        padding: 48px 0 54px;
        background: var(--profile-white);
        border-bottom: 1px solid var(--profile-border);
    }

    .profile-header-grid {
        display: grid;
        grid-template-columns:
            minmax(0, 1fr)
            minmax(360px, 0.72fr);
        gap: clamp(34px, 4vw, 68px);
        align-items: center;
    }

    .profile-header-title {
        max-width: 760px;
        margin: 0;
        color: var(--profile-navy);
        font-size: clamp(32px, 3.5vw, 46px);
        line-height: 1.1;
        font-weight: 850;
        letter-spacing: -0.04em;
    }

    .profile-header-title-line {
        width: 50px;
        height: 5px;
        margin-top: 13px;
        border-radius: 999px;
        background: linear-gradient(
            90deg,
            var(--profile-green),
            #57bd80
        );
    }

    .profile-header-description {
        max-width: 700px;
        margin: 15px 0 0;
        color: var(--profile-muted);
        font-size: 15px;
        line-height: 1.75;
    }

    .profile-header-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 11px;
        margin-top: 24px;
    }

    .profile-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 44px;
        padding: 10px 16px;
        border-radius: 12px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 800;
        transition:
            transform 0.22s ease,
            color 0.22s ease,
            background 0.22s ease,
            border-color 0.22s ease;
    }

    .profile-button:hover {
        transform: translateY(-2px);
    }

    .profile-button-primary {
        color: #ffffff;
        background: var(--profile-green);
        border: 1px solid var(--profile-green);
        box-shadow: 0 10px 24px rgba(13, 97, 57, 0.16);
    }

    .profile-button-primary:hover {
        color: #ffffff;
        background: var(--profile-green-dark);
        border-color: var(--profile-green-dark);
    }

    .profile-button-outline {
        color: var(--profile-green-dark);
        background: var(--profile-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.2);
    }

    .profile-button-outline:hover {
        color: #ffffff;
        background: var(--profile-green);
        border-color: var(--profile-green);
    }

    .profile-header-visual {
        position: relative;
        overflow: hidden;
        padding: 10px;
        background: var(--profile-white);
        border: 1px solid var(--profile-border);
        border-radius: 20px;
        box-shadow: 0 14px 36px rgba(18, 37, 28, 0.09);
    }

    .profile-header-image,
    .profile-header-logo {
        width: 100%;
        height: 290px;
        border-radius: 14px;
    }

    .profile-header-image {
        display: block;
        object-fit: cover;
    }

    .profile-header-logo {
        display: grid;
        place-items: center;
        background:
            radial-gradient(
                circle at center,
                rgba(22, 131, 79, 0.13),
                transparent 50%
            ),
            var(--profile-green-soft);
    }

    .profile-header-logo img {
        width: min(190px, 56%);
        max-height: 205px;
        object-fit: contain;
        filter: drop-shadow(
            0 12px 22px rgba(18, 37, 28, 0.12)
        );
    }

    .profile-location-badge {
        position: absolute;
        right: 24px;
        bottom: 24px;
        left: 24px;
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 12px 14px;
        color: var(--profile-navy);
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid rgba(223, 233, 227, 0.9);
        border-radius: 13px;
        box-shadow: 0 12px 28px rgba(18, 37, 28, 0.14);
    }

    .profile-location-badge i {
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        display: grid;
        place-items: center;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--profile-green),
            var(--profile-blue)
        );
        border-radius: 11px;
    }

    .profile-location-badge small {
        display: block;
        color: var(--profile-muted);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .profile-location-badge strong {
        display: block;
        margin-top: 2px;
        color: var(--profile-navy);
        font-size: 14px;
        line-height: 1.35;
    }

    /* =====================================================
       STATISTIK
    ===================================================== */

    .profile-statistics-section {
        padding: 24px 0 26px;
        background: var(--profile-white);
    }

    .profile-statistics {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--profile-border);
        border-radius: 20px;
        box-shadow: 0 18px 42px rgba(18, 69, 43, 0.12);
    }

    .profile-stat {
        position: relative;
        display: flex;
        align-items: center;
        gap: 13px;
        min-height: 92px;
        padding: 18px 21px;
    }

    .profile-stat:not(:last-child)::after {
        content: "";
        position: absolute;
        top: 20px;
        right: 0;
        bottom: 20px;
        width: 1px;
        background: var(--profile-border);
    }

    .profile-stat-icon {
        width: 43px;
        height: 43px;
        flex: 0 0 43px;
        display: grid;
        place-items: center;
        color: var(--profile-green);
        background: var(--profile-green-soft);
        border-radius: 13px;
        font-size: 17px;
    }

    .profile-stat strong {
        display: block;
        color: var(--profile-navy);
        font-size: 20px;
        line-height: 1.1;
        font-weight: 800;
    }

    .profile-stat span {
        display: block;
        margin-top: 5px;
        color: var(--profile-muted);
        font-size: 12px;
    }

    /* =====================================================
       SECTION UMUM
    ===================================================== */

    .profile-section {
        padding: 62px 0;
        background: #ffffff;
    }

    .profile-section-soft {
        background: var(--profile-green-soft);
    }

    .profile-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--profile-green);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.09em;
        text-transform: uppercase;
    }

    .profile-section-title {
        margin: 9px 0 0;
        color: var(--profile-navy);
        font-size: clamp(28px, 2.6vw, 38px);
        line-height: 1.16;
        font-weight: 800;
        letter-spacing: -0.035em;
    }

    .profile-title-line {
        width: 48px;
        height: 5px;
        margin-top: 12px;
        border-radius: 999px;
        background: linear-gradient(
            90deg,
            var(--profile-green),
            #57bd80
        );
    }

    .profile-section-description {
        max-width: 760px;
        margin: 14px 0 0;
        color: var(--profile-muted);
        font-size: 14px;
        line-height: 1.72;
    }

    /* =====================================================
       TENTANG DESA
    ===================================================== */

    .profile-about-grid {
        display: grid;
        grid-template-columns:
            minmax(0, 1.15fr)
            minmax(330px, 0.85fr);
        gap: clamp(36px, 4vw, 66px);
        align-items: start;
    }

    .profile-about-copy {
        margin-top: 22px;
        color: var(--profile-text);
        font-size: 15px;
        line-height: 1.88;
    }

    .profile-about-copy p {
        margin: 0 0 16px;
    }

    .profile-slogan {
        margin-top: 22px;
        padding: 19px 21px;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--profile-green-dark),
            var(--profile-green)
        );
        border-radius: 17px;
        box-shadow: 0 15px 32px rgba(11, 95, 64, 0.16);
    }

    .profile-slogan small {
        display: block;
        margin-bottom: 5px;
        color: rgba(255, 255, 255, 0.72);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .profile-information-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--profile-border);
        border-radius: 20px;
        box-shadow: 0 15px 38px rgba(18, 37, 28, 0.07);
    }

    .profile-information-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 15px 18px;
    }

    .profile-information-row +
    .profile-information-row {
        border-top: 1px solid var(--profile-border);
    }

    .profile-information-row i {
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        display: grid;
        place-items: center;
        color: var(--profile-green);
        background: var(--profile-green-soft);
        border-radius: 11px;
    }

    .profile-information-row small {
        display: block;
        color: var(--profile-muted);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .profile-information-row strong {
        display: block;
        margin-top: 3px;
        color: var(--profile-navy);
        font-size: 14px;
        line-height: 1.5;
    }

    /* =====================================================
       VISI, MISI, TUJUAN
    ===================================================== */

    .profile-motto-card {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 16px;
        margin-top: 28px;
        padding: 22px 24px;
        color: var(--profile-green-dark);
        background:
            radial-gradient(
                circle at 92% 10%,
                rgba(22, 131, 79, 0.14),
                transparent 31%
            ),
            #ffffff;
        border: 1px solid rgba(22, 131, 79, 0.2);
        border-radius: 18px;
        box-shadow: 0 13px 34px rgba(18, 69, 43, 0.07);
    }

    .profile-motto-icon {
        width: 50px;
        height: 50px;
        flex: 0 0 50px;
        display: grid;
        place-items: center;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--profile-green-dark),
            var(--profile-green)
        );
        border-radius: 14px;
        font-size: 21px;
    }

    .profile-motto-card small {
        display: block;
        color: var(--profile-muted);
        font-size: 10px;
        font-weight: 850;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .profile-motto-card blockquote {
        margin: 5px 0 0;
        color: var(--profile-navy);
        font-size: clamp(16px, 2vw, 20px);
        font-weight: 850;
        line-height: 1.55;
    }

    .profile-vision-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
        margin-top: 29px;
    }

    .profile-vision-grid.is-single {
        grid-template-columns: 1fr;
    }

    .profile-vision-card,
    .profile-purpose-card {
        min-height: 100%;
        padding: 27px;
        border-radius: 21px;
    }

    .profile-vision-card {
        color: #ffffff;
        background:
            radial-gradient(
                circle at 90% 10%,
                rgba(255, 255, 255, 0.14),
                transparent 32%
            ),
            linear-gradient(
                145deg,
                var(--profile-navy),
                #0c4675
            );
        box-shadow: 0 20px 46px rgba(18, 37, 28, 0.15);
    }

    .profile-vision-card i {
        color: #75e5ad;
        font-size: 28px;
    }

    .profile-vision-card small {
        display: block;
        margin-top: 17px;
        color: rgba(255, 255, 255, 0.66);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.09em;
        text-transform: uppercase;
    }

    .profile-vision-card blockquote {
        margin: 9px 0 0;
        font-size: 16px;
        line-height: 1.7;
        font-weight: 700;
    }

    .profile-purpose-card {
        background: #ffffff;
        border: 1px solid var(--profile-border);
        box-shadow: 0 14px 36px rgba(18, 37, 28, 0.07);
    }

    .profile-purpose-card h3 {
        margin: 0;
        color: var(--profile-navy);
        font-size: 19px;
        font-weight: 800;
    }

    .profile-purpose-card p {
        margin: 11px 0 0;
        color: var(--profile-muted);
        font-size: 14px;
        line-height: 1.8;
    }

    .profile-missions {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
        margin-top: 22px;
    }

    .profile-mission-card {
        display: grid;
        grid-template-columns: 40px minmax(0, 1fr);
        gap: 11px;
        align-items: start;
        min-height: 96px;
        padding: 14px;
        background: #ffffff;
        border: 1px solid var(--profile-border);
        border-radius: 15px;
        transition: 0.22s ease;
    }

    .profile-mission-card:hover {
        transform: translateY(-2px);
        border-color: rgba(22, 131, 79, 0.26);
        box-shadow: 0 11px 24px rgba(18, 37, 28, 0.07);
    }

    .profile-mission-number {
        width: 40px;
        height: 40px;
        display: grid;
        place-items: center;
        color: var(--profile-green-dark);
        background: var(--profile-green-soft);
        border-radius: 11px;
        font-size: 12px;
        font-weight: 900;
    }

    .profile-mission-card p {
        margin: 0;
        color: var(--profile-text);
        font-size: 13px;
        line-height: 1.58;
    }

    .profile-mission-card.is-hidden {
        display: none;
    }

    .profile-mission-action {
        display: flex;
        justify-content: center;
        margin-top: 21px;
    }

    .profile-mission-toggle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        padding: 9px 16px;
        color: var(--profile-green-dark);
        background: #ffffff;
        border: 1px solid rgba(22, 131, 79, 0.23);
        border-radius: 11px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        transition: 0.22s ease;
    }

    .profile-mission-toggle:hover {
        color: #ffffff;
        background: var(--profile-green);
        transform: translateY(-2px);
    }

    .profile-mission-toggle i {
        transition: transform 0.22s ease;
    }

    .profile-mission-toggle.is-open i {
        transform: rotate(180deg);
    }

    /* =====================================================
       SEJARAH
    ===================================================== */

    .profile-history-grid {
        display: grid;
        grid-template-columns:
            minmax(0, 1.2fr)
            minmax(320px, 0.8fr);
        gap: clamp(36px, 4vw, 64px);
        align-items: start;
        margin-top: 29px;
    }

    .profile-history-text {
        color: var(--profile-text);
        font-size: 15px;
        line-height: 1.9;
    }

    .profile-history-image {
        width: 100%;
        max-height: 390px;
        display: block;
        object-fit: cover;
        border-radius: 20px;
        box-shadow: 0 18px 42px rgba(18, 37, 28, 0.12);
    }

    /* =====================================================
       WILAYAH
    ===================================================== */

    .profile-region-grid {
        display: grid;
        grid-template-columns:
            minmax(0, 1.08fr)
            minmax(420px, 0.92fr);
        gap: clamp(38px, 4vw, 66px);
        align-items: center;
        margin-top: 29px;
    }

    .profile-region-text {
        color: var(--profile-muted);
        font-size: 14px;
        line-height: 1.88;
    }

    .profile-boundaries {
        position: relative;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        padding: 69px 17px 17px;
        background: #ffffff;
        border: 1px solid var(--profile-border);
        border-radius: 22px;
        box-shadow: 0 18px 42px rgba(18, 37, 28, 0.09);
    }

    .profile-compass {
        position: absolute;
        top: 16px;
        left: 50%;
        width: 45px;
        height: 45px;
        display: grid;
        place-items: center;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--profile-green),
            var(--profile-blue)
        );
        border-radius: 50%;
        font-size: 18px;
        box-shadow: 0 11px 24px rgba(36, 120, 232, 0.21);
        transform: translateX(-50%);
    }

    .profile-boundary {
        min-height: 138px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 14px;
        text-align: center;
        background: var(--profile-bg);
        border: 1px solid var(--profile-border);
        border-radius: 14px;
    }

    .profile-boundary small {
        color: var(--profile-green);
        font-size: 10px;
        font-weight: 900;
        letter-spacing: 0.1em;
    }

    .profile-boundary strong {
        display: block;
        margin-top: 7px;
        color: var(--profile-navy);
        font-size: 12px;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    /* =====================================================
       PETA
    ===================================================== */

    .profile-map-card {
        margin-top: 27px;
        padding: 12px;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--profile-border);
        border-radius: 20px;
        box-shadow: 0 17px 40px rgba(18, 37, 28, 0.09);
    }

    .profile-map-card iframe {
        width: 100% !important;
        min-height: 400px;
        display: block;
        border: 0 !important;
        border-radius: 14px;
    }

    .profile-map-card img {
        width: 100%;
        max-height: 600px;
        display: block;
        object-fit: contain;
        background: var(--profile-bg);
        border-radius: 14px;
    }

    .profile-map-link {
        padding: 22px;
        text-align: center;
    }

    /* =====================================================
       CTA
    ===================================================== */

    .profile-cta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 26px;
        padding: 38px;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--profile-navy),
            var(--profile-green-dark)
        );
        border-radius: 23px;
        box-shadow: 0 22px 50px rgba(18, 37, 28, 0.16);
    }

    .profile-cta h2 {
        margin: 0;
        color: #ffffff;
        font-size: clamp(25px, 2.5vw, 36px);
        line-height: 1.2;
        font-weight: 800;
    }

    .profile-cta p {
        max-width: 680px;
        margin: 9px 0 0;
        color: rgba(255, 255, 255, 0.74);
        font-size: 14px;
        line-height: 1.7;
    }


    .profile-button-cta {
        color: var(--profile-green-dark);
        background: #ffffff;
        border: 1px solid #ffffff;
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.13);
    }

    .profile-button-cta:hover {
        color: var(--profile-green-dark);
        background: #f3faf6;
        border-color: #f3faf6;
    }

    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 1100px) {
        .profile-header-grid {
            grid-template-columns:
                minmax(0, 1fr)
                minmax(320px, 0.76fr);
        }

        .profile-missions {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .profile-region-grid {
            grid-template-columns:
                minmax(0, 1fr)
                minmax(360px, 0.9fr);
        }
    }

    @media (max-width: 900px) {
        .profile-header-grid,
        .profile-about-grid,
        .profile-vision-grid,
        .profile-history-grid,
        .profile-region-grid {
            grid-template-columns: 1fr;
        }

        .profile-header-visual {
            max-width: 720px;
        }

        .profile-statistics {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .profile-stat:nth-child(2)::after {
            display: none;
        }

        .profile-stat:nth-child(-n + 2) {
            border-bottom: 1px solid var(--profile-border);
        }

        .profile-boundaries {
            max-width: 720px;
            margin-inline: auto;
        }

        .profile-cta {
            align-items: flex-start;
            flex-direction: column;
        }
    }

    @media (max-width: 700px) {
        .profile-container {
            width: min(100% - 30px, 1400px);
        }

        .profile-header {
            padding: 42px 0 48px;
        }

        .profile-header-title {
            font-size: 32px;
        }

        .profile-header-image,
        .profile-header-logo {
            height: 255px;
        }

        .profile-statistics-section {
            padding-top: 20px;
        }

        .profile-missions {
            grid-template-columns: 1fr;
        }

        .profile-section {
            padding: 50px 0;
        }
    }

    @media (max-width: 520px) {
        .profile-container {
            width: calc(100% - 24px);
        }

        .profile-header {
            padding: 36px 0 42px;
        }

        .profile-header-title {
            font-size: 28px;
        }

        .profile-header-description {
            font-size: 14px;
        }

        .profile-header-actions {
            display: grid;
            grid-template-columns: 1fr;
        }

        .profile-button {
            width: 100%;
        }

        .profile-header-image,
        .profile-header-logo {
            height: 235px;
        }

        .profile-location-badge {
            right: 21px;
            bottom: 21px;
            left: 21px;
        }

        .profile-statistics {
            grid-template-columns: 1fr;
        }

        .profile-stat {
            min-height: 82px;
        }

        .profile-stat:not(:last-child)::after {
            top: auto;
            right: 18px;
            bottom: 0;
            left: 18px;
            width: auto;
            height: 1px;
            display: block;
        }

        .profile-stat:nth-child(-n + 2) {
            border-bottom: 0;
        }

        .profile-vision-card,
        .profile-purpose-card {
            padding: 23px;
        }

        .profile-boundaries {
            grid-template-columns: 1fr;
            padding-top: 70px;
        }

        .profile-boundary {
            min-height: 105px;
        }

        .profile-cta {
            padding: 27px 22px;
        }

        .profile-map-card iframe {
            min-height: 330px;
        }
    }
</style>

<style>
    /* =====================================================
       DATA PENDUKUNG — VERSI SEDERHANA
    ===================================================== */

    .profile-support-section {
        padding: 62px 0;
        background: #f3f8f5;
        border-top: 1px solid rgba(22, 131, 79, 0.08);
        border-bottom: 1px solid rgba(22, 131, 79, 0.08);
    }

    .profile-support-header {
        max-width: 760px;
        margin-bottom: 26px;
    }

    .profile-support-kicker {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: var(--profile-green);
        font-size: 9px;
        font-weight: 850;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .profile-support-title {
        margin: 10px 0 0;
        color: var(--profile-navy);
        font-size: clamp(28px, 3vw, 40px);
        font-weight: 900;
        line-height: 1.12;
        letter-spacing: -0.04em;
    }

    .profile-support-description {
        max-width: 720px;
        margin: 12px 0 0;
        color: var(--profile-muted);
        font-size: 12px;
        line-height: 1.7;
    }

    .profile-facilities-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .profile-facility-card {
        min-width: 0;
        min-height: 106px;
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 17px;
        background: #ffffff;
        border: 1px solid rgba(22, 131, 79, 0.13);
        border-radius: 16px;
        box-shadow: 0 8px 22px rgba(18, 69, 43, 0.055);
    }

    .profile-facility-icon {
        width: 44px;
        height: 44px;
        flex: 0 0 44px;
        display: grid;
        place-items: center;
        color: var(--profile-green);
        background: #eaf5ee;
        border-radius: 12px;
        font-size: 17px;
    }

    .profile-facility-card strong {
        display: block;
        color: var(--profile-navy);
        font-size: 22px;
        font-weight: 900;
        line-height: 1;
    }

    .profile-facility-card span {
        display: block;
        margin-top: 7px;
        color: var(--profile-muted);
        font-size: 9.5px;
        font-weight: 650;
        line-height: 1.35;
    }

    .profile-land-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-top: 14px;
    }

    .profile-land-card {
        min-width: 0;
        padding: 18px;
        background: #ffffff;
        border: 1px solid rgba(22, 131, 79, 0.13);
        border-radius: 16px;
        box-shadow: 0 8px 22px rgba(18, 69, 43, 0.05);
    }

    .profile-land-card small {
        display: block;
        color: var(--profile-muted);
        font-size: 8.5px;
        font-weight: 850;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .profile-land-card strong {
        display: block;
        margin-top: 10px;
        color: var(--profile-navy);
        font-size: 21px;
        font-weight: 900;
        line-height: 1.1;
    }

    @media (max-width: 850px) {
        .profile-facilities-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 620px) {
        .profile-support-section {
            padding: 42px 0;
        }

        .profile-support-title {
            font-size: 28px;
        }

        .profile-land-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 420px) {
        .profile-facilities-grid {
            gap: 9px;
        }

        .profile-facility-card {
            min-height: 94px;
            gap: 10px;
            padding: 13px;
            border-radius: 13px;
        }

        .profile-facility-icon {
            width: 37px;
            height: 37px;
            flex-basis: 37px;
            font-size: 14px;
        }

        .profile-facility-card strong {
            font-size: 19px;
        }

        .profile-facility-card span {
            font-size: 8px;
        }
    }

    /* =====================================================
       KANTOR DESA
    ===================================================== */

    .profile-office-section {
        padding: 62px 0;
        background: var(--profile-bg);
        border-top: 1px solid var(--profile-border);
        border-bottom: 1px solid var(--profile-border);
    }

    .profile-office-grid {
        display: grid;
        grid-template-columns:
            minmax(360px, 0.9fr)
            minmax(0, 1.1fr);
        gap: clamp(28px, 4vw, 58px);
        align-items: center;
    }

    .profile-office-visual {
        position: relative;
        min-height: 390px;
        overflow: hidden;
        background: var(--profile-green-soft);
        border: 1px solid var(--profile-border);
        border-radius: 22px;
        box-shadow: 0 18px 46px rgba(18, 69, 43, 0.12);
    }

    .profile-office-image {
        width: 100%;
        height: 100%;
        min-height: 390px;
        display: block;
        object-fit: cover;
    }

    .profile-office-placeholder {
        min-height: 390px;
        display: grid;
        place-items: center;
        padding: 30px;
        text-align: center;
    }

    .profile-office-placeholder img {
        width: min(190px, 56%);
        max-height: 210px;
        object-fit: contain;
    }

    .profile-office-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 11px;
        color: var(--profile-green-dark);
        background: var(--profile-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.17);
        border-radius: 999px;
        font-size: 10px;
        font-weight: 850;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .profile-office-copy h2 {
        margin: 14px 0 0;
        color: var(--profile-navy);
        font-size: clamp(28px, 3vw, 39px);
        font-weight: 850;
        line-height: 1.15;
        letter-spacing: -0.04em;
    }

    .profile-office-copy > p {
        margin: 14px 0 0;
        color: var(--profile-muted);
        font-size: 14px;
        line-height: 1.78;
    }

    .profile-office-details {
        display: grid;
        gap: 10px;
        margin-top: 22px;
    }

    .profile-office-detail {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 13px 14px;
        background: #ffffff;
        border: 1px solid var(--profile-border);
        border-radius: 13px;
    }

    .profile-office-detail i {
        width: 37px;
        height: 37px;
        flex: 0 0 37px;
        display: grid;
        place-items: center;
        color: #ffffff;
        background: var(--profile-green);
        border-radius: 10px;
    }

    .profile-office-detail small {
        display: block;
        color: var(--profile-muted);
        font-size: 9px;
        font-weight: 800;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .profile-office-detail strong {
        display: block;
        margin-top: 3px;
        color: var(--profile-navy);
        font-size: 12px;
        line-height: 1.55;
        overflow-wrap: anywhere;
    }

    .profile-office-action {
        margin-top: 20px;
    }

    @media (max-width: 900px) {
        .profile-office-grid {
            grid-template-columns: 1fr;
        }

        .profile-office-visual,
        .profile-office-image,
        .profile-office-placeholder {
            min-height: 320px;
        }
    }

    @media (max-width: 575.98px) {
        .profile-motto-card {
            align-items: flex-start;
            padding: 18px;
        }

        .profile-motto-icon {
            width: 44px;
            height: 44px;
            flex-basis: 44px;
        }

        .profile-office-section {
            padding: 44px 0;
        }

        .profile-office-visual,
        .profile-office-image,
        .profile-office-placeholder {
            min-height: 245px;
        }
    }

    /* =====================================================
       TEMA GELAP — STATISTIK PROFIL
    ===================================================== */

    .profile-statistics-section {
        position: relative;
        overflow: hidden;
        padding: 30px 0 32px;
        background:
            radial-gradient(
                circle at 12% 18%,
                rgba(81, 208, 141, 0.16),
                transparent 30%
            ),
            radial-gradient(
                circle at 88% 82%,
                rgba(22, 131, 79, 0.2),
                transparent 34%
            ),
            linear-gradient(
                135deg,
                #062f1d 0%,
                #0a4b2d 48%,
                #0d6139 100%
            );
    }

    .profile-statistics-section::before {
        position: absolute;
        inset: 0;
        content: "";
        background:
            linear-gradient(
                90deg,
                rgba(255, 255, 255, 0.022) 1px,
                transparent 1px
            ),
            linear-gradient(
                rgba(255, 255, 255, 0.022) 1px,
                transparent 1px
            );
        background-size: 36px 36px;
        pointer-events: none;
    }

    .profile-statistics-section .profile-container {
        position: relative;
        z-index: 1;
    }

    .profile-statistics {
        background:
            linear-gradient(
                145deg,
                rgba(255, 255, 255, 0.13),
                rgba(255, 255, 255, 0.07)
            );
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 21px;
        box-shadow:
            0 18px 44px rgba(1, 24, 13, 0.22),
            inset 0 1px 0 rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(8px);
    }

    .profile-stat {
        min-height: 98px;
        color: #ffffff;
    }

    .profile-stat:not(:last-child)::after {
        background: rgba(255, 255, 255, 0.16);
    }

    .profile-stat-icon {
        color: #d8ffea;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.15);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.08);
    }

    .profile-stat strong {
        color: #ffffff;
        font-weight: 850;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.16);
    }

    .profile-stat span {
        color: rgba(255, 255, 255, 0.76);
        font-weight: 650;
    }

    @media (max-width: 900px) {
        .profile-stat:nth-child(-n + 2) {
            border-bottom-color: rgba(255, 255, 255, 0.14);
        }
    }

    @media (max-width: 700px) {
        .profile-statistics-section {
            padding: 22px 0 24px;
        }
    }

    @media (max-width: 520px) {
        .profile-stat {
            min-height: 78px;
            padding: 14px 16px;
        }

        .profile-stat:not(:last-child)::after {
            background: rgba(255, 255, 255, 0.14);
        }

        .profile-stat-icon {
            width: 39px;
            height: 39px;
            flex-basis: 39px;
            font-size: 15px;
        }

        .profile-stat strong {
            font-size: 18px;
        }

        .profile-stat span {
            margin-top: 3px;
            font-size: 10px;
        }
    }

</style>


<style>
    /* PROFIL DESA — HERO PREMIUM MODERN */

    .profile-header {
        position: relative;
        overflow: hidden;
        padding: 72px 0 112px;
        background:
            radial-gradient(
                circle at 8% 14%,
                rgba(22, 131, 79, 0.16),
                transparent 28%
            ),
            radial-gradient(
                circle at 92% 86%,
                rgba(82, 190, 128, 0.13),
                transparent 30%
            ),
            linear-gradient(
                135deg,
                #edf7f1 0%,
                #f8fbf9 46%,
                #ffffff 100%
            );
        border-bottom: 0;
    }

    .profile-header::before {
        position: absolute;
        top: -140px;
        right: -110px;
        width: 430px;
        height: 430px;
        content: "";
        background:
            linear-gradient(
                145deg,
                rgba(22, 131, 79, 0.10),
                rgba(22, 131, 79, 0.02)
            );
        border: 1px solid rgba(22, 131, 79, 0.08);
        border-radius: 50%;
        pointer-events: none;
    }

    .profile-header::after {
        position: absolute;
        inset: 0;
        content: "";
        background:
            linear-gradient(
                90deg,
                rgba(13, 97, 57, 0.025) 1px,
                transparent 1px
            ),
            linear-gradient(
                rgba(13, 97, 57, 0.025) 1px,
                transparent 1px
            );
        background-size: 42px 42px;
        mask-image:
            linear-gradient(
                to bottom,
                rgba(0, 0, 0, 0.72),
                transparent 82%
            );
        pointer-events: none;
    }

    .profile-header .profile-container {
        position: relative;
        z-index: 1;
    }

    .profile-header-grid {
        grid-template-columns:
            minmax(0, 0.88fr)
            minmax(470px, 1.12fr);
        gap: clamp(44px, 5vw, 82px);
    }

    .profile-header-copy {
        position: relative;
        z-index: 2;
    }

    .profile-header-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        color: var(--profile-green-dark);
        background: rgba(255, 255, 255, 0.78);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 999px;
        box-shadow: 0 8px 22px rgba(13, 97, 57, 0.07);
        backdrop-filter: blur(8px);
        font-size: 10px;
        font-weight: 850;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .profile-header-title {
        max-width: 680px;
        margin-top: 18px;
        font-size: clamp(31px, 3.35vw, 48px);
        line-height: 1.08;
        font-weight: 900;
        letter-spacing: -0.042em;
    }

    .profile-header-title-line {
        width: 72px;
        height: 6px;
        margin-top: 17px;
        background:
            linear-gradient(
                90deg,
                var(--profile-green-dark),
                #55bd7e
            );
    }

    .profile-header-description {
        max-width: 650px;
        margin-top: 19px;
        font-size: 15px;
        line-height: 1.8;
    }

    .profile-header-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 18px;
    }

    .profile-header-meta span {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 34px;
        padding: 7px 10px;
        color: var(--profile-green-dark);
        background: rgba(255, 255, 255, 0.78);
        border: 1px solid rgba(22, 131, 79, 0.14);
        border-radius: 9px;
        font-size: 9.5px;
        font-weight: 750;
        box-shadow: 0 7px 18px rgba(13, 97, 57, 0.05);
        backdrop-filter: blur(7px);
    }

    .profile-header-meta i {
        color: var(--profile-green);
    }

    .profile-header-actions {
        margin-top: 25px;
    }

    .profile-button {
        min-height: 46px;
        padding-inline: 18px;
        border-radius: 12px;
    }

    .profile-button-primary {
        background:
            linear-gradient(
                135deg,
                var(--profile-green-dark),
                var(--profile-green)
            );
        border-color: var(--profile-green);
        box-shadow: 0 13px 28px rgba(13, 97, 57, 0.18);
    }

    .profile-button-outline {
        background: rgba(255, 255, 255, 0.78);
        box-shadow: 0 8px 21px rgba(13, 97, 57, 0.06);
        backdrop-filter: blur(7px);
    }

    .profile-header-visual {
        position: relative;
        overflow: visible;
        padding: 11px;
        background: rgba(255, 255, 255, 0.88);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 24px;
        box-shadow:
            0 28px 70px rgba(12, 77, 44, 0.17),
            0 4px 12px rgba(18, 37, 28, 0.06);
        transform: rotate(0.7deg);
        backdrop-filter: blur(10px);
    }

    .profile-header-visual::before {
        position: absolute;
        right: -18px;
        bottom: -18px;
        z-index: -1;
        width: 74%;
        height: 72%;
        content: "";
        background:
            linear-gradient(
                135deg,
                rgba(22, 131, 79, 0.26),
                rgba(22, 131, 79, 0.04)
            );
        border-radius: 24px;
    }

    .profile-header-visual-label {
        position: absolute;
        top: 24px;
        left: 24px;
        z-index: 3;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 11px;
        color: #ffffff;
        background: rgba(9, 71, 43, 0.87);
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 999px;
        box-shadow: 0 9px 24px rgba(8, 58, 34, 0.20);
        backdrop-filter: blur(8px);
        font-size: 9px;
        font-weight: 850;
    }

    .profile-header-image,
    .profile-header-logo {
        height: 340px;
        border-radius: 17px;
    }

    .profile-location-badge {
        right: 25px;
        bottom: 25px;
        left: 25px;
        padding: 13px 15px;
        background: rgba(255, 255, 255, 0.93);
        border-color: rgba(255, 255, 255, 0.9);
        box-shadow: 0 15px 32px rgba(18, 37, 28, 0.15);
        backdrop-filter: blur(9px);
    }

    .profile-statistics-section {
        position: relative;
        z-index: 4;
        margin-top: -58px;
        padding: 0 0 54px;
        background: transparent;
    }

    .profile-statistics {
        position: relative;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.97);
        border: 1px solid rgba(22, 131, 79, 0.15);
        border-radius: 22px;
        box-shadow:
            0 22px 55px rgba(12, 77, 44, 0.15),
            0 4px 12px rgba(18, 37, 28, 0.04);
        backdrop-filter: blur(10px);
    }

    .profile-statistics::before {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        height: 4px;
        content: "";
        background:
            linear-gradient(
                90deg,
                var(--profile-green-dark),
                var(--profile-green),
                #68ca91
            );
    }

    .profile-stat {
        min-height: 104px;
        padding: 21px 23px;
        color: var(--profile-text);
        transition:
            background 0.2s ease,
            transform 0.2s ease;
    }

    .profile-stat:hover {
        background: #f5faf7;
    }

    .profile-stat:not(:last-child)::after {
        background: rgba(22, 131, 79, 0.13);
    }

    .profile-stat-icon {
        width: 48px;
        height: 48px;
        flex-basis: 48px;
        color: var(--profile-green);
        background:
            linear-gradient(
                145deg,
                #e7f4ec,
                #f4faf6
            );
        border: 1px solid rgba(22, 131, 79, 0.12);
        border-radius: 14px;
        box-shadow: 0 8px 18px rgba(22, 131, 79, 0.08);
    }

    .profile-stat strong {
        color: var(--profile-navy);
        font-size: 23px;
        text-shadow: none;
    }

    .profile-stat span {
        color: var(--profile-muted);
        font-size: 11px;
    }

    @media (max-width: 1100px) {
        .profile-header-grid {
            grid-template-columns:
                minmax(0, 0.9fr)
                minmax(390px, 1.1fr);
            gap: 38px;
        }

        .profile-header-title {
            font-size: clamp(29px, 3.7vw, 40px);
        }

        .profile-header-image,
        .profile-header-logo {
            height: 310px;
        }
    }

    @media (max-width: 900px) {
        .profile-header {
            padding: 54px 0 96px;
        }

        .profile-header-grid {
            grid-template-columns: 1fr;
        }

        .profile-header-copy {
            max-width: 760px;
        }

        .profile-header-visual {
            max-width: 760px;
            transform: none;
        }

        .profile-statistics-section {
            margin-top: -45px;
        }
    }

    @media (max-width: 700px) {
        .profile-header {
            padding: 40px 0 78px;
        }

        .profile-header-title {
            margin-top: 15px;
            font-size: 28px;
            line-height: 1.12;
        }

        .profile-header-description {
            font-size: 13.5px;
        }

        .profile-header-image,
        .profile-header-logo {
            height: 265px;
        }

        .profile-header-visual-label {
            top: 20px;
            left: 20px;
            font-size: 8px;
        }

        .profile-statistics-section {
            margin-top: -36px;
            padding-bottom: 40px;
        }

        .profile-stat {
            min-height: 92px;
            padding: 17px;
        }
    }

    @media (max-width: 520px) {
        .profile-header {
            padding: 32px 0 66px;
        }

        .profile-header-title {
            font-size: 24px;
            line-height: 1.14;
            letter-spacing: -0.032em;
        }

        .profile-header-meta {
            display: grid;
            grid-template-columns: 1fr;
        }

        .profile-header-actions {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .profile-button {
            min-width: 0;
            padding-inline: 10px;
            font-size: 10px;
        }

        .profile-header-image,
        .profile-header-logo {
            height: 225px;
        }

        .profile-header-visual-label {
            max-width: calc(100% - 40px);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .profile-location-badge {
            right: 20px;
            bottom: 20px;
            left: 20px;
        }

        .profile-statistics {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            border-radius: 17px;
        }

        .profile-stat {
            min-height: 102px;
            gap: 9px;
            padding: 14px 12px;
        }

        .profile-stat:nth-child(-n + 2) {
            border-bottom:
                1px solid rgba(22, 131, 79, 0.12);
        }

        .profile-stat:nth-child(2)::after {
            display: none;
        }

        .profile-stat:nth-child(3)::after {
            display: block;
        }

        .profile-stat:not(:last-child)::after {
            top: 17px;
            right: 0;
            bottom: 17px;
            left: auto;
            width: 1px;
            height: auto;
        }

        .profile-stat-icon {
            width: 39px;
            height: 39px;
            flex-basis: 39px;
            font-size: 14px;
        }

        .profile-stat strong {
            font-size: 17px;
        }

        .profile-stat span {
            margin-top: 3px;
            font-size: 8.5px;
            line-height: 1.35;
        }
    }
</style>

@endpush

@section('content')

@php
    $desaNama = $profile?->nama_desa ?? 'Desa Bakal Dalam';

    $logoUrl = filled($profile?->logo)
        ? asset(
            'storage/' .
            ltrim($profile->logo, '/')
        )
        : asset('images/transparent.png');

    /*
     * Pembagian gambar halaman Profil:
     * - cover_image  : sampul/header halaman Profil
     * - office_photo : foto khusus bagian Kantor Pemerintah Desa
     */
    $imageVersion = $profile?->updated_at?->timestamp
        ?? time();

    $historyImagePath = $history?->gambar;

    $coverImagePath = $profile?->cover_image
        ?? $profile?->hero_image
        ?? $historyImagePath;

    $officeImagePath = $profile?->office_photo
        ?? $profile?->foto_kantor;

    $coverImage = filled($coverImagePath)
        ? asset(
            'storage/' .
            ltrim($coverImagePath, '/')
        ) . '?v=' . $imageVersion
        : null;

    $officeImage = filled($officeImagePath)
        ? asset(
            'storage/' .
            ltrim($officeImagePath, '/')
        ) . '?v=' . $imageVersion
        : null;

    $historyImage = filled($historyImagePath)
        ? asset(
            'storage/' .
            ltrim($historyImagePath, '/')
        )
        : null;

    /*
     * Kontak kantor hanya diambil dari Admin > Kontak Desa.
     */
    $officeAddress = $contact?->alamat;
    $officePhone = $contact?->telepon;
    $officeEmail = $contact?->email;
    $officeHours = $contact?->jam_operasional;

    $luasWilayah = $region?->luas_wilayah
        ?? $statistics?->luas_wilayah;

    $jumlahDusun = $region?->jumlah_dusun
        ?? $statistics?->jumlah_dusun;

    $tentangDesa = $profile?->deskripsi
        ?? $profile?->tentang_desa;

    $mottoDesa = $visionMission?->motto
        ?? $settings?->slogan
        ?? null;

    $misiDesa = [];

    if (filled($visionMission?->misi)) {
        $daftarMisi = preg_split(
            '/\r\n|\r|\n/',
            trim($visionMission->misi)
        );

        $misiDesa = array_values(
            array_filter(
                array_map(function ($item) {
                    $item = trim($item);

                    return preg_replace(
                        '/^\s*(?:\d+\s*[\.\)]|[-•])\s*/u',
                        '',
                        $item
                    );
                }, $daftarMisi)
            )
        );
    }

    $mapsEmbed = $region?->google_maps_embed;
    $mapsLink = $region?->google_maps;

    $mapsImage = filled($region?->map_image)
        ? asset(
            'storage/' .
            ltrim($region->map_image, '/')
        )
        : null;

    $visiAda = filled($visionMission?->visi);
    $tujuanAda = filled($visionMission?->tujuan);
@endphp

<div class="profile-page">

    {{-- HEADER PROFIL --}}
    <section class="profile-header">
        <div class="profile-container">

            <div class="profile-header-grid">

                <div class="profile-header-copy">

                    <span class="profile-header-kicker">
                        <i class="bi bi-building-check"></i>
                        Profil Resmi Desa
                    </span>

                    <h1 class="profile-header-title">
                        Profil {{ $desaNama }}
                    </h1>

                    <div class="profile-header-title-line"></div>

                    <p class="profile-header-description">
                        Informasi lengkap mengenai identitas, sejarah,
                        arah pembangunan, dan kondisi wilayah {{ $desaNama }}.
                    </p>

                    <div class="profile-header-meta">

                        <span>
                            <i class="bi bi-geo-alt-fill"></i>
                            Kecamatan
                            {{ $profile?->kecamatan ?? 'Talo Kecil' }}
                        </span>

                        <span>
                            <i class="bi bi-map-fill"></i>
                            Kabupaten
                            {{ $profile?->kabupaten ?? 'Seluma' }}
                        </span>

                        @if(filled($profile?->kode_pos))
                            <span>
                                <i class="bi bi-mailbox2"></i>
                                Kode Pos {{ $profile->kode_pos }}
                            </span>
                        @endif

                    </div>

                    <div class="profile-header-actions">

                        @if(!empty($history))
                            <a
                                href="#sejarah-desa"
                                class="profile-button profile-button-primary"
                            >
                                <i class="bi bi-clock-history"></i>
                                Lihat Sejarah
                            </a>
                        @endif

                        @if(!empty($region))
                            <a
                                href="#wilayah-desa"
                                class="profile-button profile-button-outline"
                            >
                                <i class="bi bi-map"></i>
                                Data Wilayah
                            </a>
                        @endif

                    </div>

                </div>

                <div class="profile-header-visual">

                    <span class="profile-header-visual-label">
                        <i class="bi bi-patch-check-fill"></i>
                        Website Resmi Pemerintah Desa
                    </span>

                    @if($coverImage)

                        <img
                            src="{{ $coverImage }}"
                            alt="{{ $desaNama }}"
                            class="profile-header-image"
                        >

                    @else

                        <div class="profile-header-logo">
                            <img
                                src="{{ $logoUrl }}"
                                alt="Logo {{ $desaNama }}"
                            >
                        </div>

                    @endif

                    <div class="profile-location-badge">

                        <i class="bi bi-geo-alt-fill"></i>

                        <div>
                            <small>Lokasi Desa</small>

                            <strong>
                                {{ $profile?->kecamatan ?? 'Talo Kecil' }},
                                {{ $profile?->kabupaten ?? 'Seluma' }}
                            </strong>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>

    {{-- STATISTIK --}}
    <section class="profile-statistics-section">
        <div class="profile-container">

            <div class="profile-statistics">

                <div class="profile-stat">

                    <div class="profile-stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>

                    <div>
                        <strong>
                            {{ filled($statistics?->jumlah_penduduk)
                                ? number_format(
                                    $statistics->jumlah_penduduk,
                                    0,
                                    ',',
                                    '.'
                                )
                                : '—' }}
                        </strong>

                        <span>Jumlah Penduduk</span>
                    </div>

                </div>

                <div class="profile-stat">

                    <div class="profile-stat-icon">
                        <i class="bi bi-house-heart-fill"></i>
                    </div>

                    <div>
                        <strong>
                            {{ filled($statistics?->jumlah_kk)
                                ? number_format(
                                    $statistics->jumlah_kk,
                                    0,
                                    ',',
                                    '.'
                                )
                                : '—' }}
                        </strong>

                        <span>Kepala Keluarga</span>
                    </div>

                </div>

                <div class="profile-stat">

                    <div class="profile-stat-icon">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>

                    <div>
                        <strong>{{ $jumlahDusun ?? '—' }}</strong>
                        <span>Jumlah Dusun</span>
                    </div>

                </div>

                <div class="profile-stat">

                    <div class="profile-stat-icon">
                        <i class="bi bi-bounding-box-circles"></i>
                    </div>

                    <div>
                        <strong>
                            {{ filled($luasWilayah)
                                ? $luasWilayah . ' ha'
                                : '—' }}
                        </strong>

                        <span>Luas Wilayah</span>
                    </div>

                </div>

            </div>

        </div>
    </section>

    {{-- TENTANG DESA --}}
    <section class="profile-section">
        <div class="profile-container profile-about-grid">

            <div>

                <span class="profile-kicker">
                    <i class="bi bi-info-circle"></i>
                    Tentang Desa
                </span>

                <h2 class="profile-section-title">
                    {{ $desaNama }}
                </h2>

                <div class="profile-title-line"></div>

                <div class="profile-about-copy">

                    @if(filled($tentangDesa))

                        {!! nl2br(e($tentangDesa)) !!}

                    @else

                        <p>
                            {{ $desaNama }} berada di Kecamatan
                            {{ $profile?->kecamatan ?? 'Talo Kecil' }},
                            Kabupaten
                            {{ $profile?->kabupaten ?? 'Seluma' }},
                            Provinsi
                            {{ $profile?->provinsi ?? 'Bengkulu' }}.
                        </p>

                        <p>
                            Pemerintah desa terus meningkatkan pelayanan publik,
                            pembangunan wilayah, serta pengembangan potensi
                            masyarakat.
                        </p>

                    @endif

                </div>

                @if(filled($profile?->village_slogan))

                    <div class="profile-slogan">
                        <small>Slogan Desa</small>
                        <strong>{{ $profile->village_slogan }}</strong>
                    </div>

                @endif

            </div>

            <div class="profile-information-card">

                @foreach([
                    ['bi-building', 'Nama Desa', $desaNama],
                    ['bi-geo-alt', 'Alamat Kantor', $profile?->alamat],
                    ['bi-signpost-2', 'Kecamatan', $profile?->kecamatan],
                    ['bi-buildings', 'Kabupaten', $profile?->kabupaten],
                    ['bi-map', 'Provinsi', $profile?->provinsi],
                    ['bi-mailbox', 'Kode Pos', $profile?->kode_pos]
                ] as [$icon, $label, $value])

                    <div class="profile-information-row">

                        <i class="bi {{ $icon }}"></i>

                        <div>
                            <small>{{ $label }}</small>
                            <strong>
                                {{ $value ?: 'Belum tersedia' }}
                            </strong>
                        </div>

                    </div>

                @endforeach

            </div>

        </div>
    </section>

    {{-- KANTOR DESA --}}
    <section class="profile-office-section">
        <div class="profile-container">

            <div class="profile-office-grid">

                <div class="profile-office-visual">

                    @if($officeImage)
                        <img
                            src="{{ $officeImage }}"
                            alt="Kantor Pemerintah {{ $desaNama }}"
                            class="profile-office-image"
                            loading="lazy"
                        >
                    @else
                        <div class="profile-office-placeholder">
                            <img
                                src="{{ $logoUrl }}"
                                alt="Logo {{ $desaNama }}"
                            >
                        </div>
                    @endif

                </div>

                <div class="profile-office-copy">

                    <span class="profile-office-label">
                        <i class="bi bi-building"></i>
                        Kantor Desa
                    </span>

                    <h2>
                        Kantor Pemerintah {{ $desaNama }}
                    </h2>

                    <p>
                        Pusat pelayanan administrasi, informasi publik,
                        dan penyelenggaraan pemerintahan desa bagi
                        masyarakat.
                    </p>

                    <div class="profile-office-details">

                        @if(filled($officeAddress))
                            <div class="profile-office-detail">
                                <i class="bi bi-geo-alt-fill"></i>

                                <div>
                                    <small>Alamat Kantor</small>
                                    <strong>{{ $officeAddress }}</strong>
                                </div>
                            </div>
                        @endif

                        @if(filled($officePhone))
                            <div class="profile-office-detail">
                                <i class="bi bi-telephone-fill"></i>

                                <div>
                                    <small>Telepon</small>
                                    <strong>{{ $officePhone }}</strong>
                                </div>
                            </div>
                        @endif

                        @if(filled($officeEmail))
                            <div class="profile-office-detail">
                                <i class="bi bi-envelope-fill"></i>

                                <div>
                                    <small>Email</small>
                                    <strong>{{ $officeEmail }}</strong>
                                </div>
                            </div>
                        @endif

                        @if(filled($officeHours))
                            <div class="profile-office-detail">
                                <i class="bi bi-clock-fill"></i>

                                <div>
                                    <small>Jam Pelayanan</small>
                                    <strong>{{ $officeHours }}</strong>
                                </div>
                            </div>
                        @endif

                    </div>

                    <div class="profile-office-action">
                        <a
                            href="{{ route('public.contact') }}"
                            class="profile-button profile-button-primary"
                        >
                            <i class="bi bi-chat-dots"></i>
                            Hubungi Pemerintah Desa
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </section>

    {{-- VISI, MISI, TUJUAN --}}
    @if(
        filled($mottoDesa) ||
        $visiAda ||
        $tujuanAda ||
        !empty($misiDesa)
    )

        <section class="profile-section profile-section-soft">
            <div class="profile-container">

                <span class="profile-kicker">
                    <i class="bi bi-bullseye"></i>
                    Arah Pembangunan
                </span>

                <h2 class="profile-section-title">
                    Visi, Misi, dan Tujuan Desa
                </h2>

                <div class="profile-title-line"></div>

                <p class="profile-section-description">
                    Landasan pembangunan dan pelayanan Pemerintah
                    {{ $desaNama }}.
                </p>

                @if(filled($mottoDesa))
                    <article class="profile-motto-card">

                        <span class="profile-motto-icon">
                            <i class="bi bi-chat-quote-fill"></i>
                        </span>

                        <div>
                            <small>Motto Desa</small>

                            <blockquote>
                                “{{ $mottoDesa }}”
                            </blockquote>
                        </div>

                    </article>
                @endif

                @if($visiAda || $tujuanAda)

                    <div
                        class="profile-vision-grid
                        {{ !($visiAda && $tujuanAda)
                            ? 'is-single'
                            : '' }}"
                    >

                        @if($visiAda)

                            <article class="profile-vision-card">

                                <i class="bi bi-quote"></i>

                                <small>Visi Desa</small>

                                <blockquote>
                                    {{ $visionMission->visi }}
                                </blockquote>

                            </article>

                        @endif

                        @if($tujuanAda)

                            <article class="profile-purpose-card">

                                <h3>Tujuan Desa</h3>

                                <p>
                                    {{ $visionMission->tujuan }}
                                </p>

                            </article>

                        @endif

                    </div>

                @endif

                @if(!empty($misiDesa))

                    <div
                        class="profile-missions"
                        id="daftarMisiDesa"
                    >

                        @foreach($misiDesa as $index => $misi)

                            <article
                                class="profile-mission-card
                                {{ $index >= 6
                                    ? 'is-hidden'
                                    : '' }}"
                            >

                                <div class="profile-mission-number">
                                    {{ str_pad(
                                        $index + 1,
                                        2,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}
                                </div>

                                <p>{{ $misi }}</p>

                            </article>

                        @endforeach

                    </div>

                    @if(count($misiDesa) > 6)

                        <div class="profile-mission-action">

                            <button
                                type="button"
                                class="profile-mission-toggle"
                                id="toggleMisiDesa"
                            >
                                <span>Tampilkan Semua Misi</span>
                                <i class="bi bi-chevron-down"></i>
                            </button>

                        </div>

                    @endif

                @endif

            </div>
        </section>

    @endif

    {{-- SEJARAH --}}
    @if(!empty($history))

        <section
            class="profile-section"
            id="sejarah-desa"
        >
            <div class="profile-container">

                <span class="profile-kicker">
                    <i class="bi bi-clock-history"></i>
                    Jejak Perjalanan
                </span>

                <h2 class="profile-section-title">
                    {{ $history?->judul ?? 'Sejarah Desa' }}
                </h2>

                <div class="profile-title-line"></div>

                @if(filled($history?->excerpt))

                    <p class="profile-section-description">
                        {{ $history->excerpt }}
                    </p>

                @endif

                <div class="profile-history-grid">

                    <div class="profile-history-text">

                        @if(filled($history?->sejarah))

                            {!! nl2br(e($history->sejarah)) !!}

                        @else

                            <p>
                                Informasi sejarah desa belum tersedia.
                            </p>

                        @endif

                    </div>

                    <div>

                        @if($historyImage)

                            <img
                                src="{{ $historyImage }}"
                                alt="Sejarah {{ $desaNama }}"
                                class="profile-history-image"
                            >

                        @elseif($coverImage)

                            <img
                                src="{{ $coverImage }}"
                                alt="{{ $desaNama }}"
                                class="profile-history-image"
                            >

                        @elseif(filled($history?->year_established))

                            <div class="profile-slogan">

                                <small>Tahun Berdiri</small>

                                <strong>
                                    {{ $history->year_established }}
                                </strong>

                            </div>

                        @endif

                    </div>

                </div>

            </div>
        </section>

    @endif

    {{-- WILAYAH --}}
    @if(!empty($region))

        <section
            class="profile-section profile-section-soft"
            id="wilayah-desa"
        >
            <div class="profile-container">

                <span class="profile-kicker">
                    <i class="bi bi-compass"></i>
                    Wilayah Desa
                </span>

                <h2 class="profile-section-title">
                    Kondisi dan Batas Wilayah
                </h2>

                <div class="profile-title-line"></div>

                <p class="profile-section-description">
                    Gambaran geografis dan batas administratif
                    {{ $desaNama }}.
                </p>

                <div class="profile-region-grid">

                    <div class="profile-region-text">

                        @if(filled($region?->deskripsi))

                            {!! nl2br(e($region->deskripsi)) !!}

                        @else

                            <p>
                                Informasi kondisi geografis belum tersedia.
                            </p>

                        @endif

                    </div>

                    <div class="profile-boundaries">

                        <div class="profile-compass">
                            <i class="bi bi-compass"></i>
                        </div>

                        <div class="profile-boundary">
                            <small>UTARA</small>
                            <strong>
                                {{ $region?->batas_utara
                                    ?: 'Belum tersedia' }}
                            </strong>
                        </div>

                        <div class="profile-boundary">
                            <small>TIMUR</small>
                            <strong>
                                {{ $region?->batas_timur
                                    ?: 'Belum tersedia' }}
                            </strong>
                        </div>

                        <div class="profile-boundary">
                            <small>BARAT</small>
                            <strong>
                                {{ $region?->batas_barat
                                    ?: 'Belum tersedia' }}
                            </strong>
                        </div>

                        <div class="profile-boundary">
                            <small>SELATAN</small>
                            <strong>
                                {{ $region?->batas_selatan
                                    ?: 'Belum tersedia' }}
                            </strong>
                        </div>

                    </div>

                </div>

            </div>
        </section>

    @endif

    {{-- PETA --}}
    @if(
        !empty($mapsEmbed)
        || !empty($mapsImage)
        || !empty($mapsLink)
    )

        <section class="profile-section">
            <div class="profile-container">

                <span class="profile-kicker">
                    <i class="bi bi-map"></i>
                    Peta Desa
                </span>

                <h2 class="profile-section-title">
                    Peta Wilayah {{ $desaNama }}
                </h2>

                <div class="profile-title-line"></div>

                <div class="profile-map-card">

                    @if(!empty($mapsEmbed))

                        {!! $mapsEmbed !!}

                    @elseif(!empty($mapsImage))

                        <img
                            src="{{ $mapsImage }}"
                            alt="Peta {{ $desaNama }}"
                        >

                    @elseif(!empty($mapsLink))

                        <div class="profile-map-link">

                            <a
                                href="{{ $mapsLink }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="profile-button profile-button-primary"
                            >
                                <i class="bi bi-box-arrow-up-right"></i>
                                Buka Google Maps
                            </a>

                        </div>

                    @endif

                </div>

            </div>
        </section>

    @endif


    {{-- FASILITAS DAN PEMANFAATAN LAHAN --}}
    <section class="profile-support-section">
        <div class="profile-container">

            <div class="profile-support-header">

                <span class="profile-support-kicker">
                    <i class="bi bi-bar-chart-fill"></i>
                    Data Pendukung
                </span>

                <h2 class="profile-support-title">
                    Fasilitas dan Pemanfaatan Wilayah
                </h2>

                <p class="profile-support-description">
                    Ringkasan fasilitas umum dan penggunaan lahan
                    {{ $desaNama }}.
                </p>

            </div>

            <div class="profile-facilities-grid">

                @foreach([
                    [
                        'icon' => 'bi-mortarboard-fill',
                        'value' => $statistics?->jumlah_sekolah,
                        'label' => 'Jumlah Sekolah',
                    ],
                    [
                        'icon' => 'bi-moon-stars-fill',
                        'value' => $statistics?->jumlah_masjid,
                        'label' => 'Jumlah Masjid',
                    ],
                    [
                        'icon' => 'bi-heart-pulse-fill',
                        'value' => $statistics?->jumlah_posyandu,
                        'label' => 'Jumlah Posyandu',
                    ],
                    [
                        'icon' => 'bi-shop',
                        'value' => $statistics?->jumlah_umkm,
                        'label' => 'Jumlah UMKM',
                    ],
                ] as $facility)

                    <article class="profile-facility-card">

                        <span class="profile-facility-icon">
                            <i class="bi {{ $facility['icon'] }}"></i>
                        </span>

                        <div>
                            <strong>
                                {{ number_format(
                                    (float) (
                                        $facility['value'] ?? 0
                                    ),
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </strong>

                            <span>{{ $facility['label'] }}</span>
                        </div>

                    </article>

                @endforeach

            </div>

            <div class="profile-land-grid">

                @foreach([
                    [
                        'label' => 'Luas Wilayah',
                        'value' => $statistics?->luas_wilayah,
                    ],
                    [
                        'label' => 'Luas Sawah',
                        'value' => $statistics?->luas_sawah,
                    ],
                    [
                        'label' => 'Luas Perkebunan',
                        'value' => $statistics?->luas_perkebunan,
                    ],
                ] as $land)

                    <article class="profile-land-card">
                        <small>{{ $land['label'] }}</small>

                        <strong>
                            {{ filled($land['value'])
                                ? $land['value'] . ' ha'
                                : '—'
                            }}
                        </strong>
                    </article>

                @endforeach

            </div>

        </div>
    </section>

    {{-- CTA --}}
    <section class="profile-section">
        <div class="profile-container">

            <div class="profile-cta">

                <div>

                    <h2>
                        Butuh Informasi atau Pelayanan Desa?
                    </h2>

                    <p>
                        Hubungi Pemerintah {{ $desaNama }} untuk mendapatkan
                        informasi dan pelayanan masyarakat.
                    </p>

                </div>

                <a
                    href="{{ url('/kontak') }}"
                    class="profile-button profile-button-cta"
                >
                    <i class="bi bi-chat-dots-fill"></i>
                    Hubungi Desa
                </a>

            </div>

        </div>
    </section>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const button = document.getElementById('toggleMisiDesa');

    if (!button) {
        return;
    }

    const missionContainer =
        document.getElementById('daftarMisiDesa');

    const hiddenMissions = document.querySelectorAll(
        '#daftarMisiDesa .profile-mission-card.is-hidden'
    );

    const buttonText = button.querySelector('span');

    let opened = false;

    button.addEventListener('click', function () {
        opened = !opened;

        hiddenMissions.forEach(function (item) {
            item.style.display = opened ? 'grid' : 'none';
        });

        button.classList.toggle('is-open', opened);

        buttonText.textContent = opened
            ? 'Sembunyikan Misi'
            : 'Tampilkan Semua Misi';

        if (!opened && missionContainer) {
            missionContainer.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>
@endpush