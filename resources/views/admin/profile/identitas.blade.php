@extends('admin.layouts.app')

@section('title', 'Identitas Desa')

@section('content')

@php
    $namaDesa = old('nama_desa', $profile->nama_desa ?? 'Desa');
    $logoDesa = $profile && filled($profile->logo)
        ? asset('storage/' . ltrim($profile->logo, '/'))
        : null;

    $logoInitial = strtoupper(
        mb_substr($namaDesa ?: 'D', 0, 1)
    );
@endphp

@push('styles')
<style>
    .admin-identity-page {
        --identity-green: var(--admin-green, #16834f);
        --identity-green-dark: var(--admin-green-dark, #0d6139);
        --identity-soft: var(--admin-green-soft, #eef7f2);
        --identity-navy: var(--admin-navy, #12251c);
        --identity-text: var(--admin-text, #34463c);
        --identity-muted: var(--admin-muted, #6e7d74);
        --identity-border: var(--admin-border, #dfe9e3);
        --identity-bg: var(--admin-bg, #f5f8f6);
        width: 100%;
        min-width: 0;
        padding-bottom: 28px;
        overflow-x: clip;
    }

    .admin-identity-page form {
        min-width: 0;
    }

    .admin-identity-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 18px;
    }

    .admin-identity-header h1 {
        margin: 0;
        color: var(--identity-navy);
        font-size: 27px;
        font-weight: 850;
        line-height: 1.25;
        letter-spacing: -0.035em;
    }

    .admin-identity-header p {
        margin: 6px 0 0;
        color: var(--identity-muted);
        font-size: 12px;
        line-height: 1.6;
    }

    .admin-identity-badge {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 11px;
        color: var(--identity-green-dark);
        background: var(--identity-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 999px;
        font-size: 10px;
        font-weight: 850;
    }

    .admin-identity-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 16px;
        padding: 13px 15px;
        border-radius: 13px;
        font-size: 11px;
        line-height: 1.55;
    }

    .admin-identity-alert.success {
        color: #0c6339;
        background: #edf9f2;
        border: 1px solid #ccebd9;
    }

    .admin-identity-alert.danger {
        color: #842029;
        background: #fff1f2;
        border: 1px solid #f2c8cc;
    }

    .admin-identity-alert ul {
        margin: 7px 0 0;
        padding-left: 18px;
    }

    .admin-identity-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--identity-border);
        border-radius: 21px;
        box-shadow: 0 12px 34px rgba(18, 69, 43, 0.055);
    }

    .admin-identity-card + .admin-identity-card {
        margin-top: 18px;
    }

    .admin-identity-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 18px 20px;
        background: linear-gradient(
            180deg,
            #ffffff,
            #fbfdfc
        );
        border-bottom: 1px solid var(--identity-border);
    }

    .admin-identity-section-icon {
        width: 40px;
        height: 40px;
        flex: 0 0 40px;
        display: grid;
        place-items: center;
        color: var(--identity-green);
        background: var(--identity-soft);
        border: 1px solid rgba(22, 131, 79, 0.15);
        border-radius: 12px;
        font-size: 16px;
    }

    .admin-identity-card-header h2 {
        margin: 0;
        color: var(--identity-navy);
        font-size: 15px;
        font-weight: 850;
        line-height: 1.4;
    }

    .admin-identity-card-header p {
        margin: 3px 0 0;
        color: var(--identity-muted);
        font-size: 10px;
        line-height: 1.5;
    }

    .admin-identity-card-body {
        min-width: 0;
        padding: 20px;
    }

    .admin-identity-main-grid {
        display: grid;
        grid-template-columns: minmax(225px, 260px) minmax(0, 1fr);
        gap: 24px;
        align-items: start;
    }

    .admin-identity-logo-panel {
        min-width: 0;
        padding: 17px;
        background: var(--identity-bg);
        border: 1px solid var(--identity-border);
        border-radius: 17px;
    }

    .admin-identity-logo-wrap {
        width: 170px;
        max-width: 100%;
        aspect-ratio: 1 / 1;
        display: grid;
        place-items: center;
        margin: 0 auto 17px;
        padding: 15px;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--identity-border);
        border-radius: 26px;
        box-shadow: 0 12px 26px rgba(18, 69, 43, 0.08);
    }

    .admin-identity-logo-wrap img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: contain;
    }

    .admin-identity-logo-placeholder {
        width: 100%;
        height: 100%;
        display: grid;
        place-items: center;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--identity-green-dark),
            var(--identity-green)
        );
        border-radius: 18px;
        font-size: 54px;
        font-weight: 900;
    }

    .admin-identity-logo-name {
        margin-bottom: 13px;
        text-align: center;
    }

    .admin-identity-logo-name strong {
        display: block;
        color: var(--identity-navy);
        font-size: 13px;
        font-weight: 850;
    }

    .admin-identity-logo-name span {
        display: block;
        margin-top: 3px;
        color: var(--identity-muted);
        font-size: 10px;
    }

    .admin-identity-fields {
        min-width: 0;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        align-content: start;
        gap: 15px 18px;
    }

    .admin-identity-field {
        min-width: 0;
    }

    .admin-identity-field.full {
        grid-column: 1 / -1;
    }

    .admin-identity-field label {
        display: block;
        margin-bottom: 7px;
        color: var(--identity-navy);
        font-size: 11px;
        font-weight: 800;
    }

    .admin-identity-field input,
    .admin-identity-field textarea {
        width: 100%;
        color: var(--identity-text);
        background: #ffffff;
        border: 1px solid var(--identity-border);
        border-radius: 11px;
        outline: none;
        font-size: 12px;
        transition:
            border-color 0.2s ease,
            box-shadow 0.2s ease,
            background 0.2s ease;
    }

    .admin-identity-field input {
        min-height: 45px;
        padding: 0 13px;
    }

    .admin-identity-field textarea {
        min-height: 108px;
        padding: 12px 13px;
        resize: vertical;
    }

    .admin-identity-field input:focus,
    .admin-identity-field textarea:focus {
        background: #ffffff;
        border-color: rgba(22, 131, 79, 0.55);
        box-shadow: 0 0 0 4px rgba(22, 131, 79, 0.09);
    }

    .admin-identity-field input.is-invalid,
    .admin-identity-field textarea.is-invalid {
        border-color: #dc5b65;
    }

    .admin-identity-help {
        display: block;
        margin-top: 6px;
        color: var(--identity-muted);
        font-size: 9px;
        line-height: 1.5;
    }

    .admin-identity-error {
        display: block;
        margin-top: 5px;
        color: #c03542;
        font-size: 9px;
        font-weight: 700;
    }

    .admin-identity-file {
        position: relative;
    }

    .admin-identity-file input[type="file"] {
        min-height: 46px;
        padding: 8px;
        background: #ffffff;
    }

    .admin-identity-file input[type="file"]::file-selector-button {
        height: 30px;
        margin-right: 10px;
        padding: 0 11px;
        color: var(--identity-green-dark);
        background: var(--identity-soft);
        border: 0;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 800;
        cursor: pointer;
    }

    .admin-identity-media-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .admin-identity-upload-card {
        min-width: 0;
        padding: 16px;
        background: #ffffff;
        border: 1px solid var(--identity-border);
        border-radius: 15px;
    }

    .admin-identity-upload-card h3 {
        margin: 0;
        color: var(--identity-navy);
        font-size: 12px;
        font-weight: 850;
        line-height: 1.4;
    }

    .admin-identity-upload-card p {
        margin: 4px 0 13px;
        color: var(--identity-muted);
        font-size: 9px;
        line-height: 1.5;
    }

    .admin-identity-preview {
        width: 100%;
        height: 150px;
        display: grid;
        place-items: center;
        margin-top: 12px;
        overflow: hidden;
        color: var(--identity-green);
        background: var(--identity-bg);
        border: 1px dashed #c9d8cf;
        border-radius: 12px;
    }

    .admin-identity-preview img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .admin-identity-preview.contain img {
        object-fit: contain;
        padding: 8px;
        background: #ffffff;
    }

    .admin-identity-preview i {
        font-size: 25px;
    }

    .admin-identity-structure-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .admin-identity-coordinate-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .admin-identity-action {
        position: static;
        display: flex;
        justify-content: flex-end;
        margin-top: 18px;
        padding: 14px 0 0;
        background: transparent;
        border: 0;
    }

    .admin-identity-submit {
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 17px;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--identity-green-dark),
            var(--identity-green)
        );
        border: 0;
        border-radius: 11px;
        box-shadow: 0 10px 22px rgba(22, 131, 79, 0.2);
        font-size: 11px;
        font-weight: 850;
        cursor: pointer;
        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease;
    }

    .admin-identity-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 27px rgba(22, 131, 79, 0.25);
    }

    .admin-identity-contact-notice {
        grid-column: 1 / -1;
        min-width: 0;
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        align-items: center;
        gap: 16px;
        padding: 14px 15px;
        color: var(--identity-text);
        background: var(--identity-soft);
        border: 1px solid rgba(22, 131, 79, 0.18);
        border-radius: 14px;
    }

    .admin-identity-contact-notice-copy {
        min-width: 0;
        display: flex;
        align-items: flex-start;
        gap: 11px;
    }

    .admin-identity-contact-notice-copy > div {
        min-width: 0;
    }

    .admin-identity-contact-notice-icon {
        width: 39px;
        height: 39px;
        flex: 0 0 39px;
        display: grid;
        place-items: center;
        color: #ffffff;
        background: var(--identity-green);
        border-radius: 11px;
        font-size: 16px;
    }

    .admin-identity-contact-notice strong {
        display: block;
        color: var(--identity-navy);
        font-size: 11px;
        font-weight: 850;
    }

    .admin-identity-contact-notice p {
        max-width: 760px;
        margin: 4px 0 0;
        color: var(--identity-muted);
        font-size: 9px;
        line-height: 1.55;
        overflow-wrap: anywhere;
    }

    .admin-identity-contact-link {
        min-height: 40px;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 9px 13px;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--identity-green-dark),
            var(--identity-green)
        );
        border-radius: 10px;
        text-decoration: none;
        font-size: 9px;
        font-weight: 850;
    }

    @media (max-width: 1180px) {
        .admin-identity-main-grid {
            grid-template-columns: 215px minmax(0, 1fr);
            gap: 20px;
        }

        .admin-identity-logo-wrap {
            width: 155px;
        }

        .admin-identity-media-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 980px) {
        .admin-identity-header {
            align-items: flex-start;
        }

        .admin-identity-main-grid {
            grid-template-columns: 190px minmax(0, 1fr);
        }

        .admin-identity-logo-wrap {
            width: 145px;
        }

        .admin-identity-fields {
            gap: 13px;
        }
    }

    @media (max-width: 800px) {
        .admin-identity-main-grid {
            grid-template-columns: 1fr;
        }

        .admin-identity-logo-panel {
            display: grid;
            grid-template-columns: 150px minmax(0, 1fr);
            gap: 16px;
            align-items: center;
        }

        .admin-identity-logo-wrap {
            width: 150px;
            margin: 0;
        }

        .admin-identity-logo-name {
            text-align: left;
        }

        .admin-identity-structure-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 720px) {
        .admin-identity-contact-notice {
            grid-template-columns: 1fr;
        }

        .admin-identity-contact-link {
            width: 100%;
        }
    }

    @media (max-width: 620px) {
        .admin-identity-header {
            flex-direction: column;
            margin-bottom: 15px;
        }

        .admin-identity-header h1 {
            font-size: 23px;
        }

        .admin-identity-card {
            border-radius: 17px;
        }

        .admin-identity-card-header,
        .admin-identity-card-body {
            padding: 16px;
        }

        .admin-identity-logo-panel {
            grid-template-columns: 1fr;
        }

        .admin-identity-logo-wrap {
            width: 145px;
            margin: 0 auto;
        }

        .admin-identity-logo-name {
            text-align: center;
        }

        .admin-identity-fields,
        .admin-identity-media-grid,
        .admin-identity-coordinate-grid {
            grid-template-columns: 1fr;
        }

        .admin-identity-action {
            padding: 10px;
        }

        .admin-identity-submit {
            width: 100%;
        }
    }
</style>
@endpush

<div class="admin-identity-page">

    <div class="admin-identity-header">

        <div>
            <h1>Identitas Desa</h1>

            <p>
                Kelola informasi dasar, logo, media, koordinat,
                dan struktur organisasi desa.
            </p>
        </div>

        <span class="admin-identity-badge">
            <i class="bi bi-building"></i>
            Profil Desa
        </span>

    </div>

    @if(session('success'))

        <div class="admin-identity-alert success">
            <i class="bi bi-check-circle-fill"></i>

            <div>
                {{ session('success') }}
            </div>
        </div>

    @endif

    @if($errors->any())

        <div class="admin-identity-alert danger">
            <i class="bi bi-exclamation-triangle-fill"></i>

            <div>
                <strong>Data belum dapat disimpan.</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

    @endif

    <form
        action="{{ route('admin.identitas.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        {{-- IDENTITAS UTAMA --}}
        <section class="admin-identity-card">

            <div class="admin-identity-card-header">

                <span class="admin-identity-section-icon">
                    <i class="bi bi-building"></i>
                </span>

                <div>
                    <h2>Informasi Utama Desa</h2>

                    <p>
                        Data dasar yang tampil pada website publik.
                    </p>
                </div>

            </div>

            <div class="admin-identity-card-body">

                <div class="admin-identity-main-grid">

                    <aside class="admin-identity-logo-panel">

                        <div
                            class="admin-identity-logo-wrap"
                            id="logo-preview-wrapper"
                        >

                            @if($logoDesa)

                                <img
                                    src="{{ $logoDesa }}"
                                    alt="Logo {{ $namaDesa }}"
                                    id="logo-preview-image"
                                >

                            @else

                                <div
                                    class="admin-identity-logo-placeholder"
                                    id="logo-preview-placeholder"
                                >
                                    {{ $logoInitial }}
                                </div>

                            @endif

                        </div>

                        <div>

                            <div class="admin-identity-logo-name">
                                <strong>{{ $namaDesa ?: 'Nama Desa' }}</strong>
                                <span>Logo resmi pemerintah desa</span>
                            </div>

                            <div class="admin-identity-field admin-identity-file">

                                <label for="logo">
                                    Logo Desa
                                </label>

                                <input
                                    id="logo"
                                    type="file"
                                    name="logo"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    class="@error('logo') is-invalid @enderror"
                                    data-image-preview="logo-preview-wrapper"
                                >

                                <small class="admin-identity-help">
                                    JPG, JPEG, PNG, atau WEBP.
                                </small>

                                @error('logo')
                                    <span class="admin-identity-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                        </div>

                    </aside>

                    <div class="admin-identity-fields">

                        <div class="admin-identity-field">

                            <label for="nama_desa">
                                Nama Desa
                            </label>

                            <input
                                id="nama_desa"
                                type="text"
                                name="nama_desa"
                                value="{{ old(
                                    'nama_desa',
                                    $profile->nama_desa ?? ''
                                ) }}"
                                class="@error('nama_desa') is-invalid @enderror"
                            >

                            @error('nama_desa')
                                <span class="admin-identity-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                        <div class="admin-identity-field">

                            <label for="kecamatan">
                                Kecamatan
                            </label>

                            <input
                                id="kecamatan"
                                type="text"
                                name="kecamatan"
                                value="{{ old(
                                    'kecamatan',
                                    $profile->kecamatan ?? ''
                                ) }}"
                                class="@error('kecamatan') is-invalid @enderror"
                            >

                            @error('kecamatan')
                                <span class="admin-identity-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                        <div class="admin-identity-field">

                            <label for="kabupaten">
                                Kabupaten
                            </label>

                            <input
                                id="kabupaten"
                                type="text"
                                name="kabupaten"
                                value="{{ old(
                                    'kabupaten',
                                    $profile->kabupaten ?? ''
                                ) }}"
                                class="@error('kabupaten') is-invalid @enderror"
                            >

                            @error('kabupaten')
                                <span class="admin-identity-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                        <div class="admin-identity-field">

                            <label for="provinsi">
                                Provinsi
                            </label>

                            <input
                                id="provinsi"
                                type="text"
                                name="provinsi"
                                value="{{ old(
                                    'provinsi',
                                    $profile->provinsi ?? ''
                                ) }}"
                                class="@error('provinsi') is-invalid @enderror"
                            >

                            @error('provinsi')
                                <span class="admin-identity-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                        <div class="admin-identity-field">

                            <label for="kode_pos">
                                Kode Pos
                            </label>

                            <input
                                id="kode_pos"
                                type="text"
                                name="kode_pos"
                                value="{{ old(
                                    'kode_pos',
                                    $profile->kode_pos ?? ''
                                ) }}"
                                class="@error('kode_pos') is-invalid @enderror"
                            >

                            @error('kode_pos')
                                <span class="admin-identity-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                        <div class="admin-identity-contact-notice">

                            <div class="admin-identity-contact-notice-copy">

                                <span class="admin-identity-contact-notice-icon">
                                    <i class="bi bi-telephone-forward"></i>
                                </span>

                                <div>
                                    <strong>
                                        Kontak publik dipusatkan pada menu Kontak
                                    </strong>

                                    <p>
                                        Email, telepon, WhatsApp, website,
                                        alamat kantor, media sosial, jam
                                        pelayanan, dan Google Maps tidak lagi
                                        diedit dari Identitas Desa agar tidak
                                        terjadi data ganda.
                                    </p>
                                </div>

                            </div>

                            <a
                                href="{{ route('admin.kontak') }}"
                                class="admin-identity-contact-link"
                            >
                                <i class="bi bi-arrow-right-circle"></i>
                                Buka Kontak Desa
                            </a>

                    </div>

                </div>

            </div>

        </section>

        {{-- FOTO DESA --}}
        <section class="admin-identity-card">

            <div class="admin-identity-card-header">

                <span class="admin-identity-section-icon">
                    <i class="bi bi-images"></i>
                </span>

                <div>
                    <h2>Foto dan Gambar Desa</h2>

                    <p>
                        Media visual untuk halaman publik.
                    </p>
                </div>

            </div>

            <div class="admin-identity-card-body">

                <div class="admin-identity-media-grid">

                    @php
                        $mediaItems = [
                            [
                                'name' => 'hero_image',
                                'title' => 'Foto Banner Utama',
                                'description' =>
                                    'Muncul sebagai banner besar paling atas ' .
                                    'di halaman Beranda. Disarankan foto ' .
                                    'landscape lebar, sekitar 1920 × 900 piksel.',
                                'value' => $profile->hero_image ?? null,
                            ],
                            [
                                'name' => 'cover_image',
                                'title' => 'Foto Sampul Desa',
                                'description' =>
                                    'Muncul pada header halaman Profil Desa ' .
                                    'dan bagian Tentang Desa di Beranda. ' .
                                    'Disarankan landscape sekitar 1600 × 900 piksel.',
                                'value' => $profile->cover_image ?? null,
                            ],
                            [
                                'name' => 'office_photo',
                                'title' => 'Foto Kantor Desa',
                                'description' =>
                                    'Muncul pada bagian khusus Kantor Pemerintah ' .
                                    'Desa di halaman Profil Desa. Gunakan foto ' .
                                    'gedung kantor yang jelas dan rapi.',
                                'value' => $profile->office_photo ?? null,
                            ],
                        ];
                    @endphp

                    @foreach($mediaItems as $media)

                        <article class="admin-identity-upload-card">

                            <h3>{{ $media['title'] }}</h3>

                            <p>{{ $media['description'] }}</p>

                            <div class="admin-identity-field admin-identity-file">

                                <input
                                    type="file"
                                    name="{{ $media['name'] }}"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    class="@error($media['name']) is-invalid @enderror"
                                >

                                <small class="admin-identity-help">
                                    JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB.
                                </small>

                                @error($media['name'])
                                    <span class="admin-identity-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                            <div class="admin-identity-preview">

                                @if(filled($media['value']))

                                    <img
                                        src="{{ asset(
                                            'storage/' .
                                            ltrim($media['value'], '/')
                                        ) }}"
                                        alt="{{ $media['title'] }}"
                                    >

                                @else

                                    <i class="bi bi-image"></i>

                                @endif

                            </div>

                        </article>

                    @endforeach

                </div>

            </div>

        </section>

        {{-- STRUKTUR ORGANISASI --}}
        <section class="admin-identity-card">

            <div class="admin-identity-card-header">

                <span class="admin-identity-section-icon">
                    <i class="bi bi-diagram-3"></i>
                </span>

                <div>
                    <h2>Bagan Struktur Organisasi</h2>

                    <p>
                        Bagan Pemerintah Desa dan BPD.
                    </p>
                </div>

            </div>

            <div class="admin-identity-card-body">

                <div class="admin-identity-structure-grid">

                    @php
                        $structureItems = [
                            [
                                'name' => 'struktur_organisasi',
                                'title' => 'Struktur Pemerintah Desa',
                                'value' => $profile->struktur_organisasi ?? null,
                            ],
                            [
                                'name' => 'struktur_bpd',
                                'title' => 'Struktur BPD',
                                'value' => $profile->struktur_bpd ?? null,
                            ],
                        ];
                    @endphp

                    @foreach($structureItems as $structure)

                        <article class="admin-identity-upload-card">

                            <h3>{{ $structure['title'] }}</h3>

                            <p>
                                JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB.
                            </p>

                            <div class="admin-identity-field admin-identity-file">

                                <input
                                    type="file"
                                    name="{{ $structure['name'] }}"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    class="@error($structure['name']) is-invalid @enderror"
                                >

                                @error($structure['name'])
                                    <span class="admin-identity-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                            <div class="admin-identity-preview contain">

                                @if(filled($structure['value']))

                                    <img
                                        src="{{ asset(
                                            'storage/' .
                                            ltrim($structure['value'], '/')
                                        ) }}"
                                        alt="{{ $structure['title'] }}"
                                    >

                                @else

                                    <i class="bi bi-diagram-3"></i>

                                @endif

                            </div>

                        </article>

                    @endforeach

                </div>

            </div>

        </section>

        {{-- KOORDINAT --}}
        <section class="admin-identity-card">

            <div class="admin-identity-card-header">

                <span class="admin-identity-section-icon">
                    <i class="bi bi-geo-alt"></i>
                </span>

                <div>
                    <h2>Koordinat Kantor Desa</h2>

                    <p>
                        Lokasi kantor pada peta halaman publik.
                    </p>
                </div>

            </div>

            <div class="admin-identity-card-body">

                <div class="admin-identity-coordinate-grid">

                    <div class="admin-identity-field">

                        <label for="latitude">
                            Koordinat Latitude
                        </label>

                        <input
                            id="latitude"
                            type="text"
                            name="latitude"
                            value="{{ old(
                                'latitude',
                                $profile->latitude ?? ''
                            ) }}"
                            placeholder="-4.196446"
                            class="@error('latitude') is-invalid @enderror"
                        >

                        <small class="admin-identity-help">
                            Contoh: -4.196446
                        </small>

                        @error('latitude')
                            <span class="admin-identity-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                    <div class="admin-identity-field">

                        <label for="longitude">
                            Koordinat Longitude
                        </label>

                        <input
                            id="longitude"
                            type="text"
                            name="longitude"
                            value="{{ old(
                                'longitude',
                                $profile->longitude ?? ''
                            ) }}"
                            placeholder="102.727460"
                            class="@error('longitude') is-invalid @enderror"
                        >

                        <small class="admin-identity-help">
                            Contoh: 102.727460
                        </small>

                        @error('longitude')
                            <span class="admin-identity-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </div>

            </div>

        </section>

        <div class="admin-identity-action">

            <button
                type="submit"
                class="admin-identity-submit"
            >
                <i class="bi bi-check-circle"></i>
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const logoInput = document.getElementById('logo');
    const logoWrapper = document.getElementById(
        'logo-preview-wrapper'
    );

    logoInput?.addEventListener('change', function () {
        const file = this.files?.[0];

        if (!file || !logoWrapper) {
            return;
        }

        const imageUrl = URL.createObjectURL(file);
        const previewImage = document.createElement('img');

        previewImage.src = imageUrl;
        previewImage.alt = 'Pratinjau logo desa';
        previewImage.id = 'logo-preview-image';

        previewImage.addEventListener('load', function () {
            URL.revokeObjectURL(imageUrl);
        });

        logoWrapper.innerHTML = '';
        logoWrapper.appendChild(previewImage);
    });
});
</script>
@endpush

@endsection
