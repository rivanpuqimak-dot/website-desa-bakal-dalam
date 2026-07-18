@extends('admin.layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')

@php
    $admin = auth()->user();

    $adminInitial = strtoupper(
        mb_substr($admin?->name ?? 'A', 0, 1)
    );

    $adminPhoto = filled($admin?->foto)
        ? asset('storage/' . ltrim($admin->foto, '/'))
        : null;
@endphp

@push('styles')
<style>
    .account-settings-page {
        --settings-green: var(--admin-green, #16834f);
        --settings-green-dark: var(--admin-green-dark, #0d6139);
        --settings-green-soft: var(--admin-green-soft, #eef7f2);
        --settings-navy: var(--admin-navy, #12251c);
        --settings-text: var(--admin-text, #34463c);
        --settings-muted: var(--admin-muted, #6e7d74);
        --settings-border: var(--admin-border, #dfe9e3);
        --settings-bg: var(--admin-bg, #f5f8f6);
        --settings-white: #ffffff;
    }

    .account-settings-page,
    .account-settings-page * {
        box-sizing: border-box;
    }

    .account-settings-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 22px;
    }

    .account-settings-header h1 {
        margin: 0;
        color: var(--settings-navy);
        font-size: 27px;
        font-weight: 850;
        line-height: 1.2;
        letter-spacing: -0.035em;
    }

    .account-settings-header p {
        margin: 7px 0 0;
        color: var(--settings-muted);
        font-size: 12px;
        line-height: 1.65;
    }

    .account-settings-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 34px;
        padding: 8px 12px;
        color: var(--settings-green-dark);
        background: var(--settings-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 999px;
        font-size: 10px;
        font-weight: 850;
        white-space: nowrap;
    }

    .account-settings-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 16px;
        padding: 13px 15px;
        border-radius: 13px;
        font-size: 11px;
        line-height: 1.6;
    }

    .account-settings-alert.success {
        color: #0c6339;
        background: #edf9f2;
        border: 1px solid #ccebd9;
    }

    .account-settings-alert.danger {
        color: #912018;
        background: #fff1f0;
        border: 1px solid #f3cbc7;
    }

    .account-settings-alert ul {
        margin: 6px 0 0;
        padding-left: 18px;
    }

    .account-settings-layout {
        display: grid;
        grid-template-columns: 225px minmax(0, 1fr);
        align-items: start;
        gap: 20px;
    }

    /* =====================================================
       NAVIGASI PENGATURAN
    ===================================================== */

    .account-settings-nav {
        position: sticky;
        top: 92px;
        padding: 14px;
        background: var(--settings-white);
        border: 1px solid var(--settings-border);
        border-radius: 18px;
        box-shadow: 0 10px 28px rgba(18, 69, 43, 0.05);
    }

    .account-settings-nav-title {
        padding: 5px 7px 10px;
        color: var(--settings-muted);
        font-size: 9px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .account-settings-nav-list {
        display: grid;
        gap: 6px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .account-settings-nav-link {
        width: 100%;
        min-height: 43px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 11px;
        color: var(--settings-text);
        background: transparent;
        border: 0;
        border-radius: 11px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 800;
        transition:
            color 0.2s ease,
            background 0.2s ease,
            transform 0.2s ease;
    }

    .account-settings-nav-link i {
        width: 27px;
        height: 27px;
        display: grid;
        place-items: center;
        color: var(--settings-green);
        background: var(--settings-green-soft);
        border-radius: 8px;
        font-size: 12px;
    }

    .account-settings-nav-link:hover,
    .account-settings-nav-link.active {
        color: var(--settings-green-dark);
        background: var(--settings-green-soft);
        transform: translateX(2px);
    }

    .account-settings-nav-user {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 14px;
        padding: 13px 7px 4px;
        border-top: 1px solid var(--settings-border);
    }

    .account-settings-nav-avatar {
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        display: grid;
        place-items: center;
        overflow: hidden;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--settings-green-dark),
            var(--settings-green)
        );
        border-radius: 10px;
        font-size: 13px;
        font-weight: 900;
    }

    .account-settings-nav-avatar img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .account-settings-nav-user strong {
        display: block;
        color: var(--settings-navy);
        font-size: 10px;
        font-weight: 850;
        line-height: 1.35;
    }

    .account-settings-nav-user span {
        display: block;
        margin-top: 2px;
        color: var(--settings-muted);
        font-size: 8px;
    }

    /* =====================================================
       KONTEN PENGATURAN
    ===================================================== */

    .account-settings-content {
        display: grid;
        gap: 18px;
    }

    .account-settings-card {
        overflow: hidden;
        background: var(--settings-white);
        border: 1px solid var(--settings-border);
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(18, 69, 43, 0.045);
        scroll-margin-top: 100px;
    }

    .account-settings-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 18px 20px;
        border-bottom: 1px solid var(--settings-border);
    }

    .account-settings-card-heading {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .account-settings-card-icon {
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        display: grid;
        place-items: center;
        color: var(--settings-green);
        background: var(--settings-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.15);
        border-radius: 11px;
        font-size: 14px;
    }

    .account-settings-card-header h2 {
        margin: 0;
        color: var(--settings-navy);
        font-size: 15px;
        font-weight: 850;
    }

    .account-settings-card-header p {
        margin: 3px 0 0;
        color: var(--settings-muted);
        font-size: 9px;
        line-height: 1.5;
    }

    .account-settings-card-body {
        padding: 20px;
    }

    /* =====================================================
       FOTO PROFIL
    ===================================================== */

    .account-settings-photo-row {
        display: flex;
        align-items: center;
        gap: 17px;
        margin-bottom: 22px;
        padding-bottom: 22px;
        border-bottom: 1px solid var(--settings-border);
    }

    .account-settings-photo {
        width: 88px;
        height: 88px;
        flex: 0 0 88px;
        display: grid;
        place-items: center;
        overflow: hidden;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--settings-green-dark),
            var(--settings-green)
        );
        border: 4px solid #ffffff;
        border-radius: 50%;
        box-shadow: 0 9px 24px rgba(18, 69, 43, 0.14);
        font-size: 28px;
        font-weight: 900;
    }

    .account-settings-photo img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        object-position: center top;
    }

    .account-settings-photo-copy {
        min-width: 0;
        flex: 1;
    }

    .account-settings-photo-copy h3 {
        margin: 0;
        color: var(--settings-navy);
        font-size: 13px;
        font-weight: 850;
    }

    .account-settings-photo-copy p {
        margin: 5px 0 11px;
        color: var(--settings-muted);
        font-size: 9px;
        line-height: 1.55;
    }

    .account-settings-file {
        position: relative;
        display: inline-flex;
    }

    .account-settings-file input {
        position: absolute;
        width: 1px;
        height: 1px;
        overflow: hidden;
        opacity: 0;
        pointer-events: none;
    }

    .account-settings-file-label {
        min-height: 37px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 12px;
        color: var(--settings-green-dark);
        background: var(--settings-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.17);
        border-radius: 10px;
        font-size: 10px;
        font-weight: 850;
        cursor: pointer;
    }

    .account-settings-file-name {
        display: block;
        margin-top: 7px;
        color: var(--settings-muted);
        font-size: 8px;
        overflow-wrap: anywhere;
    }

    /* =====================================================
       FORM
    ===================================================== */

    .account-settings-fields {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px 18px;
    }

    .account-settings-field.full {
        grid-column: 1 / -1;
    }

    .account-settings-field label {
        display: block;
        margin-bottom: 7px;
        color: var(--settings-navy);
        font-size: 10px;
        font-weight: 850;
    }

    .account-settings-input-wrap {
        position: relative;
    }

    .account-settings-field input {
        width: 100%;
        min-height: 45px;
        padding: 0 13px;
        color: var(--settings-text);
        background: #ffffff;
        border: 1px solid var(--settings-border);
        border-radius: 11px;
        outline: none;
        font-size: 12px;
        transition:
            border-color 0.2s ease,
            box-shadow 0.2s ease,
            background 0.2s ease;
    }

    .account-settings-field input.has-action {
        padding-right: 44px;
    }

    .account-settings-field input:focus {
        border-color: rgba(22, 131, 79, 0.58);
        box-shadow: 0 0 0 4px rgba(22, 131, 79, 0.09);
    }

    .account-settings-field input[readonly] {
        color: var(--settings-muted);
        background: var(--settings-bg);
        cursor: not-allowed;
    }

    .account-settings-field input.is-invalid {
        border-color: #d55d53;
        box-shadow: 0 0 0 4px rgba(213, 93, 83, 0.08);
    }

    .account-settings-toggle-password {
        position: absolute;
        top: 50%;
        right: 8px;
        width: 32px;
        height: 32px;
        display: grid;
        place-items: center;
        padding: 0;
        color: var(--settings-muted);
        background: transparent;
        border: 0;
        border-radius: 8px;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .account-settings-toggle-password:hover {
        color: var(--settings-green);
        background: var(--settings-green-soft);
    }

    .account-settings-help {
        display: block;
        margin-top: 6px;
        color: var(--settings-muted);
        font-size: 8px;
        line-height: 1.5;
    }

    .account-settings-error {
        display: block;
        margin-top: 6px;
        color: #b52a21;
        font-size: 9px;
        line-height: 1.45;
    }

    .account-settings-security-note {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        margin-bottom: 17px;
        padding: 12px 13px;
        color: #5b684f;
        background: #fafbf5;
        border: 1px solid #e8eadc;
        border-radius: 11px;
        font-size: 9px;
        line-height: 1.6;
    }

    .account-settings-security-note i {
        color: var(--settings-green);
        margin-top: 1px;
    }

    /* =====================================================
       ACTION BAR
    ===================================================== */

    .account-settings-actions {
        position: sticky;
        bottom: 0;
        z-index: 5;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 15px 18px;
        background: rgba(255, 255, 255, 0.94);
        border: 1px solid var(--settings-border);
        border-radius: 16px;
        box-shadow: 0 -8px 25px rgba(18, 69, 43, 0.07);
        backdrop-filter: blur(10px);
    }

    .account-settings-actions p {
        margin: 0;
        color: var(--settings-muted);
        font-size: 9px;
        line-height: 1.5;
    }

    .account-settings-submit {
        min-height: 43px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--settings-green-dark),
            var(--settings-green)
        );
        border: 0;
        border-radius: 11px;
        box-shadow: 0 10px 22px rgba(22, 131, 79, 0.19);
        font-size: 10px;
        font-weight: 850;
        cursor: pointer;
    }

    .account-settings-submit:hover {
        filter: brightness(1.03);
    }

    @media (max-width: 900px) {
        .account-settings-layout {
            grid-template-columns: 1fr;
        }

        .account-settings-nav {
            position: static;
        }

        .account-settings-nav-list {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .account-settings-nav-user {
            display: none;
        }
    }

    @media (max-width: 620px) {
        .account-settings-header {
            flex-direction: column;
        }

        .account-settings-header h1 {
            font-size: 23px;
        }

        .account-settings-nav-list {
            grid-template-columns: 1fr;
        }

        .account-settings-card-header,
        .account-settings-card-body {
            padding: 16px;
        }

        .account-settings-photo-row {
            align-items: flex-start;
        }

        .account-settings-photo {
            width: 74px;
            height: 74px;
            flex-basis: 74px;
        }

        .account-settings-fields {
            grid-template-columns: 1fr;
        }

        .account-settings-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .account-settings-submit {
            width: 100%;
        }
    }
</style>
@endpush

<div class="account-settings-page">

    <div class="account-settings-header">

        <div>
            <h1>Pengaturan Akun</h1>

            <p>
                Kelola profil, informasi akun, dan keamanan login administrator.
            </p>
        </div>

        <span class="account-settings-status">
            <i class="bi bi-shield-check"></i>
            Akun Aktif
        </span>

    </div>

    @if(session('success'))
        <div class="account-settings-alert success">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="account-settings-alert danger">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div class="account-settings-alert danger">
            <i class="bi bi-exclamation-triangle-fill"></i>

            <div>
                <strong>Periksa kembali data berikut:</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form
        action="{{ route('admin.profil.update') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf
        @method('PUT')

        <div class="account-settings-layout">

            <aside class="account-settings-nav">

                <div class="account-settings-nav-title">
                    Menu Pengaturan
                </div>

                <ul class="account-settings-nav-list">

                    <li>
                        <a
                            href="#profil-akun"
                            class="account-settings-nav-link active"
                        >
                            <i class="bi bi-person"></i>
                            Profil Akun
                        </a>
                    </li>

                    <li>
                        <a
                            href="#keamanan-akun"
                            class="account-settings-nav-link"
                        >
                            <i class="bi bi-shield-lock"></i>
                            Keamanan
                        </a>
                    </li>

                </ul>

                <div class="account-settings-nav-user">

                    <div class="account-settings-nav-avatar">

                        @if($adminPhoto)
                            <img
                                src="{{ $adminPhoto }}"
                                alt="Foto {{ $admin?->name ?? 'Admin' }}"
                            >
                        @else
                            {{ $adminInitial }}
                        @endif

                    </div>

                    <div>
                        <strong>
                            {{ $admin?->name ?? 'Administrator' }}
                        </strong>

                        <span>
                            {{ $admin?->role ?? 'Admin' }}
                        </span>
                    </div>

                </div>

            </aside>

            <div class="account-settings-content">

                <section
                    class="account-settings-card"
                    id="profil-akun"
                >

                    <header class="account-settings-card-header">

                        <div class="account-settings-card-heading">

                            <span class="account-settings-card-icon">
                                <i class="bi bi-person-vcard"></i>
                            </span>

                            <div>
                                <h2>Profil Akun</h2>

                                <p>
                                    Informasi dasar yang digunakan untuk akun administrator.
                                </p>
                            </div>

                        </div>

                    </header>

                    <div class="account-settings-card-body">

                        <div class="account-settings-photo-row">

                            <div
                                class="account-settings-photo"
                                id="admin-photo-preview"
                            >

                                @if($adminPhoto)

                                    <img
                                        src="{{ $adminPhoto }}"
                                        alt="Foto {{ $admin?->name ?? 'Admin' }}"
                                    >

                                @else

                                    <span>{{ $adminInitial }}</span>

                                @endif

                            </div>

                            <div class="account-settings-photo-copy">

                                <h3>Foto Profil</h3>

                                <p>
                                    Gunakan foto JPG, PNG, atau WEBP. Ukuran maksimal 5 MB.
                                </p>

                                <div class="account-settings-file">

                                    <input
                                        id="foto"
                                        type="file"
                                        name="foto"
                                        accept="image/jpeg,image/png,image/webp"
                                    >

                                    <label
                                        for="foto"
                                        class="account-settings-file-label"
                                    >
                                        <i class="bi bi-camera"></i>
                                        Pilih Foto
                                    </label>

                                </div>

                                <span
                                    class="account-settings-file-name"
                                    id="admin-photo-name"
                                >
                                    Belum ada file baru dipilih.
                                </span>

                                @error('foto')
                                    <span class="account-settings-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                        </div>

                        <div class="account-settings-fields">

                            <div class="account-settings-field">

                                <label for="name">
                                    Nama Lengkap
                                </label>

                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name', $admin?->name) }}"
                                    autocomplete="name"
                                    class="@error('name') is-invalid @enderror"
                                    required
                                >

                                @error('name')
                                    <span class="account-settings-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                            <div class="account-settings-field">

                                <label for="email">
                                    Alamat Email
                                </label>

                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $admin?->email) }}"
                                    autocomplete="email"
                                    class="@error('email') is-invalid @enderror"
                                    required
                                >

                                @error('email')
                                    <span class="account-settings-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                            <div class="account-settings-field full">

                                <label for="role">
                                    Hak Akses
                                </label>

                                <input
                                    id="role"
                                    type="text"
                                    value="{{ $admin?->role ?? 'Admin' }}"
                                    readonly
                                >

                                <small class="account-settings-help">
                                    Hak akses hanya dapat diubah melalui menu Manajemen Admin.
                                </small>

                            </div>

                        </div>

                    </div>

                </section>

                <section
                    class="account-settings-card"
                    id="keamanan-akun"
                >

                    <header class="account-settings-card-header">

                        <div class="account-settings-card-heading">

                            <span class="account-settings-card-icon">
                                <i class="bi bi-shield-lock"></i>
                            </span>

                            <div>
                                <h2>Keamanan Akun</h2>

                                <p>
                                    Perbarui password untuk menjaga keamanan akun.
                                </p>
                            </div>

                        </div>

                    </header>

                    <div class="account-settings-card-body">

                        <div class="account-settings-security-note">
                            <i class="bi bi-info-circle-fill"></i>

                            <div>
                                Kosongkan kedua kolom password apabila Anda hanya ingin
                                memperbarui nama, email, atau foto profil.
                            </div>
                        </div>

                        <div class="account-settings-fields">

                            <div class="account-settings-field">

                                <label for="new-password">
                                    Password Baru
                                </label>

                                <div class="account-settings-input-wrap">

                                    <input
                                        id="new-password"
                                        type="password"
                                        name="password"
                                        autocomplete="new-password"
                                        class="
                                            has-action
                                            @error('password') is-invalid @enderror
                                        "
                                    >

                                    <button
                                        type="button"
                                        class="account-settings-toggle-password"
                                        data-password-toggle="new-password"
                                        aria-label="Tampilkan password baru"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </button>

                                </div>

                                <small class="account-settings-help">
                                    Gunakan minimal 8 karakter dan kombinasikan huruf serta angka.
                                </small>

                                @error('password')
                                    <span class="account-settings-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                            <div class="account-settings-field">

                                <label for="password-confirmation">
                                    Konfirmasi Password
                                </label>

                                <div class="account-settings-input-wrap">

                                    <input
                                        id="password-confirmation"
                                        type="password"
                                        name="password_confirmation"
                                        autocomplete="new-password"
                                        class="has-action"
                                    >

                                    <button
                                        type="button"
                                        class="account-settings-toggle-password"
                                        data-password-toggle="password-confirmation"
                                        aria-label="Tampilkan konfirmasi password"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>

                <div class="account-settings-actions">

                    <p>
                        Perubahan akan diterapkan setelah tombol simpan ditekan.
                    </p>

                    <button
                        type="submit"
                        class="account-settings-submit"
                    >
                        <i class="bi bi-check-circle"></i>
                        Simpan Perubahan
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const photoInput = document.getElementById('foto');
    const photoPreview = document.getElementById(
        'admin-photo-preview'
    );
    const photoName = document.getElementById(
        'admin-photo-name'
    );

    photoInput?.addEventListener('change', function () {
        const file = this.files?.[0];

        if (!file) {
            if (photoName) {
                photoName.textContent =
                    'Belum ada file baru dipilih.';
            }

            return;
        }

        if (photoName) {
            photoName.textContent = file.name;
        }

        if (!photoPreview) {
            return;
        }

        const imageUrl = URL.createObjectURL(file);
        const image = document.createElement('img');

        image.src = imageUrl;
        image.alt = 'Pratinjau foto profil';

        image.addEventListener('load', function () {
            URL.revokeObjectURL(imageUrl);
        });

        photoPreview.innerHTML = '';
        photoPreview.appendChild(image);
    });

    document
        .querySelectorAll('[data-password-toggle]')
        .forEach(function (button) {
            button.addEventListener('click', function () {
                const inputId = this.getAttribute(
                    'data-password-toggle'
                );
                const input = document.getElementById(inputId);
                const icon = this.querySelector('i');

                if (!input) {
                    return;
                }

                const isPassword =
                    input.type === 'password';

                input.type = isPassword
                    ? 'text'
                    : 'password';

                icon?.classList.toggle(
                    'bi-eye',
                    !isPassword
                );

                icon?.classList.toggle(
                    'bi-eye-slash',
                    isPassword
                );
            });
        });

    const navLinks = document.querySelectorAll(
        '.account-settings-nav-link'
    );

    navLinks.forEach(function (link) {
        link.addEventListener('click', function () {
            navLinks.forEach(function (item) {
                item.classList.remove('active');
            });

            this.classList.add('active');
        });
    });
});
</script>
@endpush

@endsection
