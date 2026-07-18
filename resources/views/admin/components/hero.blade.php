@php
    $desa = \App\Models\VillageProfile::first();
    $admin = auth()->user();

    $namaDesa = $desa?->nama_desa ?? 'Desa';
    $adminName = $admin?->name ?? 'Administrator';

    $logoUrl = filled($desa?->logo)
        ? asset('storage/' . ltrim($desa->logo, '/'))
        : null;

    $logoInitial = strtoupper(
        mb_substr($namaDesa, 0, 1)
    );

    $beritaUrl = \Illuminate\Support\Facades\Route::has(
        'admin.berita.create'
    )
        ? route('admin.berita.create')
        : route('admin.berita');

    $galeriUrl = \Illuminate\Support\Facades\Route::has(
        'admin.galeri.create'
    )
        ? route('admin.galeri.create')
        : route('admin.galeri');
@endphp

@push('styles')
<style>
    .admin-dashboard-hero {
        position: relative;
        overflow: hidden;
        display: grid;
        grid-template-columns:
            minmax(0, 1fr)
            minmax(220px, 0.34fr);
        gap: 34px;
        align-items: center;
        min-height: 270px;
        padding: 34px 36px;
        color: #ffffff;
        background:
            radial-gradient(
                circle at 88% 16%,
                rgba(255, 255, 255, 0.16),
                transparent 27%
            ),
            linear-gradient(
                135deg,
                var(--admin-green-deep),
                var(--admin-green-dark) 58%,
                var(--admin-green)
            );
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        box-shadow: 0 22px 48px rgba(8, 61, 36, 0.17);
    }

    .admin-dashboard-hero::before {
        content: "";
        position: absolute;
        right: -90px;
        bottom: -150px;
        width: 300px;
        height: 300px;
        border: 1px solid rgba(255, 255, 255, 0.09);
        border-radius: 50%;
    }

    .admin-dashboard-hero::after {
        content: "";
        position: absolute;
        top: -110px;
        right: 150px;
        width: 210px;
        height: 210px;
        background: rgba(255, 255, 255, 0.035);
        border-radius: 50%;
    }

    .admin-dashboard-hero-copy,
    .admin-dashboard-hero-visual {
        position: relative;
        z-index: 2;
    }

    .admin-dashboard-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 11px;
        color: #ffffff;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.17);
        border-radius: 999px;
        font-size: 10px;
        font-weight: 900;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        backdrop-filter: blur(8px);
    }

    .admin-dashboard-badge i {
        color: #9ce0b9;
        font-size: 12px;
    }

    .admin-dashboard-title {
        max-width: 760px;
        margin: 18px 0 0;
        color: #ffffff;
        font-size: clamp(27px, 2.6vw, 37px);
        font-weight: 850;
        line-height: 1.12;
        letter-spacing: -0.04em;
    }

    .admin-dashboard-title span {
        color: #a8e5c2;
    }

    .admin-dashboard-description {
        max-width: 710px;
        margin: 14px 0 0;
        color: rgba(255, 255, 255, 0.75);
        font-size: 13px;
        line-height: 1.75;
    }

    .admin-dashboard-description strong {
        color: #ffffff;
        font-weight: 800;
    }

    .admin-dashboard-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 22px;
    }

    .admin-dashboard-meta-item {
        min-width: 170px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 13px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 13px;
    }

    .admin-dashboard-meta-icon {
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        display: grid;
        place-items: center;
        color: var(--admin-green-dark);
        background: #ffffff;
        border-radius: 10px;
        font-size: 14px;
    }

    .admin-dashboard-meta-item small {
        display: block;
        color: rgba(255, 255, 255, 0.57);
        font-size: 9px;
        font-weight: 800;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .admin-dashboard-meta-item strong {
        display: block;
        margin-top: 3px;
        color: #ffffff;
        font-size: 11px;
        line-height: 1.45;
        font-weight: 800;
    }

    .admin-dashboard-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 24px;
    }

    .admin-dashboard-action {
        min-height: 43px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 15px;
        border-radius: 11px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 850;
        transition:
            color 0.2s ease,
            background 0.2s ease,
            border-color 0.2s ease,
            transform 0.2s ease;
    }

    .admin-dashboard-action:hover {
        transform: translateY(-2px);
    }

    .admin-dashboard-action-primary {
        color: var(--admin-green-dark);
        background: #ffffff;
        border: 1px solid #ffffff;
        box-shadow: 0 10px 22px rgba(0, 0, 0, 0.13);
    }

    .admin-dashboard-action-primary:hover {
        color: var(--admin-green-dark);
        background: #f1faf5;
        border-color: #f1faf5;
    }

    .admin-dashboard-action-soft {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.11);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .admin-dashboard-action-soft:hover {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.18);
    }

    .admin-dashboard-action-outline {
        color: #ffffff;
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.38);
    }

    .admin-dashboard-action-outline:hover {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.58);
    }

    .admin-dashboard-hero-visual {
        display: grid;
        place-items: center;
    }

    .admin-dashboard-logo-card {
        width: min(220px, 100%);
        aspect-ratio: 1 / 1;
        display: grid;
        place-items: center;
        padding: 20px;
        background: rgba(255, 255, 255, 0.11);
        border: 1px solid rgba(255, 255, 255, 0.19);
        border-radius: 28px;
        box-shadow: 0 18px 36px rgba(0, 0, 0, 0.14);
        backdrop-filter: blur(10px);
        transform: rotate(2deg);
    }

    .admin-dashboard-logo-card img {
        width: 100%;
        height: 100%;
        display: block;
        padding: 9px;
        object-fit: contain;
        background: rgba(255, 255, 255, 0.96);
        border-radius: 20px;
        transform: rotate(-2deg);
    }

    .admin-dashboard-logo-placeholder {
        width: 100%;
        height: 100%;
        display: grid;
        place-items: center;
        color: var(--admin-green-dark);
        background: rgba(255, 255, 255, 0.96);
        border-radius: 20px;
        font-size: 64px;
        font-weight: 900;
        transform: rotate(-2deg);
    }

    @media (max-width: 991px) {
        .admin-dashboard-hero {
            grid-template-columns: 1fr;
            min-height: auto;
            padding: 30px;
        }

        .admin-dashboard-hero-visual {
            display: none;
        }
    }

    @media (max-width: 560px) {
        .admin-dashboard-hero {
            padding: 24px 20px;
            border-radius: 19px;
        }

        .admin-dashboard-title {
            font-size: 28px;
        }

        .admin-dashboard-meta {
            display: grid;
            grid-template-columns: 1fr;
        }

        .admin-dashboard-meta-item {
            min-width: 0;
        }

        .admin-dashboard-actions {
            display: grid;
            grid-template-columns: 1fr;
        }

        .admin-dashboard-action {
            width: 100%;
        }
    }
</style>
@endpush

<section class="admin-dashboard-hero">

    <div class="admin-dashboard-hero-copy">

        <span class="admin-dashboard-badge">
            <i class="bi bi-stars"></i>
            Dashboard Administrator
        </span>

        <h2 class="admin-dashboard-title">
            Selamat Datang
        </h2>

        <p class="admin-dashboard-description">
            Halo, <strong>{{ $adminName }}</strong>.
            Kelola seluruh informasi website resmi
            <strong>{{ $namaDesa }}</strong>
            melalui dashboard ini.
        </p>

        <div class="admin-dashboard-meta">

            <div class="admin-dashboard-meta-item">

                <span class="admin-dashboard-meta-icon">
                    <i class="bi bi-building"></i>
                </span>

                <div>
                    <small>Nama Desa</small>
                    <strong>{{ $namaDesa }}</strong>
                </div>

            </div>

            <div class="admin-dashboard-meta-item">

                <span class="admin-dashboard-meta-icon">
                    <i class="bi bi-calendar3"></i>
                </span>

                <div>
                    <small>Hari Ini</small>

                    <strong>
                        {{ now()
                            ->locale('id')
                            ->translatedFormat('l, d F Y') }}
                    </strong>
                </div>

            </div>

        </div>

        <div class="admin-dashboard-actions">

            <a
                href="{{ $beritaUrl }}"
                class="
                    admin-dashboard-action
                    admin-dashboard-action-primary
                "
            >
                <i class="bi bi-plus-circle"></i>
                Tambah Berita
            </a>

            <a
                href="{{ $galeriUrl }}"
                class="
                    admin-dashboard-action
                    admin-dashboard-action-soft
                "
            >
                <i class="bi bi-images"></i>
                Kelola Galeri
            </a>

            <a
                href="/"
                target="_blank"
                rel="noopener"
                class="
                    admin-dashboard-action
                    admin-dashboard-action-outline
                "
            >
                <i class="bi bi-globe"></i>
                Lihat Website
            </a>

        </div>

    </div>

    <div class="admin-dashboard-hero-visual">

        <div class="admin-dashboard-logo-card">

            @if($logoUrl)

                <img
                    src="{{ $logoUrl }}"
                    alt="Logo {{ $namaDesa }}"
                >

            @else

                <div class="admin-dashboard-logo-placeholder">
                    {{ $logoInitial }}
                </div>

            @endif

        </div>

    </div>

</section>
