-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Jul 2026 pada 15.56
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `agendas`
--

CREATE TABLE `agendas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `waktu` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) NOT NULL,
  `poster` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Draft',
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `agendas`
--

INSERT INTO `agendas` (`id`, `judul`, `slug`, `deskripsi`, `tanggal_mulai`, `tanggal_selesai`, `waktu`, `lokasi`, `poster`, `status`, `featured`, `created_at`, `updated_at`) VALUES
(1, 'Kegiatan Posyandu Desa Bakal Dalam', 'kegiatan-posyandu-desa-bakal-dalam', 'Kegiatan Posyandu Desa Bakal Dalam meliputi pemeriksaan kesehatan balita, penimbangan berat badan, pengukuran tinggi badan, pemeriksaan ibu hamil, pemantauan tekanan darah, pemeriksaan kesehatan lansia, pemberian vitamin, serta konsultasi kesehatan.', '2026-07-13', '2026-07-13', '08.00 WIB', 'Balai Serba Guna', NULL, 'Publik', 1, '2026-07-13 20:12:27', '2026-07-13 20:12:27'),
(2, 'Gotong Royong Perbaikan Masjid Nurul Iman', 'gotong-royong-perbaikan-masjid-nurul-iman', 'Pemerintah Desa Bakal Dalam bersama pengurus Masjid Nurul Iman dan masyarakat melaksanakan kegiatan gotong royong untuk memperbaiki area parkir masjid serta mengganti dan memperbarui beberapa fasilitas masjid. Kegiatan ini bertujuan menciptakan lingkungan masjid yang lebih aman, nyaman, bersih, dan layak digunakan oleh jamaah.', '2026-07-03', '2026-07-03', '08.00 WIB', 'Masjid Nurul Iman', NULL, 'Publik', 0, '2026-07-13 20:16:26', '2026-07-13 20:16:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `ringkasan` text NOT NULL,
  `isi` text NOT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `published_at` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Draft',
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `announcements`
--

INSERT INTO `announcements` (`id`, `judul`, `slug`, `ringkasan`, `isi`, `lampiran`, `published_at`, `status`, `featured`, `created_at`, `updated_at`) VALUES
(3, 'Pelaksanaan Posyandu Balita, Ibu Hamil dan Lansia Bulan Juli 2026', 'pelaksanaan-posyandu-balita-ibu-hamil-dan-lansia-bulan-juli-2026', 'Pemerintah Desa Bakal Dalam mengimbau masyarakat yang memiliki balita, ibu hamil dan lansia untuk mengikuti kegiatan Posyandu yang akan dilaksanakan di Posyandu Desa Bakal Dalam.', 'Pemerintah Desa Bakal Dalam menginformasikan kepada seluruh masyarakat, khususnya orang tua yang memiliki balita, ibu yang sedang mengandung dan warga lanjut usia, bahwa kegiatan Posyandu Bulan Juli 2026 akan dilaksanakan pada:\r\n\r\nHari/Tanggal: Jumat, 18 Juli 2026\r\nWaktu: 08.00 WIB – selesai\r\nTempat: Posyandu Desa Bakal Dalam\r\n\r\nKegiatan meliputi penimbangan berat badan dan tinggi badan balita, imunisasi sesuai jadwal, pemeriksaan kesehatan ibu hamil, pemeriksaan kesehatan lansia, konsultasi gizi, serta penyuluhan kesehatan.\r\n\r\nDiharapkan seluruh masyarakat yang menjadi sasaran Posyandu dapat hadir tepat waktu dan membawa Buku KIA atau buku kesehatan masing-masing. Partisipasi masyarakat sangat diharapkan untuk mendukung peningkatan derajat kesehatan keluarga di Desa Bakal Dalam.\r\n\r\nCatatan: Tanggal, waktu, dan tempat dapat kamu sesuaikan dengan jadwal Posyandu di desa.', NULL, '2026-07-12', 'Publik', 1, '2026-07-12 05:11:07', '2026-07-14 10:07:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bpds`
--

CREATE TABLE `bpds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bpds`
--

INSERT INTO `bpds` (`id`, `nama`, `jabatan`, `deskripsi`, `foto`, `created_at`, `updated_at`) VALUES
(2, 'EPAN PUTRA WIJAYA', 'Ketua BPD', NULL, 'bpd/PUst42PyMOhuJJK6dj2n84fh1G5juKjVuMi04uBw.png', '2026-07-12 02:51:31', '2026-07-14 23:04:08'),
(3, 'ELI WANSA', 'Wakil Ketua BPD', NULL, 'bpd/JsM8OjUTdXXzIa9yCsUEEILq5vcEshg2O80eGbE8.png', '2026-07-12 02:51:57', '2026-07-14 23:02:15'),
(4, 'U. SISTRO WARIO', 'Sekretaris BPD', NULL, 'bpd/WsJ21fBF5yvaRKXCHJTllkLom1zpo5Dp9mVO22Kd.png', '2026-07-12 02:52:15', '2026-07-14 23:06:25'),
(5, 'GUNAWAN', 'Anggota BPD', NULL, 'bpd/uskHmMQRwgxrmWlflS9I6LPCox4fEgtekywXwXw7.png', '2026-07-12 02:52:47', '2026-07-14 23:01:33'),
(6, 'INDRAN', 'Anggota BPD', NULL, 'bpd/RI1aUIPllXMv3LdHjTn3BxXyLxcDd0pnlJlI1MeU.png', '2026-07-12 02:53:15', '2026-07-14 23:04:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `telepon` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `tiktok` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `jam_operasional` varchar(255) DEFAULT NULL,
  `google_maps` varchar(255) DEFAULT NULL,
  `google_maps_embed` longtext DEFAULT NULL,
  `maps` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `contacts`
--

INSERT INTO `contacts` (`id`, `telepon`, `whatsapp`, `email`, `website`, `facebook`, `instagram`, `youtube`, `tiktok`, `alamat`, `jam_operasional`, `google_maps`, `google_maps_embed`, `maps`, `created_at`, `updated_at`) VALUES
(1, '082283155159', '082283155159', 'bakaldalam6@gmail.com', 'desa bakal dalam', 'https://www.facebook.com/share/g/1HGQ6it4Y7/', NULL, NULL, NULL, 'Jl. Lintas Bengkulu–Manna KM 93, Desa Bakal Dalam, Kecamatan Talo Kecil, Kabupaten Seluma, Provinsi Bengkulu, Kode Pos 38574.', '08.00 WIB - 14.00 WIB', 'https://maps.app.goo.gl/MoHkmWvTv2f7xAie8', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d900.2240111487068!2d102.7278143352581!3d-4.196844774974725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNMKwMTEnNDkuMSJTIDEwMsKwNDMnMzguNiJF!5e1!3m2!1sen!2sid!4v1784220249757!5m2!1sen!2sid\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"strict-origin-when-cross-origin\"></iframe>', 'http', '2026-07-11 12:25:54', '2026-07-18 01:09:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `tanggal_kegiatan` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'Draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `galleries`
--

INSERT INTO `galleries` (`id`, `judul`, `kategori`, `tanggal_kegiatan`, `description`, `gambar`, `featured`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Lokakarya KKN UNIB', 'Kegiatan Desa', '2026-07-12', NULL, 'gallery/EOWXAH0r7ZDbsTAbNgdPOSuqJypZitFzBHnIkgno.jpg', 1, 'Publik', '2026-07-12 03:11:37', '2026-07-12 03:11:37'),
(4, 'Senam Sehat', 'Kegiatan Desa', '2026-07-12', NULL, 'gallery/14wKHoRDw0BLSUfQv9j57ddfVyEAKThZyoBj2u7L.jpg', 1, 'Publik', '2026-07-12 03:12:22', '2026-07-12 06:24:39'),
(5, 'Gotong Royong di Masjid Nurul Iman', 'Pembangunan', '2026-07-12', 'Sebagai bentuk kepedulian terhadap sarana ibadah, mahasiswa KKN Universitas Bengkulu bersama masyarakat Desa Bakal Dalam bergotong royong memperbaiki area parkir Masjid Nurul Iman yang mengalami kerusakan serta mengganti fasilitas masjid yang sudah tidak layak digunakan. Kegiatan ini diharapkan dapat meningkatkan kenyamanan jamaah sekaligus mempererat semangat kebersamaan antara mahasiswa dan masyarakat.', 'gallery/W3VDymxfptAgSwAPYerthNYuevXDLtKGDrEkVTPD.jpg', 1, 'Publik', '2026-07-12 05:17:42', '2026-07-12 06:19:15'),
(6, 'Gotong Royong di Masjid Nurul Iman', 'Pembangunan', '2026-07-12', 'Sebagai bentuk kepedulian terhadap sarana ibadah, masyarakat Desa Bakal Dalam bergotong royong memperbaiki area parkir Masjid Nurul Iman yang mengalami kerusakan serta mengganti fasilitas masjid yang sudah tidak layak digunakan. Kegiatan ini diharapkan dapat meningkatkan kenyamanan jamaah', 'gallery/Uurr5OH38muT9NKfipy5MDbUURA3bHGdtPdvbQ9M.jpg', 1, 'Publik', '2026-07-12 06:21:48', '2026-07-12 06:21:48'),
(7, 'Pemeriksaan Kesehatan Lansia di Puskesmas Desa Bakal Dalam', 'Kesehatan', '2026-07-12', 'Pemeriksaan Kesehatan Lansia Dilaksanakan Usai Senam Rutin Hari Jumat', 'gallery/I58c2xCxxl9lKUdLPloHpR5nF1pnXnEhE28aoOSJ.jpg', 1, 'Publik', '2026-07-12 06:26:21', '2026-07-12 08:10:06'),
(11, 'SDN 111 SELUMA', 'Pendidikan', '2026-07-15', NULL, 'gallery/AO8eQVU0DbsA18OYr9jAS50yyvvwUSnTAjQ4g8Cd.jpg', 1, 'Publik', '2026-07-15 11:53:12', '2026-07-15 11:53:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `histories`
--

CREATE TABLE `histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `year_established` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `sejarah` longtext DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `histories`
--

INSERT INTO `histories` (`id`, `judul`, `year_established`, `excerpt`, `sejarah`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'Sejarah Desa Bakal Dalam', '1845', 'Desa Bakal Dalam memiliki sejarah yang berawal dari dua versi asal-usul nama desa. Berdasarkan arsip tertulis Pemerintah Kolonial Belanda, Dusun Bakal Dalam telah tercatat sejak tahun 1845 sebagai bagian dari Marga Anak Marigo. Seiring perkembangan pemerintahan, desa mengalami perubahan kepemimpinan dari sistem Depati menjadi Kepala Desa pada tahun 1982. Desa juga pernah meraih prestasi sebagai Juara Lomba Desa Tingkat Provinsi Bengkulu yang membawa berbagai bantuan pembangunan bagi masyarakat. Sejak tahun 2003, Desa Bakal Dalam secara administratif menjadi bagian dari Kabupaten Seluma, Kecamatan Talo Kecil.', 'Nama Desa Bakal Dalam memiliki dua riwayat asal-usul. Versi pertama menyebutkan bahwa nama \"Bakal Dalam\" berasal dari letak dusun yang berada di pinggir luang atau lembah yang dahulu diyakini merupakan bekas jalur gajah (Bakal Gajah). Versi kedua menyebutkan bahwa nenek moyang yang berasal dari Masmambang membuka hutan untuk berladang dan berkebun di daerah yang sangat jauh ke pedalaman sehingga wilayah tersebut dikenal sebagai Bakal Dalam.\r\n\r\nSecara historis, Desa Bakal Dalam pertama kali tercatat dalam dokumen tertulis pada tahun 1845 melalui Buku Sejarah/Riwayat Kabupaten Seluma yang memuat daftar dusun dalam wilayah Marga Anak Marigo. Berdasarkan arsip tersebut, usia Desa Bakal Dalam telah melampaui satu abad dan menjadi salah satu desa yang memiliki sejarah panjang di wilayah tersebut.\r\n\r\nPerjalanan pemerintahan desa dimulai dari kepemimpinan para Depati, di antaranya Datuk Asip sekitar tahun 1930, kemudian Datuk Zikri pada tahun 1950, dan Tahwi hingga tahun 1971. Setelah itu kepemimpinan desa terus berkembang hingga pada tahun 1982 sistem pemerintahan berubah dari jabatan Depati menjadi Kepala Desa dengan M. Zen Zaidi sebagai Kepala Desa pertama.\r\n\r\nPada masa kepemimpinan M. Zen Zaidi, Desa Bakal Dalam berhasil meraih Juara Lomba Desa Tingkat Provinsi Bengkulu sehingga memperoleh berbagai bantuan pembangunan dari pemerintah pusat maupun daerah, seperti pembangunan balai desa, Puskesmas Pembantu (PUSTU), jaringan listrik tenaga diesel, pengembangan perkebunan karet, bantuan bibit unggul, serta berbagai sarana penunjang lainnya. Prestasi tersebut menjadi salah satu tonggak penting dalam perkembangan desa.\r\n\r\nSelanjutnya pembangunan desa terus berlangsung melalui berbagai periode kepemimpinan kepala desa hingga saat ini. Sejak tahun 2003, Desa Bakal Dalam secara administratif menjadi bagian dari Kabupaten Seluma, Kecamatan Talo Kecil, Provinsi Bengkulu, dan terus berkembang sebagai desa yang mengedepankan pembangunan di bidang pertanian, perkebunan, infrastruktur, dan pelayanan masyarakat.', 'history/dOC4316nzETt6sDUouuriELQP2so8PnUbS6SAE7Q.jpg', '2026-07-12 04:40:14', '2026-07-13 19:34:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `institutions`
--

CREATE TABLE `institutions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `institutions`
--

INSERT INTO `institutions` (`id`, `nama`, `jabatan`, `deskripsi`, `foto`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(2, 'PKK', 'Bagan Struktur Organisasi', 'Bagan struktur organisasi PKK Desa.', 'institutions/BeKw83jLcp94SUIjBqLI9IEGH8KhALhIuOCGCM6m.png', 1, 'Aktif', '2026-07-12 02:54:36', '2026-07-15 11:13:32'),
(3, 'Posyandu', 'Bagan Struktur Organisasi', 'Bagan struktur organisasi Posyandu Desa.', 'institutions/eAdsDGIlejlHwi40K58E4WIMWfaZlQ1LLm2IuvI2.png', 2, 'Aktif', '2026-07-15 11:13:09', '2026-07-15 11:13:09'),
(4, 'Karang Taruna', 'Bagan Struktur Organisasi', 'Bagan struktur organisasi Karang Taruna Desa.', 'institutions/QtgAhcKxzwoI5y2xPxrqR4kIbpkBzgtWmgojjG8e.png', 3, 'Aktif', '2026-07-15 11:13:23', '2026-07-15 11:13:23'),
(5, 'LPM', 'Bagan Struktur Organisasi', 'Bagan struktur Lembaga Pemberdayaan Masyarakat.', 'institutions/Vq37V7nyYUGQGpGB8pf1mPWN53QqYkHgfEFlY5UN.png', 4, 'Aktif', '2026-07-15 11:13:47', '2026-07-15 11:13:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_10_142304_create_village_profiles_table', 1),
(5, '2026_07_10_142304_create_vision_missions_table', 1),
(6, '2026_07_10_142305_create_histories_table', 1),
(7, '2026_07_10_142305_create_regions_table', 1),
(8, '2026_07_10_142306_create_bpds_table', 1),
(9, '2026_07_10_142306_create_officials_table', 1),
(10, '2026_07_10_142307_create_institutions_table', 1),
(11, '2026_07_10_142307_create_potentials_table', 1),
(12, '2026_07_10_142308_create_news_table', 1),
(13, '2026_07_10_142309_create_contacts_table', 1),
(14, '2026_07_10_142309_create_galleries_table', 1),
(15, '2026_07_10_142312_create_settings_table', 1),
(16, '2026_07_11_170734_add_logo_to_village_profiles_table', 2),
(17, '2026_07_11_191938_add_maps_to_contacts_table', 2),
(18, '2026_07_12_000001_add_fields_to_village_profiles_table', 3),
(19, '2026_07_12_000002_add_fields_to_vision_missions_table', 4),
(20, '2026_07_12_000003_add_fields_to_regions_table', 4),
(21, '2026_07_12_000004_add_fields_to_histories_table', 4),
(22, '2026_07_12_000005_add_order_status_to_officials_table', 4),
(23, '2026_07_12_000006_add_nip_to_officials_table', 5),
(24, '2026_07_12_000007_add_order_status_to_institutions_table', 6),
(25, '2026_07_12_000008_add_fields_to_potentials_table', 7),
(26, '2026_07_12_000009_add_fields_to_news_table', 8),
(27, '2026_07_12_000010_add_fields_to_galleries_table', 9),
(28, '2026_07_12_000011_create_agendas_table', 10),
(29, '2026_07_12_000012_create_announcements_table', 11),
(30, '2026_07_12_000013_create_village_statistics_table', 12),
(31, '2026_07_12_000014_add_fields_to_contacts_table', 13),
(32, '2026_07_12_000015_add_fields_to_settings_table', 14),
(33, '2026_07_14_000000_add_fields_to_village_profiles_table', 15),
(34, '2026_07_14_010000_remove_rt_rw_from_village_and_regions_tables', 16),
(35, '2026_07_14_020000_update_village_statistics_luas_to_decimal', 17),
(36, '2026_07_14_030000_add_structure_organisasi_to_village_profiles_table', 18),
(37, '2026_07_18_110000_add_tanggal_kegiatan_to_galleries_table', 19),
(38, '2026_07_15_150031_add_struktur_bpd_to_village_profiles_table', 20),
(39, '2026_07_14_203119_add_struktur_organisasi_to_village_profiles_table', 21),
(40, '2026_07_18_130000_add_kata_sambutan_to_officials_table', 22),
(41, '2026_07_18_140000_consolidate_contact_data', 23),
(42, '2026_07_18_150000_create_village_services_table', 24);

-- --------------------------------------------------------

--
-- Struktur dari tabel `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Draft',
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0,
  `isi` longtext NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `news`
--

INSERT INTO `news` (`id`, `judul`, `slug`, `excerpt`, `kategori`, `penulis`, `published_at`, `status`, `featured`, `views`, `isi`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'Lokakarya Awal KKN Universitas Bengkulu Resmi Dilaksanakan di Desa Bakal Dalam', 'lokakarya-awal-kkn-universitas-bengkulu-resmi-dilaksanakan-di-desa-bakal-dalam', 'Pemerintah Desa Bakal Dalam bersama mahasiswa KKN Universitas Bengkulu melaksanakan Lokakarya Awal sebagai pembuka rangkaian program kerja yang akan dilaksanakan selama masa KKN.', 'Kegiatan', 'Admin Desa Bakal Dalam', '2026-05-31 17:00:00', 'Publik', 1, 0, 'Pemerintah Desa Bakal Dalam bersama mahasiswa Kuliah Kerja Nyata (KKN) Universitas Bengkulu Kelompok 82 melaksanakan kegiatan Lokakarya Awal di Balai Desa Bakal Dalam. Kegiatan ini dihadiri oleh Kepala Desa, perangkat desa, tokoh masyarakat, serta perwakilan masyarakat.\r\nDalam kegiatan tersebut, mahasiswa KKN memaparkan rencana program kerja yang akan dilaksanakan, meliputi bidang lingkungan, pertanian, dan digitalisasi desa. Lokakarya menjadi wadah diskusi antara pemerintah desa, masyarakat, dan mahasiswa untuk menyelaraskan program kerja dengan kebutuhan desa.\r\nMelalui kegiatan ini diharapkan terjalin kerja sama yang baik sehingga seluruh program KKN dapat berjalan dengan lancar dan memberikan manfaat bagi masyarakat Desa Bakal Dalam.', 'news/ezrOMns3Pwe9yp7GVwaAF1MXKuPhtJLe0QZNstL9.jpg', '2026-07-11 12:00:34', '2026-07-12 03:07:48'),
(3, 'Senam Sehat Rutin Hari Jumat Tingkatkan Kebugaran Masyarakat', 'senam-sehat-rutin-hari-jumat-tingkatkan-kebugaran-masyarakat', 'Kegiatan senam sehat rutin setiap hari Jumat menjadi salah satu upaya Desa Bakal Dalam dalam meningkatkan kebugaran masyarakat yang disertai pemeriksaan kesehatan.', 'Kesehatan', 'Admin Desa Bakal Dalam', '2026-07-09 17:00:00', 'Publik', 1, 0, 'Desa Bakal Dalam secara rutin melaksanakan kegiatan Senam Sehat setiap hari Jumat yang diikuti oleh masyarakat, perangkat desa, kader kesehatan, serta mahasiswa KKN Universitas Bengkulu.\r\nSetelah kegiatan senam selesai, masyarakat diberikan kesempatan untuk mengikuti pemeriksaan kesehatan, seperti pengecekan gula darah, sebagai upaya meningkatkan kesadaran akan pentingnya menjaga kesehatan sejak dini.\r\nMelalui kegiatan ini diharapkan masyarakat Desa Bakal Dalam dapat menerapkan pola hidup sehat serta menjaga kebersamaan melalui aktivitas yang bermanfaat bagi kesehatan dan kehidupan bermasyarakat.', 'news/NxrVlEivf8SGw4ymSNbCY5Zsln8RblRPgZb48xl8.jpg', '2026-07-12 03:09:21', '2026-07-12 06:27:49'),
(4, 'Pemeriksaan Kesehatan Lansia Dilaksanakan Usai Senam Rutin Hari Jumat', 'pemeriksaan-kesehatan-lansia-dilaksanakan-usai-senam-rutin-hari-jumat', 'Setelah mengikuti senam sehat rutin setiap hari Jumat, para lansia di Desa Bakal Dalam menjalani pemeriksaan kesehatan yang dilaksanakan oleh tenaga kesehatan dari Puskesmas Talo Kecil.', 'Kesehatan', 'Admin Desa Bakal Dalam', '2026-06-11 17:00:00', 'Publik', 1, 0, 'Pemerintah Desa Bakal Dalam bekerja sama dengan Puskesmas Talo Kecil kembali melaksanakan kegiatan pemeriksaan kesehatan bagi lanjut usia (lansia) setelah kegiatan senam sehat rutin yang diselenggarakan setiap hari Jumat.\r\n\r\nPemeriksaan kesehatan meliputi pengecekan tekanan darah, gula darah, berat badan, serta konsultasi kesehatan sesuai dengan kondisi masing-masing peserta. Kegiatan ini bertujuan untuk memantau kondisi kesehatan lansia sekaligus meningkatkan kesadaran akan pentingnya pemeriksaan kesehatan secara berkala.\r\n\r\nAntusiasme masyarakat, khususnya para lansia, terlihat dari tingginya partisipasi dalam mengikuti rangkaian kegiatan mulai dari senam sehat hingga pemeriksaan kesehatan. Pemerintah Desa Bakal Dalam berharap kegiatan ini dapat terus dilaksanakan secara rutin sebagai upaya meningkatkan kualitas kesehatan masyarakat serta mewujudkan desa yang sehat dan sejahtera.', 'news/aGqEu2N7F1I0EfHVmPSPrtoSE7o1TDcYIIJeP9Ym.jpg', '2026-07-12 06:27:23', '2026-07-12 08:21:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `officials`
--

CREATE TABLE `officials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'Aktif',
  `deskripsi` text DEFAULT NULL,
  `kata_sambutan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `officials`
--

INSERT INTO `officials` (`id`, `nama`, `nip`, `jabatan`, `foto`, `sort_order`, `status`, `deskripsi`, `kata_sambutan`, `created_at`, `updated_at`) VALUES
(5, 'HENDRI SAPUTRA, S.H', NULL, 'Kepala Desa', 'officials/mQGKxVkksx1J6BeTBKKjeYR1pkDI4gIplojetq5A.jpg', 1, 'Aktif', 'Kepala Desa Bakal Dalam bertugas memimpin penyelenggaraan pemerintahan desa, melaksanakan pembangunan, pembinaan kemasyarakatan, serta pemberdayaan masyarakat. Dalam menjalankan tugasnya, Kepala Desa berkomitmen meningkatkan kualitas pelayanan publik, keterbukaan informasi, dan pembangunan desa yang berkelanjutan dengan melibatkan seluruh masyarakat.', 'Selamat datang di Website Resmi Desa Bakal Dalam. Website ini menjadi media informasi dan pelayanan publik yang menyajikan profil desa, potensi, berita, pengumuman, serta berbagai kegiatan pemerintahan dan kemasyarakatan. Semoga website ini dapat memberikan informasi yang bermanfaat serta mempererat komunikasi antara Pemerintah Desa Bakal Dalam dan masyarakat.', '2026-07-12 04:48:17', '2026-07-18 00:34:50'),
(6, 'RONAL, S.Pd', NULL, 'Sekretaris Desa', 'officials/JseiLQAsIRaxwizpSgJywZJA99bx5I7mPTRo7jWk.jpg', 2, 'Aktif', 'Membantu Kepala Desa dalam penyelenggaraan administrasi pemerintahan, pengelolaan surat-menyurat, penyusunan laporan, serta koordinasi administrasi desa.', NULL, '2026-07-12 04:49:27', '2026-07-14 22:10:35'),
(7, 'HERI APUAN', NULL, 'Kepala Seksi Pemerintahan', 'officials/qQfK2ZztmLGdjK1sH4K5Bn00761Z72GJDN5ivFJD.jpg', 3, 'Aktif', 'Membantu Kepala Desa dalam penyelenggaraan pemerintahan desa, administrasi kependudukan, ketertiban masyarakat, serta koordinasi pelaksanaan kegiatan pemerintahan di tingkat desa.', NULL, '2026-07-12 04:52:34', '2026-07-14 22:10:48'),
(8, 'DORESMAN EFENDI', NULL, 'Kepala Seksi Kesejahteraan dan Pelayanan', 'officials/GBSoSuOtege6bjJoCNMvX5CQE4eIXub26VNWCGT9.jpg', 4, 'Aktif', 'Membantu Kepala Desa dalam pelaksanaan pelayanan kepada masyarakat, pembinaan kesejahteraan sosial, pendidikan, kesehatan, serta pemberdayaan masyarakat desa.', NULL, '2026-07-12 04:53:12', '2026-07-14 22:11:15'),
(9, 'HOKI POBRIANTO', NULL, 'Kepala Urusan Umum dan Perencanaan', 'officials/JawdNirJUNEyWPpPThXxNJ67xtqK9AFXmCWja7vL.jpg', 5, 'Aktif', 'Bertanggung jawab dalam pengelolaan administrasi umum, surat-menyurat, inventaris aset desa, penyusunan perencanaan program, serta mendukung kelancaran kegiatan pemerintahan desa.', NULL, '2026-07-12 04:54:07', '2026-07-14 22:11:40'),
(10, 'HARYULIS', NULL, 'Kepala Urusan Keuangan', 'officials/9qqTGXiE2lKXPjsNI0Pw5oNDZxjNUP2x5SqRMn0d.jpg', 6, 'Aktif', 'Mengelola administrasi keuangan desa, mulai dari perencanaan anggaran, penatausahaan, pelaporan, hingga pertanggungjawaban keuangan sesuai dengan ketentuan yang berlaku.', NULL, '2026-07-12 04:54:48', '2026-07-14 22:12:16'),
(11, 'EKY FIRMANSYAH', NULL, 'Kepala Dusun Darat', 'officials/HKBBzJ2GWdd6P0UZ9YXnXBslORoNt898wWabkyON.jpg', 7, 'Aktif', 'Membantu Kepala Desa dalam penyelenggaraan pemerintahan, pembinaan masyarakat, serta penyampaian informasi dan pelayanan kepada warga di wilayah Dusun Darat.', NULL, '2026-07-12 04:55:43', '2026-07-14 22:13:16'),
(12, 'HERI APUAN', NULL, 'PLT Kepala Dusun Lembak', 'officials/A6Mb8azX47NcykGko8OT5fFTxRgAQalah1i6yHkt.jpg', 8, 'Aktif', 'Membantu Kepala Desa dalam mengoordinasikan kegiatan pemerintahan, pembangunan, serta pelayanan masyarakat di wilayah Dusun Lembak.', NULL, '2026-07-12 04:56:22', '2026-07-14 22:13:31'),
(13, 'SEPTO HANDOYO', NULL, 'Kepala Dusun Cugung Kupang', 'officials/W6xdUlUvhZFDKaVb3ZkOqWLBQ9oNEcrVsozsSzly.png', 9, 'Aktif', 'Membantu Kepala Desa dalam melaksanakan pembinaan masyarakat, menjaga ketertiban lingkungan, serta mengoordinasikan kegiatan pembangunan di wilayah Dusun Cugung Kupang.', NULL, '2026-07-12 04:57:09', '2026-07-14 22:17:20'),
(14, 'RAHMAN BADRI', NULL, 'Kepala Dusun Cugung Pelawi', 'officials/t5yQ13gzGX2nGuo2TIproSJD9kin8RI9u9KfHpDz.png', 10, 'Aktif', 'Membantu Kepala Desa dalam menyampaikan informasi pemerintahan, melayani kebutuhan masyarakat, serta mengoordinasikan pelaksanaan pembangunan di wilayah Dusun Cugung Pelawi.', NULL, '2026-07-12 04:57:53', '2026-07-14 22:19:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `potentials`
--

CREATE TABLE `potentials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) NOT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `excerpt` text NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Publik',
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `potentials`
--

INSERT INTO `potentials` (`id`, `nama`, `slug`, `kategori`, `lokasi`, `excerpt`, `deskripsi`, `gambar`, `status`, `featured`, `created_at`, `updated_at`) VALUES
(3, 'Perkebunan Kelapa Sawit', 'perkebunan-kelapa-sawit', 'Perkebunan', 'Desa Bakal Dalam', 'Komoditas unggulan yang menjadi sumber mata pencaharian utama masyarakat.', 'Perkebunan kelapa sawit merupakan sektor ekonomi utama di Desa Bakal Dalam. Sebagian besar masyarakat menggantungkan penghasilannya dari budidaya kelapa sawit yang dikelola secara mandiri maupun kelompok. Potensi ini menjadi penggerak utama perekonomian desa.', 'potentials/hwzKjUrotFyzCUAiBcIN5svTMVoEprNhuw93p2P7.png', 'Publik', 1, '2026-07-12 05:02:39', '2026-07-16 09:34:50'),
(4, 'Persawahan', 'persawahan', 'Pertanian', 'Desa Bakal Dalam', 'Lahan persawahan yang dimanfaatkan untuk budidaya padi.', 'Persawahan di Desa Bakal Dalam menjadi salah satu sumber produksi pangan masyarakat. Aktivitas pertanian dilakukan setiap musim tanam untuk memenuhi kebutuhan pangan dan meningkatkan pendapatan petani.', 'potensi/XIXes2NQWo3vlAnyEdhbe2gQ4Jf8Zqs5rnLVTtlf.jpg', 'Publik', 1, '2026-07-12 05:04:45', '2026-07-12 06:18:13'),
(5, 'Perkebunan Karet', 'perkebunan-karet', 'Perkebunan', 'Desa Bakal Dalam', 'Salah satu komoditas perkebunan yang masih dibudidayakan masyarakat.', 'Selain kelapa sawit, masyarakat juga mengembangkan perkebunan karet sebagai sumber pendapatan tambahan yang memiliki nilai ekonomi.', 'potensi/zUOronWzaWTLjiAAKq6ZpRbQlBHNvKgMfcZAu8YE.jpg', 'Publik', 1, '2026-07-12 05:06:22', '2026-07-12 05:06:22'),
(6, 'Peternakan', 'peternakan', 'Peternakan', 'Desa Bakal Dalam', 'Masyarakat memelihara ternak sebagai usaha sampingan.', 'Beberapa warga memelihara sapi, kambing, maupun unggas sebagai usaha tambahan yang mendukung perekonomian keluarga.', 'potensi/hH5W7oyhHrieLJKBG1w65V7f9K91sLoyCEGKTKlI.webp', 'Publik', 1, '2026-07-12 05:07:30', '2026-07-12 05:07:30'),
(7, 'UMKM Desa', 'umkm-desa', 'UMKM', 'Desa Bakal Dalam', 'Usaha mikro yang dikelola oleh masyarakat desa.', 'Masyarakat Desa Bakal Dalam memiliki berbagai usaha kecil seperti warung, kuliner, dan perdagangan yang berperan dalam meningkatkan perekonomian lokal.', 'potensi/UF8rhkIJwNI0176JTeCLKXF81C4sIOQ8tcdAJ0Jp.jpg', 'Publik', 1, '2026-07-12 05:08:33', '2026-07-12 08:16:36'),
(8, 'Sungai', 'sungai', 'Wisata', 'Desa Bakal Dalam', 'Sungai dimanfaatkan sebagai aktivitas masyarakat sehari-hari.', 'Sungai di Desa Bakal Dalam dimanfaatkan untuk kegiatan masyarakat seperti mandi, mencuci, serta memiliki potensi untuk dikembangkan sebagai wisata berbasis alam apabila dikelola dengan baik.', 'potentials/bn7cxmCov9Q3OhmxaBKhwn3SXecnKkvcxVnARhRE.jpg', 'Publik', 1, '2026-07-12 05:09:04', '2026-07-16 09:36:35'),
(9, 'Embung', 'embung', 'Wisata', 'Desa Bakal Dalam', 'Embung Desa Bakal Dalam merupakan kawasan penampungan air yang memiliki manfaat bagi lingkungan serta berpotensi dikembangkan menjadi tempat wisata dan rekreasi masyarakat.', 'Embung Desa Bakal Dalam merupakan salah satu potensi desa berupa kawasan penampungan air yang berada di wilayah Desa Bakal Dalam. Keberadaan embung ini dapat membantu menjaga ketersediaan air, terutama pada musim kemarau, serta mendukung kebutuhan pertanian dan lingkungan di sekitarnya.\r\nSelain mempunyai fungsi sebagai tempat penyimpanan air, kawasan embung juga memiliki suasana alam yang menarik dan berpotensi dikembangkan sebagai tempat wisata, rekreasi, serta ruang berkumpul bagi masyarakat. Dengan penataan dan pengelolaan yang baik, Embung Desa Bakal Dalam dapat menjadi salah satu daya tarik desa sekaligus memberikan peluang usaha bagi masyarakat, seperti kegiatan kuliner, tempat bersantai, dan usaha kecil di sekitar kawasan embung.', 'potensi/nQ6MuUX6DFbKiuRGdZLjHq2NMfP2VdaoMAP9LObd.jpg', 'Publik', 1, '2026-07-16 09:31:01', '2026-07-16 09:31:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `regions`
--

CREATE TABLE `regions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `luas_wilayah` varchar(255) DEFAULT NULL,
  `jumlah_dusun` int(11) DEFAULT NULL,
  `batas_utara` varchar(255) DEFAULT NULL,
  `batas_selatan` varchar(255) DEFAULT NULL,
  `batas_timur` varchar(255) DEFAULT NULL,
  `batas_barat` varchar(255) DEFAULT NULL,
  `google_maps` varchar(255) DEFAULT NULL,
  `google_maps_embed` longtext DEFAULT NULL,
  `map_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `regions`
--

INSERT INTO `regions` (`id`, `deskripsi`, `luas_wilayah`, `jumlah_dusun`, `batas_utara`, `batas_selatan`, `batas_timur`, `batas_barat`, `google_maps`, `google_maps_embed`, `map_image`, `created_at`, `updated_at`) VALUES
(1, 'Desa Bakal Dalam merupakan salah satu desa yang berada di Kecamatan Talo Kecil, Kabupaten Seluma, Provinsi Bengkulu, dengan luas wilayah sekitar 824,68 hektare. Wilayah desa didominasi oleh dataran berbukit yang dimanfaatkan untuk perkebunan kelapa sawit, karet, serta persawahan tadah hujan. Sekitar 76% wilayah desa digunakan sebagai lahan pertanian dan perkebunan, sedangkan 24% lainnya dimanfaatkan sebagai kawasan permukiman dan fasilitas umum.\r\n\r\nSecara administratif, Desa Bakal Dalam memiliki batas wilayah sebagai berikut:\r\nUtara: Desa Lubuk Lagan dan Desa Talang Padang, Kecamatan Talo Kecil.\r\nSelatan: Desa Tebat Sibun (Kecamatan Talo Kecil) dan Desa Kembang Seri, Kecamatan Talo.\r\nTimur: Desa Suka Mereindu dan Desa Taba, Kecamatan Talo Kecil.\r\nBarat: Desa Napalan, Kecamatan Talo Kecil dan Desa Muara Danau, Kecamatan Talo.\r\n\r\nDesa Bakal Dalam memiliki iklim tropis dengan dua musim, yaitu musim hujan dan musim kemarau, yang sangat mendukung aktivitas pertanian dan perkebunan sebagai mata pencaharian utama masyarakat. Kondisi geografis tersebut menjadikan desa ini memiliki potensi besar dalam pengembangan sektor pertanian dan perkebunan yang menjadi penopang utama perekonomian masyarakat.', '824,68', 4, 'Berbatasan dengan Desa Lubuk Lagan dan Desa Talang Padang Kecamatan Talo Kecil.', 'Berbatasan dengan Desa Tebat Sibun Kecamatan Talo Kecil dan Desa Kembang Seri Kecamatan Talo.', 'Berbatasan dengan Desa Suka Mereindu dan Desa Taba Kecamatan Talo Kecil.', 'Berbatasan dengan Desa Napalan Kecamatan Talo Kecil dan Desa Muara Danau Kecamatan Talo.', 'https://maps.app.goo.gl/AJCd8y2VRqU3NTg1A?g_st=ac', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3600.9003089583643!2d102.72745499999999!3d-4.19592!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNMKwMTEnNDUuMyJTIDEwMsKwNDMnMzguOCJF!5e1!3m2!1sen!2sid!4v1784139472879!5m2!1sen!2sid\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"strict-origin-when-cross-origin\"></iframe>', 'region-map/WosyCINnVJS97eoF6Bn2B9eBp1DBx7WixK8ClO5n.jpg', '2026-07-12 02:48:17', '2026-07-15 11:19:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('17HLXUAIYkmHZGe5gJZMcXxY7N7VtBKv5o2NypO2', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.128.0 Chrome/148.0.7778.271 Electron/42.5.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQ2lJQjFpOUJzYVFyU1N2U2JqbUwyYXBMQnB0eGkyald6azUxUzFUMSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1783709274);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_website` varchar(255) NOT NULL,
  `slogan` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `footer` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `maintenance_mode` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `nama_website`, `slogan`, `logo`, `favicon`, `footer`, `meta_title`, `meta_description`, `meta_keywords`, `maintenance_mode`, `created_at`, `updated_at`) VALUES
(1, 'website desa bakal dalam seluma', 'Desa Membangun untuk Indonesia', 'settings/dHHvlzfW2oMIDbsUubVwcTNrCg1aUOz1S29Zeod6.png', 'settings/L4bxDLhmjgYZ1NTdoabJlIYh1B3B841GrnmxR3Aw.png', '© 2026 Pemerintah Desa Bakal Dalam. Hak Cipta Dilindungi.', 'Website Resmi Desa Bakal Dalam | Kecamatan Talo Kecil', 'Website resmi Desa Bakal Dalam, Kecamatan Talo Kecil, Kabupaten Seluma, yang menyediakan informasi profil desa, berita, agenda, pengumuman, potensi desa, dan pelayanan masyarakat.', 'Desa Bakal Dalam, Kecamatan Talo Kecil, Kabupaten Seluma, website desa, profil desa, berita desa, agenda desa, pengumuman desa, potensi desa', 0, '2026-07-11 12:14:27', '2026-07-17 23:49:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `role` enum('Super Admin','Admin','Editor') NOT NULL DEFAULT 'Admin',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `foto`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Desa', 'admin@desa.com', NULL, '$2y$12$gQH9RTgjfgjx8ALJgA4hJe30aoLz91e0xoH6WF5DqQbPELFmWrYFy', 'users/2FwuakkeTCfqduJLKs4Uv10vs4cTTe1g4nD1GtTx.jpg', 'Admin', NULL, '2026-07-10 11:19:41', '2026-07-17 23:06:30'),
(2, 'Super Admin Desa Bakal Dalam', 'adminbakaldalam@gmail.com', NULL, '$2y$12$TWcGtCpwd.JXTfV2ZMV80uu1ZawKfaqbWYC0byBEJ6./NCtk0mHTK', 'users/SPffKzEodAexb9gNLInrg2hCiEJ6wNSqSlXb4aLO.jpg', 'Super Admin', 'Qz7FfQFAKzMi6SzE2Thrs3uI8qUAcvUxL3dJNQY5k6cbneXKQY1VTYdoolrF', '2026-07-17 23:02:51', '2026-07-17 23:05:30'),
(3, 'Editor Desa', 'editordesa@gmail.com', NULL, '$2y$12$XWGU.udZmKVeXx72GoPhxeIFQ/paMl1K7wycqRvMGOs1VmopP7Kpa', 'users/eToXdickEyJB0tiMIcZ9jDuMxubx5f80uReHoMkj.jpg', 'Editor', NULL, '2026-07-17 23:05:10', '2026-07-17 23:06:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `village_profiles`
--

CREATE TABLE `village_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_desa` varchar(255) NOT NULL,
  `village_slogan` varchar(255) DEFAULT NULL,
  `kecamatan` varchar(255) NOT NULL,
  `kabupaten` varchar(255) NOT NULL,
  `provinsi` varchar(255) NOT NULL,
  `kode_pos` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telepon` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `hero_image` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `office_photo` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `struktur_organisasi` varchar(255) DEFAULT NULL,
  `struktur_bpd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `village_profiles`
--

INSERT INTO `village_profiles` (`id`, `nama_desa`, `village_slogan`, `kecamatan`, `kabupaten`, `provinsi`, `kode_pos`, `email`, `telepon`, `whatsapp`, `website`, `hero_image`, `cover_image`, `office_photo`, `latitude`, `longitude`, `alamat`, `logo`, `created_at`, `updated_at`, `struktur_organisasi`, `struktur_bpd`) VALUES
(1, 'Desa Bakal Dalam', NULL, 'Talo Kecil', 'Seluma', 'Bengkulu', '38574', 'desabakaldalam@gmail.com', '082283155159', '082283155159', 'desa bakal dalam', 'village-hero/cTuJcOndmVWGKyWwqkcN54KFwT3iZO8dBXAGl32O.jpg', 'village-cover/PNGMflBzt1h36GrE8IDJgaP8JbWKYqg2sZ62WOqi.jpg', 'village-office/Br0o9gp2IfHDs0y9hC70PakmY4LgmijiPVIFWGVA.jpg', '4.196446', '102.727460', 'Jl. Lintas Bengkulu - Manna KM.93', 'logo-desa/ero6p9O4qTPVbYWcaAw9iMcgi0sxTUabJ4qeyLNM.png', '2026-07-11 09:54:20', '2026-07-15 08:53:20', 'struktur-organisasi/0i9TnpI0sLx43jmRN33aai4UdO8bs3u9c7dVAf3X.png', 'struktur-bpd/WuuVGmb19hqFnq0il7gGna5iDCaVWW1qatpZ8HgP.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `village_services`
--

CREATE TABLE `village_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL DEFAULT 'bi-file-earmark-text',
  `description` text NOT NULL,
  `requirements` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`requirements`)),
  `processing_time` varchar(255) DEFAULT NULL,
  `cost` varchar(255) DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'Publik',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `village_services`
--

INSERT INTO `village_services` (`id`, `title`, `icon`, `description`, `requirements`, `processing_time`, `cost`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Surat Pengantar KTP dan KK', 'bi-person-vcard', 'Informasi pengantar untuk keperluan administrasi Kartu Tanda Penduduk dan Kartu Keluarga.', '[\"Kartu Keluarga\",\"KTP atau identitas pemohon\",\"Dokumen pendukung sesuai kebutuhan\"]', NULL, NULL, 1, 'Publik', '2026-07-18 05:07:00', '2026-07-18 05:07:00'),
(2, 'Surat Keterangan Domisili', 'bi-house-check', 'Pengajuan keterangan tempat tinggal atau domisili warga sesuai data yang dapat diverifikasi.', '[\"Kartu Keluarga\",\"KTP pemohon\",\"Bukti atau keterangan tempat tinggal\"]', NULL, NULL, 2, 'Publik', '2026-07-18 05:07:00', '2026-07-18 05:07:00'),
(3, 'Surat Keterangan Usaha', 'bi-shop', 'Keterangan dari pemerintah desa untuk usaha yang dijalankan warga di wilayah desa.', '[\"Kartu Keluarga dan KTP\",\"Nama serta jenis usaha\",\"Alamat atau lokasi usaha\"]', NULL, NULL, 3, 'Publik', '2026-07-18 05:07:00', '2026-07-18 05:07:00'),
(4, 'Surat Keterangan Tidak Mampu', 'bi-file-earmark-check', 'Pelayanan keterangan untuk kebutuhan bantuan atau administrasi lain setelah dilakukan pemeriksaan data.', '[\"Kartu Keluarga\",\"KTP pemohon\",\"Dokumen tujuan penggunaan surat\"]', NULL, NULL, 4, 'Publik', '2026-07-18 05:07:00', '2026-07-18 05:07:00'),
(5, 'Surat Pengantar Nikah', 'bi-heart', 'Informasi awal pengurusan dokumen pengantar nikah sesuai ketentuan administrasi yang berlaku.', '[\"Kartu Keluarga dan KTP\",\"Akta kelahiran atau dokumen pendukung\",\"Data calon pasangan\"]', NULL, NULL, 5, 'Publik', '2026-07-18 05:07:00', '2026-07-18 05:07:00'),
(6, 'Pengaduan dan Informasi Desa', 'bi-chat-square-dots', 'Saluran untuk menyampaikan pertanyaan, pengaduan, saran, atau kebutuhan informasi publik desa.', '[\"Identitas pelapor\",\"Uraian pertanyaan atau pengaduan\",\"Bukti pendukung bila tersedia\"]', NULL, NULL, 6, 'Publik', '2026-07-18 05:07:00', '2026-07-18 05:07:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `village_statistics`
--

CREATE TABLE `village_statistics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jumlah_penduduk` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `jumlah_kk` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `jumlah_dusun` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `jumlah_rt` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `jumlah_rw` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `luas_wilayah` decimal(12,2) NOT NULL DEFAULT 0.00,
  `luas_sawah` decimal(12,2) NOT NULL DEFAULT 0.00,
  `luas_perkebunan` decimal(12,2) NOT NULL DEFAULT 0.00,
  `jumlah_umkm` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `jumlah_masjid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `jumlah_musala` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `jumlah_sekolah` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `jumlah_posyandu` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `village_statistics`
--

INSERT INTO `village_statistics` (`id`, `jumlah_penduduk`, `jumlah_kk`, `jumlah_dusun`, `jumlah_rt`, `jumlah_rw`, `luas_wilayah`, `luas_sawah`, `luas_perkebunan`, `jumlah_umkm`, `jumlah_masjid`, `jumlah_musala`, `jumlah_sekolah`, `jumlah_posyandu`, `created_at`, `updated_at`) VALUES
(1, 1400, 443, 4, 0, 0, 824.68, 218.00, 530.00, 10, 3, 0, 2, 0, '2026-07-11 16:20:22', '2026-07-14 08:58:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `vision_missions`
--

CREATE TABLE `vision_missions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `visi` longtext DEFAULT NULL,
  `misi` longtext DEFAULT NULL,
  `tujuan` longtext DEFAULT NULL,
  `motto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `vision_missions`
--

INSERT INTO `vision_missions` (`id`, `visi`, `misi`, `tujuan`, `motto`, `created_at`, `updated_at`) VALUES
(1, '\"DESA BAKAL DALAM YANG AMAN DAN SEJAHTERA BERBASIS EKONOMI KERAKYATAN DAN PERTANIAN\"', '1. Mengembangkan pinjaman permodalan untuk usaha kecil dan usaha pertanian.\r\n2. Mengembangkan dan meningkatkan hasil perkebunan dan usaha kecil masyarakat.\r\n3. Pembuatan sarana jalan usaha tani dan peningkatan jalan lingkungan di perdesaan.\r\n4. Mengembangkan usaha perkebunan karet dan sawit.\r\n5. Peningkatan kapasitas masyarakat dalam pengelolaan usaha.\r\n6. Peningkatan kapasitas masyarakat dalam bidang pertanian dan perkebunan.\r\n7. Mengembangkan usaha pertanian dan perkebunan dengan menggunakan teknologi tepat guna dengan sistem intensifikasi.\r\n8. Perbaikan dan peningkatan layanan sarana kesehatan dan umum.\r\n9. Peningkatan sarana dan prasarana pendidikan.\r\n10. Meningkatkan keterampilan dan kualitas SDM masyarakat.\r\n11. Pengadaan permodalan usaha kecil, dan manajemen usaha masyarakat.\r\n12. Peningkatan kapasitas aparatur pemerintahan desa dan BPD.\r\n13. Peningkatan sarana dan prasarana kerja aparat desa dan BPD.\r\n14. Peningkatan sarana dan prasarana peribadatan.\r\n15. Meningkatkan kesadaran masyarakat tentang pentingnya Kamtibmas.\r\n16. Meningkatkan Pelayanan Umum.\r\n17. Terbentuknya Desa yang Mandiri dan bermartabat.', 'Tujuan Desa Bakal Dalam adalah mewujudkan tata kelola pemerintahan desa yang baik, meningkatkan kualitas pelayanan kepada masyarakat, mengembangkan potensi desa, serta memperkuat partisipasi dan semangat gotong royong guna terciptanya masyarakat yang mandiri, maju, dan sejahtera.', 'SMART TANI  \"Semangat Melayani dengan Amanah, Ramah, Terbuka dan Berkarya demi Berkelanjutan Pembangunan, Pertanian & Pangan.\"', '2026-07-11 18:55:28', '2026-07-13 20:27:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `agendas`
--
ALTER TABLE `agendas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `agendas_slug_unique` (`slug`);

--
-- Indeks untuk tabel `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `announcements_slug_unique` (`slug`);

--
-- Indeks untuk tabel `bpds`
--
ALTER TABLE `bpds`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galleries_date_category_index` (`tanggal_kegiatan`,`kategori`);

--
-- Indeks untuk tabel `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `institutions`
--
ALTER TABLE `institutions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`);

--
-- Indeks untuk tabel `officials`
--
ALTER TABLE `officials`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `potentials`
--
ALTER TABLE `potentials`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `village_profiles`
--
ALTER TABLE `village_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `village_services`
--
ALTER TABLE `village_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `village_services_status_order_index` (`status`,`sort_order`);

--
-- Indeks untuk tabel `village_statistics`
--
ALTER TABLE `village_statistics`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `vision_missions`
--
ALTER TABLE `vision_missions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `agendas`
--
ALTER TABLE `agendas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `bpds`
--
ALTER TABLE `bpds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `histories`
--
ALTER TABLE `histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `institutions`
--
ALTER TABLE `institutions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `officials`
--
ALTER TABLE `officials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `potentials`
--
ALTER TABLE `potentials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `village_profiles`
--
ALTER TABLE `village_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `village_services`
--
ALTER TABLE `village_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `village_statistics`
--
ALTER TABLE `village_statistics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `vision_missions`
--
ALTER TABLE `vision_missions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
