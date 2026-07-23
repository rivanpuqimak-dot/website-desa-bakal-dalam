<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    @php
        $siteSettings = $settings
            ?? \App\Models\Setting::query()->first();

        $siteProfile = $profile
            ?? \App\Models\VillageProfile::query()->first();

        $siteContact = $contact
            ?? \App\Models\Contact::query()->first();

        $siteName = trim(
            (string) (
                $siteSettings?->nama_website
                ?: $siteProfile?->nama_desa
                ?: config(
                    'seo.site_name',
                    'Website Resmi Desa Bakal Dalam'
                )
            )
        );

        $siteMetaTitle = trim(
            (string) (
                $siteSettings?->meta_title
                ?: config(
                    'seo.default_title',
                    $siteName
                )
            )
        );

        $sectionTitle = html_entity_decode(
            trim($__env->yieldContent('title')),
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        );

        $documentTitle = $sectionTitle !== ''
            && mb_strtolower($sectionTitle)
                !== mb_strtolower($siteMetaTitle)
            ? $sectionTitle . ' | ' . $siteMetaTitle
            : $siteMetaTitle;

        $sectionDescription = trim(
            $__env->yieldContent('meta_description')
        );

        $siteDescription = $sectionDescription !== ''
            ? $sectionDescription
            : trim(
                (string) (
                    $siteSettings?->meta_description
                    ?: $siteSettings?->slogan
                    ?: config(
                        'seo.default_description',
                        'Website resmi Pemerintah Desa Bakal Dalam.'
                    )
                )
            );

        $siteKeywords = trim(
            (string) ($siteSettings?->meta_keywords ?? '')
        );

        $siteFaviconUrl = filled($siteSettings?->favicon)
            ? asset(
                'storage/' .
                ltrim($siteSettings->favicon, '/')
            ) . '?v=' . (
                $siteSettings->updated_at?->timestamp
                ?? time()
            )
            : asset('favicon.ico');

        $siteLogoPath = $siteSettings?->logo
            ?? $siteProfile?->logo;

        $siteLogoUrl = filled($siteLogoPath)
            ? asset(
                'storage/' .
                ltrim($siteLogoPath, '/')
            ) . '?v=' . (
                $siteSettings?->updated_at?->timestamp
                ?? $siteProfile?->updated_at?->timestamp
                ?? time()
            )
            : null;

        $siteSocialImagePath =
            $siteSettings?->logo
            ?? $siteProfile?->cover_image
            ?? $siteProfile?->hero_image
            ?? $siteProfile?->logo;

        $siteSocialImageUrl = filled($siteSocialImagePath)
            ? asset(
                'storage/' .
                ltrim($siteSocialImagePath, '/')
            )
            : null;

        $canonicalBaseUrl = rtrim(
            (string) config(
                'seo.canonical_url',
                'https://desabakaldalam.web.id'
            ),
            '/'
        );

        $requestPath = trim(
            request()->path(),
            '/'
        );

        $canonicalUrl = $requestPath === ''
            ? $canonicalBaseUrl
            : $canonicalBaseUrl . '/' . $requestPath;

        $googleSiteVerification = trim(
            (string) config(
                'seo.google_site_verification',
                ''
            )
        );


        $organizationSameAs = collect([
            $siteContact?->facebook,
            $siteContact?->instagram,
            $siteContact?->youtube,
            $siteContact?->tiktok,
        ])
            ->filter(fn ($url) => filled($url))
            ->values()
            ->all();

        $organizationSchema = array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'GovernmentOrganization',
            '@id' => $canonicalBaseUrl . '/#organization',
            'name' => $siteName,
            'alternateName' => 'Pemerintah Desa Bakal Dalam',
            'url' => $canonicalBaseUrl . '/',
            'logo' => $siteLogoUrl,
            'image' => $siteSocialImageUrl,
            'description' => $siteDescription,
            'email' => $siteContact?->email,
            'telephone' => $siteContact?->telepon
                ?: $siteContact?->whatsapp,
            'address' => array_filter([
                '@type' => 'PostalAddress',
                'streetAddress' => $siteContact?->alamat,
                'addressLocality' => $siteProfile?->nama_desa
                    ?: 'Desa Bakal Dalam',
                'addressRegion' => $siteProfile?->provinsi
                    ?: 'Bengkulu',
                'postalCode' => $siteProfile?->kode_pos,
                'addressCountry' => 'ID',
            ]),
            'geo' => filled($siteProfile?->latitude)
                && filled($siteProfile?->longitude)
                ? [
                    '@type' => 'GeoCoordinates',
                    'latitude' => (string) $siteProfile->latitude,
                    'longitude' => (string) $siteProfile->longitude,
                ]
                : null,
            'sameAs' => $organizationSameAs ?: null,
        ]);

        $websiteSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => $canonicalBaseUrl . '/#website',
            'url' => $canonicalBaseUrl . '/',
            'name' => $siteName,
            'alternateName' => 'Website Resmi Desa Bakal Dalam',
            'description' => $siteDescription,
            'inLanguage' => 'id-ID',
            'publisher' => [
                '@id' =>
                    $canonicalBaseUrl . '/#organization',
            ],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' =>
                        $canonicalBaseUrl .
                        '/cari?q={search_term_string}',
                ],
                'query-input' =>
                    'required name=search_term_string',
            ],
        ];

        $webPageSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            '@id' => $canonicalUrl . '#webpage',
            'url' => $canonicalUrl,
            'name' => $documentTitle,
            'description' => $siteDescription,
            'inLanguage' => 'id-ID',
            'isPartOf' => [
                '@id' =>
                    $canonicalBaseUrl . '/#website',
            ],
            'about' => [
                '@id' =>
                    $canonicalBaseUrl . '/#organization',
            ],
        ];
    @endphp

    <title>{{ $documentTitle }}</title>

    <meta
        name="description"
        content="{{ $siteDescription }}"
    >

    @if($siteKeywords !== '')
        <meta
            name="keywords"
            content="{{ $siteKeywords }}"
        >
    @endif

    @if($googleSiteVerification !== '')
        <meta
            name="google-site-verification"
            content="{{ $googleSiteVerification }}"
        >
    @endif

    <meta
        name="robots"
        content="index,follow,max-image-preview:large"
    >

    <link
        rel="canonical"
        href="{{ $canonicalUrl }}"
    >

    <meta
        property="og:locale"
        content="id_ID"
    >

    <meta
        property="og:type"
        content="website"
    >

    <meta
        property="og:site_name"
        content="{{ $siteName }}"
    >

    <meta
        property="og:title"
        content="{{ $documentTitle }}"
    >

    <meta
        property="og:description"
        content="{{ $siteDescription }}"
    >

    <meta
        property="og:url"
        content="{{ $canonicalUrl }}"
    >

    @if($siteSocialImageUrl)
        <meta
            property="og:image"
            content="{{ $siteSocialImageUrl }}"
        >

        <meta
            property="og:image:alt"
            content="{{ $siteName }}"
        >
    @endif

    <meta
        name="twitter:card"
        content="{{ $siteSocialImageUrl
            ? 'summary_large_image'
            : 'summary'
        }}"
    >

    <meta
        name="twitter:title"
        content="{{ $documentTitle }}"
    >

    <meta
        name="twitter:description"
        content="{{ $siteDescription }}"
    >

    @if($siteSocialImageUrl)
        <meta
            name="twitter:image"
            content="{{ $siteSocialImageUrl }}"
        >

        <meta
            name="twitter:image:alt"
            content="{{ $siteName }}"
        >
    @endif

    <link
        rel="sitemap"
        type="application/xml"
        title="Sitemap"
        href="{{ route('public.sitemap') }}"
    >

    <script type="application/ld+json">
        {!! json_encode(
            $organizationSchema,
            JSON_UNESCAPED_SLASHES |
            JSON_UNESCAPED_UNICODE
        ) !!}
    </script>

    <script type="application/ld+json">
        {!! json_encode(
            $websiteSchema,
            JSON_UNESCAPED_SLASHES |
            JSON_UNESCAPED_UNICODE
        ) !!}
    </script>

    <script type="application/ld+json">
        {!! json_encode(
            $webPageSchema,
            JSON_UNESCAPED_SLASHES |
            JSON_UNESCAPED_UNICODE
        ) !!}
    </script>

    <link
        rel="icon"
        href="{{ $siteFaviconUrl }}"
    >

    <link
        rel="shortcut icon"
        href="{{ $siteFaviconUrl }}"
    >

    @if($siteLogoUrl)
        <link
            rel="apple-touch-icon"
            href="{{ $siteLogoUrl }}"
        >
    @endif

    @vite([
        'resources/css/app.css',
        'resources/css/app.public-home.css',
        'resources/js/app.js'
    ])

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        :root {
            --public-green: #16834f;
            --public-green-dark: #0d6139;
            --public-green-soft: #eef7f2;
            --public-navy: #12251c;
            --public-text: #34463c;
            --public-muted: #6e7d74;
            --public-border: #dfe9e3;
            --public-white: #ffffff;
        }

        html {
            scroll-behavior: smooth;
        }

        body.public-body {
            margin: 0;
            color: var(--public-text);
            background: var(--public-white);
        }

        body.public-overlay-open {
            overflow: hidden;
        }

        .public-skip-link {
            position: fixed;
            top: 12px;
            left: 12px;
            z-index: 10050;
            padding: 10px 14px;
            color: #ffffff;
            background: var(--public-green-dark);
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 800;
            transform: translateY(-160%);
            transition: transform 0.2s ease;
        }

        .public-skip-link:focus {
            transform: translateY(0);
        }

        /* =====================================================
           MODAL PENCARIAN
        ===================================================== */

        .public-search-modal {
            position: fixed;
            inset: 0;
            z-index: 10000;
            display: grid;
            place-items: start center;
            padding: 92px 20px 30px;
            visibility: hidden;
            opacity: 0;
            pointer-events: none;
            background: rgba(6, 29, 18, 0.68);
            backdrop-filter: blur(7px);
            transition:
                opacity 0.22s ease,
                visibility 0.22s ease;
        }

        .public-search-modal.is-open {
            visibility: visible;
            opacity: 1;
            pointer-events: auto;
        }

        .public-search-dialog {
            width: min(680px, 100%);
            overflow: hidden;
            background: var(--public-white);
            border: 1px solid rgba(255, 255, 255, 0.45);
            border-radius: 22px;
            box-shadow: 0 28px 70px rgba(0, 0, 0, 0.24);
            transform: translateY(-12px) scale(0.985);
            transition: transform 0.22s ease;
        }

        .public-search-modal.is-open .public-search-dialog {
            transform: translateY(0) scale(1);
        }

        .public-search-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            padding: 24px 24px 18px;
            border-bottom: 1px solid var(--public-border);
        }

        .public-search-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--public-green);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .public-search-eyebrow::before {
            content: "";
            width: 24px;
            height: 3px;
            border-radius: 999px;
            background: var(--public-green);
        }

        .public-search-title {
            margin: 7px 0 0;
            color: var(--public-navy);
            font-size: clamp(24px, 3vw, 32px);
            line-height: 1.15;
            font-weight: 850;
            letter-spacing: -0.035em;
        }

        .public-search-description {
            margin: 8px 0 0;
            color: var(--public-muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .public-search-close {
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            display: grid;
            place-items: center;
            color: var(--public-navy);
            background: var(--public-green-soft);
            border: 1px solid var(--public-border);
            border-radius: 12px;
            font-size: 17px;
            cursor: pointer;
            transition:
                color 0.2s ease,
                background 0.2s ease,
                transform 0.2s ease;
        }

        .public-search-close:hover {
            color: #ffffff;
            background: var(--public-green);
            transform: rotate(4deg);
        }

        .public-search-body {
            padding: 22px 24px 26px;
        }

        .public-search-form {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 10px;
        }

        .public-search-input-wrap {
            position: relative;
            min-width: 0;
        }

        .public-search-input-wrap i {
            position: absolute;
            top: 50%;
            left: 15px;
            color: var(--public-green);
            font-size: 17px;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .public-search-input {
            width: 100%;
            height: 50px;
            padding: 0 15px 0 44px;
            color: var(--public-navy);
            background: #f8fbf9;
            border: 1px solid var(--public-border);
            border-radius: 13px;
            outline: none;
            font-size: 14px;
            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease,
                background 0.2s ease;
        }

        .public-search-input:focus {
            background: #ffffff;
            border-color: rgba(22, 131, 79, 0.65);
            box-shadow: 0 0 0 4px rgba(22, 131, 79, 0.11);
        }

        .public-search-submit {
            min-height: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0 19px;
            color: #ffffff;
            background: var(--public-green);
            border: 1px solid var(--public-green);
            border-radius: 13px;
            font-size: 13px;
            font-weight: 850;
            cursor: pointer;
            transition:
                background 0.2s ease,
                border-color 0.2s ease,
                transform 0.2s ease;
        }

        .public-search-submit:hover {
            background: var(--public-green-dark);
            border-color: var(--public-green-dark);
            transform: translateY(-1px);
        }

        .public-search-hint {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-top: 13px;
            color: var(--public-muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .public-search-hint i {
            color: var(--public-green);
        }

        @media (max-width: 560px) {
            .public-search-modal {
                padding: 72px 12px 20px;
            }

            .public-search-dialog {
                border-radius: 18px;
            }

            .public-search-header {
                padding: 20px 18px 16px;
            }

            .public-search-body {
                padding: 18px;
            }

            .public-search-form {
                grid-template-columns: 1fr;
            }

            .public-search-submit {
                width: 100%;
            }
        }

        /* =====================================================
           NAVBAR DAN MENU MOBILE
        ===================================================== */

        .public-site-header {
            position: sticky;
            top: 0;
            z-index: 5000;
            width: 100%;
            background: rgba(255, 255, 255, 0.98);
            border-bottom: 1px solid var(--public-border);
            box-shadow: 0 6px 22px rgba(18, 69, 43, 0.06);
            backdrop-filter: blur(12px);
        }

        .public-site-header,
        .public-site-header * {
            box-sizing: border-box;
        }

        .public-navbar-inner {
            width: min(1180px, calc(100% - 48px));
            min-height: 86px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 22px;
            margin-inline: auto;
        }

        .public-brand {
            min-width: 240px;
            display: inline-flex;
            align-items: center;
            gap: 13px;
            color: var(--public-navy);
            text-decoration: none;
        }

        .public-brand-logo {
            width: 56px;
            height: 56px;
            flex: 0 0 56px;
            display: grid;
            place-items: center;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid var(--public-border);
            border-radius: 15px;
        }

        .public-brand-logo img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: contain;
            padding: 5px;
        }

        .public-brand-name {
            display: block;
            color: var(--public-navy);
            font-size: 17px;
            font-weight: 900;
            line-height: 1.25;
        }

        .public-brand-region {
            display: block;
            margin-top: 3px;
            color: var(--public-muted);
            font-size: 11px;
            line-height: 1.45;
        }

        .public-desktop-navigation {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 24px;
        }

        .public-desktop-navigation a {
            position: relative;
            padding: 31px 0 28px;
            color: var(--public-navy);
            text-decoration: none;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .public-desktop-navigation a::after {
            position: absolute;
            right: 0;
            bottom: 21px;
            left: 0;
            height: 2px;
            content: "";
            background: var(--public-green);
            border-radius: 999px;
            transform: scaleX(0);
            transition: transform 0.2s ease;
        }

        .public-desktop-navigation a:hover,
        .public-desktop-navigation a.active {
            color: var(--public-green);
        }

        .public-desktop-navigation a:hover::after,
        .public-desktop-navigation a.active::after {
            transform: scaleX(1);
        }

        .public-navbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .public-search-toggle {
            width: 45px;
            height: 45px;
            display: grid;
            place-items: center;
            padding: 0;
            color: var(--public-navy);
            background: #ffffff;
            border: 1px solid var(--public-border);
            border-radius: 12px;
            cursor: pointer;
        }

        .public-service-link {
            min-height: 45px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            color: #ffffff;
            background: #1976f3;
            border-radius: 11px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 850;
            box-shadow: 0 8px 20px rgba(25, 118, 243, 0.18);
        }

        .public-menu-toggle {
            position: relative;
            z-index: 5105;
            width: 45px;
            height: 45px;
            display: none;
            place-items: center;
            flex: 0 0 45px;
            padding: 0;
            color: var(--public-green-dark);
            background: var(--public-green-soft);
            border: 1px solid rgba(22, 131, 79, 0.19);
            border-radius: 12px;
            font-size: 21px;
            cursor: pointer;
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
        }

        .public-menu-toggle:focus-visible {
            outline: 3px solid rgba(22, 131, 79, 0.24);
            outline-offset: 2px;
        }

        .public-mobile-overlay {
            position: fixed;
            inset: 0;
            z-index: 5090;
            visibility: hidden;
            opacity: 0;
            pointer-events: none;
            background: rgba(6, 29, 18, 0.52);
            backdrop-filter: blur(3px);
            transition:
                opacity 0.22s ease,
                visibility 0.22s ease;
        }

        .public-mobile-overlay.is-open {
            visibility: visible;
            opacity: 1;
            pointer-events: auto;
        }

        .public-mobile-menu {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            z-index: 5100;
            width: min(86vw, 350px);
            display: flex !important;
            flex-direction: column;
            visibility: hidden;
            opacity: 0;
            pointer-events: none;
            background: #ffffff;
            border-left: 1px solid var(--public-border);
            box-shadow: -18px 0 48px rgba(6, 29, 18, 0.18);
            transform: translateX(105%);
            transition:
                transform 0.24s ease,
                opacity 0.2s ease,
                visibility 0.24s ease;
        }

        .public-mobile-menu.is-open {
            visibility: visible;
            opacity: 1;
            pointer-events: auto;
            transform: translateX(0);
        }

        .public-mobile-menu-header {
            min-height: 76px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 16px;
            border-bottom: 1px solid var(--public-border);
        }

        .public-mobile-menu-title {
            color: var(--public-navy);
            font-size: 15px;
            font-weight: 900;
        }

        .public-mobile-menu-close {
            width: 39px;
            height: 39px;
            display: grid;
            place-items: center;
            padding: 0;
            color: var(--public-green-dark);
            background: var(--public-green-soft);
            border: 1px solid rgba(22, 131, 79, 0.16);
            border-radius: 10px;
            font-size: 17px;
            cursor: pointer;
            touch-action: manipulation;
        }

        .public-mobile-navigation {
            display: grid;
            gap: 6px;
            overflow-y: auto;
            padding: 16px;
            overscroll-behavior: contain;
            -webkit-overflow-scrolling: touch;
        }

        .public-mobile-navigation a {
            min-height: 48px;
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 11px 13px;
            color: var(--public-text);
            background: #ffffff;
            border: 1px solid transparent;
            border-radius: 11px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 800;
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
        }

        .public-mobile-navigation a i {
            width: 31px;
            height: 31px;
            flex: 0 0 31px;
            display: grid;
            place-items: center;
            color: var(--public-green);
            background: var(--public-green-soft);
            border-radius: 9px;
            font-size: 13px;
        }

        .public-mobile-navigation a:hover,
        .public-mobile-navigation a:active,
        .public-mobile-navigation a.active {
            color: var(--public-green-dark);
            background: var(--public-green-soft);
            border-color: rgba(22, 131, 79, 0.14);
        }

        .public-mobile-service {
            margin: auto 16px 18px;
            min-height: 47px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 14px;
            color: #ffffff;
            background: linear-gradient(
                135deg,
                var(--public-green-dark),
                var(--public-green)
            );
            border-radius: 11px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 850;
        }

        body.public-mobile-menu-open {
            overflow: hidden !important;
            touch-action: none;
        }

        @media (max-width: 991.98px) {
            .public-navbar-inner {
                width: min(100% - 28px, 960px);
                min-height: 74px;
                gap: 12px;
            }

            .public-brand {
                min-width: 0;
                max-width: calc(100% - 58px);
            }

            .public-brand-logo {
                width: 48px;
                height: 48px;
                flex-basis: 48px;
                border-radius: 13px;
            }

            .public-brand-copy {
                min-width: 0;
            }

            .public-brand-name,
            .public-brand-region {
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .public-brand-name {
                font-size: 14px;
            }

            .public-brand-region {
                max-width: 190px;
                font-size: 9px;
            }

            .public-desktop-navigation,
            .public-navbar-actions {
                display: none;
            }

            .public-menu-toggle {
                display: grid !important;
            }
        }

        @media (min-width: 992px) {
            .public-mobile-overlay,
            .public-mobile-menu {
                display: none !important;
            }
        }

        @media (max-width: 380px) {
            .public-navbar-inner {
                width: calc(100% - 20px);
            }

            .public-brand-region {
                max-width: 145px;
            }

            .public-mobile-menu {
                width: min(90vw, 330px);
            }
        }

    </style>

    @stack('styles')
</head>

@php
    $publicSearchAction = \Illuminate\Support\Facades\Route::has(
        'public.search'
    )
        ? route('public.search')
        : url('/cari');

    $publicServiceUrl = \Illuminate\Support\Facades\Route::has(
        'public.services.index'
    )
        ? route('public.services.index')
        : url('/layanan-desa');
@endphp

<body class="public-body">

    <a href="#main-content" class="public-skip-link">
        Lewati ke isi halaman
    </a>

    @include('public.components.navbar')

    <main id="main-content" tabindex="-1">
        @yield('content')
    </main>

    @include('public.components.footer')

    {{-- MODAL PENCARIAN GLOBAL --}}
    <div
        id="public-search-modal"
        class="public-search-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="public-search-title"
        aria-hidden="true"
    >
        <div class="public-search-dialog">

            <div class="public-search-header">

                <div>
                    <span class="public-search-eyebrow">
                        Pencarian
                    </span>

                    <h2
                        id="public-search-title"
                        class="public-search-title"
                    >
                        Cari Informasi Desa
                    </h2>

                    <p class="public-search-description">
                        Cari berita, potensi, profil, layanan, atau informasi
                        lain mengenai Desa Bakal Dalam.
                    </p>
                </div>

                <button
                    type="button"
                    class="public-search-close"
                    aria-label="Tutup pencarian"
                    data-public-search-close
                >
                    <i class="bi bi-x-lg"></i>
                </button>

            </div>

            <div class="public-search-body">

                <form
                    action="{{ $publicSearchAction }}"
                    method="GET"
                    class="public-search-form"
                    role="search"
                >
                    <div class="public-search-input-wrap">

                        <i class="bi bi-search"></i>

                        <input
                            id="public-search-input"
                            type="search"
                            name="q"
                            value="{{ request('q') }}"
                            class="public-search-input"
                            placeholder="Ketik kata kunci..."
                            autocomplete="off"
                            minlength="2"
                            required
                        >

                    </div>

                    <button
                        type="submit"
                        class="public-search-submit"
                    >
                        <i class="bi bi-search"></i>
                        Cari
                    </button>

                </form>

                <div class="public-search-hint">
                    <i class="bi bi-info-circle"></i>
                    Masukkan sedikitnya dua karakter untuk melakukan pencarian.
                </div>

            </div>

        </div>
    </div>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const body = document.body;

            /* =================================================
               MENU MOBILE ANDROID
            ================================================= */

            const menuToggle = document.querySelector(
                '[data-public-menu-toggle]'
            );

            const mobileMenu = document.querySelector(
                '[data-public-mobile-menu]'
            );

            const menuOverlay = document.querySelector(
                '[data-public-menu-overlay]'
            );

            const menuCloseButtons = document.querySelectorAll(
                '[data-public-menu-close]'
            );

            const menuIcon = menuToggle?.querySelector('i');

            function openMobileMenu() {
                if (!menuToggle || !mobileMenu) {
                    return;
                }

                mobileMenu.classList.add('is-open');
                menuOverlay?.classList.add('is-open');

                mobileMenu.setAttribute(
                    'aria-hidden',
                    'false'
                );

                menuToggle.setAttribute(
                    'aria-expanded',
                    'true'
                );

                body.classList.add(
                    'public-mobile-menu-open'
                );

                if (menuIcon) {
                    menuIcon.className = 'bi bi-x-lg';
                }
            }

            function closeMobileMenu() {
                if (!menuToggle || !mobileMenu) {
                    return;
                }

                mobileMenu.classList.remove('is-open');
                menuOverlay?.classList.remove('is-open');

                mobileMenu.setAttribute(
                    'aria-hidden',
                    'true'
                );

                menuToggle.setAttribute(
                    'aria-expanded',
                    'false'
                );

                body.classList.remove(
                    'public-mobile-menu-open'
                );

                if (menuIcon) {
                    menuIcon.className = 'bi bi-list';
                }
            }

            function toggleMobileMenu(event) {
                event?.preventDefault();
                event?.stopPropagation();

                const opened =
                    mobileMenu?.classList.contains('is-open');

                if (opened) {
                    closeMobileMenu();
                } else {
                    openMobileMenu();
                }
            }

            if (
                menuToggle &&
                mobileMenu &&
                menuToggle.dataset.menuReady !== 'true'
            ) {
                menuToggle.dataset.menuReady = 'true';

                menuToggle.addEventListener(
                    'click',
                    toggleMobileMenu
                );

                menuToggle.addEventListener(
                    'touchend',
                    function (event) {
                        event.preventDefault();
                        toggleMobileMenu(event);
                    },
                    {
                        passive: false
                    }
                );
            }

            menuOverlay?.addEventListener(
                'click',
                closeMobileMenu
            );

            menuCloseButtons.forEach(function (button) {
                button.addEventListener(
                    'click',
                    closeMobileMenu
                );
            });

            mobileMenu
                ?.querySelectorAll('a')
                .forEach(function (link) {
                    link.addEventListener(
                        'click',
                        closeMobileMenu
                    );
                });

            window.addEventListener(
                'resize',
                function () {
                    if (window.innerWidth >= 992) {
                        closeMobileMenu();
                    }
                }
            );

            /* =================================================
               TOMBOL LAYANAN DESA
            ================================================= */

            const serviceUrl = @json($publicServiceUrl);

            const serviceButtons = Array.from(
                document.querySelectorAll(
                    [
                        '.public-service-toggle',
                        '.public-services-toggle',
                        '[data-public-services]',
                        '[data-public-service-link]'
                    ].join(',')
                )
            );

            document
                .querySelectorAll('nav a, nav button')
                .forEach(function (element) {
                    const label = (
                        element.textContent || ''
                    )
                        .replace(/\s+/g, ' ')
                        .trim()
                        .toLowerCase();

                    if (
                        label.includes('layanan desa') &&
                        !serviceButtons.includes(element)
                    ) {
                        serviceButtons.push(element);
                    }
                });

            serviceButtons.forEach(function (button) {
                const isAnchor =
                    button.tagName.toLowerCase() === 'a';

                const currentHref = isAnchor
                    ? button.getAttribute('href')
                    : null;

                const hasUsefulHref =
                    currentHref &&
                    currentHref !== '#' &&
                    !currentHref.startsWith('javascript:');

                if (!hasUsefulHref) {
                    if (isAnchor) {
                        button.setAttribute('href', serviceUrl);
                    } else {
                        button.addEventListener(
                            'click',
                            function () {
                                window.location.href = serviceUrl;
                            }
                        );
                    }
                }
            });

            /* =================================================
               MODAL PENCARIAN
            ================================================= */

            const searchModal = document.getElementById(
                'public-search-modal'
            );

            const searchInput = document.getElementById(
                'public-search-input'
            );

            const closeSearchButton = searchModal?.querySelector(
                '[data-public-search-close]'
            );

            const searchButtons = Array.from(
                document.querySelectorAll(
                    [
                        '.public-search-toggle',
                        '[data-public-search-open]',
                        'button[aria-label*="cari" i]',
                        'a[aria-label*="cari" i]'
                    ].join(',')
                )
            );

            document
                .querySelectorAll('nav button, nav a')
                .forEach(function (element) {
                    const hasSearchIcon =
                        element.querySelector('.bi-search');

                    if (
                        hasSearchIcon &&
                        !searchButtons.includes(element)
                    ) {
                        searchButtons.push(element);
                    }
                });

            let lastFocusedElement = null;

            function openSearchModal() {
                if (!searchModal) {
                    return;
                }

                lastFocusedElement = document.activeElement;

                closeMobileMenu();

                searchModal.classList.add('is-open');
                searchModal.setAttribute('aria-hidden', 'false');
                body.classList.add('public-overlay-open');

                window.setTimeout(function () {
                    searchInput?.focus();
                    searchInput?.select();
                }, 120);
            }

            function closeSearchModal() {
                if (!searchModal) {
                    return;
                }

                searchModal.classList.remove('is-open');
                searchModal.setAttribute('aria-hidden', 'true');
                body.classList.remove('public-overlay-open');

                if (
                    lastFocusedElement &&
                    typeof lastFocusedElement.focus === 'function'
                ) {
                    lastFocusedElement.focus();
                }
            }

            searchButtons.forEach(function (button) {
                button.addEventListener(
                    'click',
                    function (event) {
                        event.preventDefault();
                        openSearchModal();
                    }
                );
            });

            closeSearchButton?.addEventListener(
                'click',
                closeSearchModal
            );

            searchModal?.addEventListener(
                'click',
                function (event) {
                    if (event.target === searchModal) {
                        closeSearchModal();
                    }
                }
            );

            document.addEventListener(
                'keydown',
                function (event) {
                    if (event.key === 'Escape') {
                        closeSearchModal();
                        closeMobileMenu();
                    }
                }
            );
        });
    </script>

</body>
</html>
