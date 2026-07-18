<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

/*
|--------------------------------------------------------------------------
| Perintah bawaan Laravel
|--------------------------------------------------------------------------
*/

Artisan::command('inspire', function (): void {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Membuat atau memperbarui akun Super Admin
|--------------------------------------------------------------------------
|
| Jalankan:
| php artisan admin:create-super
|
| Perintah ini meminta nama, email, dan password secara interaktif.
| Password tidak ditampilkan saat diketik.
|
*/

Artisan::command('admin:create-super', function (): int {
    $this->newLine();
    $this->info('Pembuatan Akun Super Admin');
    $this->line('Isi data berikut dengan benar.');
    $this->newLine();

    $name = trim(
        (string) $this->ask(
            'Nama lengkap',
            'Super Admin Desa Bakal Dalam'
        )
    );

    $email = strtolower(
        trim(
            (string) $this->ask(
                'Email login',
                'superadmin@desabakal.com'
            )
        )
    );

    $basicValidator = Validator::make(
        [
            'name' => $name,
            'email' => $email,
        ],
        [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
            ],
        ],
        [
            'name.required' =>
                'Nama lengkap wajib diisi.',
            'name.max' =>
                'Nama lengkap maksimal 255 karakter.',
            'email.required' =>
                'Email wajib diisi.',
            'email.email' =>
                'Format email tidak valid.',
            'email.max' =>
                'Email maksimal 255 karakter.',
        ]
    );

    if ($basicValidator->fails()) {
        foreach (
            $basicValidator->errors()->all()
            as $message
        ) {
            $this->error($message);
        }

        return self::FAILURE;
    }

    $existingUser = User::query()
        ->where('email', $email)
        ->first();

    if ($existingUser) {
        $this->warn(
            'Email tersebut sudah terdaftar atas nama: ' .
            $existingUser->name
        );

        if (
            !$this->confirm(
                'Perbarui akun tersebut menjadi Super Admin?',
                false
            )
        ) {
            $this->line('Pembuatan akun dibatalkan.');

            return self::SUCCESS;
        }
    }

    $password = (string) $this->secret(
        'Password baru'
    );

    $passwordConfirmation = (string) $this->secret(
        'Ulangi password'
    );

    $passwordValidator = Validator::make(
        [
            'password' => $password,
            'password_confirmation' =>
                $passwordConfirmation,
        ],
        [
            'password' => [
                'required',
                'confirmed',
                Password::min(10)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ],
        [
            'password.required' =>
                'Password wajib diisi.',
            'password.confirmed' =>
                'Konfirmasi password tidak sama.',
        ]
    );

    if ($passwordValidator->fails()) {
        foreach (
            $passwordValidator->errors()->all()
            as $message
        ) {
            $this->error($message);
        }

        $this->newLine();
        $this->line(
            'Gunakan minimal 10 karakter, huruf besar, ' .
            'huruf kecil, angka, dan simbol.'
        );

        return self::FAILURE;
    }

    try {
        $user = User::query()->updateOrCreate(
            [
                'email' => $email,
            ],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'role' => 'Super Admin',
                'email_verified_at' => now(),
            ]
        );

        $this->newLine();
        $this->info(
            $user->wasRecentlyCreated
                ? 'Akun Super Admin berhasil dibuat.'
                : 'Akun berhasil diperbarui menjadi Super Admin.'
        );

        $this->table(
            [
                'Data',
                'Keterangan',
            ],
            [
                [
                    'Nama',
                    $user->name,
                ],
                [
                    'Email',
                    $user->email,
                ],
                [
                    'Role',
                    $user->role,
                ],
                [
                    'Halaman login',
                    rtrim(
                        (string) config('app.url'),
                        '/'
                    ) . '/login',
                ],
            ]
        );

        $this->warn(
            'Simpan password secara pribadi dan jangan kirim ' .
            'melalui grup umum.'
        );

        return self::SUCCESS;
    } catch (Throwable $exception) {
        report($exception);

        $this->error(
            'Akun gagal dibuat: ' .
            $exception->getMessage()
        );

        return self::FAILURE;
    }
})
    ->purpose(
        'Membuat atau memperbarui akun Super Admin'
    );
