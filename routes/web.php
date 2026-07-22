<?php

use App\Http\Controllers\Admin\agenda\AgendaController;
use App\Http\Controllers\Admin\announcement\AnnouncementController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\contact\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\gallery\GalleryController;
use App\Http\Controllers\Admin\government\BpdController;
use App\Http\Controllers\Admin\government\InstitutionController;
use App\Http\Controllers\Admin\government\OfficialController;
use App\Http\Controllers\Admin\news\NewsController;
use App\Http\Controllers\Admin\potential\PotentialController;
use App\Http\Controllers\Admin\profile\HistoryController;
use App\Http\Controllers\Admin\profile\RegionController;
use App\Http\Controllers\Admin\profile\VillageProfileController;
use App\Http\Controllers\Admin\profile\VisionMissionController;
use App\Http\Controllers\Admin\settings\SettingController;
use App\Http\Controllers\Admin\service\VillageServiceController;
use App\Http\Controllers\Admin\statistics\StatisticsController;
use App\Http\Controllers\Admin\user\ProfileController;
use App\Http\Controllers\Admin\user\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Website Publik
|--------------------------------------------------------------------------
*/

Route::middleware('public.maintenance')
    ->controller(HomeController::class)
    ->group(function (): void {
    Route::get('/', 'index')
        ->name('home');

    Route::get('/sitemap.xml', 'sitemap')
        ->name('public.sitemap');

    Route::get('/profil-desa', 'profile')
        ->name('public.profile');

    Route::get('/pemerintahan', 'government')
        ->name('public.government');

    Route::get('/potensi-desa', 'potentials')
        ->name('public.potentials');

    Route::get(
        '/potensi-desa/{potential}',
        'potentialDetail'
    )->name('public.potentials.show');

    Route::get('/berita', 'news')
        ->name('public.news');

    Route::get('/berita/{news}', 'newsDetail')
        ->name('public.news.show');

    Route::get('/galeri', 'galleries')
        ->name('public.galleries');

    Route::get('/agenda/{agenda}', 'agendaDetail')
        ->name('public.agenda.detail');

    Route::get('/cari', 'search')
        ->name('public.search');

    Route::get('/layanan-desa', 'services')
        ->name('public.services.index');

    Route::get(
        '/pengumuman/{announcement}',
        'announcementDetail'
    )->name('public.announcements.show');

    Route::get('/kontak', 'contact')
        ->name('public.contact');
});

/*
|--------------------------------------------------------------------------
| Autentikasi Admin
|--------------------------------------------------------------------------
|
| Semua perangkat desa menggunakan alamat /login yang sama. Hak akses
| dibedakan dari kolom role pada akun masing-masing.
|
*/

/*
 * GET /login tidak memakai middleware guest.
 * LoginController akan mengarahkan akun yang sudah login
 * langsung ke dashboard admin, bukan ke halaman publik.
 */
Route::get(
    '/login',
    [LoginController::class, 'index']
)->name('login');

Route::middleware('guest')->group(function (): void {
    Route::post(
        '/login',
        [LoginController::class, 'login']
    )
        ->middleware('throttle:5,1')
        ->name('login.proses');

    Route::get(
        '/password/forgot',
        [AuthController::class, 'showForgotPassword']
    )->name('password.forgot');

    Route::post(
        '/password/forgot',
        [AuthController::class, 'forgotPassword']
    )
        ->middleware('throttle:3,10')
        ->name('password.forgot.proses');

    Route::get(
        '/password/reset/{token}',
        [AuthController::class, 'showResetPassword']
    )->name('password.reset');

    Route::post(
        '/password/reset',
        [AuthController::class, 'resetPassword']
    )
        ->middleware('throttle:5,10')
        ->name('password.reset.proses');
});

Route::post(
    '/logout',
    [LoginController::class, 'logout']
)
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware('auth')
    ->group(function (): void {
        /*
        |--------------------------------------------------------------------------
        | Semua Role
        |--------------------------------------------------------------------------
        |
        | Super Admin, Admin, dan Editor dapat membuka dashboard serta
        | mengubah profil akunnya sendiri.
        |
        */

        Route::get(
            '/dashboard',
            [DashboardController::class, 'index']
        )->name('admin.dashboard');

        Route::get(
            '/profil',
            [ProfileController::class, 'index']
        )->name('admin.profil');

        Route::put(
            '/profil',
            [ProfileController::class, 'update']
        )->name('admin.profil.update');

        /*
        |--------------------------------------------------------------------------
        | Super Admin dan Admin
        |--------------------------------------------------------------------------
        |
        | Mengelola data utama desa, pemerintahan, potensi, statistik,
        | serta informasi kontak.
        |
        */

        Route::middleware(
            'role:Super Admin,Admin'
        )->group(function (): void {
            // Profil Desa
            Route::get(
                '/identitas-desa',
                [VillageProfileController::class, 'index']
            )->name('admin.identitas');

            Route::post(
                '/identitas-desa',
                [VillageProfileController::class, 'store']
            )->name('admin.identitas.store');

            Route::get(
                '/visi-misi',
                [VisionMissionController::class, 'index']
            )->name('admin.visi');

            Route::post(
                '/visi-misi',
                [VisionMissionController::class, 'store']
            )->name('admin.visi.store');

            Route::get(
                '/sejarah',
                [HistoryController::class, 'index']
            )->name('admin.sejarah');

            Route::post(
                '/sejarah',
                [HistoryController::class, 'store']
            )->name('admin.sejarah.store');

            Route::get(
                '/wilayah',
                [RegionController::class, 'index']
            )->name('admin.wilayah');

            Route::post(
                '/wilayah',
                [RegionController::class, 'store']
            )->name('admin.wilayah.store');

            // Aparat Desa
            Route::get(
                '/aparat',
                [OfficialController::class, 'index']
            )->name('admin.aparat');

            Route::post(
                '/aparat',
                [OfficialController::class, 'store']
            )->name('admin.aparat.store');

            Route::get(
                '/aparat/{official}/edit',
                [OfficialController::class, 'edit']
            )->name('admin.aparat.edit');

            Route::put(
                '/aparat/{official}',
                [OfficialController::class, 'update']
            )->name('admin.aparat.update');

            Route::delete(
                '/aparat/{official}',
                [OfficialController::class, 'destroy']
            )->name('admin.aparat.destroy');

            // BPD
            Route::get(
                '/bpd',
                [BpdController::class, 'index']
            )->name('admin.bpd');

            Route::post(
                '/bpd',
                [BpdController::class, 'store']
            )->name('admin.bpd.store');

            Route::get(
                '/bpd/{bpd}/edit',
                [BpdController::class, 'edit']
            )->name('admin.bpd.edit');

            Route::put(
                '/bpd/{bpd}',
                [BpdController::class, 'update']
            )->name('admin.bpd.update');

            Route::delete(
                '/bpd/{bpd}',
                [BpdController::class, 'destroy']
            )->name('admin.bpd.destroy');

            // Lembaga Desa
            Route::get(
                '/lembaga',
                [InstitutionController::class, 'index']
            )->name('admin.lembaga');

            Route::post(
                '/lembaga',
                [InstitutionController::class, 'store']
            )->name('admin.lembaga.store');

            Route::get(
                '/lembaga/{institution}/edit',
                [InstitutionController::class, 'edit']
            )->name('admin.lembaga.edit');

            Route::put(
                '/lembaga/{institution}',
                [InstitutionController::class, 'update']
            )->name('admin.lembaga.update');

            Route::delete(
                '/lembaga/{institution}',
                [InstitutionController::class, 'destroy']
            )->name('admin.lembaga.destroy');

            // Potensi Desa
            Route::get(
                '/potensi',
                [PotentialController::class, 'index']
            )->name('admin.potensi');

            Route::post(
                '/potensi',
                [PotentialController::class, 'store']
            )->name('admin.potensi.store');

            Route::get(
                '/potensi/{potential}/edit',
                [PotentialController::class, 'edit']
            )->name('admin.potensi.edit');

            Route::put(
                '/potensi/{potential}',
                [PotentialController::class, 'update']
            )->name('admin.potensi.update');

            Route::delete(
                '/potensi/{potential}',
                [PotentialController::class, 'destroy']
            )->name('admin.potensi.destroy');

            // Layanan Desa
            Route::get(
                '/layanan-desa',
                [VillageServiceController::class, 'index']
            )->name('admin.layanan');

            Route::post(
                '/layanan-desa',
                [VillageServiceController::class, 'store']
            )->name('admin.layanan.store');

            Route::get(
                '/layanan-desa/{service}/edit',
                [VillageServiceController::class, 'edit']
            )->name('admin.layanan.edit');

            Route::put(
                '/layanan-desa/{service}',
                [VillageServiceController::class, 'update']
            )->name('admin.layanan.update');

            Route::delete(
                '/layanan-desa/{service}',
                [VillageServiceController::class, 'destroy']
            )->name('admin.layanan.destroy');

            // Statistik
            Route::get(
                '/statistik',
                [StatisticsController::class, 'index']
            )->name('admin.statistik');

            Route::post(
                '/statistik',
                [StatisticsController::class, 'store']
            )->name('admin.statistik.store');

            // Kontak
            Route::get(
                '/kontak',
                [ContactController::class, 'index']
            )->name('admin.kontak');

            Route::post(
                '/kontak',
                [ContactController::class, 'store']
            )->name('admin.kontak.store');
        });

        /*
        |--------------------------------------------------------------------------
        | Super Admin, Admin, dan Editor
        |--------------------------------------------------------------------------
        |
        | Ketiga role dapat mengelola konten publikasi.
        |
        */

        Route::middleware(
            'role:Super Admin,Admin,Editor'
        )->group(function (): void {
            // Berita
            Route::get(
                '/berita',
                [NewsController::class, 'index']
            )->name('admin.berita');

            Route::post(
                '/berita',
                [NewsController::class, 'store']
            )->name('admin.berita.store');

            Route::get(
                '/berita/{news}/edit',
                [NewsController::class, 'edit']
            )->name('admin.berita.edit');

            Route::put(
                '/berita/{news}',
                [NewsController::class, 'update']
            )->name('admin.berita.update');

            Route::delete(
                '/berita/{news}',
                [NewsController::class, 'destroy']
            )->name('admin.berita.destroy');

            // Galeri
            Route::get(
                '/galeri',
                [GalleryController::class, 'index']
            )->name('admin.galeri');

            Route::post(
                '/galeri',
                [GalleryController::class, 'store']
            )->name('admin.galeri.store');

            Route::get(
                '/galeri/{gallery}/edit',
                [GalleryController::class, 'edit']
            )->name('admin.galeri.edit');

            Route::put(
                '/galeri/{gallery}',
                [GalleryController::class, 'update']
            )->name('admin.galeri.update');

            Route::delete(
                '/galeri/{gallery}',
                [GalleryController::class, 'destroy']
            )->name('admin.galeri.destroy');

            // Agenda
            Route::get(
                '/agenda',
                [AgendaController::class, 'index']
            )->name('admin.agenda');

            Route::post(
                '/agenda',
                [AgendaController::class, 'store']
            )->name('admin.agenda.store');

            Route::get(
                '/agenda/{agenda}/edit',
                [AgendaController::class, 'edit']
            )->name('admin.agenda.edit');

            Route::put(
                '/agenda/{agenda}',
                [AgendaController::class, 'update']
            )->name('admin.agenda.update');

            Route::delete(
                '/agenda/{agenda}',
                [AgendaController::class, 'destroy']
            )->name('admin.agenda.destroy');

            // Pengumuman
            Route::get(
                '/pengumuman',
                [AnnouncementController::class, 'index']
            )->name('admin.pengumuman');

            Route::post(
                '/pengumuman',
                [AnnouncementController::class, 'store']
            )->name('admin.pengumuman.store');

            Route::get(
                '/pengumuman/{announcement}/edit',
                [AnnouncementController::class, 'edit']
            )->name('admin.pengumuman.edit');

            Route::put(
                '/pengumuman/{announcement}',
                [AnnouncementController::class, 'update']
            )->name('admin.pengumuman.update');

            Route::delete(
                '/pengumuman/{announcement}',
                [AnnouncementController::class, 'destroy']
            )->name('admin.pengumuman.destroy');
        });

        /*
        |--------------------------------------------------------------------------
        | Khusus Super Admin
        |--------------------------------------------------------------------------
        */

        Route::middleware(
            'role:Super Admin'
        )->group(function (): void {
            // Pengaturan website
            Route::get(
                '/pengaturan',
                [SettingController::class, 'index']
            )->name('admin.pengaturan');

            Route::post(
                '/pengaturan',
                [SettingController::class, 'store']
            )->name('admin.pengaturan.store');

            // Manajemen akun
            Route::get(
                '/users',
                [UserController::class, 'index']
            )->name('admin.users');

            Route::post(
                '/users',
                [UserController::class, 'store']
            )->name('admin.users.store');

            Route::get(
                '/users/{user}/edit',
                [UserController::class, 'edit']
            )->name('admin.users.edit');

            Route::put(
                '/users/{user}',
                [UserController::class, 'update']
            )->name('admin.users.update');

            Route::delete(
                '/users/{user}',
                [UserController::class, 'destroy']
            )->name('admin.users.destroy');
        });
    });
