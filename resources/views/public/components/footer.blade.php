
<style>
    .public-footer {
        padding: 42px 0 26px !important;
    }

    .public-footer .container {
        width: min(1180px, calc(100% - 36px));
    }

    .public-footer h5 {
        margin-bottom: 12px !important;
        font-size: 15px !important;
        line-height: 1.35;
    }

    .public-footer p,
    .public-footer a {
        font-size: 12px !important;
        line-height: 1.65;
    }

    .public-footer li {
        margin-bottom: 7px !important;
    }

    .public-footer small {
        font-size: 10px !important;
        line-height: 1.6;
    }

    .public-footer .footer-contact-line {
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }

    .public-footer .footer-contact-line i {
        flex: 0 0 15px;
        margin-top: 3px;
        color: rgba(130, 221, 163, 0.92);
        font-size: 11px;
    }

    @media (max-width: 767.98px) {
        .public-footer {
            padding: 22px 0 15px !important;
        }

        .public-footer .container {
            width: min(100% - 30px, 1180px) !important;
        }

        .public-footer .row {
            --bs-gutter-y: 18px;
        }

        .public-footer h5 {
            margin-bottom: 7px !important;
            font-size: 11px !important;
            line-height: 1.3 !important;
        }

        .public-footer p,
        .public-footer a,
        .public-footer li {
            font-size: 8.8px !important;
            line-height: 1.5 !important;
        }

        .public-footer li {
            margin-bottom: 3px !important;
        }

        .public-footer .footer-contact-line {
            gap: 6px !important;
            margin-bottom: 5px !important;
        }

        .public-footer .footer-contact-line i {
            flex-basis: 12px !important;
            margin-top: 2px !important;
            font-size: 9px !important;
        }

        .public-footer .border-top {
            margin-top: 18px !important;
            padding-top: 11px !important;
        }

        .public-footer small {
            font-size: 7.5px !important;
            line-height: 1.45 !important;
        }
    }

    @media (max-width: 420px) {
        .public-footer {
            padding-top: 19px !important;
        }

        .public-footer h5 {
            font-size: 10.5px !important;
        }

        .public-footer p,
        .public-footer a,
        .public-footer li {
            font-size: 8.4px !important;
        }

        .public-footer small {
            font-size: 7.2px !important;
        }
    }
</style>

@php
    $footerSettings = $siteSettings
        ?? $settings
        ?? \App\Models\Setting::query()->first();

    $footerProfile = $profile
        ?? \App\Models\VillageProfile::query()->first();

    $footerContact = $contact
        ?? \App\Models\Contact::query()->first();

    $footerSiteName = $footerSettings?->nama_website
        ?? $footerProfile?->nama_desa
        ?? 'Desa Bakal Dalam';

    $footerDescription = $footerSettings?->slogan
        ?? 'Website resmi Pemerintah Desa.';

    $customFooterText = trim(
        (string) ($footerSettings?->footer ?? '')
    );
@endphp

<footer class="py-5 public-footer">
    <div class="container">
        <div class="row gy-4">

            <div class="col-md-6 col-lg-4 footer-brand-column">
                <h5 class="mb-3">
                    {{ $footerSiteName }}
                </h5>

                <p class="mb-0">
                    {{ $footerDescription }}
                </p>
            </div>

            <div class="col-md-6 col-lg-4 footer-menu-column">
                <h5 class="mb-3">Menu Cepat</h5>

                <ul class="list-unstyled footer-links mb-0">
                    <li>
                        <a href="{{ route('public.profile') }}">
                            Profil Desa
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('public.government') }}">
                            Pemerintahan
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('public.potentials') }}">
                            Potensi Desa
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('public.news') }}">
                            Berita
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('public.galleries') }}">
                            Galeri
                        </a>
                    </li>

                    @if(
                        \Illuminate\Support\Facades\Route::has(
                            'public.services.index'
                        )
                    )
                        <li>
                            <a
                                href="{{ route(
                                    'public.services.index'
                                ) }}"
                            >
                                Layanan Desa
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="col-md-6 col-lg-4 footer-contact-column">
                <h5 class="mb-3">Kontak</h5>

                <p class="mb-2 footer-contact-line">
                    <i class="bi bi-geo-alt"></i>

                    <span>
                        {{ $footerContact?->alamat
                            ?? 'Alamat belum tersedia'
                        }}
                    </span>
                </p>

                <p class="mb-2 footer-contact-line">
                    <i class="bi bi-telephone"></i>

                    <span>
                        {{ $footerContact?->telepon ?? '-' }}
                    </span>
                </p>

                <p class="mb-0 footer-contact-line">
                    <i class="bi bi-envelope"></i>

                    <span>
                        {{ $footerContact?->email ?? '-' }}
                    </span>
                </p>
            </div>

        </div>

        <div class="border-top mt-5 pt-4 text-center text-white-75">
            <small>
                @if($customFooterText !== '')
                    {!! nl2br(e($customFooterText)) !!}
                @else
                    Copyright © {{ now()->year }}
                    {{ $footerSiteName }}.
                    Seluruh hak dilindungi.
                @endif
            </small>
        </div>
    </div>
</footer>
