<aside class="sidebar admin-sidebar">

    @php
        $desa = \App\Models\VillageProfile::first();
        $admin = auth()->user();

        $adminInitial = strtoupper(
            mb_substr($admin?->name ?? 'A', 0, 1)
        );

        $role = $admin?->role;

        $isSuperAdmin = $role === 'Super Admin';

        $canManageVillageData = in_array(
            $role,
            [
                'Super Admin',
                'Admin',
            ],
            true
        );

        $canManagePublications = in_array(
            $role,
            [
                'Super Admin',
                'Admin',
                'Editor',
            ],
            true
        );

        $menuGroups = [
            [
                'label' => 'Ringkasan',
                'show' => true,
                'items' => [
                    [
                        'route' => 'admin.dashboard',
                        'pattern' => 'admin.dashboard',
                        'icon' => 'bi-grid',
                        'label' => 'Dashboard',
                    ],
                ],
            ],
            [
                'label' => 'Profil Desa',
                'show' => $canManageVillageData,
                'items' => [
                    [
                        'route' => 'admin.identitas',
                        'pattern' => 'admin.identitas*',
                        'icon' => 'bi-building',
                        'label' => 'Identitas Desa',
                    ],
                    [
                        'route' => 'admin.visi',
                        'pattern' => 'admin.visi*',
                        'icon' => 'bi-bullseye',
                        'label' => 'Visi & Misi',
                    ],
                    [
                        'route' => 'admin.sejarah',
                        'pattern' => 'admin.sejarah*',
                        'icon' => 'bi-clock-history',
                        'label' => 'Sejarah Desa',
                    ],
                    [
                        'route' => 'admin.wilayah',
                        'pattern' => 'admin.wilayah*',
                        'icon' => 'bi-map',
                        'label' => 'Wilayah Desa',
                    ],
                ],
            ],
            [
                'label' => 'Pemerintahan',
                'show' => $canManageVillageData,
                'items' => [
                    [
                        'route' => 'admin.aparat',
                        'pattern' => 'admin.aparat*',
                        'icon' => 'bi-person-badge',
                        'label' => 'Aparat Desa',
                    ],
                    [
                        'route' => 'admin.bpd',
                        'pattern' => 'admin.bpd*',
                        'icon' => 'bi-people',
                        'label' => 'BPD',
                    ],
                    [
                        'route' => 'admin.lembaga',
                        'pattern' => 'admin.lembaga*',
                        'icon' => 'bi-diagram-3',
                        'label' => 'Lembaga Desa',
                    ],
                ],
            ],
            [
                'label' => 'Publikasi',
                'show' => $canManagePublications,
                'items' => [
                    [
                        'route' => 'admin.berita',
                        'pattern' => 'admin.berita*',
                        'icon' => 'bi-newspaper',
                        'label' => 'Berita',
                    ],
                    [
                        'route' => 'admin.pengumuman',
                        'pattern' => 'admin.pengumuman*',
                        'icon' => 'bi-megaphone-fill',
                        'label' => 'Pengumuman',
                    ],
                    [
                        'route' => 'admin.agenda',
                        'pattern' => 'admin.agenda*',
                        'icon' => 'bi-calendar-event',
                        'label' => 'Agenda',
                    ],
                    [
                        'route' => 'admin.galeri',
                        'pattern' => 'admin.galeri*',
                        'icon' => 'bi-images',
                        'label' => 'Galeri',
                    ],
                ],
            ],
            [
                'label' => 'Data Desa',
                'show' => $canManageVillageData,
                'items' => [
                    [
                        'route' => 'admin.potensi',
                        'pattern' => 'admin.potensi*',
                        'icon' => 'bi-tree',
                        'label' => 'Potensi Desa',
                    ],
                    [
                        'route' => 'admin.layanan',
                        'pattern' => 'admin.layanan*',
                        'icon' => 'bi-ui-checks-grid',
                        'label' => 'Layanan Desa',
                    ],
                    [
                        'route' => 'admin.statistik',
                        'pattern' => 'admin.statistik*',
                        'icon' => 'bi-bar-chart-line-fill',
                        'label' => 'Statistik',
                    ],
                    [
                        'route' => 'admin.kontak',
                        'pattern' => 'admin.kontak*',
                        'icon' => 'bi-telephone',
                        'label' => 'Kontak',
                    ],
                ],
            ],
            [
                'label' => 'Akun dan Sistem',
                'show' => true,
                'items' => [
                    [
                        'route' => 'admin.profil',
                        'pattern' => 'admin.profil*',
                        'icon' => 'bi-person-circle',
                        'label' => 'Profil Saya',
                    ],
                ],
            ],
        ];

        if ($isSuperAdmin) {
            $menuGroups[count($menuGroups) - 1]['items'][] = [
                'route' => 'admin.pengaturan',
                'pattern' => 'admin.pengaturan*',
                'icon' => 'bi-gear',
                'label' => 'Pengaturan',
            ];

            $menuGroups[count($menuGroups) - 1]['items'][] = [
                'route' => 'admin.users',
                'pattern' => 'admin.users*',
                'icon' => 'bi-person-gear',
                'label' => 'Manajemen Admin',
            ];
        }
    @endphp

    <button
        type="button"
        class="sidebar-close"
        aria-label="Tutup menu admin"
        data-sidebar-close
    >
        <i class="bi bi-x-lg"></i>
    </button>

    <div class="sidebar-top">

        <div class="village-logo">

            @if($desa && $desa->logo)

                <img
                    src="{{ asset(
                        'storage/' .
                        ltrim($desa->logo, '/')
                    ) }}"
                    alt="Logo {{ $desa->nama_desa ?? 'Desa' }}"
                >

            @else

                <div class="logo-default">
                    {{ strtoupper(
                        mb_substr(
                            $desa?->nama_desa ?? 'D',
                            0,
                            1
                        )
                    ) }}
                </div>

            @endif

        </div>

        <div class="village-info">

            <h5>
                {{ $desa?->nama_desa ?? 'Nama Desa' }}
            </h5>

            <small>
                {{ $desa?->kecamatan ?? '-' }},
                {{ $desa?->kabupaten ?? '-' }}
            </small>

        </div>

    </div>

    <div class="admin-card">

        @if(filled($admin?->foto))

            <img
                src="{{ asset(
                    'storage/' .
                    ltrim($admin->foto, '/')
                ) }}"
                alt="Foto {{ $admin?->name ?? 'Admin' }}"
            >

        @else

            <div class="admin-avatar-fallback">
                {{ $adminInitial }}
            </div>

        @endif

        <div>

            <h6>
                {{ $admin?->name ?? 'Administrator' }}
            </h6>

            <span>
                {{ $admin?->role ?? 'Admin' }}
            </span>

        </div>

    </div>

    <div class="sidebar-menu-scroll admin-side-menu-scroll">

        @foreach($menuGroups as $group)

            @continue(!$group['show'])

            <span class="admin-side-section-label">
                {{ $group['label'] }}
            </span>

            <ul class="admin-side-menu">

                @foreach($group['items'] as $item)

                    @php
                        $active = request()->routeIs(
                            $item['pattern']
                        );
                    @endphp

                    <li
                        class="
                            admin-side-menu-item
                            {{ $active ? 'active' : '' }}
                        "
                    >

                        <a
                            class="admin-side-menu-link"
                            href="{{ route($item['route']) }}"
                            @if($active)
                                aria-current="page"
                            @endif
                        >
                            <i
                                class="
                                    bi
                                    {{ $item['icon'] }}
                                "
                            ></i>

                            <span>
                                {{ $item['label'] }}
                            </span>
                        </a>

                    </li>

                @endforeach

            </ul>

        @endforeach

    </div>

    <div class="sidebar-bottom">

        <a
            href="{{ route('home') }}"
            target="_blank"
            rel="noopener"
        >
            <i class="bi bi-globe"></i>
            <span>Website Publik</span>
        </a>

        <form
            id="admin-logout-form"
            action="{{ route('logout') }}"
            method="POST"
        >
            @csrf

            <button
                class="logout"
                type="button"
                data-logout-open
            >
                <i class="bi bi-box-arrow-right"></i>
                <span>Keluar</span>
            </button>

        </form>

    </div>

</aside>


<div
    id="admin-logout-modal"
    class="admin-logout-modal"
    aria-hidden="true"
>
    <div
        class="admin-logout-backdrop"
        data-logout-close
    ></div>

    <section
        class="admin-logout-dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="admin-logout-title"
        aria-describedby="admin-logout-description"
    >
        <div class="admin-logout-icon">
            <i class="bi bi-box-arrow-right"></i>
        </div>

        <h3 id="admin-logout-title">
            Yakin ingin keluar?
        </h3>

        <p id="admin-logout-description">
            Anda akan keluar dari dashboard admin dan perlu login
            kembali untuk mengelola website desa.
        </p>

        <div class="admin-logout-actions">
            <button
                type="button"
                class="admin-logout-cancel"
                data-logout-close
            >
                Batal
            </button>

            <button
                type="button"
                class="admin-logout-confirm"
                data-logout-confirm
            >
                Ya, Keluar
            </button>
        </div>
    </section>
</div>

<style>
    .admin-logout-modal {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: grid;
        place-items: center;
        padding: 20px;
        visibility: hidden;
        opacity: 0;
        transition:
            opacity 0.2s ease,
            visibility 0.2s ease;
    }

    .admin-logout-modal.is-open {
        visibility: visible;
        opacity: 1;
    }

    .admin-logout-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(7, 24, 16, 0.58);
        backdrop-filter: blur(4px);
    }

    .admin-logout-dialog {
        position: relative;
        width: min(100%, 410px);
        padding: 29px;
        background: #ffffff;
        border: 1px solid #dfe9e3;
        border-radius: 20px;
        box-shadow: 0 28px 80px rgba(8, 48, 28, 0.26);
        text-align: center;
        transform: translateY(10px) scale(0.98);
        transition: transform 0.2s ease;
    }

    .admin-logout-modal.is-open .admin-logout-dialog {
        transform: translateY(0) scale(1);
    }

    .admin-logout-icon {
        width: 66px;
        height: 66px;
        display: grid;
        place-items: center;
        margin: 0 auto 17px;
        color: #b42b22;
        background: #fff1f0;
        border: 1px solid #f3cbc7;
        border-radius: 18px;
        font-size: 27px;
    }

    .admin-logout-dialog h3 {
        margin: 0;
        color: #12251c;
        font-size: 22px;
        font-weight: 900;
        letter-spacing: -0.03em;
    }

    .admin-logout-dialog p {
        margin: 10px auto 0;
        max-width: 330px;
        color: #6e7d74;
        font-size: 13px;
        line-height: 1.65;
    }

    .admin-logout-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 23px;
    }

    .admin-logout-actions button {
        min-height: 43px;
        padding: 10px 15px;
        border-radius: 11px;
        font-size: 12px;
        font-weight: 850;
        cursor: pointer;
    }

    .admin-logout-cancel {
        color: #34463c;
        background: #f5f8f6;
        border: 1px solid #dfe9e3;
    }

    .admin-logout-confirm {
        color: #ffffff;
        background: #b42b22;
        border: 1px solid #b42b22;
        box-shadow: 0 9px 20px rgba(180, 43, 34, 0.2);
    }

    .admin-logout-cancel:hover {
        background: #eef3f0;
    }

    .admin-logout-confirm:hover {
        background: #98221b;
    }

    body.admin-logout-lock {
        overflow: hidden;
    }

    @media (max-width: 480px) {
        .admin-logout-dialog {
            padding: 25px 18px;
        }

        .admin-logout-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById(
        'admin-logout-modal'
    );

    const form = document.getElementById(
        'admin-logout-form'
    );

    const openButton = document.querySelector(
        '[data-logout-open]'
    );

    const closeButtons = document.querySelectorAll(
        '[data-logout-close]'
    );

    const confirmButton = document.querySelector(
        '[data-logout-confirm]'
    );

    if (!modal || !form || !openButton || !confirmButton) {
        return;
    }

    function openModal() {
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('admin-logout-lock');

        window.setTimeout(function () {
            confirmButton.focus();
        }, 50);
    }

    function closeModal() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('admin-logout-lock');
        openButton.focus();
    }

    openButton.addEventListener('click', openModal);

    closeButtons.forEach(function (button) {
        button.addEventListener('click', closeModal);
    });

    confirmButton.addEventListener('click', function () {
        confirmButton.disabled = true;
        confirmButton.textContent = 'Sedang keluar...';
        form.submit();
    });

    document.addEventListener('keydown', function (event) {
        if (
            event.key === 'Escape' &&
            modal.classList.contains('is-open')
        ) {
            closeModal();
        }
    });
});
</script>
