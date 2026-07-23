<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Bpd;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\History;
use App\Models\Institution;
use App\Models\News;
use App\Models\Official;
use App\Models\Potential;
use App\Models\Region;
use App\Models\Setting;
use App\Models\VillageProfile;
use App\Models\VillageService;
use App\Models\VillageStatistic;
use App\Models\VisionMission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Data yang dibutuhkan oleh hampir seluruh halaman publik.
     */
    private function sharedData(): array
    {
        return [
            'profile' => VillageProfile::first(),
            'contact' => Contact::first(),
            'region' => Region::first(),
            'settings' => Setting::first(),
        ];
    }

    /**
     * Halaman utama website publik.
     */
    public function index(): View
    {
        $profile = VillageProfile::first();
        $statistics = VillageStatistic::first();
        $visionMission = VisionMission::first();
        $contact = Contact::first();
        $settings = Setting::first();

        $headOfficial = Official::query()
            ->where('status', 'Aktif')
            ->where('jabatan', 'Kepala Desa')
            ->orderBy('sort_order')
            ->first()
            ?? Official::query()
                ->where('status', 'Aktif')
                ->orderBy('sort_order')
                ->first();

        /*
         * Data pemerintahan yang dapat ditampilkan pada beranda.
         * Blade tetap bebas menentukan berapa data yang ingin ditampilkan.
         */
        $officials = Official::query()
            ->where('status', 'Aktif')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->take(8)
            ->get();

        $bpds = Bpd::query()
            ->orderBy('id')
            ->take(8)
            ->get();

        $institutions = Institution::query()
            ->where('status', 'Aktif')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->take(8)
            ->get();

        $galleries = Gallery::query()
            ->where('status', 'Publik')
            ->orderByDesc('featured')
            ->orderByDesc('tanggal_kegiatan')
            ->latest('created_at')
            ->take(8)
            ->get();

        $potentials = Potential::query()
            ->where('status', 'Publik')
            ->orderByDesc('featured')
            ->latest()
            ->take(6)
            ->get();

        $news = News::query()
            ->where('status', 'Publik')
            ->whereNotNull('published_at')
            ->whereDate('published_at', '<=', today())
            ->orderByDesc('published_at')
            ->orderByDesc('featured')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->take(6)
            ->get();

        $announcements = Announcement::query()
            ->where('status', 'Publik')
            ->where(function ($query) {
                $query
                    ->whereNull('published_at')
                    ->orWhereDate('published_at', '<=', today());
            })
            ->orderByDesc('featured')
            ->latest('published_at')
            ->latest('created_at')
            ->take(6)
            ->get();

        $agendas = Agenda::query()
            ->where('status', 'Publik')
            ->orderByDesc('featured')
            ->orderBy('tanggal_mulai')
            ->take(6)
            ->get();

        return view('public.home', compact(
            'profile',
            'statistics',
            'headOfficial',
            'visionMission',
            'galleries',
            'contact',
            'settings',
            'potentials',
            'news',
            'agendas',
            'announcements',
            'officials',
            'bpds',
            'institutions'
        ));
    }

    /**
     * Sitemap XML untuk membantu mesin pencari menemukan
     * halaman publik dan konten terbaru website desa.
     */
    public function sitemap(): Response
    {
        $urls = collect([
            [
                'loc' => route('home'),
                'lastmod' => Setting::query()->max('updated_at'),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ],
            [
                'loc' => route('public.profile'),
                'lastmod' => VillageProfile::query()->max('updated_at'),
                'changefreq' => 'monthly',
                'priority' => '0.9',
            ],
            [
                'loc' => route('public.government'),
                'lastmod' => Official::query()->max('updated_at'),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ],
            [
                'loc' => route('public.potentials'),
                'lastmod' => Potential::query()->max('updated_at'),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ],
            [
                'loc' => route('public.news'),
                'lastmod' => News::query()->max('updated_at'),
                'changefreq' => 'daily',
                'priority' => '0.9',
            ],
            [
                'loc' => route('public.galleries'),
                'lastmod' => Gallery::query()->max('updated_at'),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ],
            [
                'loc' => route('public.services.index'),
                'lastmod' => VillageService::query()->max('updated_at'),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ],
            [
                'loc' => route('public.contact'),
                'lastmod' => Contact::query()->max('updated_at'),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ],
        ]);

        News::query()
            ->where('status', 'Publik')
            ->whereNotNull('published_at')
            ->whereDate('published_at', '<=', today())
            ->latest('updated_at')
            ->get()
            ->each(function (News $item) use ($urls): void {
                $urls->push([
                    'loc' => route('public.news.show', $item),
                    'lastmod' => $item->updated_at,
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ]);
            });

        Potential::query()
            ->where('status', 'Publik')
            ->latest('updated_at')
            ->get()
            ->each(function (Potential $item) use ($urls): void {
                $urls->push([
                    'loc' => route('public.potentials.show', $item),
                    'lastmod' => $item->updated_at,
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                ]);
            });

        Agenda::query()
            ->where('status', 'Publik')
            ->latest('updated_at')
            ->get()
            ->each(function (Agenda $item) use ($urls): void {
                $urls->push([
                    'loc' => route('public.agenda.detail', $item),
                    'lastmod' => $item->updated_at,
                    'changefreq' => 'weekly',
                    'priority' => '0.6',
                ]);
            });

        Announcement::query()
            ->where('status', 'Publik')
            ->where(function ($query): void {
                $query
                    ->whereNull('published_at')
                    ->orWhereDate('published_at', '<=', today());
            })
            ->latest('updated_at')
            ->get()
            ->each(function (Announcement $item) use ($urls): void {
                $urls->push([
                    'loc' => route(
                        'public.announcements.show',
                        $item
                    ),
                    'lastmod' => $item->updated_at,
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ]);
            });

        return response()
            ->view(
                'public.sitemap',
                ['urls' => $urls]
            )
            ->header(
                'Content-Type',
                'application/xml; charset=UTF-8'
            );
    }

    /**
     * Halaman profil desa.
     */
    public function profile(): View
    {
        $headOfficial = Official::query()
            ->where('status', 'Aktif')
            ->where('jabatan', 'Kepala Desa')
            ->orderBy('sort_order')
            ->first()
            ?? Official::query()
                ->where('status', 'Aktif')
                ->orderBy('sort_order')
                ->first();

        return view('public.profile', array_merge(
            $this->sharedData(),
            [
                'statistics' => VillageStatistic::first(),
                'visionMission' => VisionMission::first(),
                'region' => Region::first(),
                'history' => History::first(),
                'headOfficial' => $headOfficial,
            ]
        ));
    }

    /**
     * Halaman pemerintahan desa.
     */
    public function government(): View
    {
        return view('public.government', array_merge(
            $this->sharedData(),
            [
                'officials' => Official::query()
                    ->where('status', 'Aktif')
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->get(),

                'bpds' => Bpd::query()
                    ->orderBy('id')
                    ->get(),

                'institutions' => Institution::query()
                    ->where('status', 'Aktif')
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->get(),
            ]
        ));
    }

    /**
     * Halaman daftar potensi desa.
     */
    public function potentials(): View
    {
        return view('public.potentials', array_merge(
            $this->sharedData(),
            [
                'potentials' => Potential::query()
                    ->where('status', 'Publik')
                    ->orderByDesc('featured')
                    ->latest()
                    ->paginate(9)
                    ->withQueryString(),
            ]
        ));
    }

    /**
     * Halaman detail potensi.
     */
    public function potentialDetail(Potential $potential): View
    {
        abort_unless(
            $potential->status === 'Publik',
            404
        );

        return view('public.potential-detail', array_merge(
            $this->sharedData(),
            compact('potential')
        ));
    }

    /**
     * Halaman daftar berita.
     */
    public function news(): View
    {
        return view('public.news', array_merge(
            $this->sharedData(),
            [
                'news' => News::query()
                    ->where('status', 'Publik')
                    ->whereNotNull('published_at')
                    ->whereDate('published_at', '<=', today())
                    ->orderByDesc('published_at')
                    ->orderByDesc('featured')
                    ->orderByDesc('created_at')
                    ->orderByDesc('id')
                    ->paginate(9)
                    ->withQueryString(),
            ]
        ));
    }

    /**
     * Halaman detail berita.
     *
     * Satu browser dihitung maksimal satu kali untuk berita yang sama
     * dalam rentang 12 jam. Akun admin yang sedang login tidak ikut
     * menambah jumlah pembaca ketika melakukan pratinjau halaman publik.
     */
    public function newsDetail(
        Request $request,
        News $news
    ): View {
        $isPublished = News::query()
            ->whereKey($news->getKey())
            ->where('status', 'Publik')
            ->whereNotNull('published_at')
            ->whereDate(
                'published_at',
                '<=',
                today()
            )
            ->exists();

        abort_unless($isPublished, 404);

        $sessionKey =
            'public_news_viewed.' . $news->getKey();

        $lastViewedAt = (int) $request
            ->session()
            ->get($sessionKey, 0);

        $viewCooldownSeconds = 12 * 60 * 60;

        $mayCountView =
            !$request->user() &&
            (
                $lastViewedAt === 0 ||
                now()->timestamp - $lastViewedAt
                    >= $viewCooldownSeconds
            );

        if ($mayCountView) {
            News::query()
                ->whereKey($news->getKey())
                ->increment('views');

            $request
                ->session()
                ->put(
                    $sessionKey,
                    now()->timestamp
                );

            /*
             * Muat ulang agar angka terbaru langsung tampil pada
             * halaman detail setelah increment atomik berhasil.
             */
            $news->refresh();
        }

        return view(
            'public.news-detail',
            array_merge(
                $this->sharedData(),
                compact('news')
            )
        );
    }

    /**
     * Halaman galeri publik.
     */
    public function galleries(Request $request): View
    {
        $query = Gallery::query()
            ->where('status', 'Publik');

        if ($request->filled('tahun')) {
            $query->whereYear(
                'tanggal_kegiatan',
                (int) $request->input('tahun')
            );
        }

        if ($request->filled('kategori')) {
            $query->where(
                'kategori',
                $request->input('kategori')
            );
        }

        $galleries = $query
            ->orderByDesc('tanggal_kegiatan')
            ->orderBy('kategori')
            ->orderByDesc('featured')
            ->latest('created_at')
            ->get();

        $galleryYears = Gallery::query()
            ->where('status', 'Publik')
            ->whereNotNull('tanggal_kegiatan')
            ->selectRaw('YEAR(tanggal_kegiatan) AS year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $galleryCategories = Gallery::query()
            ->where('status', 'Publik')
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('public.galleries', array_merge(
            $this->sharedData(),
            compact(
                'galleries',
                'galleryYears',
                'galleryCategories'
            )
        ));
    }


    /**
     * Halaman detail agenda publik.
     */
    public function agendaDetail(Agenda $agenda): View
    {
        abort_unless(
            $agenda->status === 'Publik',
            404
        );

        return view('public.agenda-detail', array_merge(
            $this->sharedData(),
            compact('agenda')
        ));
    }

    /**
     * Pencarian informasi publik.
     */
    public function search(Request $request): View
    {
        $keyword = trim(
            (string) $request->query('q', '')
        );

        $type = (string) $request->query(
            'type',
            'semua'
        );

        $allowedTypes = [
            'semua',
            'berita',
            'potensi',
            'agenda',
            'pengumuman',
        ];

        if (!in_array($type, $allowedTypes, true)) {
            $type = 'semua';
        }

        $searchPerformed = mb_strlen($keyword) >= 2;

        $searchError = null;

        if (
            $keyword !== '' &&
            !$searchPerformed
        ) {
            $searchError =
                'Kata kunci pencarian minimal 2 karakter.';
        }

        $results = collect();

        if ($searchPerformed) {
            /*
             * Karakter wildcard dihindari agar pencarian sesuai dengan
             * teks yang benar-benar dimasukkan pengunjung.
             */
            $safeKeyword = addcslashes(
                $keyword,
                '\\%_'
            );

            $like = '%' . $safeKeyword . '%';

            if (
                $type === 'semua' ||
                $type === 'berita'
            ) {
                $newsResults = News::query()
                    ->where('status', 'Publik')
                    ->whereNotNull('published_at')
                    ->whereDate(
                        'published_at',
                        '<=',
                        today()
                    )
                    ->where(function ($query) use ($like): void {
                        $query
                            ->where('judul', 'like', $like)
                            ->orWhere('excerpt', 'like', $like)
                            ->orWhere('isi', 'like', $like)
                            ->orWhere('kategori', 'like', $like)
                            ->orWhere('penulis', 'like', $like);
                    })
                    ->latest('published_at')
                    ->limit(15)
                    ->get()
                    ->map(function (News $item): array {
                        $date = $item->published_at
                            ?? $item->created_at;

                        return [
                            'type' => 'berita',
                            'type_label' => 'Berita',
                            'title' => $item->judul,
                            'excerpt' => Str::limit(
                                strip_tags(
                                    $item->excerpt
                                        ?: $item->isi
                                ),
                                190
                            ),
                            'url' => route(
                                'public.news.show',
                                $item
                            ),
                            'date' => $date,
                            'sort_date' => $date?->timestamp ?? 0,
                            'meta' => $item->kategori
                                ?: 'Berita Desa',
                            'icon' => 'bi-newspaper',
                            'image' => filled($item->gambar)
                                ? asset(
                                    'storage/' .
                                    ltrim($item->gambar, '/')
                                )
                                : null,
                        ];
                    });

                $results = $results->concat(
                    $newsResults
                );
            }

            if (
                $type === 'semua' ||
                $type === 'potensi'
            ) {
                $potentialResults = Potential::query()
                    ->where('status', 'Publik')
                    ->where(function ($query) use ($like): void {
                        $query
                            ->where('nama', 'like', $like)
                            ->orWhere('kategori', 'like', $like)
                            ->orWhere('lokasi', 'like', $like)
                            ->orWhere('excerpt', 'like', $like)
                            ->orWhere('deskripsi', 'like', $like);
                    })
                    ->latest()
                    ->limit(15)
                    ->get()
                    ->map(function (Potential $item): array {
                        $date = $item->created_at;

                        return [
                            'type' => 'potensi',
                            'type_label' => 'Potensi Desa',
                            'title' => $item->nama,
                            'excerpt' => Str::limit(
                                strip_tags(
                                    $item->excerpt
                                        ?: $item->deskripsi
                                ),
                                190
                            ),
                            'url' => route(
                                'public.potentials.show',
                                $item
                            ),
                            'date' => $date,
                            'sort_date' => $date?->timestamp ?? 0,
                            'meta' => collect([
                                $item->kategori,
                                $item->lokasi,
                            ])->filter()->implode(' • '),
                            'icon' => 'bi-stars',
                            'image' => filled($item->gambar)
                                ? asset(
                                    'storage/' .
                                    ltrim($item->gambar, '/')
                                )
                                : null,
                        ];
                    });

                $results = $results->concat(
                    $potentialResults
                );
            }

            if (
                $type === 'semua' ||
                $type === 'agenda'
            ) {
                $agendaResults = Agenda::query()
                    ->where('status', 'Publik')
                    ->where(function ($query) use ($like): void {
                        $query
                            ->where('judul', 'like', $like)
                            ->orWhere('deskripsi', 'like', $like)
                            ->orWhere('lokasi', 'like', $like);
                    })
                    ->orderBy('tanggal_mulai')
                    ->limit(15)
                    ->get()
                    ->map(function (Agenda $item): array {
                        $date = $item->tanggal_mulai
                            ?? $item->created_at;

                        return [
                            'type' => 'agenda',
                            'type_label' => 'Agenda',
                            'title' => $item->judul,
                            'excerpt' => Str::limit(
                                strip_tags($item->deskripsi),
                                190
                            ),
                            'url' => route(
                                'public.agenda.detail',
                                $item
                            ),
                            'date' => $date,
                            'sort_date' => $date?->timestamp ?? 0,
                            'meta' => $item->lokasi
                                ?: 'Desa Bakal Dalam',
                            'icon' => 'bi-calendar-event',
                            'image' => filled($item->poster)
                                ? asset(
                                    'storage/' .
                                    ltrim($item->poster, '/')
                                )
                                : null,
                        ];
                    });

                $results = $results->concat(
                    $agendaResults
                );
            }

            if (
                $type === 'semua' ||
                $type === 'pengumuman'
            ) {
                $announcementResults = Announcement::query()
                    ->where('status', 'Publik')
                    ->where(function ($query): void {
                        $query
                            ->whereNull('published_at')
                            ->orWhereDate(
                                'published_at',
                                '<=',
                                today()
                            );
                    })
                    ->where(function ($query) use ($like): void {
                        $query
                            ->where('judul', 'like', $like)
                            ->orWhere('ringkasan', 'like', $like)
                            ->orWhere('isi', 'like', $like);
                    })
                    ->latest('published_at')
                    ->latest('created_at')
                    ->limit(15)
                    ->get()
                    ->map(function (Announcement $item): array {
                        $date = $item->published_at
                            ?? $item->created_at;

                        return [
                            'type' => 'pengumuman',
                            'type_label' => 'Pengumuman',
                            'title' => $item->judul,
                            'excerpt' => Str::limit(
                                strip_tags(
                                    $item->ringkasan
                                        ?: $item->isi
                                ),
                                190
                            ),
                            'url' => route(
                                'public.announcements.show',
                                $item
                            ),
                            'date' => $date,
                            'sort_date' => $date?->timestamp ?? 0,
                            'meta' => 'Informasi Resmi Desa',
                            'icon' => 'bi-megaphone',
                            'image' => null,
                        ];
                    });

                $results = $results->concat(
                    $announcementResults
                );
            }

            $results = $results
                ->sortByDesc('sort_date')
                ->take(40)
                ->values();
        }

        $resultTypes = [
            'semua' => 'Semua Informasi',
            'berita' => 'Berita',
            'potensi' => 'Potensi Desa',
            'agenda' => 'Agenda',
            'pengumuman' => 'Pengumuman',
        ];

        return view('public.search', array_merge(
            $this->sharedData(),
            compact(
                'keyword',
                'type',
                'results',
                'resultTypes',
                'searchPerformed',
                'searchError'
            )
        ));
    }

    /**
     * Halaman informasi layanan administrasi desa.
     */
    public function services(): View
    {
        $services = VillageService::query()
            ->where('status', 'Publik')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view(
            'public.services',
            array_merge(
                $this->sharedData(),
                compact('services')
            )
        );
    }

    /**
     * Halaman detail pengumuman publik.
     */
    public function announcementDetail(
        Announcement $announcement
    ): View {
        $isPublished = Announcement::query()
            ->whereKey($announcement->getKey())
            ->where('status', 'Publik')
            ->where(function ($query): void {
                $query
                    ->whereNull('published_at')
                    ->orWhereDate(
                        'published_at',
                        '<=',
                        today()
                    );
            })
            ->exists();

        abort_unless($isPublished, 404);

        return view(
            'public.announcement-detail',
            array_merge(
                $this->sharedData(),
                compact('announcement')
            )
        );
    }

    /**
     * Halaman kontak publik.
     */
    public function contact(): View
    {
        return view(
            'public.contact',
            $this->sharedData()
        );
    }
}
