<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('village_services')) {
            Schema::create(
                'village_services',
                function (Blueprint $table): void {
                    $table->id();
                    $table->string('title');
                    $table
                        ->string('icon')
                        ->default('bi-file-earmark-text');
                    $table->text('description');
                    $table->json('requirements')->nullable();
                    $table
                        ->string('processing_time')
                        ->nullable();
                    $table
                        ->string('cost')
                        ->nullable();
                    $table
                        ->unsignedInteger('sort_order')
                        ->default(0);
                    $table
                        ->string('status')
                        ->default('Publik');
                    $table->timestamps();

                    $table->index(
                        ['status', 'sort_order'],
                        'village_services_status_order_index'
                    );
                }
            );
        }

        /*
         * Pindahkan enam layanan bawaan yang sebelumnya ditulis langsung
         * di HomeController ke database agar langsung dapat dikelola
         * melalui dashboard admin.
         */
        if (
            Schema::hasTable('village_services') &&
            DB::table('village_services')->count() === 0
        ) {
            $now = now();

            DB::table('village_services')->insert([
                [
                    'title' => 'Surat Pengantar KTP dan KK',
                    'icon' => 'bi-person-vcard',
                    'description' =>
                        'Informasi pengantar untuk keperluan administrasi Kartu Tanda Penduduk dan Kartu Keluarga.',
                    'requirements' => json_encode([
                        'Kartu Keluarga',
                        'KTP atau identitas pemohon',
                        'Dokumen pendukung sesuai kebutuhan',
                    ], JSON_UNESCAPED_UNICODE),
                    'processing_time' => null,
                    'cost' => null,
                    'sort_order' => 1,
                    'status' => 'Publik',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'title' => 'Surat Keterangan Domisili',
                    'icon' => 'bi-house-check',
                    'description' =>
                        'Pengajuan keterangan tempat tinggal atau domisili warga sesuai data yang dapat diverifikasi.',
                    'requirements' => json_encode([
                        'Kartu Keluarga',
                        'KTP pemohon',
                        'Bukti atau keterangan tempat tinggal',
                    ], JSON_UNESCAPED_UNICODE),
                    'processing_time' => null,
                    'cost' => null,
                    'sort_order' => 2,
                    'status' => 'Publik',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'title' => 'Surat Keterangan Usaha',
                    'icon' => 'bi-shop',
                    'description' =>
                        'Keterangan dari pemerintah desa untuk usaha yang dijalankan warga di wilayah desa.',
                    'requirements' => json_encode([
                        'Kartu Keluarga dan KTP',
                        'Nama serta jenis usaha',
                        'Alamat atau lokasi usaha',
                    ], JSON_UNESCAPED_UNICODE),
                    'processing_time' => null,
                    'cost' => null,
                    'sort_order' => 3,
                    'status' => 'Publik',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'title' => 'Surat Keterangan Tidak Mampu',
                    'icon' => 'bi-file-earmark-check',
                    'description' =>
                        'Pelayanan keterangan untuk kebutuhan bantuan atau administrasi lain setelah dilakukan pemeriksaan data.',
                    'requirements' => json_encode([
                        'Kartu Keluarga',
                        'KTP pemohon',
                        'Dokumen tujuan penggunaan surat',
                    ], JSON_UNESCAPED_UNICODE),
                    'processing_time' => null,
                    'cost' => null,
                    'sort_order' => 4,
                    'status' => 'Publik',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'title' => 'Surat Pengantar Nikah',
                    'icon' => 'bi-heart',
                    'description' =>
                        'Informasi awal pengurusan dokumen pengantar nikah sesuai ketentuan administrasi yang berlaku.',
                    'requirements' => json_encode([
                        'Kartu Keluarga dan KTP',
                        'Akta kelahiran atau dokumen pendukung',
                        'Data calon pasangan',
                    ], JSON_UNESCAPED_UNICODE),
                    'processing_time' => null,
                    'cost' => null,
                    'sort_order' => 5,
                    'status' => 'Publik',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'title' => 'Pengaduan dan Informasi Desa',
                    'icon' => 'bi-chat-square-dots',
                    'description' =>
                        'Saluran untuk menyampaikan pertanyaan, pengaduan, saran, atau kebutuhan informasi publik desa.',
                    'requirements' => json_encode([
                        'Identitas pelapor',
                        'Uraian pertanyaan atau pengaduan',
                        'Bukti pendukung bila tersedia',
                    ], JSON_UNESCAPED_UNICODE),
                    'processing_time' => null,
                    'cost' => null,
                    'sort_order' => 6,
                    'status' => 'Publik',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('village_services');
    }
};
