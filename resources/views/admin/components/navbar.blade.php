<nav class="navbar">

    @php
        /*
         * Isi @section('title') sudah dapat berbentuk entitas HTML,
         * misalnya "Visi &amp; Misi". Decode terlebih dahulu agar saat
         * dicetak dengan {{ }} tidak mengalami encoding dua kali.
         */
        $pageTitle = html_entity_decode(
            trim($__env->yieldContent('title')),
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        ) ?: 'Dashboard';

        $admin = auth()->user();

        $adminInitial = strtoupper(
            mb_substr($admin?->name ?? 'A', 0, 1)
        );

        $searchMenuItems = [
            [
                'label' => 'Dashboard',
                'url' => route('admin.dashboard')
            ],
            [
                'label' => 'Identitas Desa',
                'url' => route('admin.identitas')
            ],
            [
                'label' => 'Visi & Misi',
                'url' => route('admin.visi')
            ],
            [
                'label' => 'Sejarah Desa',
                'url' => route('admin.sejarah')
            ],
            [
                'label' => 'Wilayah Desa',
                'url' => route('admin.wilayah')
            ],
            [
                'label' => 'Aparatur Desa',
                'url' => route('admin.aparat')
            ],
            [
                'label' => 'BPD',
                'url' => route('admin.bpd')
            ],
            [
                'label' => 'Lembaga Desa',
                'url' => route('admin.lembaga')
            ],
            [
                'label' => 'Potensi Desa',
                'url' => route('admin.potensi')
            ],
            [
                'label' => 'Berita',
                'url' => route('admin.berita')
            ],
            [
                'label' => 'Galeri',
                'url' => route('admin.galeri')
            ],
            [
                'label' => 'Agenda',
                'url' => route('admin.agenda')
            ],
            [
                'label' => 'Pengumuman',
                'url' => route('admin.pengumuman')
            ],
            [
                'label' => 'Layanan Desa',
                'url' => route('admin.layanan')
            ],
            [
                'label' => 'Statistik Desa',
                'url' => route('admin.statistik')
            ],
            [
                'label' => 'Kontak',
                'url' => route('admin.kontak')
            ],
            [
                'label' => 'Pengaturan',
                'url' => route('admin.pengaturan')
            ],
            [
                'label' => 'Profil Saya',
                'url' => route('admin.profil')
            ],
        ];

        if ($admin?->role === 'Super Admin') {
            $searchMenuItems[] = [
                'label' => 'Manajemen Admin',
                'url' => route('admin.users')
            ];
        }
    @endphp

    <button
        type="button"
        class="navbar-menu-toggle"
        aria-label="Buka menu admin"
        aria-expanded="false"
        data-sidebar-toggle
    >
        <i class="bi bi-list"></i>
    </button>

    <div class="navbar-left">

        <div class="navbar-breadcrumb">
            <span>Admin</span>
            <span class="breadcrumb-separator">/</span>
            <span>{{ $pageTitle }}</span>
        </div>

        <h1 class="navbar-title">
            {{ $pageTitle }}
        </h1>

    </div>

    <div class="navbar-center" id="admin-mobile-search">

        <div
            class="search-box"
            aria-haspopup="listbox"
            data-search-items='@json($searchMenuItems)'
        >
            <i class="bi bi-search"></i>

            <input
                id="navbar-search"
                type="search"
                placeholder="Cari menu admin..."
                autocomplete="off"
                aria-label="Cari menu admin"
                aria-controls="navbar-search-results"
            >

            <ul
                class="search-suggestions"
                id="navbar-search-results"
                role="listbox"
                aria-label="Hasil pencarian menu"
            ></ul>

        </div>

    </div>

    <div class="navbar-right">

        <button
            type="button"
            class="mobile-admin-search-toggle"
            aria-label="Buka pencarian menu"
            aria-expanded="false"
            aria-controls="admin-mobile-search"
            data-mobile-admin-search
        >
            <i class="bi bi-search"></i>
        </button>

        <div class="navbar-meta">

            <div class="date-label">
                <span id="navbar-date"></span>
                <span id="navbar-time"></span>
            </div>

        </div>

        <div
            class="notification-dropdown"
            data-notification-dropdown
        >
            <button
                type="button"
                class="notif"
                aria-label="Buka notifikasi"
                aria-haspopup="true"
                aria-expanded="false"
                aria-controls="admin-notification-panel"
                title="Notifikasi"
                data-notification-toggle
            >
                <i class="bi bi-bell"></i>
            </button>

            <div
                class="notification-panel"
                id="admin-notification-panel"
                role="dialog"
                aria-label="Notifikasi admin"
                data-notification-panel
            >
                <div class="notification-panel-header">
                    <div>
                        <strong>Notifikasi</strong>
                        <span>Informasi terbaru untuk admin</span>
                    </div>

                    <span class="notification-count">
                        0 baru
                    </span>
                </div>

                <div class="notification-empty">
                    <span class="notification-empty-icon">
                        <i class="bi bi-bell-slash"></i>
                    </span>

                    <strong>Belum ada notifikasi baru</strong>

                    <p>
                        Informasi penting dan pembaruan aktivitas
                        website akan tampil di bagian ini.
                    </p>
                </div>

                <div class="notification-quick-links">
                    <a href="{{ route('admin.berita') }}">
                        <i class="bi bi-newspaper"></i>
                        Kelola Berita
                    </a>

                    <a href="{{ route('admin.agenda') }}">
                        <i class="bi bi-calendar-event"></i>
                        Kelola Agenda
                    </a>

                    <a href="{{ route('admin.pengumuman') }}">
                        <i class="bi bi-megaphone"></i>
                        Pengumuman
                    </a>
                </div>
            </div>
        </div>

        <div class="admin-profile dropdown js-dropdown">

            <button
                type="button"
                class="profile-trigger js-profile-trigger"
                aria-haspopup="true"
                aria-expanded="false"
            >

                @if(filled($admin?->foto))

                    <img
                        src="{{ asset(
                            'storage/' . ltrim($admin->foto, '/')
                        ) }}"
                        alt="Foto {{ $admin?->name ?? 'Admin' }}"
                    >

                @else

                    <span class="profile-avatar-fallback">
                        {{ $adminInitial }}
                    </span>

                @endif

                <div class="profile-info">

                    <strong>
                        {{ $admin?->name ?? 'Administrator' }}
                    </strong>

                    <span class="profile-badge">
                        {{ $admin?->role ?? 'Admin' }}
                    </span>

                </div>

                <i class="bi bi-chevron-down"></i>

            </button>

            <div
                class="profile-menu js-profile-menu"
                aria-label="Menu profil"
            >

                <a href="{{ route('admin.profil') }}">
                    Profil Saya
                </a>

                <a href="{{ route('admin.profil') }}#password">
                    Ubah Password
                </a>

                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >
                    @csrf

                    <button type="submit">
                        Keluar
                    </button>
                </form>

            </div>

        </div>

    </div>

</nav>


<style>
    /*
     * Navbar admin Android:
     * pencarian tidak lagi tampil sebagai kapsul besar.
     * Yang tampil hanya ikon pencarian kecil. Kolom pencarian muncul
     * sebagai dropdown ketika ikon ditekan.
     */
    .mobile-admin-search-toggle {
        display: none;
    }

    @media (max-width: 991px) {
        :root {
            --admin-navbar-height: 58px !important;
        }

        .navbar {
            position: sticky !important;
            top: 0 !important;
            z-index: 1200 !important;
            height: 58px !important;
            min-height: 58px !important;
            max-height: 58px !important;
            display: grid !important;
            grid-template-columns:
                40px
                minmax(0, 1fr)
                auto !important;
            grid-template-rows: 40px !important;
            align-items: center !important;
            gap: 8px !important;
            padding: 9px 10px !important;
            overflow: visible !important;
            background: #ffffff !important;
            border-bottom: 1px solid var(--admin-border) !important;
        }

        .navbar-menu-toggle {
            grid-column: 1 !important;
            grid-row: 1 !important;
            width: 40px !important;
            height: 40px !important;
            min-width: 40px !important;
            min-height: 40px !important;
            margin: 0 !important;
            border-radius: 11px !important;
        }

        .navbar-left {
            grid-column: 2 !important;
            grid-row: 1 !important;
            min-width: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .navbar-breadcrumb {
            display: none !important;
        }

        .navbar-title {
            margin: 0 !important;
            font-size: 15px !important;
            line-height: 40px !important;
        }

        .navbar-right {
            grid-column: 3 !important;
            grid-row: 1 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            gap: 5px !important;
            min-width: 0 !important;
            margin: 0 !important;
        }

        .navbar-meta,
        .navbar .notif {
            display: none !important;
        }

        .mobile-admin-search-toggle {
            width: 38px !important;
            height: 38px !important;
            min-width: 38px !important;
            min-height: 38px !important;
            display: grid !important;
            place-items: center !important;
            flex: 0 0 38px !important;
            margin: 0 !important;
            padding: 0 !important;
            color: var(--admin-green-dark) !important;
            background: var(--admin-green-soft) !important;
            border: 1px solid rgba(22, 131, 79, 0.17) !important;
            border-radius: 10px !important;
            box-shadow: none !important;
            font-size: 14px !important;
            cursor: pointer !important;
            touch-action: manipulation !important;
        }

        .mobile-admin-search-toggle.is-open {
            color: #ffffff !important;
            background: var(--admin-green) !important;
            border-color: var(--admin-green) !important;
        }

        .profile-trigger {
            width: 38px !important;
            height: 38px !important;
            min-width: 38px !important;
            min-height: 38px !important;
            justify-content: center !important;
            margin: 0 !important;
            padding: 1px !important;
            background: transparent !important;
            border: 0 !important;
        }

        .profile-trigger img,
        .profile-trigger .profile-avatar-fallback {
            width: 34px !important;
            height: 34px !important;
            flex: 0 0 34px !important;
        }

        .profile-info,
        .profile-trigger > i {
            display: none !important;
        }

        /*
         * Pencarian menjadi dropdown kecil.
         * display:none menghilangkan kapsul lama sepenuhnya.
         */
        .navbar .navbar-center {
            position: absolute !important;
            top: calc(100% + 6px) !important;
            right: 10px !important;
            left: 10px !important;
            z-index: 1300 !important;
            width: auto !important;
            height: auto !important;
            min-height: 0 !important;
            max-height: none !important;
            display: none !important;
            grid-column: auto !important;
            grid-row: auto !important;
            margin: 0 !important;
            padding: 8px !important;
            overflow: visible !important;
            background: #ffffff !important;
            border: 1px solid var(--admin-border) !important;
            border-radius: 12px !important;
            box-shadow: 0 15px 38px rgba(18, 69, 43, 0.16) !important;
        }

        .navbar .navbar-center.mobile-search-open {
            display: block !important;
        }

        .navbar .navbar-center::before,
        .navbar .navbar-center::after,
        .navbar .search-box::before,
        .navbar .search-box::after {
            display: none !important;
            content: none !important;
        }

        .navbar .search-box {
            position: relative !important;
            width: 100% !important;
            height: 36px !important;
            min-height: 36px !important;
            max-height: 36px !important;
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
        }

        .navbar .search-box input,
        .navbar #navbar-search {
            width: 100% !important;
            height: 36px !important;
            min-height: 36px !important;
            max-height: 36px !important;
            margin: 0 !important;
            padding: 0 12px 0 35px !important;
            color: var(--admin-navy) !important;
            background: #f7faf8 !important;
            border: 1px solid var(--admin-border) !important;
            border-radius: 9px !important;
            box-shadow: none !important;
            font-size: 10.5px !important;
            line-height: 36px !important;
        }

        .navbar .search-box > i {
            position: absolute !important;
            top: 50% !important;
            left: 12px !important;
            z-index: 2 !important;
            color: var(--admin-green) !important;
            font-size: 11px !important;
            transform: translateY(-50%) !important;
        }

        .navbar .search-suggestions {
            top: calc(100% + 7px) !important;
            right: 0 !important;
            left: 0 !important;
            max-height: min(280px, 48vh) !important;
            border-radius: 10px !important;
        }

        .profile-menu {
            top: calc(100% + 8px) !important;
            right: 0 !important;
            width: min(230px, calc(100vw - 20px)) !important;
        }
    }

    @media (max-width: 420px) {
        .navbar {
            grid-template-columns:
                38px
                minmax(0, 1fr)
                auto !important;
            padding-inline: 8px !important;
        }

        .navbar-menu-toggle,
        .mobile-admin-search-toggle,
        .profile-trigger {
            width: 36px !important;
            height: 36px !important;
            min-width: 36px !important;
            min-height: 36px !important;
        }

        .navbar-title {
            font-size: 14px !important;
        }

        .navbar .navbar-center {
            right: 8px !important;
            left: 8px !important;
        }
    }

    /*
     * DESKTOP
     * Lebar setiap bagian dikunci secara proporsional agar pencarian
     * tidak mendorong tanggal dan profil menjadi sempit.
     */
    @media (min-width: 992px) {
        .mobile-admin-search-toggle {
            display: none !important;
        }

        .navbar {
            min-height: 82px !important;
            grid-template-columns:
                minmax(230px, 270px)
                minmax(320px, 620px)
                minmax(390px, 1fr) !important;
            align-items: center !important;
            justify-content: stretch !important;
            gap: 20px !important;
            padding: 12px 28px !important;
        }

        .navbar-left {
            width: 100% !important;
            min-width: 0 !important;
        }

        .navbar-breadcrumb {
            min-width: 0 !important;
            flex-wrap: nowrap !important;
            overflow: hidden !important;
            white-space: nowrap !important;
        }

        .navbar-breadcrumb span:last-child {
            min-width: 0 !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        .navbar-title {
            max-width: 100% !important;
            margin-top: 5px !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }

        .navbar .navbar-center {
            width: 100% !important;
            min-width: 0 !important;
            max-width: 620px !important;
            display: block !important;
            justify-self: stretch !important;
        }

        .navbar .search-box,
        .navbar .search-box input {
            width: 100% !important;
        }

        .navbar .search-box input {
            height: 50px !important;
            padding-right: 18px !important;
            border-radius: 15px !important;
        }

        .navbar-right {
            width: 100% !important;
            min-width: 390px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            gap: 12px !important;
            justify-self: stretch !important;
        }

        .navbar-meta {
            min-width: 126px !important;
            flex: 0 0 126px !important;
            padding: 0 4px 0 0 !important;
        }

        .date-label {
            width: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-end !important;
            justify-content: center !important;
            text-align: right !important;
            white-space: nowrap !important;
            line-height: 1.2 !important;
        }

        .date-label span {
            width: 100% !important;
            display: block !important;
            white-space: nowrap !important;
        }

        #navbar-date {
            overflow: hidden !important;
            font-size: 10px !important;
            font-weight: 850 !important;
            text-overflow: ellipsis !important;
        }

        #navbar-time {
            margin-top: 5px !important;
            color: var(--admin-navy) !important;
            font-size: 13px !important;
            font-weight: 850 !important;
            letter-spacing: 0.02em !important;
        }

        .navbar .notif {
            width: 48px !important;
            height: 48px !important;
            flex: 0 0 48px !important;
            border-radius: 14px !important;
        }

        .admin-profile {
            min-width: 0 !important;
            flex: 0 0 auto !important;
        }

        .profile-trigger {
            width: 245px !important;
            max-width: 245px !important;
            min-height: 54px !important;
            gap: 11px !important;
            padding: 6px 11px 6px 6px !important;
            border-radius: 15px !important;
        }

        .profile-trigger img,
        .profile-trigger .profile-avatar-fallback {
            width: 42px !important;
            height: 42px !important;
            flex: 0 0 42px !important;
            border-radius: 11px !important;
        }

        .profile-info {
            min-width: 0 !important;
            flex: 1 1 auto !important;
        }

        .profile-info strong {
            max-width: 150px !important;
            font-size: 12px !important;
        }

        .profile-badge {
            font-size: 9.5px !important;
        }

        .profile-trigger > i {
            flex: 0 0 auto !important;
        }
    }

    /*
     * Laptop sedang: tanggal disembunyikan supaya bagian lain tetap
     * sejajar. Waktu dan tanggal masih tersedia pada perangkat lebar.
     */
    @media (min-width: 992px) and (max-width: 1279px) {
        .navbar {
            grid-template-columns:
                minmax(190px, 220px)
                minmax(250px, 1fr)
                minmax(285px, 320px) !important;
            gap: 13px !important;
            padding-inline: 18px !important;
        }

        .navbar-meta {
            display: none !important;
        }

        .navbar-right {
            min-width: 285px !important;
        }

        .profile-trigger {
            width: 220px !important;
            max-width: 220px !important;
        }

        .profile-info strong {
            max-width: 130px !important;
        }
    }

    /*
     * Desktop menengah: tanggal tetap satu baris dan profil sedikit
     * diperkecil agar pencarian tidak terlalu lebar.
     */
    @media (min-width: 1280px) and (max-width: 1450px) {
        .navbar {
            grid-template-columns:
                minmax(215px, 240px)
                minmax(290px, 1fr)
                minmax(395px, 430px) !important;
            gap: 15px !important;
            padding-inline: 22px !important;
        }

        .navbar .navbar-center {
            max-width: none !important;
        }

        .navbar-right {
            min-width: 395px !important;
        }

        .navbar-meta {
            min-width: 112px !important;
            flex-basis: 112px !important;
        }

        .profile-trigger {
            width: 220px !important;
            max-width: 220px !important;
        }

        .profile-info strong {
            max-width: 128px !important;
        }
    }

    /*
     * DESKTOP — ANTI TUMPANG TINDIH
     * Membatasi lebar pencarian dan memberi ruang tetap untuk
     * tanggal, notifikasi, serta profil admin.
     */
    @media (min-width: 992px) {
        .navbar,
        .navbar *,
        .navbar *::before,
        .navbar *::after {
            box-sizing: border-box !important;
        }

        .navbar {
            grid-template-columns:
                minmax(210px, 280px)
                minmax(260px, 1fr)
                auto !important;
            gap: 24px !important;
            padding: 12px 26px !important;
        }

        .navbar .navbar-center {
            width: min(100%, 520px) !important;
            max-width: 520px !important;
            min-width: 0 !important;
            justify-self: center !important;
        }

        .navbar .search-box,
        .navbar .search-box input {
            width: 100% !important;
            max-width: 100% !important;
        }

        .navbar-right {
            width: auto !important;
            min-width: 0 !important;
            justify-self: end !important;
            justify-content: flex-end !important;
            gap: 12px !important;
            margin-left: 0 !important;
        }

        .navbar-meta {
            min-width: 128px !important;
            flex: 0 0 128px !important;
            margin: 0 !important;
            padding: 8px 11px !important;
            background: #f7faf8 !important;
            border: 1px solid var(--admin-border) !important;
            border-radius: 13px !important;
        }

        .date-label {
            align-items: center !important;
            text-align: center !important;
        }

        #navbar-date {
            font-size: 9.5px !important;
        }

        #navbar-time {
            margin-top: 4px !important;
            font-size: 12.5px !important;
        }

        .navbar .notif {
            width: 48px !important;
            height: 48px !important;
            flex: 0 0 48px !important;
        }

        .profile-trigger {
            width: 245px !important;
            max-width: 245px !important;
            min-width: 0 !important;
        }
    }

    /*
     * Laptop: tanggal disembunyikan supaya pencarian dan profil
     * tetap memiliki ruang yang cukup.
     */
    @media (min-width: 992px) and (max-width: 1299px) {
        .navbar {
            grid-template-columns:
                minmax(185px, 220px)
                minmax(230px, 1fr)
                auto !important;
            gap: 14px !important;
            padding-inline: 18px !important;
        }

        .navbar .navbar-center {
            width: min(100%, 440px) !important;
            max-width: 440px !important;
        }

        .navbar-meta {
            display: none !important;
        }

        .profile-trigger {
            width: 215px !important;
            max-width: 215px !important;
        }
    }

    /*
     * Desktop menengah: pencarian sedikit diperkecil agar ada
     * jarak nyata sebelum kartu tanggal.
     */
    @media (min-width: 1300px) and (max-width: 1499px) {
        .navbar {
            grid-template-columns:
                minmax(205px, 245px)
                minmax(260px, 1fr)
                auto !important;
            gap: 18px !important;
            padding-inline: 22px !important;
        }

        .navbar .navbar-center {
            width: min(100%, 455px) !important;
            max-width: 455px !important;
        }

        .navbar-meta {
            min-width: 116px !important;
            flex-basis: 116px !important;
        }

        .profile-trigger {
            width: 220px !important;
            max-width: 220px !important;
        }
    }

    @media (min-width: 1500px) {
        .navbar .navbar-center {
            width: min(100%, 540px) !important;
            max-width: 540px !important;
        }
    }


    /* =====================================================
       DROPDOWN NOTIFIKASI ADMIN
    ===================================================== */

    .notification-dropdown {
        position: relative;
        flex: 0 0 auto;
    }

    .notification-panel {
        position: absolute;
        top: calc(100% + 11px);
        right: 0;
        z-index: 1700;
        width: min(340px, calc(100vw - 24px));
        overflow: hidden;
        display: none;
        background: #ffffff;
        border: 1px solid var(--admin-border);
        border-radius: 17px;
        box-shadow: 0 22px 55px rgba(18, 69, 43, 0.18);
    }

    .notification-dropdown.is-open
    .notification-panel {
        display: block;
        animation: adminNotificationIn 0.16s ease;
    }

    .notification-dropdown.is-open
    .notif {
        color: #ffffff !important;
        background: var(--admin-green) !important;
        border-color: var(--admin-green) !important;
    }

    .notification-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 16px 17px;
        background: #f7faf8;
        border-bottom: 1px solid var(--admin-border);
    }

    .notification-panel-header > div {
        min-width: 0;
    }

    .notification-panel-header strong {
        display: block;
        color: var(--admin-navy);
        font-size: 13px;
        font-weight: 850;
    }

    .notification-panel-header span:not(
        .notification-count
    ) {
        display: block;
        margin-top: 3px;
        color: var(--admin-muted);
        font-size: 9px;
        line-height: 1.4;
    }

    .notification-count {
        flex: 0 0 auto;
        padding: 5px 8px;
        color: var(--admin-green-dark);
        background: var(--admin-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.13);
        border-radius: 999px;
        font-size: 8.5px;
        font-weight: 800;
    }

    .notification-empty {
        padding: 24px 20px 21px;
        text-align: center;
    }

    .notification-empty-icon {
        width: 45px;
        height: 45px;
        display: grid;
        place-items: center;
        margin: 0 auto 11px;
        color: var(--admin-green);
        background: var(--admin-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.14);
        border-radius: 13px;
        font-size: 17px;
    }

    .notification-empty strong {
        display: block;
        color: var(--admin-navy);
        font-size: 11.5px;
        font-weight: 850;
    }

    .notification-empty p {
        max-width: 250px;
        margin: 7px auto 0;
        color: var(--admin-muted);
        font-size: 9px;
        line-height: 1.6;
    }

    .notification-quick-links {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 7px;
        padding: 11px;
        background: #fbfdfc;
        border-top: 1px solid var(--admin-border);
    }

    .notification-quick-links a {
        min-width: 0;
        min-height: 59px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 5px;
        color: var(--admin-green-dark);
        background: #ffffff;
        border: 1px solid var(--admin-border);
        border-radius: 11px;
        font-size: 8px;
        font-weight: 750;
        text-align: center;
        text-decoration: none;
        transition:
            color 0.18s ease,
            background 0.18s ease,
            border-color 0.18s ease;
    }

    .notification-quick-links a:hover {
        color: #ffffff;
        background: var(--admin-green);
        border-color: var(--admin-green);
    }

    .notification-quick-links i {
        font-size: 14px;
    }

    @keyframes adminNotificationIn {
        from {
            opacity: 0;
            transform: translateY(-7px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 991px) {
        .navbar-meta {
            display: none !important;
        }

        .navbar .notification-dropdown {
            display: block !important;
        }

        .navbar .notif {
            width: 38px !important;
            height: 38px !important;
            min-width: 38px !important;
            min-height: 38px !important;
            display: grid !important;
            place-items: center !important;
            flex: 0 0 38px !important;
            margin: 0 !important;
            padding: 0 !important;
            color: var(--admin-green-dark) !important;
            background: var(--admin-green-soft) !important;
            border: 1px solid rgba(22, 131, 79, 0.17) !important;
            border-radius: 10px !important;
            box-shadow: none !important;
            font-size: 14px !important;
            cursor: pointer !important;
        }

        .notification-panel {
            position: fixed;
            top: 64px;
            right: 8px;
            left: 8px;
            width: auto;
            max-width: none;
        }
    }

    @media (max-width: 420px) {
        .navbar .notif {
            width: 36px !important;
            height: 36px !important;
            min-width: 36px !important;
            min-height: 36px !important;
        }

        .notification-panel {
            top: 62px;
        }
    }

</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchToggle = document.querySelector(
        '[data-mobile-admin-search]'
    );

    const searchPanel = document.getElementById(
        'admin-mobile-search'
    );

    const searchInput = document.getElementById(
        'navbar-search'
    );

    if (!searchToggle || !searchPanel) {
        return;
    }

    function closeMobileSearch() {
        searchPanel.classList.remove(
            'mobile-search-open'
        );

        searchToggle.classList.remove('is-open');

        searchToggle.setAttribute(
            'aria-expanded',
            'false'
        );
    }

    function openMobileSearch() {
        searchPanel.classList.add(
            'mobile-search-open'
        );

        searchToggle.classList.add('is-open');

        searchToggle.setAttribute(
            'aria-expanded',
            'true'
        );

        window.setTimeout(function () {
            searchInput?.focus();
        }, 60);
    }

    searchToggle.addEventListener(
        'click',
        function (event) {
            event.preventDefault();
            event.stopPropagation();

            if (
                searchPanel.classList.contains(
                    'mobile-search-open'
                )
            ) {
                closeMobileSearch();
            } else {
                openMobileSearch();
            }
        }
    );

    document.addEventListener(
        'click',
        function (event) {
            if (
                !searchPanel.contains(event.target) &&
                !searchToggle.contains(event.target)
            ) {
                closeMobileSearch();
            }
        }
    );

    document.addEventListener(
        'keydown',
        function (event) {
            if (event.key === 'Escape') {
                closeMobileSearch();
            }
        }
    );

    window.addEventListener(
        'resize',
        function () {
            if (window.innerWidth >= 992) {
                closeMobileSearch();
            }
        }
    );
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const notificationDropdown = document.querySelector(
        '[data-notification-dropdown]'
    );

    const notificationToggle = document.querySelector(
        '[data-notification-toggle]'
    );

    const notificationPanel = document.querySelector(
        '[data-notification-panel]'
    );

    if (
        !notificationDropdown ||
        !notificationToggle ||
        !notificationPanel
    ) {
        return;
    }

    function closeNotificationPanel() {
        notificationDropdown.classList.remove('is-open');

        notificationToggle.setAttribute(
            'aria-expanded',
            'false'
        );
    }

    function openNotificationPanel() {
        notificationDropdown.classList.add('is-open');

        notificationToggle.setAttribute(
            'aria-expanded',
            'true'
        );
    }

    notificationToggle.addEventListener(
        'click',
        function (event) {
            event.preventDefault();
            event.stopPropagation();

            if (
                notificationDropdown.classList.contains(
                    'is-open'
                )
            ) {
                closeNotificationPanel();
            } else {
                openNotificationPanel();
            }
        }
    );

    notificationPanel.addEventListener(
        'click',
        function (event) {
            event.stopPropagation();
        }
    );

    document.addEventListener(
        'click',
        function (event) {
            if (
                !notificationDropdown.contains(event.target)
            ) {
                closeNotificationPanel();
            }
        }
    );

    document.addEventListener(
        'keydown',
        function (event) {
            if (event.key === 'Escape') {
                closeNotificationPanel();
            }
        }
    );
});
</script>

