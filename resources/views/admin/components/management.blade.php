@php
    $menus = [
        [
            'icon' => 'bi-building',
            'title' => 'Identitas Desa',
            'description' => 'Kelola data dasar dan profil desa.',
            'route' => route('admin.identitas'),
            'accent' => 'green',
        ],
        [
            'icon' => 'bi-bullseye',
            'title' => 'Visi & Misi',
            'description' => 'Atur visi, misi, dan tujuan desa.',
            'route' => route('admin.visi'),
            'accent' => 'amber',
        ],
        [
            'icon' => 'bi-clock-history',
            'title' => 'Sejarah Desa',
            'description' => 'Kelola informasi perjalanan sejarah desa.',
            'route' => route('admin.sejarah'),
            'accent' => 'blue',
        ],
        [
            'icon' => 'bi-map',
            'title' => 'Wilayah Desa',
            'description' => 'Atur data geografis dan batas wilayah.',
            'route' => route('admin.wilayah'),
            'accent' => 'teal',
        ],
        [
            'icon' => 'bi-person-badge',
            'title' => 'Aparat Desa',
            'description' => 'Kelola data perangkat pemerintah desa.',
            'route' => route('admin.aparat'),
            'accent' => 'purple',
        ],
        [
            'icon' => 'bi-people',
            'title' => 'BPD',
            'description' => 'Kelola anggota Badan Permusyawaratan Desa.',
            'route' => route('admin.bpd'),
            'accent' => 'rose',
        ],
        [
            'icon' => 'bi-diagram-3',
            'title' => 'Lembaga Desa',
            'description' => 'Kelola lembaga dan organisasi kemasyarakatan.',
            'route' => route('admin.lembaga'),
            'accent' => 'orange',
        ],
        [
            'icon' => 'bi-tree',
            'title' => 'Potensi Desa',
            'description' => 'Kelola potensi unggulan yang dimiliki desa.',
            'route' => route('admin.potensi'),
            'accent' => 'olive',
        ],
        [
            'icon' => 'bi-newspaper',
            'title' => 'Berita',
            'description' => 'Publikasikan dan kelola berita desa.',
            'route' => route('admin.berita'),
            'accent' => 'red',
        ],
        [
            'icon' => 'bi-megaphone',
            'title' => 'Pengumuman',
            'description' => 'Kelola informasi dan pengumuman publik.',
            'route' => route('admin.pengumuman'),
            'accent' => 'blue',
        ],
        [
            'icon' => 'bi-bar-chart-line',
            'title' => 'Statistik',
            'description' => 'Perbarui data statistik utama desa.',
            'route' => route('admin.statistik'),
            'accent' => 'indigo',
        ],
        [
            'icon' => 'bi-calendar-event',
            'title' => 'Agenda',
            'description' => 'Atur jadwal dan agenda kegiatan desa.',
            'route' => route('admin.agenda'),
            'accent' => 'cyan',
        ],
        [
            'icon' => 'bi-images',
            'title' => 'Galeri',
            'description' => 'Kelola foto dokumentasi kegiatan desa.',
            'route' => route('admin.galeri'),
            'accent' => 'violet',
        ],
        [
            'icon' => 'bi-telephone',
            'title' => 'Kontak',
            'description' => 'Atur alamat, kontak, dan lokasi kantor desa.',
            'route' => route('admin.kontak'),
            'accent' => 'green',
        ],
        [
            'icon' => 'bi-gear',
            'title' => 'Pengaturan',
            'description' => 'Kelola konfigurasi umum website desa.',
            'route' => route('admin.pengaturan'),
            'accent' => 'slate',
        ],
    ];
@endphp

@push('styles')
<style>
    .admin-management-section {
        margin-top: 26px;
    }

    .admin-management-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 17px;
    }

    .admin-management-header h2 {
        margin: 0;
        color: var(--admin-navy);
        font-size: 19px;
        font-weight: 850;
        line-height: 1.3;
        letter-spacing: -0.025em;
    }

    .admin-management-header p {
        max-width: 640px;
        margin: 5px 0 0;
        color: var(--admin-muted);
        font-size: 11px;
        line-height: 1.6;
    }

    .admin-management-count {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 11px;
        color: var(--admin-green-dark);
        background: var(--admin-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 999px;
        font-size: 10px;
        font-weight: 850;
    }

    .admin-management-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .admin-management-card {
        --menu-accent: var(--admin-green);
        --menu-soft: rgba(22, 131, 79, 0.09);
        --menu-border: rgba(22, 131, 79, 0.24);

        position: relative;
        min-width: 0;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        min-height: 176px;
        padding: 17px;
        color: inherit;
        background: #ffffff;
        border: 1px solid var(--admin-border);
        border-radius: 17px;
        box-shadow: 0 9px 26px rgba(18, 69, 43, 0.05);
        text-decoration: none;
        transition:
            transform 0.22s ease,
            box-shadow 0.22s ease,
            border-color 0.22s ease;
    }

    .admin-management-card::before {
        content: "";
        position: absolute;
        top: -50px;
        right: -44px;
        width: 116px;
        height: 116px;
        background: var(--menu-soft);
        border-radius: 50%;
        transition: transform 0.25s ease;
    }

    .admin-management-card:hover {
        color: inherit;
        border-color: var(--menu-border);
        box-shadow: 0 17px 36px rgba(18, 69, 43, 0.1);
        transform: translateY(-4px);
    }

    .admin-management-card:hover::before {
        transform: scale(1.16);
    }

    .admin-management-card.is-green {
        --menu-accent: #16834f;
        --menu-soft: rgba(22, 131, 79, 0.1);
        --menu-border: rgba(22, 131, 79, 0.28);
    }

    .admin-management-card.is-amber {
        --menu-accent: #b7791f;
        --menu-soft: rgba(183, 121, 31, 0.1);
        --menu-border: rgba(183, 121, 31, 0.27);
    }

    .admin-management-card.is-blue {
        --menu-accent: #2478e8;
        --menu-soft: rgba(36, 120, 232, 0.09);
        --menu-border: rgba(36, 120, 232, 0.26);
    }

    .admin-management-card.is-teal {
        --menu-accent: #168b83;
        --menu-soft: rgba(22, 139, 131, 0.1);
        --menu-border: rgba(22, 139, 131, 0.27);
    }

    .admin-management-card.is-purple {
        --menu-accent: #7653c8;
        --menu-soft: rgba(118, 83, 200, 0.09);
        --menu-border: rgba(118, 83, 200, 0.26);
    }

    .admin-management-card.is-rose {
        --menu-accent: #c45473;
        --menu-soft: rgba(196, 84, 115, 0.09);
        --menu-border: rgba(196, 84, 115, 0.26);
    }

    .admin-management-card.is-orange {
        --menu-accent: #c8732d;
        --menu-soft: rgba(200, 115, 45, 0.09);
        --menu-border: rgba(200, 115, 45, 0.27);
    }

    .admin-management-card.is-olive {
        --menu-accent: #6f8d27;
        --menu-soft: rgba(111, 141, 39, 0.1);
        --menu-border: rgba(111, 141, 39, 0.27);
    }

    .admin-management-card.is-red {
        --menu-accent: #ce4c4c;
        --menu-soft: rgba(206, 76, 76, 0.09);
        --menu-border: rgba(206, 76, 76, 0.25);
    }

    .admin-management-card.is-indigo {
        --menu-accent: #536ac8;
        --menu-soft: rgba(83, 106, 200, 0.09);
        --menu-border: rgba(83, 106, 200, 0.26);
    }

    .admin-management-card.is-cyan {
        --menu-accent: #2189a5;
        --menu-soft: rgba(33, 137, 165, 0.09);
        --menu-border: rgba(33, 137, 165, 0.26);
    }

    .admin-management-card.is-violet {
        --menu-accent: #8b55c7;
        --menu-soft: rgba(139, 85, 199, 0.09);
        --menu-border: rgba(139, 85, 199, 0.26);
    }

    .admin-management-card.is-slate {
        --menu-accent: #66756d;
        --menu-soft: rgba(102, 117, 109, 0.09);
        --menu-border: rgba(102, 117, 109, 0.25);
    }

    .admin-management-card-top {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }

    .admin-management-icon {
        width: 44px;
        height: 44px;
        flex: 0 0 44px;
        display: grid;
        place-items: center;
        color: var(--menu-accent);
        background: var(--menu-soft);
        border: 1px solid var(--menu-border);
        border-radius: 13px;
        font-size: 17px;
    }

    .admin-management-arrow {
        width: 29px;
        height: 29px;
        flex: 0 0 29px;
        display: grid;
        place-items: center;
        color: var(--admin-muted);
        background: var(--admin-bg);
        border-radius: 9px;
        font-size: 11px;
        transition:
            color 0.2s ease,
            background 0.2s ease,
            transform 0.2s ease;
    }

    .admin-management-card:hover .admin-management-arrow {
        color: #ffffff;
        background: var(--menu-accent);
        transform: translate(2px, -2px);
    }

    .admin-management-card-body {
        position: relative;
        z-index: 2;
        margin-top: auto;
        padding-top: 22px;
    }

    .admin-management-title {
        display: block;
        color: var(--admin-navy);
        font-size: 13px;
        font-weight: 850;
        line-height: 1.4;
    }

    .admin-management-description {
        display: block;
        margin-top: 5px;
        color: var(--admin-muted);
        font-size: 10px;
        line-height: 1.55;
    }

    @media (max-width: 1199px) {
        .admin-management-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 850px) {
        .admin-management-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 560px) {
        .admin-management-section {
            margin-top: 20px;
        }

        .admin-management-header {
            align-items: flex-start;
            flex-direction: column;
            margin-bottom: 14px;
        }

        .admin-management-grid {
            grid-template-columns: 1fr;
            gap: 11px;
        }

        .admin-management-card {
            min-height: 150px;
            padding: 16px;
        }

        .admin-management-card-body {
            padding-top: 18px;
        }
    }
</style>
@endpush

<section class="admin-management-section">

    <div class="admin-management-header">

        <div>
            <h2>Menu Manajemen</h2>

            <p>
                Akses cepat untuk mengelola seluruh informasi,
                publikasi, dan pengaturan website desa.
            </p>
        </div>

        <span class="admin-management-count">
            <i class="bi bi-grid-3x3-gap"></i>
            {{ count($menus) }} Menu
        </span>

    </div>

    <div class="admin-management-grid">

        @foreach($menus as $menu)

            <a
                href="{{ $menu['route'] }}"
                class="
                    admin-management-card
                    is-{{ $menu['accent'] }}
                "
                aria-label="Kelola {{ $menu['title'] }}"
            >

                <div class="admin-management-card-top">

                    <span class="admin-management-icon">
                        <i
                            class="bi {{ $menu['icon'] }}"
                            aria-hidden="true"
                        ></i>
                    </span>

                    <span
                        class="admin-management-arrow"
                        aria-hidden="true"
                    >
                        <i class="bi bi-arrow-up-right"></i>
                    </span>

                </div>

                <div class="admin-management-card-body">

                    <span class="admin-management-title">
                        {{ $menu['title'] }}
                    </span>

                    <span class="admin-management-description">
                        {{ $menu['description'] }}
                    </span>

                </div>

            </a>

        @endforeach

    </div>

</section>
