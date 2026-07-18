@php
    $statItems = [
        [
            'label' => 'Jumlah Berita',
            'value' => $jumlahBerita ?? 0,
            'icon' => 'bi-newspaper',
            'route' => 'admin.berita',
            'class' => 'is-green',
            'description' => 'Berita yang telah ditambahkan',
        ],
        [
            'label' => 'Jumlah Aparat',
            'value' => $jumlahAparat ?? 0,
            'icon' => 'bi-person-badge',
            'route' => 'admin.aparat',
            'class' => 'is-amber',
            'description' => 'Data aparatur pemerintah desa',
        ],
        [
            'label' => 'Jumlah Foto',
            'value' => $jumlahGaleri ?? 0,
            'icon' => 'bi-images',
            'route' => 'admin.galeri',
            'class' => 'is-blue',
            'description' => 'Foto yang tersedia di galeri',
        ],
        [
            'label' => 'Jumlah Potensi',
            'value' => $jumlahPotensi ?? 0,
            'icon' => 'bi-tree',
            'route' => 'admin.potensi',
            'class' => 'is-purple',
            'description' => 'Potensi unggulan yang dikelola',
        ],
    ];
@endphp

@push('styles')
<style>
    .admin-statistics-section {
        margin-top: 24px;
    }

    .admin-statistics-heading {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 16px;
    }

    .admin-statistics-heading h2 {
        margin: 0;
        color: var(--admin-navy);
        font-size: 18px;
        font-weight: 850;
        line-height: 1.3;
        letter-spacing: -0.025em;
    }

    .admin-statistics-heading p {
        margin: 4px 0 0;
        color: var(--admin-muted);
        font-size: 11px;
        line-height: 1.55;
    }

    .admin-statistics-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }

    .admin-stat-card {
        position: relative;
        min-width: 0;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        min-height: 176px;
        padding: 19px;
        color: inherit;
        background: #ffffff;
        border: 1px solid var(--admin-border);
        border-radius: 18px;
        box-shadow: 0 10px 28px rgba(18, 69, 43, 0.055);
        text-decoration: none;
        transition:
            transform 0.22s ease,
            box-shadow 0.22s ease,
            border-color 0.22s ease;
    }

    .admin-stat-card::before {
        content: "";
        position: absolute;
        top: -56px;
        right: -48px;
        width: 128px;
        height: 128px;
        border-radius: 50%;
        background: var(--stat-soft);
        transition: transform 0.25s ease;
    }

    .admin-stat-card:hover {
        color: inherit;
        border-color: var(--stat-border);
        box-shadow: 0 18px 38px rgba(18, 69, 43, 0.105);
        transform: translateY(-4px);
    }

    .admin-stat-card:hover::before {
        transform: scale(1.12);
    }

    .admin-stat-card.is-green {
        --stat-color: #16834f;
        --stat-soft: rgba(22, 131, 79, 0.1);
        --stat-border: rgba(22, 131, 79, 0.3);
    }

    .admin-stat-card.is-amber {
        --stat-color: #b7791f;
        --stat-soft: rgba(183, 121, 31, 0.11);
        --stat-border: rgba(183, 121, 31, 0.3);
    }

    .admin-stat-card.is-blue {
        --stat-color: #2478e8;
        --stat-soft: rgba(36, 120, 232, 0.1);
        --stat-border: rgba(36, 120, 232, 0.28);
    }

    .admin-stat-card.is-purple {
        --stat-color: #7653c8;
        --stat-soft: rgba(118, 83, 200, 0.1);
        --stat-border: rgba(118, 83, 200, 0.28);
    }

    .admin-stat-card-top {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }

    .admin-stat-icon {
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        display: grid;
        place-items: center;
        color: var(--stat-color);
        background: var(--stat-soft);
        border: 1px solid var(--stat-border);
        border-radius: 14px;
        font-size: 18px;
    }

    .admin-stat-arrow {
        width: 30px;
        height: 30px;
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

    .admin-stat-card:hover .admin-stat-arrow {
        color: #ffffff;
        background: var(--stat-color);
        transform: translate(2px, -2px);
    }

    .admin-stat-value {
        position: relative;
        z-index: 2;
        display: block;
        margin-top: 18px;
        color: var(--admin-navy);
        font-size: 29px;
        font-weight: 900;
        line-height: 1;
        letter-spacing: -0.045em;
    }

    .admin-stat-label {
        position: relative;
        z-index: 2;
        display: block;
        margin-top: 8px;
        color: var(--admin-navy);
        font-size: 12px;
        font-weight: 850;
        line-height: 1.4;
    }

    .admin-stat-description {
        position: relative;
        z-index: 2;
        display: block;
        margin-top: 4px;
        color: var(--admin-muted);
        font-size: 10px;
        line-height: 1.5;
    }

    @media (max-width: 1199px) {
        .admin-statistics-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 620px) {
        .admin-statistics-section {
            margin-top: 18px;
        }

        .admin-statistics-heading {
            align-items: flex-start;
            flex-direction: column;
            margin-bottom: 13px;
        }

        .admin-statistics-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .admin-stat-card {
            min-height: 156px;
            padding: 17px;
        }

        .admin-stat-value {
            font-size: 27px;
        }
    }
</style>
@endpush

<section class="admin-statistics-section">

    <div class="admin-statistics-heading">

        <div>
            <h2>Ringkasan Data Desa</h2>

            <p>
                Ikhtisar data utama yang dikelola melalui dashboard.
            </p>
        </div>

    </div>

    <div class="admin-statistics-grid">

        @foreach($statItems as $item)

            <a
                href="{{ route($item['route']) }}"
                class="admin-stat-card {{ $item['class'] }}"
            >

                <div class="admin-stat-card-top">

                    <span class="admin-stat-icon">
                        <i class="bi {{ $item['icon'] }}"></i>
                    </span>

                    <span class="admin-stat-arrow">
                        <i class="bi bi-arrow-up-right"></i>
                    </span>

                </div>

                <strong class="admin-stat-value">
                    {{ number_format(
                        (int) $item['value'],
                        0,
                        ',',
                        '.'
                    ) }}
                </strong>

                <span class="admin-stat-label">
                    {{ $item['label'] }}
                </span>

                <span class="admin-stat-description">
                    {{ $item['description'] }}
                </span>

            </a>

        @endforeach

    </div>

</section>
