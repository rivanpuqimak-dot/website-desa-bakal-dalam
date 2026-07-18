<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            !Schema::hasTable('contacts') ||
            !Schema::hasTable('village_profiles')
        ) {
            return;
        }

        $profile = DB::table('village_profiles')
            ->orderBy('id')
            ->first();

        if (!$profile) {
            return;
        }

        $profileToContactMap = [
            'telepon' => 'telepon',
            'whatsapp' => 'whatsapp',
            'email' => 'email',
            'website' => 'website',
            'alamat' => 'alamat',
        ];

        $contact = DB::table('contacts')
            ->orderBy('id')
            ->first();

        /*
         * Bila tabel kontak masih kosong, buat satu record utama.
         * Kolom yang tersedia di Identitas Desa disalin agar data lama
         * tidak hilang ketika form kontak dipusatkan ke menu Kontak.
         */
        if (!$contact) {
            $insertData = [];

            foreach (
                $profileToContactMap
                as $profileField => $contactField
            ) {
                if (
                    Schema::hasColumn(
                        'contacts',
                        $contactField
                    ) &&
                    property_exists(
                        $profile,
                        $profileField
                    )
                ) {
                    $insertData[$contactField] =
                        $profile->{$profileField};
                }
            }

            if (
                Schema::hasColumn(
                    'contacts',
                    'created_at'
                )
            ) {
                $insertData['created_at'] = now();
            }

            if (
                Schema::hasColumn(
                    'contacts',
                    'updated_at'
                )
            ) {
                $insertData['updated_at'] = now();
            }

            DB::table('contacts')->insert($insertData);

            return;
        }

        /*
         * Bila data Kontak sudah ada, hanya isi kolom yang masih kosong.
         * Data yang sudah dikelola dari menu Kontak tidak ditimpa.
         */
        $updateData = [];

        foreach (
            $profileToContactMap
            as $profileField => $contactField
        ) {
            if (
                !Schema::hasColumn(
                    'contacts',
                    $contactField
                ) ||
                !property_exists(
                    $profile,
                    $profileField
                )
            ) {
                continue;
            }

            $contactValue = $contact->{$contactField}
                ?? null;

            $profileValue = $profile->{$profileField}
                ?? null;

            if (
                blank($contactValue) &&
                filled($profileValue)
            ) {
                $updateData[$contactField] =
                    $profileValue;
            }
        }

        if ($updateData === []) {
            return;
        }

        if (
            Schema::hasColumn(
                'contacts',
                'updated_at'
            )
        ) {
            $updateData['updated_at'] = now();
        }

        DB::table('contacts')
            ->where('id', $contact->id)
            ->update($updateData);
    }

    public function down(): void
    {
        /*
         * Tidak ada rollback data.
         * Nilai lama pada village_profiles tetap disimpan sebagai
         * cadangan dan tidak dihapus oleh migration ini.
         */
    }
};
