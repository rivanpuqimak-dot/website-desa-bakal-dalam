@extends('layouts.public')

@section('title', 'Beranda Desa Bakal Dalam')

@push('styles')
<style>
    .home-section {
        padding: 60px 0;
    }

    .home-section-label {
        display: inline-block;
        margin-bottom: 8px;
        color: #1e7a46;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .home-section-heading {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 26px;
    }

    .home-section-heading h2 {
        margin: 0;
        color: #17211b;
        font-size: 30px;
        font-weight: 800;
        line-height: 1.25;
    }

    .home-section-heading > a {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #1e7a46;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
    }

    /* HERO */

    .home-hero {
        position: relative;
        min-height: 610px;
        overflow: hidden;
        color: #ffffff;
        background: #164329;
    }

    .home-hero-background,
    .home-hero-overlay {
        position: absolute;
        inset: 0;
    }

    .home-hero-background {
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .home-hero-overlay {
        background: linear-gradient(
            90deg,
            rgba(5, 55, 27, .58) 0%,
            rgba(5, 55, 27, .34) 55%,
            rgba(5, 35, 18, .16) 100%
        );
    }

    .home-hero-content {
        position: relative;
        z-index: 2;
        min-height: 610px;
        display: flex;
        align-items: center;
    }

.home-hero-title {
        max-width: 800px;
        margin: 0;
        color: #ffffff;
        /* diperkecil supaya tidak terlalu memenuhi layar */
        font-size: clamp(34px, 4vw, 54px);
        font-weight: 800;
        line-height: 1.08;
        letter-spacing: -.02em;
    }

    .home-hero-description {
        max-width: 750px;
        margin: 22px 0 0;
        color: rgba(255, 255, 255, .9);
        font-size: 18px;
        line-height: 1.75;
    }

    .home-hero-motto {
        width: fit-content;
        max-width: 760px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-top: 20px;
        padding: 12px 15px;
        color: #ffffff;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.24);
        border-radius: 13px;
        backdrop-filter: blur(7px);
        font-size: 14px;
        font-weight: 750;
        line-height: 1.65;
    }

    .home-hero-motto i {
        flex: 0 0 auto;
        margin-top: 3px;
        color: #b9f3d5;
        font-size: 16px;
    }

    .home-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 28px;
    }

    .home-stat-card {
        padding: 26px;
        color: #17211b;
        background: rgba(255, 255, 255, .97);
        border: 1px solid rgba(255, 255, 255, .75);
        border-radius: 22px;
        box-shadow: 0 22px 60px rgba(0, 0, 0, .2);
    }

    .home-stat-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .home-stat-item {
        min-height: 112px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 18px;
        background: #f4f7f5;
        border: 1px solid #e1e8e3;
        border-radius: 16px;
    }

    .home-stat-item span {
        margin-bottom: 8px;
        color: #758078;
        font-size: 13px;
    }

    .home-stat-item strong {
        color: #1e7a46;
        /* diperkecil agar sesuai dengan tampilan */
        font-size: 20px;
        font-weight: 800;
    }

    /* SAMBUTAN */

    .home-sambutan {
        background: linear-gradient(180deg, #f7faf8, #ffffff);
    }

    .home-sambutan-grid {
        display: grid !important;
        grid-template-columns: 320px minmax(0, 1fr) !important;
        gap: 28px !important;
        align-items: stretch;
    }

    .home-leader-card,
    .home-sambutan-card {
        background: #ffffff;
        border: 1px solid #e0e8e2;
        border-radius: 20px;
        box-shadow: 0 12px 35px rgba(18, 70, 40, .08);
    }

    .home-leader-card {
        padding: 16px;
    }

    .home-leader-photo {
        width: 100%;
        height: 320px;
        overflow: hidden;
        background: #eef3ef;
        border-radius: 15px;
    }

    .home-leader-photo img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        object-position: center top;
    }

    .home-leader-info {
        padding: 15px 5px 3px;
        text-align: center;
    }

    .home-leader-info h3 {
        margin: 0 0 4px;
        color: #17211b;
        font-size: 19px;
        font-weight: 800;
    }

    .home-leader-info p {
        margin: 0;
        color: #1e7a46;
        font-size: 13px;
        font-weight: 700;
    }

    .home-sambutan-card {
        display: flex;
        flex-direction: column;
        padding: 34px 38px;
    }

    .home-sambutan-card h2 {
        max-width: 800px;
        margin: 0 0 20px;
        color: #17211b;
        font-size: 34px;
        font-weight: 800;
        line-height: 1.28;
    }

    .home-sambutan-text {
        flex: 1;
        color: #5f6b64;
        font-size: 15px;
        line-height: 1.85;
        text-align: justify;
    }

    .home-sambutan-action {
        margin-top: 24px;
        text-align: right;
    }

    /* PROFIL */

    .home-profile {
        background: #ffffff;
    }

    .home-profile-grid {
        display: grid !important;
        grid-template-columns: minmax(0, .95fr) minmax(0, 1.05fr) !important;
        gap: 42px !important;
        align-items: center;
    }

    .home-profile-image {
        overflow: hidden;
        border-radius: 22px;
        box-shadow: 0 18px 48px rgba(17, 67, 39, .14);
    }

    .home-profile-image img {
        width: 100%;
        height: 410px;
        display: block;
        object-fit: cover;
    }

    .home-profile-content h2 {
        margin: 0;
        color: #17211b;
        font-size: 38px;
        font-weight: 800;
    }

    .home-profile-description {
        margin: 16px 0 24px;
        color: #66726b;
        font-size: 15px;
        line-height: 1.8;
    }

    .home-profile-info {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .home-profile-item {
        min-height: 95px;
        padding: 18px;
        background: #ffffff;
        border: 1px solid #e1e9e4;
        border-left: 4px solid #1e7a46;
        border-radius: 15px;
        box-shadow: 0 8px 24px rgba(18, 75, 42, .06);
    }

    .home-profile-item span {
        display: block;
        margin-bottom: 4px;
        color: #7a867f;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .home-profile-item strong {
        color: #17211b;
        font-size: 16px;
    }

    /* POTENSI */

    .home-potentials {
        background: #f5f8f6;
    }

    .home-potential-grid {
        display: grid !important;
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        gap: 20px !important;
    }

    .home-potential-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e0e8e2;
        border-radius: 17px;
        box-shadow: 0 8px 26px rgba(18, 70, 40, .07);
    }

    .home-potential-image {
        position: relative;
        height: 175px;
        overflow: hidden;
        background: #eef3ef;
    }

    .home-potential-image img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .home-potential-content {
        padding: 17px;
    }

    .home-potential-content h3 {
        margin: 0 0 8px;
        color: #17211b;
        font-size: 17px;
        font-weight: 800;
    }

    .home-potential-content p {
        height: 42px;
        margin: 0 0 14px;
        overflow: hidden;
        color: #68746d;
        font-size: 12px;
        line-height: 21px;
    }

    /* BERITA — 3 KARTU KECIL */

    .home-news {
        background: #ffffff;
    }

    .home-news-grid {
        display: grid !important;
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        gap: 18px !important;
    }

    .home-news-card {
        min-width: 0 !important;
        width: 100% !important;
        display: block !important;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e0e8e2;
        border-radius: 15px;
        box-shadow: 0 8px 24px rgba(18, 70, 40, .07);
    }

    .home-news-image {
        width: 100% !important;
        height: 135px !important;
        display: block !important;
        overflow: hidden;
        background: #eef3ef;
    }

    .home-news-image img {
        width: 100% !important;
        height: 100% !important;
        display: block !important;
        object-fit: cover !important;
    }

    .home-news-content {
        width: 100% !important;
        padding: 15px !important;
    }

    .home-news-date {
        color: #7b867f;
        font-size: 10px;
    }

    .home-news-content h3 {
        height: 42px;
        margin: 6px 0 8px;
        overflow: hidden;
        font-size: 15px;
        font-weight: 800;
        line-height: 21px;
    }

    .home-news-content h3 a {
        color: #17211b;
        text-decoration: none;
    }

    .home-news-content p {
        height: 38px;
        margin: 0 0 12px;
        overflow: hidden;
        color: #68746d;
        font-size: 11px;
        line-height: 19px;
    }

    .home-news-button {
        display: inline-flex;
        padding: 6px 10px;
        color: #1e7a46;
        border: 1px solid #1e7a46;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 700;
        text-decoration: none;
    }

    /* GALERI — 5 FOTO KOTAK */

    .home-gallery {
        background: #f5f8f6;
    }

    .home-gallery-grid {
        display: grid !important;
        grid-template-columns: repeat(5, minmax(0, 1fr)) !important;
        gap: 12px !important;
    }

    .home-gallery-card {
        width: 100% !important;
        margin: 0 !important;
        overflow: hidden;
        background: #e9efeb;
        border: 1px solid #dde6df;
        border-radius: 13px;
        box-shadow: 0 7px 18px rgba(17, 65, 37, .07);
    }

    .home-gallery-card > a {
        position: relative;
        width: 100% !important;
        display: block !important;
        overflow: hidden;
        aspect-ratio: 1 / 1;
    }

    .home-gallery-card img {
        width: 100% !important;
        height: 100% !important;
        display: block !important;
        object-fit: cover !important;
    }

    .home-gallery-overlay {
        position: absolute;
        inset: 0;
        display: grid;
        place-items: center;
        color: #ffffff;
        opacity: 0;
        background: rgba(5, 48, 24, .45);
        font-size: 20px;
        transition: opacity .2s ease;
    }

    .home-gallery-card:hover .home-gallery-overlay {
        opacity: 1;
    }

    /* MAP DAN KONTAK */

    .home-location {
        background: #ffffff;
    }

    .home-location-grid {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 24px !important;
        align-items: stretch;
    }

    .home-map-card,
    .home-contact-card {
        min-height: 470px;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e0e8e2;
        border-radius: 19px;
        box-shadow: 0 12px 35px rgba(18, 70, 40, .08);
    }

    .home-map-card iframe {
        width: 100% !important;
        height: 100% !important;
        min-height: 470px !important;
        display: block !important;
        border: 0 !important;
    }

    .home-map-placeholder {
        min-height: 470px;
        display: grid;
        place-items: center;
        color: #6d7871;
        background: #eef3ef;
    }

    .home-contact-card {
        padding: 28px;
    }

    .home-contact-card h2 {
        margin: 0 0 20px;
        color: #17211b;
        font-size: 30px;
        font-weight: 800;
    }

    .home-contact-list {
        display: grid;
        gap: 12px;
    }

    .home-contact-item {
        padding: 14px 16px;
        background: #f5f8f6;
        border-radius: 13px;
    }

    .home-contact-item strong {
        display: block;
        margin-bottom: 3px;
        color: #17211b;
        font-size: 13px;
    }

    .home-contact-item span {
        color: #66726b;
        font-size: 12px;
    }

    /* CTA */

    .home-cta {
        padding: 52px 0;
        color: #ffffff;
        background: linear-gradient(135deg, #145c35, #1e7a46);
    }

    .home-cta h2 {
        margin: 0 0 10px;
        color: #ffffff;
        font-size: 32px;
        font-weight: 800;
    }

    .home-cta p {
        margin: 0;
        color: rgba(255, 255, 255, .82);
    }

    /* Lightbox tidak menghalangi menu */

    .public-lightbox-modal {
        pointer-events: none;
    }

    .public-lightbox-modal.open {
        pointer-events: auto;
    }

    @media (max-width: 991.98px) {
        .home-sambutan-grid,
        .home-profile-grid,
        .home-location-grid {
            grid-template-columns: 1fr !important;
        }

        .home-potential-grid,
        .home-news-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }

        .home-gallery-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        }

        .home-leader-card {
            max-width: 430px;
            margin: 0 auto;
        }
    }

    @media (max-width: 767.98px) {
        .home-section {
            padding: 46px 0;
        }

        .home-section-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .home-section-heading h2 {
            font-size: 27px;
        }

        .home-profile-info,
        .home-potential-grid,
        .home-news-grid {
            grid-template-columns: 1fr !important;
        }

        .home-gallery-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }

        .home-hero-content {
            min-height: auto;
            padding: 70px 0;
        }

        .home-hero-title {
            font-size: 38px;
        }

        .home-profile-image img {
            height: 300px;
        }
    }
</style>


<style>
    :root {
        --home-green: #16834f;
        --home-green-dark: #0d6139;
        --home-green-soft: #eef7f2;
        --home-navy: #12251c;
        --home-text: #34463c;
        --home-muted: #6e7d74;
        --home-border: #dfe9e3;
        --home-white: #ffffff;
        --home-bg: #f7faf8;
    }

    .home-page,
    .home-page * {
        box-sizing: border-box;
    }

    .home-page {
        width: 100%;
        overflow-x: hidden;
        color: var(--home-text);
        background: var(--home-white);
    }

    .home-section {
        padding: 72px 0;
    }

    .home-section-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 9px;
        color: var(--home-green);
        font-size: 11px;
        font-weight: 900;
        letter-spacing: .11em;
        text-transform: uppercase;
    }

    .home-section-label::before {
        content: "";
        width: 24px;
        height: 3px;
        border-radius: 999px;
        background: currentColor;
    }

    .home-section-label.is-light {
        color: rgba(255, 255, 255, .92);
    }

    .home-section-heading {
        align-items: flex-end;
        margin-bottom: 30px;
    }

    .home-section-heading h2,
    .home-profile-content h2,
    .home-contact-card h2,
    .home-sambutan-card h2 {
        color: var(--home-navy);
        font-weight: 850;
        letter-spacing: -.035em;
    }

    .home-section-heading h2 {
        font-size: clamp(27px, 2.6vw, 38px);
        line-height: 1.18;
    }

    .home-section-heading > a {
        flex: 0 0 auto;
        padding: 10px 13px;
        color: var(--home-green-dark);
        background: var(--home-white);
        border: 1px solid rgba(22, 131, 79, .18);
        border-radius: 11px;
        font-size: 12px;
        font-weight: 850;
        transition: .22s ease;
    }

    .home-section-heading > a:hover {
        color: #ffffff;
        background: var(--home-green);
        transform: translateX(2px);
    }

    .home-button,
    .home-card-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 44px;
        padding: 10px 16px;
        border-radius: 12px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 850;
        transition: .22s ease;
    }

    .home-button:hover,
    .home-card-link:hover {
        transform: translateY(-2px);
    }

    .home-button-primary {
        color: #ffffff;
        background: var(--home-green);
        border: 1px solid var(--home-green);
    }

    .home-button-primary:hover {
        color: #ffffff;
        background: var(--home-green-dark);
        border-color: var(--home-green-dark);
    }

    .home-button-light {
        color: var(--home-green-dark);
        background: #ffffff;
        border: 1px solid #ffffff;
        box-shadow: 0 12px 26px rgba(0, 0, 0, .13);
    }

    .home-button-light:hover {
        color: var(--home-green-dark);
        background: #f2faf5;
    }

    .home-button-outline-light {
        color: #ffffff;
        background: rgba(255, 255, 255, .08);
        border: 1px solid rgba(255, 255, 255, .42);
    }

    .home-button-outline-light:hover {
        color: #ffffff;
        background: rgba(255, 255, 255, .16);
        border-color: rgba(255, 255, 255, .62);
    }

    .home-card-link {
        min-height: 40px;
        padding: 8px 13px;
        color: var(--home-green-dark);
        background: var(--home-green-soft);
        border: 1px solid rgba(22, 131, 79, .17);
        font-size: 12px;
    }

    .home-card-link:hover {
        color: #ffffff;
        background: var(--home-green);
        border-color: var(--home-green);
    }

    /* HERO */
    .home-hero {
        min-height: 620px;
        background: var(--home-green-dark);
    }

    .home-hero-background {
        transform: scale(1.015);
    }

    .home-hero-overlay {
        background:
            radial-gradient(
                circle at 84% 16%,
                rgba(255, 255, 255, .13),
                transparent 26%
            ),
            linear-gradient(
                90deg,
                rgba(6, 54, 29, .92) 0%,
                rgba(6, 54, 29, .74) 48%,
                rgba(6, 42, 23, .35) 100%
            );
    }

    .home-hero-content {
        min-height: 620px;
        padding-top: 48px;
        padding-bottom: 48px;
    }

    .home-hero-title {
        max-width: 790px;
        font-size: clamp(38px, 4.4vw, 60px);
        font-weight: 850;
        line-height: 1.07;
        letter-spacing: -.045em;
    }

    .home-hero-description {
        max-width: 720px;
        margin-top: 20px;
        color: rgba(255, 255, 255, .85);
        font-size: 16px;
        line-height: 1.75;
    }

    .home-hero-actions {
        gap: 12px;
        margin-top: 27px;
    }

    .home-stat-card {
        padding: 22px;
        color: var(--home-navy);
        background: rgba(255, 255, 255, .96);
        border: 1px solid rgba(255, 255, 255, .68);
        border-radius: 22px;
        box-shadow: 0 24px 64px rgba(0, 0, 0, .22);
        backdrop-filter: blur(10px);
    }

    .home-stat-heading {
        margin: 0 0 15px;
        color: var(--home-navy);
        font-size: 17px;
        font-weight: 850;
    }

    .home-stat-grid {
        gap: 12px;
    }

    .home-stat-item {
        min-height: 105px;
        padding: 16px;
        background: var(--home-bg);
        border: 1px solid var(--home-border);
        border-radius: 15px;
    }

    .home-stat-item span {
        color: var(--home-muted);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .home-stat-item strong {
        color: var(--home-green);
        font-size: 21px;
        font-weight: 850;
    }

    /* SAMBUTAN */
    .home-sambutan {
        background: linear-gradient(
            180deg,
            var(--home-green-soft),
            var(--home-white)
        );
    }

    .home-sambutan-grid {
        grid-template-columns: minmax(280px, 330px) minmax(0, 1fr) !important;
        gap: 26px !important;
    }

    .home-leader-card,
    .home-sambutan-card {
        border-color: var(--home-border);
        border-radius: 20px;
        box-shadow: 0 14px 38px rgba(18, 69, 43, .08);
    }

    .home-leader-card {
        padding: 14px;
    }

    .home-leader-photo {
        height: 340px;
        background: var(--home-green-soft);
        border-radius: 15px;
    }

    .home-leader-info h3 {
        color: var(--home-navy);
        font-size: 18px;
        font-weight: 850;
    }

    .home-leader-info p {
        color: var(--home-green);
        font-size: 12px;
        font-weight: 800;
    }

    .home-sambutan-card {
        padding: 34px 38px;
    }

    .home-sambutan-card h2 {
        font-size: clamp(27px, 2.8vw, 38px);
        line-height: 1.22;
    }

    .home-sambutan-text {
        margin-top: 19px;
        color: var(--home-muted);
        font-size: 14px;
        line-height: 1.88;
        text-align: left;
        white-space: pre-line;
    }

    /* PROFIL */
    .home-profile-grid {
        gap: clamp(36px, 4vw, 62px) !important;
    }

    .home-profile-image {
        padding: 10px;
        background: var(--home-white);
        border: 1px solid var(--home-border);
        border-radius: 21px;
        box-shadow: 0 16px 42px rgba(18, 69, 43, .10);
    }

    .home-profile-image img {
        height: 410px;
        border-radius: 14px;
    }

    .home-profile-content h2 {
        font-size: clamp(29px, 3vw, 40px);
        line-height: 1.16;
    }

    .home-title-line {
        width: 48px;
        height: 5px;
        margin-top: 12px;
        border-radius: 999px;
        background: linear-gradient(
            90deg,
            var(--home-green),
            #57bd80
        );
    }

    .home-profile-description {
        color: var(--home-muted);
        font-size: 14px;
        line-height: 1.82;
    }

    .home-profile-info {
        gap: 12px;
    }

    .home-profile-item {
        min-height: 92px;
        padding: 16px;
        border-color: var(--home-border);
        border-left-color: var(--home-green);
        border-radius: 14px;
        box-shadow: 0 8px 22px rgba(18, 69, 43, .05);
    }

    .home-profile-item span {
        color: var(--home-muted);
        font-size: 10px;
        font-weight: 800;
    }

    .home-profile-item strong {
        color: var(--home-navy);
        font-size: 15px;
    }

    /* POTENSI DAN BERITA */
    .home-potentials,
    .home-gallery {
        background: var(--home-green-soft);
    }

    .home-potential-grid,
    .home-news-grid {
        gap: 22px !important;
    }

    .home-potential-card,
    .home-news-card {
        border-color: var(--home-border);
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(19, 69, 43, .06);
        transition: .25s ease;
    }

    .home-potential-card:hover,
    .home-news-card:hover {
        transform: translateY(-5px);
        border-color: rgba(22, 131, 79, .3);
        box-shadow: 0 19px 40px rgba(19, 69, 43, .12);
    }

    .home-potential-image {
        height: auto;
        aspect-ratio: 16 / 10;
    }

    .home-news-image {
        height: auto !important;
        aspect-ratio: 16 / 9;
    }

    .home-potential-image img,
    .home-news-image img {
        transition: transform .38s ease;
    }

    .home-potential-card:hover img,
    .home-news-card:hover img {
        transform: scale(1.04);
    }

    .home-potential-badge {
        position: absolute;
        left: 14px;
        bottom: 14px;
        display: inline-flex;
        padding: 7px 10px;
        color: #ffffff;
        background: rgba(13, 97, 57, .92);
        border: 1px solid rgba(255, 255, 255, .2);
        border-radius: 999px;
        font-size: 10px;
        font-weight: 850;
        letter-spacing: .05em;
        text-transform: uppercase;
        backdrop-filter: blur(8px);
    }

    .home-potential-content,
    .home-news-content {
        min-height: 220px;
        display: flex;
        flex-direction: column;
        padding: 20px !important;
    }

    .home-potential-content h3,
    .home-news-content h3 {
        height: auto;
        color: var(--home-navy);
        font-size: 19px;
        font-weight: 850;
        line-height: 1.35;
    }

    .home-news-content h3 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .home-potential-content p,
    .home-news-content p {
        height: auto;
        display: -webkit-box;
        margin: 11px 0 18px;
        color: var(--home-muted);
        font-size: 13px;
        line-height: 1.68;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .home-news-date {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 10px;
        color: var(--home-green);
        font-size: 11px;
        font-weight: 800;
    }

    .home-news-button {
        align-self: flex-start;
        margin-top: auto;
        padding: 9px 13px;
        color: var(--home-green-dark);
        background: var(--home-green-soft);
        border: 1px solid rgba(22, 131, 79, .17);
        border-radius: 10px;
        font-size: 12px;
        font-weight: 850;
        transition: .22s ease;
    }

    .home-news-button:hover {
        color: #ffffff;
        background: var(--home-green);
        transform: translateX(2px);
    }

    /* GALERI */
    .home-gallery-grid {
        gap: 13px !important;
    }

    .home-gallery-card {
        border-color: var(--home-border);
        border-radius: 14px;
        box-shadow: 0 8px 22px rgba(17, 65, 37, .07);
        transition: .22s ease;
    }

    .home-gallery-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(17, 65, 37, .12);
    }

    .home-gallery-card img {
        transition: transform .35s ease;
    }

    .home-gallery-card:hover img {
        transform: scale(1.06);
    }

    .home-gallery-overlay {
        background: rgba(6, 54, 29, .5);
    }

    /* LOKASI */
    .home-location-grid {
        gap: 24px !important;
    }

    .home-map-card,
    .home-contact-card {
        min-height: 500px;
        border-color: var(--home-border);
        border-radius: 20px;
        box-shadow: 0 13px 36px rgba(18, 70, 40, .08);
    }

    .home-map-card iframe,
    .home-map-placeholder {
        min-height: 500px !important;
    }

    .home-map-placeholder {
        padding: 28px;
        color: var(--home-muted);
        text-align: center;
        background:
            radial-gradient(
                circle at center,
                rgba(22, 131, 79, .1),
                transparent 46%
            ),
            var(--home-green-soft);
    }

    .home-contact-card {
        padding: 30px;
    }

    .home-contact-card h2 {
        font-size: clamp(27px, 2.7vw, 36px);
        line-height: 1.2;
    }

    .home-contact-list {
        margin-top: 23px;
        gap: 11px;
    }

    .home-contact-item {
        padding: 13px 14px;
        background: var(--home-bg);
        border: 1px solid #e6eee9;
        border-radius: 13px;
    }

    .home-contact-item strong {
        color: var(--home-navy);
        font-size: 12px;
        font-weight: 850;
    }

    .home-contact-item span {
        display: block;
        color: var(--home-muted);
        font-size: 12px;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .home-map-action {
        margin-top: 20px;
    }

    /* CTA */
    .home-cta {
        padding: 58px 0;
        background:
            radial-gradient(
                circle at 88% 14%,
                rgba(255, 255, 255, .12),
                transparent 27%
            ),
            linear-gradient(
                135deg,
                var(--home-navy),
                var(--home-green-dark)
            );
    }

    .home-cta h2 {
        font-size: clamp(27px, 2.8vw, 38px);
        font-weight: 850;
        line-height: 1.2;
        letter-spacing: -.035em;
    }

    .home-cta p {
        max-width: 720px;
        margin-top: 10px;
        font-size: 14px;
        line-height: 1.72;
    }

    .home-empty {
        padding: 30px 24px;
        color: var(--home-muted);
        text-align: center;
        background: var(--home-white);
        border: 1px dashed #cbdcd2;
        border-radius: 17px;
        font-size: 13px;
    }

    /* LIGHTBOX */
    .public-lightbox-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px;
        visibility: hidden;
        opacity: 0;
        pointer-events: none;
        background: rgba(4, 20, 12, .9);
        transition: opacity .25s ease, visibility .25s ease;
    }

    .public-lightbox-modal.open {
        visibility: visible;
        opacity: 1;
        pointer-events: auto;
    }

    .public-lightbox-content {
        max-width: min(1100px, 95vw);
        max-height: 88vh;
        text-align: center;
    }

    .public-lightbox-content img {
        max-width: 100%;
        max-height: 78vh;
        display: block;
        margin: 0 auto;
        object-fit: contain;
        border-radius: 14px;
    }

    .public-lightbox-title {
        margin-top: 14px;
        color: #ffffff;
        font-size: 14px;
        font-weight: 750;
    }

    .public-lightbox-close {
        position: absolute;
        top: 20px;
        right: 24px;
        z-index: 2;
        width: 44px;
        height: 44px;
        display: grid;
        place-items: center;
        color: #ffffff;
        background: rgba(255, 255, 255, .12);
        border: 1px solid rgba(255, 255, 255, .25);
        border-radius: 50%;
        font-size: 18px;
        cursor: pointer;
    }

    @media (max-width: 991.98px) {
        .home-sambutan-grid,
        .home-profile-grid,
        .home-location-grid {
            grid-template-columns: 1fr !important;
        }

        .home-potential-grid,
        .home-news-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }

        .home-gallery-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        }

        .home-leader-card {
            width: min(100%, 430px);
            margin-inline: auto;
        }

        .home-map-card,
        .home-contact-card,
        .home-map-card iframe,
        .home-map-placeholder {
            min-height: 430px !important;
        }
    }

    @media (max-width: 767.98px) {
        .home-section {
            padding: 54px 0;
        }

        .home-section-heading {
            align-items: flex-start;
            flex-direction: column;
            margin-bottom: 25px;
        }

        .home-hero,
        .home-hero-content {
            min-height: auto;
        }

        .home-hero-content {
            padding-top: 68px;
            padding-bottom: 68px;
        }

        .home-hero-title {
            font-size: 38px;
        }

        .home-hero-description {
            font-size: 14px;
        }

        .home-stat-card {
            margin-top: 12px;
        }

        .home-profile-info,
        .home-potential-grid,
        .home-news-grid {
            grid-template-columns: 1fr !important;
        }

        .home-gallery-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }

        .home-profile-image img {
            height: 310px;
        }

        .home-sambutan-card {
            padding: 28px 24px;
        }
    }

    @media (max-width: 480px) {
        .home-section {
            padding: 46px 0;
        }

        .home-hero-content {
            padding-top: 58px;
            padding-bottom: 58px;
        }

        .home-hero-title {
            font-size: 32px;
        }

        .home-hero-actions,
        .home-cta-actions {
            display: grid;
            grid-template-columns: 1fr;
            width: 100%;
        }

        .home-button {
            width: 100%;
        }

        .home-stat-grid {
            grid-template-columns: 1fr;
        }

        .home-stat-item {
            min-height: 88px;
        }

        .home-leader-photo {
            height: 310px;
        }

        .home-gallery-grid {
            gap: 8px !important;
        }

        .home-contact-card {
            padding: 22px;
        }

        .home-map-card,
        .home-contact-card,
        .home-map-card iframe,
        .home-map-placeholder {
            min-height: 350px !important;
        }

        .public-lightbox-modal {
            padding: 15px;
        }

        .public-lightbox-close {
            top: 12px;
            right: 12px;
        }
    }
</style>


<style>
    /* =====================================================
       DATA TAMBAHAN DARI DASHBOARD ADMIN
    ===================================================== */

    .home-facility-section {
        padding: 28px 0 54px;
        background: #ffffff;
    }

    .home-facility-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .home-facility-card {
        display: flex;
        align-items: center;
        gap: 13px;
        min-height: 94px;
        padding: 17px;
        background: #ffffff;
        border: 1px solid var(--home-border, #dfe9e3);
        border-radius: 16px;
        box-shadow: 0 9px 26px rgba(18, 69, 43, 0.06);
    }

    .home-facility-icon {
        width: 43px;
        height: 43px;
        flex: 0 0 43px;
        display: grid;
        place-items: center;
        color: var(--home-green, #16834f);
        background: var(--home-green-soft, #eef7f2);
        border-radius: 13px;
        font-size: 17px;
    }

    .home-facility-card strong {
        display: block;
        color: var(--home-navy, #12251c);
        font-size: 20px;
        font-weight: 850;
        line-height: 1.15;
    }

    .home-facility-card span {
        display: block;
        margin-top: 4px;
        color: var(--home-muted, #6e7d74);
        font-size: 11px;
    }

    .home-government {
        background: #f5f8f6;
    }

    .home-government-groups {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .home-government-group {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--home-border, #dfe9e3);
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(18, 69, 43, 0.065);
    }

    .home-government-group-header {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 16px 17px;
        border-bottom: 1px solid var(--home-border, #dfe9e3);
    }

    .home-government-group-header i {
        width: 38px;
        height: 38px;
        display: grid;
        place-items: center;
        color: var(--home-green, #16834f);
        background: var(--home-green-soft, #eef7f2);
        border-radius: 11px;
    }

    .home-government-group-header h3 {
        margin: 0;
        color: var(--home-navy, #12251c);
        font-size: 15px;
        font-weight: 850;
    }

    .home-government-list {
        display: grid;
        gap: 0;
    }

    .home-government-person {
        display: grid;
        grid-template-columns: 50px minmax(0, 1fr);
        gap: 11px;
        align-items: center;
        padding: 12px 16px;
    }

    .home-government-person +
    .home-government-person {
        border-top: 1px solid #edf2ef;
    }

    .home-government-photo {
        width: 50px;
        height: 50px;
        display: grid;
        place-items: center;
        overflow: hidden;
        color: var(--home-green, #16834f);
        background: var(--home-green-soft, #eef7f2);
        border-radius: 12px;
        font-size: 18px;
        font-weight: 900;
    }

    .home-government-photo img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        object-position: center top;
    }

    .home-government-person strong {
        display: block;
        color: var(--home-navy, #12251c);
        font-size: 12px;
        font-weight: 850;
        line-height: 1.4;
    }

    .home-government-person span {
        display: block;
        margin-top: 3px;
        color: var(--home-muted, #6e7d74);
        font-size: 9px;
        line-height: 1.4;
    }

    .home-government-empty {
        padding: 24px 17px;
        color: var(--home-muted, #6e7d74);
        font-size: 11px;
        text-align: center;
    }

    .home-information {
        background: #ffffff;
    }

    .home-information-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
        align-items: start;
    }

    .home-information-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--home-border, #dfe9e3);
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(18, 69, 43, 0.065);
    }

    .home-information-card-header {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 17px 18px;
        border-bottom: 1px solid var(--home-border, #dfe9e3);
    }

    .home-information-card-header i {
        width: 40px;
        height: 40px;
        display: grid;
        place-items: center;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--home-green-dark, #0d6139),
            var(--home-green, #16834f)
        );
        border-radius: 12px;
    }

    .home-information-card-header h3 {
        margin: 0;
        color: var(--home-navy, #12251c);
        font-size: 16px;
        font-weight: 850;
    }

    .home-information-list {
        display: grid;
    }

    .home-information-item {
        padding: 15px 18px;
    }

    .home-information-item +
    .home-information-item {
        border-top: 1px solid #edf2ef;
    }

    .home-information-item h4 {
        margin: 0;
        color: var(--home-navy, #12251c);
        font-size: 13px;
        font-weight: 850;
        line-height: 1.45;
    }

    .home-information-item p {
        margin: 6px 0 0;
        color: var(--home-muted, #6e7d74);
        font-size: 10px;
        line-height: 1.6;
    }

    .home-information-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 8px;
    }

    .home-information-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 8px;
        color: var(--home-green-dark, #0d6139);
        background: var(--home-green-soft, #eef7f2);
        border-radius: 999px;
        font-size: 8px;
        font-weight: 850;
    }

    .home-social-links {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 17px;
    }

    .home-social-link {
        width: 39px;
        height: 39px;
        display: grid;
        place-items: center;
        color: var(--home-green-dark, #0d6139);
        background: var(--home-green-soft, #eef7f2);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 11px;
        text-decoration: none;
        transition:
            color 0.2s ease,
            background 0.2s ease,
            transform 0.2s ease;
    }

    .home-social-link:hover {
        color: #ffffff;
        background: var(--home-green, #16834f);
        transform: translateY(-2px);
    }

    @media (max-width: 991.98px) {
        .home-facility-grid,
        .home-government-groups {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .home-information-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767.98px) {
        .home-facility-grid,
        .home-government-groups {
            grid-template-columns: 1fr;
        }
    }

    .home-map-card iframe {
        width: 100% !important;
        height: 100% !important;
        min-height: 520px !important;
        display: block;
        border: 0 !important;
    }

    @media (max-width: 767.98px) {
        .home-map-card iframe {
            min-height: 360px !important;
        }
    }

    .home-agenda-detail-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-top: 11px;
        padding: 8px 11px;
        color: var(--home-green-dark, #0d6139);
        background: var(--home-green-soft, #eef7f2);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 9px;
        text-decoration: none;
        font-size: 9px;
        font-weight: 850;
        transition:
            color 0.2s ease,
            background 0.2s ease,
            transform 0.2s ease;
    }

    .home-agenda-detail-link:hover {
        color: #ffffff;
        background: var(--home-green, #16834f);
        transform: translateX(2px);
    }
    /* =====================================================
       TEMA HIJAU–PUTIH — FASILITAS DESA
    ===================================================== */

    .home-facility-section {
        position: relative;
        overflow: hidden;
        padding: 34px 0 56px;
        background:
            radial-gradient(
                circle at 8% 16%,
                rgba(22, 131, 79, 0.10),
                transparent 30%
            ),
            radial-gradient(
                circle at 92% 86%,
                rgba(13, 97, 57, 0.08),
                transparent 32%
            ),
            linear-gradient(
                180deg,
                #eaf5ee 0%,
                #f5faf7 48%,
                #ffffff 100%
            );
        border-top: 1px solid rgba(22, 131, 79, 0.10);
    }

    .home-facility-section::before {
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
        background-size: 36px 36px;
        pointer-events: none;
    }

    .home-facility-section::after {
        position: absolute;
        right: -90px;
        bottom: -120px;
        width: 330px;
        height: 330px;
        content: "";
        background: rgba(22, 131, 79, 0.055);
        border-radius: 50%;
        pointer-events: none;
    }

    .home-facility-section .container {
        position: relative;
        z-index: 1;
    }

    .home-facility-card {
        position: relative;
        min-height: 96px;
        overflow: hidden;
        padding: 18px;
        color: var(--home-text, #34463c);
        background:
            linear-gradient(
                145deg,
                #ffffff 0%,
                #fbfefc 100%
            );
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 17px;
        box-shadow:
            0 13px 30px rgba(16, 82, 48, 0.075),
            inset 0 1px 0 rgba(255, 255, 255, 0.9);
        transition:
            transform 0.22s ease,
            box-shadow 0.22s ease,
            border-color 0.22s ease;
    }

    .home-facility-card::before {
        position: absolute;
        top: 15px;
        bottom: 15px;
        left: 0;
        width: 4px;
        content: "";
        background:
            linear-gradient(
                180deg,
                var(--home-green, #16834f),
                var(--home-green-dark, #0d6139)
            );
        border-radius: 0 999px 999px 0;
    }

    .home-facility-card:hover {
        border-color: rgba(22, 131, 79, 0.30);
        box-shadow:
            0 18px 38px rgba(16, 82, 48, 0.12),
            inset 0 1px 0 rgba(255, 255, 255, 0.95);
        transform: translateY(-3px);
    }

    .home-facility-icon {
        color: var(--home-green, #16834f);
        background:
            linear-gradient(
                145deg,
                #e8f5ed,
                #f3faf6
            );
        border: 1px solid rgba(22, 131, 79, 0.13);
        box-shadow:
            0 8px 18px rgba(22, 131, 79, 0.08);
    }

    .home-facility-card strong {
        color: var(--home-navy, #12251c);
        text-shadow: none;
    }

    .home-facility-card span {
        color: var(--home-muted, #6e7d74);
        font-weight: 650;
    }

    .home-facility-card:nth-child(even) {
        background:
            linear-gradient(
                145deg,
                #ffffff 0%,
                #f7fcf9 100%
            );
    }

    @media (max-width: 700px) {
        .home-facility-section {
            padding: 24px 0 38px;
        }

        .home-facility-card {
            min-height: 84px;
            padding: 14px;
        }

        .home-facility-card::before {
            top: 12px;
            bottom: 12px;
            width: 3px;
        }

        .home-facility-icon {
            width: 39px;
            height: 39px;
            flex-basis: 39px;
            font-size: 15px;
        }

        .home-facility-card strong {
            font-size: 17px;
        }

        .home-facility-card span {
            font-size: 9.5px;
        }
    }

</style>

@endpush


<style>
    /* =====================================================
       BERITA ANDROID — HORIZONTAL, RINGKAS, DAN SERAGAM
    ===================================================== */

    .home-news-image {
        position: relative;
    }

    .home-news-image-fallback {
        width: 100%;
        height: 100%;
        display: grid;
        place-items: center;
        color: var(--home-green);
        background:
            linear-gradient(
                145deg,
                #edf7f1,
                #e5f1e9
            );
        font-size: 28px;
    }

    .home-news-image-fallback[hidden] {
        display: none !important;
    }

    .home-news-image.is-image-missing {
        border-right: 1px solid var(--home-border);
    }

    @media (max-width: 767.98px) {
        .home-news {
            padding-top: 42px !important;
            padding-bottom: 42px !important;
        }

        .home-news .home-section-heading {
            margin-bottom: 18px !important;
        }

        .home-news-grid {
            display: grid !important;
            grid-template-columns: 1fr !important;
            gap: 12px !important;
        }

        .home-news-card {
            min-height: 150px !important;
            display: grid !important;
            grid-template-columns: 124px minmax(0, 1fr) !important;
            overflow: hidden !important;
            border-radius: 15px !important;
        }

        .home-news-image {
            width: 124px !important;
            height: 100% !important;
            min-height: 150px !important;
            aspect-ratio: auto !important;
            border-radius: 0 !important;
        }

        .home-news-image img {
            width: 100% !important;
            height: 100% !important;
            min-height: 150px !important;
            object-fit: cover !important;
            object-position: center !important;
            color: transparent !important;
            font-size: 0 !important;
        }

        .home-news-content {
            min-width: 0 !important;
            min-height: 150px !important;
            padding: 13px 14px !important;
        }

        .home-news-date {
            margin-bottom: 5px !important;
            font-size: 8.5px !important;
        }

        .home-news-content h3 {
            height: auto !important;
            display: -webkit-box !important;
            margin: 0 0 6px !important;
            overflow: hidden !important;
            font-size: 13px !important;
            line-height: 1.35 !important;
            -webkit-box-orient: vertical !important;
            -webkit-line-clamp: 2 !important;
        }

        .home-news-content p {
            height: auto !important;
            display: -webkit-box !important;
            margin: 0 0 8px !important;
            overflow: hidden !important;
            font-size: 9.5px !important;
            line-height: 1.5 !important;
            -webkit-box-orient: vertical !important;
            -webkit-line-clamp: 2 !important;
        }

        .home-news-button {
            margin-top: auto !important;
            padding: 6px 9px !important;
            border-radius: 8px !important;
            font-size: 8.5px !important;
        }

        .home-news-card:hover {
            transform: none !important;
        }

        .home-news-card:hover img {
            transform: none !important;
        }
    }

    @media (max-width: 420px) {
        .home-news-card {
            min-height: 138px !important;
            grid-template-columns: 102px minmax(0, 1fr) !important;
        }

        .home-news-image {
            width: 102px !important;
            min-height: 138px !important;
        }

        .home-news-image img {
            min-height: 138px !important;
        }

        .home-news-content {
            min-height: 138px !important;
            padding: 11px 12px !important;
        }

        .home-news-content h3 {
            font-size: 12px !important;
        }

        .home-news-content p {
            font-size: 8.8px !important;
        }
    }
</style>

@section('content')

@php
    /*
     * Pembagian gambar:
     * - hero_image   : banner utama halaman Beranda
     * - cover_image  : gambar sampul bagian profil desa
     * - office_photo : khusus bagian Kantor Desa di halaman Profil
     */
    $imageVersion = $profile?->updated_at?->timestamp
        ?? time();

    $heroImagePath = $profile?->hero_image
        ?? $profile?->cover_image
        ?? $profile?->office_photo;

    $coverImagePath = $profile?->cover_image
        ?? $profile?->hero_image
        ?? $profile?->office_photo;

    $heroImage = filled($heroImagePath)
        ? asset(
            'storage/' .
            ltrim($heroImagePath, '/')
        ) . '?v=' . $imageVersion
        : asset('images/transparent.png');

    $coverImage = filled($coverImagePath)
        ? asset(
            'storage/' .
            ltrim($coverImagePath, '/')
        ) . '?v=' . $imageVersion
        : asset('images/transparent.png');

    $headPhoto = !empty($headOfficial?->foto)
        ? asset(
            'storage/' .
            ltrim($headOfficial->foto, '/')
        )
        : asset('images/transparent.png');

    $officialList = collect($officials ?? []);
    $bpdList = collect($bpds ?? []);
    $institutionList = collect($institutions ?? []);
    $announcementList = collect($announcements ?? []);
    $agendaList = collect($agendas ?? []);

    $villageName = $profile?->nama_desa
        ?? 'Desa Bakal Dalam';

    $mottoDesa = trim(
        (string) ($visionMission?->motto ?? '')
    );

    /*
     * Seluruh informasi kontak publik hanya berasal dari menu
     * Admin > Kontak Desa. Identitas Desa tidak lagi menjadi fallback.
     */
    $contactData = $contact
        ?? \App\Models\Contact::query()
            ->orderBy('id')
            ->first();

    $googleMaps = $contactData?->google_maps;

    $googleMapsEmbed =
        $contactData?->google_maps_embed;

    /*
     * Ambil URL src iframe agar peta dapat ditampilkan secara stabil.
     */
    $homeMapEmbedSrc = null;

    if (filled($googleMapsEmbed)) {
        $decodedHomeEmbed = html_entity_decode(
            $googleMapsEmbed,
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        );

        if (preg_match(
            '/src=["\\\']([^"\\\']+)["\\\']/i',
            $decodedHomeEmbed,
            $homeMapMatches
        )) {
            $homeMapEmbedSrc = $homeMapMatches[1];
        } elseif (
            filter_var(
                trim($decodedHomeEmbed),
                FILTER_VALIDATE_URL
            )
        ) {
            $homeMapEmbedSrc = trim($decodedHomeEmbed);
        }
    }

    $governmentUrl =
        \Illuminate\Support\Facades\Route::has('public.government')
            ? route('public.government')
            : url('/pemerintahan');
@endphp

<div class="home-page">

{{-- HERO --}}
<section id="hero" class="home-hero">
    <div
        class="home-hero-background"
        style="background-image: url('{{ $heroImage }}');"
    ></div>

    <div class="home-hero-overlay"></div>

    <div class="container home-hero-content">
        <div class="row align-items-center g-4 w-100">
            <div class="col-lg-7">
                <span class="home-section-label is-light">
                    {{ $profile?->nama_desa ?? 'Desa Bakal Dalam' }}
                </span>

                <h1 class="home-hero-title">
                    Membangun
                    {{ $profile?->nama_desa ?? 'Desa Bakal Dalam' }}
                    Menuju Desa Mandiri dan Sejahtera
                </h1>

                <p class="home-hero-description">
                    {{ $profile?->village_slogan
                        ?? 'Desa Bakal Dalam bekerja sama mewujudkan kesejahteraan masyarakat dan pelayanan publik yang profesional.'
                    }}
                </p>

                @if(filled($mottoDesa))
                    <div class="home-hero-motto">
                        <i class="bi bi-quote"></i>

                        <span>
                            <strong>Motto Desa:</strong>
                            “{{ $mottoDesa }}”
                        </span>
                    </div>
                @endif

                <div class="home-hero-actions">
                    <a
                        href="{{ url('/#tentang') }}"
                        class="home-button home-button-light"
                    >
                        Jelajahi Desa
                    </a>

                    <a
                        href="{{ url('/#lokasi') }}"
                        class="home-button home-button-outline-light"
                    >
                        Hubungi Kami
                    </a>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="home-stat-card">
                    <h2 class="home-stat-heading">
                        Statistik Utama
                    </h2>

                    <div class="home-stat-grid">
                        <div class="home-stat-item">
                            <span>Jumlah Penduduk</span>

                            <strong>
                                {{ number_format(
                                    $statistics?->jumlah_penduduk ?? 0,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </strong>
                        </div>

                        <div class="home-stat-item">
                            <span>Jumlah KK</span>

                            <strong>
                                {{ number_format(
                                    $statistics?->jumlah_kk ?? 0,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </strong>
                        </div>

                        <div class="home-stat-item">
                            <span>Jumlah Dusun</span>

                            <strong>
                                {{ number_format(
                                    $statistics?->jumlah_dusun ?? 0,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </strong>
                        </div>

                        <div class="home-stat-item">
                            <span>Luas Wilayah</span>

                            <strong>
                                {{ $statistics?->luas_wilayah
                                    ? $statistics->luas_wilayah . ' ha'
                                    : '—'
                                }}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- FASILITAS UMUM --}}
<section class="home-facility-section">
    <div class="container">

        <div class="home-facility-grid">

            @foreach([
                [
                    'icon' => 'bi-mortarboard-fill',
                    'value' => $statistics?->jumlah_sekolah,
                    'label' => 'Sekolah',
                ],
                [
                    'icon' => 'bi-moon-stars-fill',
                    'value' => $statistics?->jumlah_masjid,
                    'label' => 'Masjid',
                ],
                [
                    'icon' => 'bi-heart-pulse-fill',
                    'value' => $statistics?->jumlah_posyandu,
                    'label' => 'Posyandu',
                ],
                [
                    'icon' => 'bi-shop',
                    'value' => $statistics?->jumlah_umkm,
                    'label' => 'UMKM',
                ],
            ] as $facility)

                <article class="home-facility-card">

                    <span class="home-facility-icon">
                        <i class="bi {{ $facility['icon'] }}"></i>
                    </span>

                    <div>
                        <strong>
                            {{ number_format(
                                (float) ($facility['value'] ?? 0),
                                0,
                                ',',
                                '.'
                            ) }}
                        </strong>

                        <span>
                            Jumlah {{ $facility['label'] }}
                        </span>
                    </div>

                </article>

            @endforeach

        </div>

    </div>
</section>

{{-- SAMBUTAN --}}
<section id="sambutan" class="home-section home-sambutan">
    <div class="container">
        <div class="home-sambutan-grid">
            <article class="home-leader-card">
                <div class="home-leader-photo">
                    <img
                        src="{{ $headPhoto }}"
                        alt="{{ $headOfficial?->nama ?? 'Kepala Desa' }}"
                    >
                </div>

                <div class="home-leader-info">
                    <h3>
                        {{ $headOfficial?->nama ?? 'Kepala Desa' }}
                    </h3>

                    <p>
                        {{ $headOfficial?->jabatan ?? 'Kepala Desa' }}
                    </p>
                </div>
            </article>

            <article class="home-sambutan-card">
                <span class="home-section-label">
                    Sambutan Kepala Desa
                </span>

                <h2>
                    Selamat Datang di Website Resmi
                    {{ $profile?->nama_desa ?? 'Desa Bakal Dalam' }}
                </h2>

                <div class="home-sambutan-text">
                    {{ filled($headOfficial?->kata_sambutan)
                        ? $headOfficial->kata_sambutan
                        : 'Sambutan Kepala Desa belum tersedia.'
                    }}
                </div>

                <div class="home-sambutan-action">
                    <a
                        href="{{ url('/#tentang') }}"
                        class="home-card-link"
                    >
                        Selengkapnya
                    </a>
                </div>
            </article>
        </div>
    </div>
</section>

{{-- PROFIL --}}
<section id="tentang" class="home-section home-profile">
    <div class="container">
        <div class="home-profile-grid">
            <div class="home-profile-image">
                <img
                    src="{{ $coverImage }}"
                    alt="Sampul profil {{ $profile?->nama_desa ?? 'Desa Bakal Dalam' }}"
                    loading="lazy"
                >
            </div>

            <div class="home-profile-content">
                <span class="home-section-label">
                    Tentang Desa
                </span>

                <h2>
                    Profil {{ $profile?->nama_desa ?? 'Desa Bakal Dalam' }}
                </h2>

                <div class="home-title-line"></div>

                <p class="home-profile-description">
                    {{ $profile?->deskripsi
                        ?? $profile?->tentang_desa
                        ?? $profile?->profil_singkat
                        ?? $profile?->alamat
                        ?? 'Informasi profil desa belum tersedia.'
                    }}
                </p>

                <div class="home-profile-info">
                    <div class="home-profile-item">
                        <span>Nama Desa</span>
                        <strong>
                            {{ $profile?->nama_desa ?? 'Desa Bakal Dalam' }}
                        </strong>
                    </div>

                    <div class="home-profile-item">
                        <span>Kecamatan</span>
                        <strong>
                            {{ $profile?->kecamatan ?? 'Talo Kecil' }}
                        </strong>
                    </div>

                    <div class="home-profile-item">
                        <span>Kabupaten</span>
                        <strong>
                            {{ $profile?->kabupaten ?? 'Seluma' }}
                        </strong>
                    </div>

                    <div class="home-profile-item">
                        <span>Provinsi</span>
                        <strong>
                            {{ $profile?->provinsi ?? 'Bengkulu' }}
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- PEMERINTAHAN DAN KELEMBAGAAN --}}
<section class="home-section home-government">
    <div class="container">

        <div class="home-section-heading">

            <div>
                <span class="home-section-label">
                    Pemerintahan Desa
                </span>

                <h2>
                    Aparatur dan Kelembagaan Desa
                </h2>
            </div>

            <a href="{{ $governmentUrl }}">
                Lihat Selengkapnya
                <i class="bi bi-chevron-right"></i>
            </a>

        </div>

        <div class="home-government-groups">

            <article class="home-government-group">

                <div class="home-government-group-header">
                    <i class="bi bi-person-badge"></i>
                    <h3>Aparat Desa</h3>
                </div>

                @if($officialList->isEmpty())

                    <div class="home-government-empty">
                        Data aparat desa belum tersedia.
                    </div>

                @else

                    <div class="home-government-list">

                        @foreach($officialList->take(4) as $official)

                            @php
                                $officialPhoto = filled($official->foto)
                                    ? asset(
                                        'storage/' .
                                        ltrim($official->foto, '/')
                                    )
                                    : null;
                            @endphp

                            <div class="home-government-person">

                                <div class="home-government-photo">

                                    @if($officialPhoto)
                                        <img
                                            src="{{ $officialPhoto }}"
                                            alt="{{ $official->nama }}"
                                            loading="lazy"
                                        >
                                    @else
                                        {{ strtoupper(
                                            mb_substr(
                                                $official->nama ?? 'A',
                                                0,
                                                1
                                            )
                                        ) }}
                                    @endif

                                </div>

                                <div>
                                    <strong>{{ $official->nama }}</strong>
                                    <span>{{ $official->jabatan }}</span>
                                </div>

                            </div>

                        @endforeach

                    </div>

                @endif

            </article>

            <article class="home-government-group">

                <div class="home-government-group-header">
                    <i class="bi bi-people-fill"></i>
                    <h3>BPD</h3>
                </div>

                @if($bpdList->isEmpty())

                    <div class="home-government-empty">
                        Data BPD belum tersedia.
                    </div>

                @else

                    <div class="home-government-list">

                        @foreach($bpdList->take(4) as $bpd)

                            @php
                                $bpdPhoto = filled($bpd->foto)
                                    ? asset(
                                        'storage/' .
                                        ltrim($bpd->foto, '/')
                                    )
                                    : null;
                            @endphp

                            <div class="home-government-person">

                                <div class="home-government-photo">

                                    @if($bpdPhoto)
                                        <img
                                            src="{{ $bpdPhoto }}"
                                            alt="{{ $bpd->nama }}"
                                            loading="lazy"
                                        >
                                    @else
                                        {{ strtoupper(
                                            mb_substr(
                                                $bpd->nama ?? 'B',
                                                0,
                                                1
                                            )
                                        ) }}
                                    @endif

                                </div>

                                <div>
                                    <strong>{{ $bpd->nama }}</strong>
                                    <span>{{ $bpd->jabatan }}</span>
                                </div>

                            </div>

                        @endforeach

                    </div>

                @endif

            </article>

            <article class="home-government-group">

                <div class="home-government-group-header">
                    <i class="bi bi-diagram-3-fill"></i>
                    <h3>Lembaga Desa</h3>
                </div>

                @if($institutionList->isEmpty())

                    <div class="home-government-empty">
                        Data lembaga desa belum tersedia.
                    </div>

                @else

                    <div class="home-government-list">

                        @foreach($institutionList->take(4) as $institution)

                            @php
                                $institutionPhoto = filled($institution->foto)
                                    ? asset(
                                        'storage/' .
                                        ltrim($institution->foto, '/')
                                    )
                                    : null;
                            @endphp

                            <div class="home-government-person">

                                <div class="home-government-photo">

                                    @if($institutionPhoto)
                                        <img
                                            src="{{ $institutionPhoto }}"
                                            alt="{{ $institution->nama }}"
                                            loading="lazy"
                                        >
                                    @else
                                        {{ strtoupper(
                                            mb_substr(
                                                $institution->nama ?? 'L',
                                                0,
                                                1
                                            )
                                        ) }}
                                    @endif

                                </div>

                                <div>
                                    <strong>{{ $institution->nama }}</strong>
                                    <span>{{ $institution->jabatan }}</span>
                                </div>

                            </div>

                        @endforeach

                    </div>

                @endif

            </article>

        </div>

    </div>
</section>

{{-- POTENSI --}}
<section id="potensi" class="home-section home-potentials">
    <div class="container">
        <div class="home-section-heading">
            <div>
                <span class="home-section-label">
                    Potensi Desa
                </span>

                <h2>
                    Eksplorasi Potensi Unggulan Desa
                </h2>
            </div>

            <a href="{{ route('public.potentials') }}">
                Lihat Semua Potensi
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>

        @if($potentials->isEmpty())
            <div class="home-empty">Belum ada data potensi desa.</div>
        @else
            <div class="home-potential-grid">
                @foreach($potentials->take(3) as $potential)
                    @php
                        $potentialImage = !empty($potential->gambar)
                            ? asset('storage/' . $potential->gambar)
                            : asset('images/transparent.png');

                        $potentialUrl =
                            \Illuminate\Support\Facades\Route::has(
                                'public.potentials.show'
                            )
                                ? route(
                                    'public.potentials.show',
                                    $potential
                                )
                                : url('/#potensi');
                    @endphp

                    <article class="home-potential-card">
                        <div class="home-potential-image">
                            <img
                                src="{{ $potentialImage }}"
                                alt="{{ $potential->nama }}"
                            >

                            @if(!empty($potential->kategori))
                                <span class="home-potential-badge">
                                    {{ $potential->kategori }}
                                </span>
                            @endif
                        </div>

                        <div class="home-potential-content">
                            <h3>{{ $potential->nama }}</h3>

                            <p>
                                {{ \Illuminate\Support\Str::limit(
                                    $potential->excerpt
                                        ?? 'Informasi potensi desa.',
                                    100
                                ) }}
                            </p>

                    <a
                                href="{{ $potentialUrl }}"
                                class="home-card-link"
                            >
                                Lihat Detail
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- BERITA --}}
<section id="berita" class="home-section home-news">
    <div class="container">
        <div class="home-section-heading">
            <div>
                <span class="home-section-label">
                    Berita Terbaru
                </span>

                <h2>
                    Informasi dan Kegiatan Desa
                </h2>
            </div>

            <a href="{{ route('public.news') }}">
                Lihat Semua Berita
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>

        @if($news->isEmpty())
            <div class="home-empty">Belum ada berita publik terbaru.</div>
        @else
            <div class="home-news-grid">
                @foreach($news->take(3) as $item)
                    @php
                        $newsImage = !empty($item->gambar)
                            ? asset('storage/' . $item->gambar)
                            : asset('images/transparent.png');

                        $newsUrl =
                            \Illuminate\Support\Facades\Route::has(
                                'public.news.show'
                            )
                                ? route('public.news.show', $item)
                                : url('/#berita');
                    @endphp

                    <article class="home-news-card">
                        <a
                            href="{{ $newsUrl }}"
                            class="home-news-image"
                        >
                            <img
                                src="{{ $newsImage }}"
                                alt=""
                                loading="lazy"
                                onerror="
                                    this.hidden = true;
                                    this.nextElementSibling.hidden = false;
                                    this.parentElement.classList.add(
                                        'is-image-missing'
                                    );
                                "
                            >

                            <span
                                class="home-news-image-fallback"
                                hidden
                            >
                                <i class="bi bi-newspaper"></i>
                            </span>
                        </a>

                        <div class="home-news-content">
                            <span class="home-news-date">
                                {{ $item->published_at
                                    ? $item->published_at->translatedFormat(
                                        'd F Y'
                                    )
                                    : 'Tanggal tidak tersedia'
                                }}
                            </span>

                            <h3>
                                <a href="{{ $newsUrl }}">
                                    {{ $item->judul }}
                                </a>
                            </h3>

                            <p>
                                {{ \Illuminate\Support\Str::limit(
                                    $item->excerpt
                                        ?? 'Informasi berita desa.',
                                    90
                                ) }}
                            </p>

                            <a
                                href="{{ $newsUrl }}"
                                class="home-news-button"
                            >
                                Baca Selengkapnya
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>


{{-- PENGUMUMAN DAN AGENDA --}}
<section class="home-section home-information">
    <div class="container">

        <div class="home-section-heading">

            <div>
                <span class="home-section-label">
                    Informasi Masyarakat
                </span>

                <h2>
                    Pengumuman dan Agenda Desa
                </h2>
            </div>

        </div>

        <div class="home-information-grid">

            <article class="home-information-card">

                <div class="home-information-card-header">
                    <i class="bi bi-megaphone-fill"></i>
                    <h3>Pengumuman Terbaru</h3>
                </div>

                @if($announcementList->isEmpty())

                    <div class="home-government-empty">
                        Belum ada pengumuman publik.
                    </div>

                @else

                    <div class="home-information-list">

                        @foreach($announcementList->take(4) as $announcement)

                            <div class="home-information-item">

                                <h4>{{ $announcement->judul }}</h4>

                                @if(filled($announcement->ringkasan))
                                    <p>
                                        {{ \Illuminate\Support\Str::limit(
                                            strip_tags(
                                                $announcement->ringkasan
                                            ),
                                            135
                                        ) }}
                                    </p>
                                @endif

                                <div class="home-information-meta">

                                    <span class="home-information-pill">
                                        <i class="bi bi-calendar3"></i>

                                        {{ $announcement->published_at
                                            ? $announcement
                                                ->published_at
                                                ->locale('id')
                                                ->translatedFormat('d M Y')
                                            : $announcement
                                                ->created_at
                                                ?->locale('id')
                                                ?->translatedFormat('d M Y')
                                        }}
                                    </span>

                                    @if(filled($announcement->lampiran))
                                        <a
                                            href="{{ asset(
                                                'storage/' .
                                                ltrim(
                                                    $announcement->lampiran,
                                                    '/'
                                                )
                                            ) }}"
                                            target="_blank"
                                            rel="noopener"
                                            class="home-information-pill"
                                        >
                                            <i class="bi bi-paperclip"></i>
                                            Lampiran
                                        </a>
                                    @endif

                                </div>

                            </div>

                        @endforeach

                    </div>

                @endif

            </article>

            <article class="home-information-card">

                <div class="home-information-card-header">
                    <i class="bi bi-calendar-event-fill"></i>
                    <h3>Agenda Desa</h3>
                </div>

                @if($agendaList->isEmpty())

                    <div class="home-government-empty">
                        Belum ada agenda publik.
                    </div>

                @else

                    <div class="home-information-list">

                        @foreach($agendaList->take(4) as $agenda)

                            <div class="home-information-item">

                                <h4>{{ $agenda->judul }}</h4>

                                @if(filled($agenda->deskripsi))
                                    <p>
                                        {{ \Illuminate\Support\Str::limit(
                                            strip_tags($agenda->deskripsi),
                                            135
                                        ) }}
                                    </p>
                                @endif

                                <div class="home-information-meta">

                                    <span class="home-information-pill">
                                        <i class="bi bi-calendar3"></i>
                                        {{ $agenda
                                            ->tanggal_mulai
                                            ->locale('id')
                                            ->translatedFormat('d M Y')
                                        }}
                                    </span>

                                    @if(filled($agenda->waktu))
                                        <span class="home-information-pill">
                                            <i class="bi bi-clock"></i>
                                            {{ $agenda->waktu }}
                                        </span>
                                    @endif

                                    @if(filled($agenda->lokasi))
                                        <span class="home-information-pill">
                                            <i class="bi bi-geo-alt"></i>
                                            {{ $agenda->lokasi }}
                                        </span>
                                    @endif

                                </div>

                                <a
                                    href="{{ route(
                                        'public.agenda.detail',
                                        $agenda
                                    ) }}"
                                    class="home-agenda-detail-link"
                                >
                                    Lihat Selengkapnya
                                    <i class="bi bi-arrow-right"></i>
                                </a>

                            </div>

                        @endforeach

                    </div>

                @endif

            </article>

        </div>

    </div>
</section>

{{-- GALERI --}}
<section id="galeri" class="home-section home-gallery">
    <div class="container">
        <div class="home-section-heading">
            <div>
                <span class="home-section-label">
                    Galeri Desa
                </span>

                <h2>
                    Potret Kegiatan dan Lingkungan Desa
                </h2>
            </div>

            <a href="{{ route('public.galleries') }}">
                Lihat Semua Galeri
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>

        @if($galleries->isEmpty())
            <div class="home-empty">Belum ada foto galeri.</div>
        @else
            <div class="home-gallery-grid">
                @foreach($galleries->take(5) as $gallery)
                    @php
                        $galleryImage = !empty($gallery->gambar)
                            ? asset('storage/' . $gallery->gambar)
                            : asset('images/transparent.png');
                    @endphp

                    <figure class="home-gallery-card">
                        <a
                            href="{{ $galleryImage }}"
                            class="public-lightbox"
                            data-title="{{ $gallery->judul }}"
                        >
                            <img
                                src="{{ $galleryImage }}"
                                alt="{{ $gallery->judul }}"
                                loading="lazy"
                            >

                            <span class="home-gallery-overlay">
                                <i class="bi bi-zoom-in"></i>
                            </span>
                        </a>
                    </figure>
                @endforeach
            </div>

            <div
                id="public-lightbox"
                class="public-lightbox-modal"
                aria-hidden="true"
            >
                <button
                    type="button"
                    class="public-lightbox-close"
                    aria-label="Tutup"
                >
                    <i class="bi bi-x-lg"></i>
                </button>

                <div class="public-lightbox-content">
                    <img id="public-lightbox-img" alt="">

                    <div
                        id="public-lightbox-title"
                        class="public-lightbox-title"
                    ></div>
                </div>
            </div>
        @endif
    </div>
</section>

{{-- LOKASI --}}
<section id="lokasi" class="home-section home-location">
    <div class="container">
        <div class="home-location-grid">
            <div class="home-map-card">
                @if(filled($homeMapEmbedSrc))

                    <iframe
                        src="{{ $homeMapEmbedSrc }}"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Peta lokasi kantor desa"
                    ></iframe>

                @elseif(filled($googleMapsEmbed))

                    {!! $googleMapsEmbed !!}

                @else

                    <div class="home-map-placeholder">
                        Peta Google Maps belum tersedia.
                    </div>

                @endif
            </div>

            <div class="home-contact-card">
                <span class="home-section-label">
                    Lokasi Desa
                </span>

                <h2>
                    Alamat Kantor
                    {{ $profile?->nama_desa ?? 'Desa Bakal Dalam' }}
                </h2>

                <div class="home-contact-list">
                    <div class="home-contact-item">
                        <strong>Alamat</strong>

                        <span>
                            {{ $contactData?->alamat
                                ?? 'Alamat belum tersedia'
                            }}
                        </span>
                    </div>

                    <div class="home-contact-item">
                        <strong>Telepon</strong>
                        <span>{{ $contactData?->telepon ?? '-' }}</span>
                    </div>

                    <div class="home-contact-item">
                        <strong>WhatsApp</strong>
                        <span>{{ $contactData?->whatsapp ?? '-' }}</span>
                    </div>

                    <div class="home-contact-item">
                        <strong>Email</strong>
                        <span>{{ $contactData?->email ?? '-' }}</span>
                    </div>

                    <div class="home-contact-item">
                        <strong>Jam Pelayanan</strong>
                        <span>{{ $contactData?->jam_operasional ?? '-' }}</span>
                    </div>

                    @if(filled($contactData?->website))
                        <div class="home-contact-item">
                            <strong>Website</strong>
                            <span>{{ $contactData->website }}</span>
                        </div>
                    @endif

                </div>

                @php
                    $homeSocials = [
                        ['field' => 'facebook', 'icon' => 'bi-facebook'],
                        ['field' => 'instagram', 'icon' => 'bi-instagram'],
                        ['field' => 'youtube', 'icon' => 'bi-youtube'],
                        ['field' => 'tiktok', 'icon' => 'bi-tiktok'],
                    ];
                @endphp

                <div class="home-social-links">
                    @foreach($homeSocials as $social)
                        @if(filled(data_get($contactData, $social['field'])))
                            <a
                                href="{{ data_get(
                                    $contact,
                                    $social['field']
                                ) }}"
                                target="_blank"
                                rel="noopener"
                                class="home-social-link"
                                aria-label="{{ ucfirst(
                                    $social['field']
                                ) }}"
                            >
                                <i class="bi {{ $social['icon'] }}"></i>
                            </a>
                        @endif
                    @endforeach
                </div>

                @if(filled($googleMaps))
                    <a
                        href="{{ $googleMaps }}"
                        target="_blank"
                        rel="noopener"
                        class="home-button home-button-primary home-map-action"
                    >
                        Buka Google Maps
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="home-cta">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <h2>
                    Bersama Membangun Desa Bakal Dalam
                </h2>

                <p>
                    Mari berkontribusi dalam pembangunan desa melalui ide,
                    dukungan, dan partisipasi aktif untuk meningkatkan
                    pelayanan serta kesejahteraan warga.
                </p>
            </div>

            <div class="col-lg-4 d-flex flex-wrap gap-3 justify-content-lg-end home-cta-actions">
                <a
                    href="{{ route('public.contact') }}"
                    class="home-button home-button-light"
                >
                    Hubungi Pemerintah Desa
                </a>

                <a
                    href="{{ route('public.potentials') }}"
                    class="home-button home-button-outline-light"
                >
                    Lihat Potensi Desa
                </a>
            </div>
        </div>
    </div>
</section>

</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('public-lightbox');

        if (!modal) {
            return;
        }

        const image = document.getElementById('public-lightbox-img');
        const title = document.getElementById('public-lightbox-title');
        const closeButton = modal.querySelector(
            '.public-lightbox-close'
        );

        function openLightbox(source, imageTitle) {
            if (image) {
                image.src = source;
            }

            if (title) {
                title.textContent = imageTitle || '';
            }

            modal.classList.add('open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            modal.classList.remove('open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';

            if (image) {
                image.src = '';
            }

            if (title) {
                title.textContent = '';
            }
        }

        document
            .querySelectorAll('.public-lightbox')
            .forEach(function (link) {
                link.addEventListener('click', function (event) {
                    event.preventDefault();

                    openLightbox(
                        this.getAttribute('href'),
                        this.getAttribute('data-title')
                    );
                });
            });

        closeButton?.addEventListener('click', closeLightbox);

        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
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