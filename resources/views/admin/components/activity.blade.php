@php
    $latestNews = $beritaTerbaru ?? collect();

    $newsIndexUrl = \Illuminate\Support\Facades\Route::has(
        'admin.berita'
    )
        ? route('admin.berita')
        : '#';
@endphp

@push('styles')
<style>
    .admin-activity-section {
        margin-top: 26px;
    }

    .admin-activity-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .admin-activity-card {
        min-width: 0;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--admin-border);
        border-radius: 19px;
        box-shadow: 0 10px 30px rgba(18, 69, 43, 0.055);
    }

    .admin-activity-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        padding: 19px 20px 16px;
        border-bottom: 1px solid var(--admin-border);
    }

    .admin-activity-card-header h2 {
        margin: 0;
        color: var(--admin-navy);
        font-size: 17px;
        font-weight: 850;
        line-height: 1.3;
        letter-spacing: -0.025em;
    }

    .admin-activity-card-header p {
        margin: 4px 0 0;
        color: var(--admin-muted);
        font-size: 10px;
        line-height: 1.55;
    }

    .admin-activity-card-link {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 10px;
        color: var(--admin-green-dark);
        background: var(--admin-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 10px;
        text-decoration: none;
        font-size: 10px;
        font-weight: 850;
        transition:
            color 0.2s ease,
            background 0.2s ease,
            transform 0.2s ease;
    }

    .admin-activity-card-link:hover {
        color: #ffffff;
        background: var(--admin-green);
        transform: translateX(2px);
    }

    .admin-activity-list {
        display: grid;
        padding: 8px 12px 12px;
    }

    .admin-activity-item {
        display: grid;
        grid-template-columns: 42px minmax(0, 1fr);
        gap: 12px;
        align-items: start;
        padding: 12px 8px;
        border-bottom: 1px solid #edf2ef;
    }

    .admin-activity-item:last-child {
        border-bottom: 0;
    }

    .admin-activity-icon {
        width: 42px;
        height: 42px;
        display: grid;
        place-items: center;
        color: var(--admin-green);
        background: var(--admin-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 12px;
        font-size: 15px;
    }

    .admin-activity-content {
        min-width: 0;
        padding-top: 1px;
    }

    .admin-activity-content strong {
        display: -webkit-box;
        overflow: hidden;
        color: var(--admin-navy);
        font-size: 12px;
        font-weight: 800;
        line-height: 1.45;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .admin-activity-meta {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 6px;
        color: var(--admin-muted);
        font-size: 10px;
        line-height: 1.4;
    }

    .admin-activity-meta i {
        color: var(--admin-green);
        font-size: 10px;
    }

    .admin-news-list {
        display: grid;
        padding: 8px 12px 12px;
    }

    .admin-news-item {
        display: grid;
        grid-template-columns: 76px minmax(0, 1fr);
        gap: 12px;
        align-items: center;
        padding: 12px 8px;
        color: inherit;
        border-bottom: 1px solid #edf2ef;
        text-decoration: none;
        transition:
            background 0.2s ease,
            transform 0.2s ease;
    }

    .admin-news-item:last-child {
        border-bottom: 0;
    }

    .admin-news-item:hover {
        color: inherit;
        background: var(--admin-bg);
        border-radius: 12px;
        transform: translateX(2px);
    }

    .admin-news-image {
        width: 76px;
        height: 70px;
        overflow: hidden;
        background: var(--admin-green-soft);
        border: 1px solid var(--admin-border);
        border-radius: 12px;
    }

    .admin-news-image img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .admin-news-placeholder {
        width: 100%;
        height: 100%;
        display: grid;
        place-items: center;
        color: var(--admin-green);
        background:
            radial-gradient(
                circle at center,
                rgba(22, 131, 79, 0.12),
                transparent 48%
            ),
            var(--admin-green-soft);
        font-size: 21px;
    }

    .admin-news-content {
        min-width: 0;
    }

    .admin-news-content strong {
        display: -webkit-box;
        overflow: hidden;
        color: var(--admin-navy);
        font-size: 12px;
        font-weight: 850;
        line-height: 1.45;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .admin-news-content p {
        display: -webkit-box;
        margin: 6px 0 0;
        overflow: hidden;
        color: var(--admin-muted);
        font-size: 10px;
        line-height: 1.55;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .admin-news-date {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 7px;
        color: var(--admin-green);
        font-size: 9px;
        font-weight: 750;
    }

    .admin-activity-empty {
        display: grid;
        place-items: center;
        min-height: 220px;
        padding: 28px;
        text-align: center;
    }

    .admin-activity-empty-icon {
        width: 54px;
        height: 54px;
        display: grid;
        place-items: center;
        margin: 0 auto 12px;
        color: var(--admin-green);
        background: var(--admin-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.15);
        border-radius: 15px;
        font-size: 21px;
    }

    .admin-activity-empty h3 {
        margin: 0;
        color: var(--admin-navy);
        font-size: 14px;
        font-weight: 850;
    }

    .admin-activity-empty p {
        margin: 6px 0 0;
        color: var(--admin-muted);
        font-size: 10px;
        line-height: 1.55;
    }

    @media (max-width: 991px) {
        .admin-activity-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 560px) {
        .admin-activity-section {
            margin-top: 20px;
        }

        .admin-activity-card-header {
            padding: 17px 16px 14px;
        }

        .admin-activity-list,
        .admin-news-list {
            padding-inline: 8px;
        }

        .admin-news-item {
            grid-template-columns: 68px minmax(0, 1fr);
        }

        .admin-news-image {
            width: 68px;
            height: 64px;
        }
    }
</style>
@endpush

<section class="admin-activity-section">

    <div class="admin-activity-grid">

        {{-- AKTIVITAS TERBARU --}}
        <article class="admin-activity-card">

            <div class="admin-activity-card-header">

                <div>
                    <h2>Aktivitas Terbaru</h2>

                    <p>
                        Ringkasan berita yang baru ditambahkan.
                    </p>
                </div>

                <a
                    href="{{ $newsIndexUrl }}"
                    class="admin-activity-card-link"
                >
                    Lihat Semua
                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>

            @forelse($latestNews->take(5) as $item)

                @php
                    $activityTime = $item->created_at
                        ? $item->created_at
                            ->locale('id')
                            ->diffForHumans()
                        : 'Waktu tidak tersedia';
                @endphp

                @if($loop->first)
                    <div class="admin-activity-list">
                @endif

                    <div class="admin-activity-item">

                        <span class="admin-activity-icon">
                            <i class="bi bi-newspaper"></i>
                        </span>

                        <div class="admin-activity-content">

                            <strong>
                                {{ $item->judul }}
                            </strong>

                            <span class="admin-activity-meta">
                                <i class="bi bi-clock"></i>

                                {{ $activityTime }}
                            </span>

                        </div>

                    </div>

                @if($loop->last)
                    </div>
                @endif

            @empty

                <div class="admin-activity-empty">

                    <div>
                        <div class="admin-activity-empty-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>

                        <h3>Belum ada aktivitas</h3>

                        <p>
                            Aktivitas terbaru akan tampil setelah
                            data berita ditambahkan.
                        </p>
                    </div>

                </div>

            @endforelse

        </article>

        {{-- BERITA TERBARU --}}
        <article class="admin-activity-card">

            <div class="admin-activity-card-header">

                <div>
                    <h2>Berita Terbaru</h2>

                    <p>
                        Pratinjau publikasi berita terkini.
                    </p>
                </div>

                <a
                    href="{{ $newsIndexUrl }}"
                    class="admin-activity-card-link"
                >
                    Kelola Berita
                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>

            @forelse($latestNews->take(5) as $item)

                @php
                    $newsImage = filled($item->gambar)
                        ? asset(
                            'storage/' .
                            ltrim($item->gambar, '/')
                        )
                        : null;

                    $newsBody = data_get($item, 'isi')
                        ?? data_get($item, 'content')
                        ?? data_get($item, 'deskripsi')
                        ?? '';

                    $newsExcerpt = \Illuminate\Support\Str::limit(
                        strip_tags($newsBody),
                        90
                    );

                    $newsDate = $item->created_at
                        ? $item->created_at
                            ->locale('id')
                            ->translatedFormat('d M Y')
                        : 'Tanggal tidak tersedia';

                    $newsDetailUrl =
                        \Illuminate\Support\Facades\Route::has(
                            'admin.berita.edit'
                        )
                            ? route('admin.berita.edit', $item)
                            : $newsIndexUrl;
                @endphp

                @if($loop->first)
                    <div class="admin-news-list">
                @endif

                    <a
                        href="{{ $newsDetailUrl }}"
                        class="admin-news-item"
                    >

                        <div class="admin-news-image">

                            @if($newsImage)

                                <img
                                    src="{{ $newsImage }}"
                                    alt="{{ $item->judul }}"
                                    loading="lazy"
                                >

                            @else

                                <div class="admin-news-placeholder">
                                    <i class="bi bi-image"></i>
                                </div>

                            @endif

                        </div>

                        <div class="admin-news-content">

                            <strong>
                                {{ $item->judul }}
                            </strong>

                            <p>
                                {{ filled($newsExcerpt)
                                    ? $newsExcerpt
                                    : 'Belum ada ringkasan berita.'
                                }}
                            </p>

                            <span class="admin-news-date">
                                <i class="bi bi-calendar3"></i>

                                {{ $newsDate }}
                            </span>

                        </div>

                    </a>

                @if($loop->last)
                    </div>
                @endif

            @empty

                <div class="admin-activity-empty">

                    <div>
                        <div class="admin-activity-empty-icon">
                            <i class="bi bi-newspaper"></i>
                        </div>

                        <h3>Belum ada berita</h3>

                        <p>
                            Berita terbaru akan tampil setelah
                            ditambahkan melalui menu Berita.
                        </p>
                    </div>

                </div>

            @endforelse

        </article>

    </div>

</section>
