@php
    $navbarSettings = $siteSettings
        ?? $settings
        ?? \App\Models\Setting::query()->first();

    $navbarProfile = $profile
        ?? \App\Models\VillageProfile::query()->first();

    $navbarLogoPath = $navbarSettings?->logo
        ?? $navbarProfile?->logo;

    $navbarLogo = filled($navbarLogoPath)
        ? asset(
            'storage/' .
            ltrim($navbarLogoPath, '/')
        ) . '?v=' . (
            $navbarSettings?->updated_at?->timestamp
            ?? $navbarProfile?->updated_at?->timestamp
            ?? time()
        )
        : asset('images/transparent.png');

    $villageName = $navbarSettings?->nama_website
        ?? $navbarProfile?->nama_desa
        ?? 'Desa Bakal Dalam';

    $villageRegion = collect([
        $navbarProfile?->kecamatan
            ? 'Kecamatan ' . $navbarProfile->kecamatan
            : null,
        $navbarProfile?->kabupaten
            ? 'Kabupaten ' . $navbarProfile->kabupaten
            : null,
    ])->filter()->implode(', ');

    $publicServiceUrl = \Illuminate\Support\Facades\Route::has(
        'public.services.index'
    )
        ? route('public.services.index')
        : route('public.contact');

    $publicMenus = [
        [
            'label' => 'Beranda',
            'icon' => 'bi-house-door',
            'route' => 'home',
            'active' => request()->routeIs('home'),
        ],
        [
            'label' => 'Profil Desa',
            'icon' => 'bi-building',
            'route' => 'public.profile',
            'active' => request()->routeIs('public.profile'),
        ],
        [
            'label' => 'Pemerintahan',
            'icon' => 'bi-people',
            'route' => 'public.government',
            'active' => request()->routeIs('public.government'),
        ],
        [
            'label' => 'Potensi Desa',
            'icon' => 'bi-stars',
            'route' => 'public.potentials',
            'active' => request()->routeIs(
                'public.potentials',
                'public.potentials.show'
            ),
        ],
        [
            'label' => 'Berita',
            'icon' => 'bi-newspaper',
            'route' => 'public.news',
            'active' => request()->routeIs(
                'public.news',
                'public.news.show'
            ),
        ],
        [
            'label' => 'Galeri',
            'icon' => 'bi-images',
            'route' => 'public.galleries',
            'active' => request()->routeIs('public.galleries'),
        ],
        [
            'label' => 'Kontak',
            'icon' => 'bi-telephone',
            'route' => 'public.contact',
            'active' => request()->routeIs('public.contact'),
        ],
    ];
@endphp

<style>
    .public-navbar-fixed,
    .public-navbar-fixed * {
        box-sizing: border-box;
    }

    .public-navbar-fixed {
        position: sticky;
        top: 0;
        z-index: 9999;
        width: 100%;
        background: #ffffff;
        border-bottom: 1px solid #dfe9e3;
        box-shadow: 0 6px 22px rgba(18, 69, 43, 0.06);
    }

    .public-navbar-fixed-inner {
        width: min(1180px, calc(100% - 48px));
        min-height: 86px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 22px;
        margin-inline: auto;
    }

    .public-navbar-fixed-brand {
        min-width: 245px;
        display: inline-flex;
        align-items: center;
        gap: 13px;
        color: #12251c;
        text-decoration: none;
    }

    .public-navbar-fixed-logo {
        width: 56px;
        height: 56px;
        flex: 0 0 56px;
        display: grid;
        place-items: center;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #dfe9e3;
        border-radius: 15px;
    }

    .public-navbar-fixed-logo img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: contain;
        padding: 5px;
    }

    .public-navbar-fixed-copy {
        min-width: 0;
    }

    .public-navbar-fixed-name {
        display: block;
        color: #12251c;
        font-size: 17px;
        font-weight: 900;
        line-height: 1.25;
    }

    .public-navbar-fixed-region {
        display: block;
        margin-top: 3px;
        color: #6e7d74;
        font-size: 11px;
        line-height: 1.45;
    }

    .public-navbar-fixed-desktop {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 24px;
    }

    .public-navbar-fixed-desktop a {
        position: relative;
        padding: 31px 0 28px;
        color: #12251c;
        text-decoration: none;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .public-navbar-fixed-desktop a::after {
        position: absolute;
        right: 0;
        bottom: 21px;
        left: 0;
        height: 2px;
        content: "";
        background: #16834f;
        border-radius: 999px;
        transform: scaleX(0);
        transition: transform 0.2s ease;
    }

    .public-navbar-fixed-desktop a:hover,
    .public-navbar-fixed-desktop a.active {
        color: #16834f;
    }

    .public-navbar-fixed-desktop a:hover::after,
    .public-navbar-fixed-desktop a.active::after {
        transform: scaleX(1);
    }

    .public-navbar-fixed-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .public-navbar-fixed-search {
        width: 45px;
        height: 45px;
        flex: 0 0 45px;
        display: grid;
        place-items: center;
        padding: 0;
        color: #0d6139;
        background: #eef7f2;
        border: 1px solid rgba(22, 131, 79, 0.18);
        border-radius: 11px;
        font-size: 16px;
        cursor: pointer;
        transition:
            color 0.2s ease,
            background 0.2s ease,
            transform 0.2s ease;
    }

    .public-navbar-fixed-search:hover {
        color: #ffffff;
        background: #16834f;
        transform: translateY(-1px);
    }

    .public-navbar-fixed-contact {
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

    /*
     * Menu Android memakai elemen details/summary.
     * Jadi tetap dapat dibuka walaupun JavaScript gagal dimuat.
     */
    .public-navbar-mobile-details {
        position: relative;
        display: none;
        margin: 0;
    }

    .public-navbar-mobile-summary {
        width: 48px;
        height: 48px;
        display: grid;
        place-items: center;
        padding: 0;
        color: #0d6139;
        background: #eef7f2;
        border: 1px solid rgba(22, 131, 79, 0.18);
        border-radius: 13px;
        font-size: 22px;
        cursor: pointer;
        list-style: none;
        touch-action: manipulation;
        -webkit-tap-highlight-color: transparent;
    }

    .public-navbar-mobile-summary::-webkit-details-marker {
        display: none;
    }

    .public-navbar-mobile-summary::marker {
        display: none;
        content: "";
    }

    .public-navbar-mobile-summary .icon-close {
        display: none;
    }

    .public-navbar-mobile-details[open]
        .public-navbar-mobile-summary {
        color: #ffffff;
        background: #16834f;
        border-color: #16834f;
    }

    .public-navbar-mobile-details[open]
        .public-navbar-mobile-summary
        .icon-menu {
        display: none;
    }

    .public-navbar-mobile-details[open]
        .public-navbar-mobile-summary
        .icon-close {
        display: inline-block;
    }

    /*
     * MENU ANDROID BERGAYA SIDEBAR ADMIN
     * Panel tampil dari kiri, satu kolom, dengan menu aktif putih.
     */
    .public-navbar-mobile-details[open]::before {
        position: fixed;
        top: 74px;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 9998;
        content: "";
        background: rgba(7, 26, 16, 0.48);
        backdrop-filter: blur(2px);
    }

    .public-navbar-mobile-panel {
        position: fixed;
        top: 74px;
        right: 0;
        bottom: 0;
        left: auto;
        z-index: 10000;
        width: min(82vw, 355px);
        max-height: none;
        overflow-y: auto;
        padding: 20px 15px 16px;
        color: #ffffff;
        background:
            linear-gradient(
                180deg,
                #075a35 0%,
                #0b6a40 58%,
                #075a35 100%
            );
        border-top: 1px solid rgba(255, 255, 255, 0.12);
        border-left: 1px solid rgba(255, 255, 255, 0.12);
        box-shadow: -20px 0 44px rgba(5, 34, 20, 0.27);
        animation: publicMobileDrawerIn 0.22s ease both;
        -webkit-overflow-scrolling: touch;
    }

    @keyframes publicMobileDrawerIn {
        from {
            opacity: 0;
            transform: translateX(18px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .public-navbar-mobile-section-label {
        display: block;
        margin: 3px 11px 11px;
        color: rgba(255, 255, 255, 0.54);
        font-size: 8px;
        font-weight: 900;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .public-navbar-mobile-list {
        display: grid;
        grid-template-columns: 1fr;
        gap: 5px;
        width: 100%;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .public-navbar-mobile-link {
        position: relative;
        min-height: 50px;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 13px;
        color: rgba(255, 255, 255, 0.88);
        background: transparent;
        border: 1px solid transparent;
        border-radius: 12px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 800;
        transition:
            color 0.18s ease,
            background 0.18s ease,
            transform 0.18s ease;
        touch-action: manipulation;
        -webkit-tap-highlight-color: transparent;
    }

    .public-navbar-mobile-link::before {
        position: absolute;
        top: 50%;
        right: -15px;
        left: auto;
        width: 4px;
        height: 24px;
        content: "";
        background: #ffffff;
        border-radius: 999px 0 0 999px;
        opacity: 0;
        transform: translateY(-50%);
    }

    .public-navbar-mobile-link i {
        width: 25px;
        height: 25px;
        flex: 0 0 25px;
        display: grid;
        place-items: center;
        color: rgba(255, 255, 255, 0.8);
        background: transparent;
        border-radius: 0;
        font-size: 15px;
    }

    .public-navbar-mobile-link:hover,
    .public-navbar-mobile-link:active {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.1);
    }

    .public-navbar-mobile-link.active {
        color: #0d6139;
        background: #ffffff;
        border-color: rgba(255, 255, 255, 0.7);
        box-shadow: 0 10px 24px rgba(3, 39, 22, 0.15);
    }

    .public-navbar-mobile-link.active::before {
        opacity: 1;
    }

    .public-navbar-mobile-link.active i {
        color: #16834f;
    }

    .public-navbar-mobile-bottom {
        display: grid;
        gap: 9px;
        margin-top: 22px;
        padding-top: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.14);
    }

    .public-navbar-mobile-service {
        min-height: 48px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 11px;
        width: 100%;
        margin: 0;
        padding: 11px 14px;
        color: #ffffff;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 12px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 850;
        cursor: pointer;
    }

    .public-navbar-mobile-service i {
        width: 24px;
        display: grid;
        place-items: center;
        font-size: 14px;
    }

    .public-navbar-mobile-service.search {
        color: #0d6139;
        background: #ffffff;
        border-color: #ffffff;
    }

    .public-navbar-mobile-service.primary {
        color: #ffffff;
        background: #16834f;
        border-color: rgba(255, 255, 255, 0.22);
    }

    .public-navbar-mobile-location {
        margin-top: 16px;
        padding: 13px;
        color: rgba(255, 255, 255, 0.76);
        background: rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        font-size: 9px;
        line-height: 1.55;
    }

    .public-navbar-mobile-location strong {
        display: block;
        margin-bottom: 3px;
        color: #ffffff;
        font-size: 10px;
    }

    @media (max-width: 991.98px) {
        .public-navbar-fixed-inner {
            width: min(100% - 28px, 960px);
            min-height: 74px;
            gap: 12px;
        }

        .public-navbar-fixed-brand {
            min-width: 0;
            max-width: calc(100% - 62px);
        }

        .public-navbar-fixed-logo {
            width: 50px;
            height: 50px;
            flex-basis: 50px;
            border-radius: 13px;
        }

        .public-navbar-fixed-name,
        .public-navbar-fixed-region {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .public-navbar-fixed-name {
            font-size: 15px;
        }

        .public-navbar-fixed-region {
            max-width: 270px;
            font-size: 9px;
        }

        .public-navbar-fixed-desktop,
        .public-navbar-fixed-actions {
            display: none;
        }

        .public-navbar-mobile-details {
            display: block;
        }
    }

    @media (max-width: 500px) {
        .public-navbar-mobile-panel {
            width: min(86vw, 340px);
            padding-inline: 13px;
        }

        .public-navbar-fixed-region {
            max-width: 190px;
        }
    }

    @media (min-width: 992px) {
        .public-navbar-mobile-details {
            display: none !important;
        }
    }
</style>

<header class="public-navbar-fixed">

    <div class="public-navbar-fixed-inner">

        <a
            href="{{ route('home') }}"
            class="public-navbar-fixed-brand"
            aria-label="Beranda {{ $villageName }}"
        >

            <span class="public-navbar-fixed-logo">
                <img
                    src="{{ $navbarLogo }}"
                    alt="Logo {{ $villageName }}"
                >
            </span>

            <span class="public-navbar-fixed-copy">

                <span class="public-navbar-fixed-name">
                    {{ $villageName }}
                </span>

                <span class="public-navbar-fixed-region">
                    {{ $villageRegion ?: 'Website Resmi Desa' }}
                </span>

            </span>

        </a>

        <nav
            class="public-navbar-fixed-desktop"
            aria-label="Navigasi utama"
        >

            @foreach($publicMenus as $menu)

                <a
                    href="{{ route($menu['route']) }}"
                    class="{{ $menu['active'] ? 'active' : '' }}"
                    @if($menu['active'])
                        aria-current="page"
                    @endif
                >
                    {{ $menu['label'] }}
                </a>

            @endforeach

        </nav>

        <div class="public-navbar-fixed-actions">

            <button
                type="button"
                class="
                    public-navbar-fixed-search
                    public-search-toggle
                "
                aria-label="Cari informasi desa"
                data-public-search-open
            >
                <i class="bi bi-search"></i>
            </button>

            <a
                href="{{ $publicServiceUrl }}"
                class="public-navbar-fixed-contact"
            >
                Layanan Desa
            </a>

        </div>

        <details class="public-navbar-mobile-details">

            <summary
                class="public-navbar-mobile-summary"
                aria-label="Buka atau tutup menu"
            >
                <i class="bi bi-list icon-menu"></i>
                <i class="bi bi-x-lg icon-close"></i>
            </summary>

            <div class="public-navbar-mobile-panel">

                <nav aria-label="Navigasi Android">

                    <span class="public-navbar-mobile-section-label">
                        Menu Utama
                    </span>

                    <ul class="public-navbar-mobile-list">

                        @foreach($publicMenus as $menu)

                            <li>
                                <a
                                    href="{{ route($menu['route']) }}"
                                    class="
                                        public-navbar-mobile-link
                                        {{ $menu['active']
                                            ? 'active'
                                            : ''
                                        }}
                                    "
                                    @if($menu['active'])
                                        aria-current="page"
                                    @endif
                                >
                                    <i class="bi {{ $menu['icon'] }}"></i>

                                    <span>
                                        {{ $menu['label'] }}
                                    </span>
                                </a>
                            </li>

                        @endforeach

                    </ul>

                    <div class="public-navbar-mobile-bottom">

                        <button
                            type="button"
                            class="
                                public-navbar-mobile-service
                                public-search-toggle
                                search
                            "
                            data-public-search-open
                        >
                            <i class="bi bi-search"></i>
                            Cari Informasi Desa
                        </button>

                        <a
                            href="{{ $publicServiceUrl }}"
                            class="
                                public-navbar-mobile-service
                                primary
                            "
                        >
                            <i class="bi bi-headset"></i>
                            Layanan Desa
                        </a>

                    </div>

                    <div class="public-navbar-mobile-location">
                        <strong>{{ $villageName }}</strong>

                        {{ $villageRegion
                            ?: 'Website resmi pemerintah desa'
                        }}
                    </div>

                </nav>

            </div>

        </details>

    </div>

</header>
