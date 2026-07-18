PERUBAHAN GALERI TAHUNAN DAN KATEGORI

Fitur baru:
- Galeri admin dan publik dikelompokkan berdasarkan tahun kegiatan.
- Setiap tahun dikelompokkan lagi berdasarkan kategori.
- Filter tahun dan kategori tersedia.
- Tanggal kegiatan wajib diisi saat menambah foto.
- Foto lama otomatis memakai tanggal created_at setelah migration.
- Batas unggahan tetap 5 MB per foto.

Setelah menyalin proyek, jalankan:
php artisan migrate
php artisan storage:link
php artisan view:clear
php artisan optimize:clear

Kemudian buka /admin/galeri untuk mengoreksi tanggal kegiatan foto lama bila diperlukan.
