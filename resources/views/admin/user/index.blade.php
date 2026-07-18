@extends('admin.layouts.app')

@section('title', 'Manajemen Admin')

@section('content')

@php
    $isEditing = isset($user);
    $currentAdmin = auth()->user();

    $roles = [
        'Super Admin',
        'Admin',
        'Editor',
    ];

    $editingPhoto = $isEditing && filled($user->foto)
        ? asset(
            'storage/' .
            ltrim($user->foto, '/')
        ) . '?v=' . (
            $user->updated_at?->timestamp
            ?? time()
        )
        : null;
@endphp

@push('styles')
<style>
    .admin-users-page {
        --users-green: var(--admin-green, #16834f);
        --users-green-dark: var(--admin-green-dark, #0d6139);
        --users-green-soft: var(--admin-green-soft, #eef7f2);
        --users-navy: var(--admin-navy, #12251c);
        --users-text: var(--admin-text, #34463c);
        --users-muted: var(--admin-muted, #6e7d74);
        --users-border: var(--admin-border, #dfe9e3);
        --users-bg: var(--admin-bg, #f5f8f6);
        --users-white: #ffffff;
    }

    .admin-users-page,
    .admin-users-page * {
        box-sizing: border-box;
    }

    .users-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 21px;
    }

    .users-header h1 {
        margin: 0;
        color: var(--users-navy);
        font-size: 27px;
        font-weight: 900;
        line-height: 1.2;
        letter-spacing: -0.04em;
    }

    .users-header p {
        margin: 7px 0 0;
        color: var(--users-muted);
        font-size: 12px;
        line-height: 1.65;
    }

    .users-header-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 34px;
        padding: 8px 12px;
        color: var(--users-green-dark);
        background: var(--users-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 999px;
        font-size: 10px;
        font-weight: 850;
        white-space: nowrap;
    }

    .users-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 16px;
        padding: 13px 15px;
        border-radius: 13px;
        font-size: 11px;
        line-height: 1.6;
    }

    .users-alert.success {
        color: #0c6339;
        background: #edf9f2;
        border: 1px solid #ccebd9;
    }

    .users-alert.danger {
        color: #912018;
        background: #fff1f0;
        border: 1px solid #f3cbc7;
    }

    .users-alert ul {
        margin: 6px 0 0;
        padding-left: 18px;
    }

    .users-layout {
        display: grid;
        grid-template-columns:
            minmax(310px, 0.72fr)
            minmax(0, 1.28fr);
        align-items: start;
        gap: 19px;
    }

    .users-card {
        overflow: hidden;
        background: var(--users-white);
        border: 1px solid var(--users-border);
        border-radius: 18px;
        box-shadow: 0 11px 31px rgba(18, 69, 43, 0.05);
    }

    .users-form-card {
        position: sticky;
        top: 90px;
    }

    .users-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 13px;
        padding: 18px 20px;
        border-bottom: 1px solid var(--users-border);
    }

    .users-card-heading {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .users-card-icon {
        width: 40px;
        height: 40px;
        flex: 0 0 40px;
        display: grid;
        place-items: center;
        color: var(--users-green);
        background: var(--users-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.15);
        border-radius: 11px;
        font-size: 15px;
    }

    .users-card-header h2 {
        margin: 0;
        color: var(--users-navy);
        font-size: 15px;
        font-weight: 850;
    }

    .users-card-header p {
        margin: 3px 0 0;
        color: var(--users-muted);
        font-size: 9px;
        line-height: 1.5;
    }

    .users-card-body {
        padding: 20px;
    }

    .users-photo-row {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 19px;
        padding-bottom: 19px;
        border-bottom: 1px solid var(--users-border);
    }

    .users-photo-preview {
        width: 82px;
        height: 82px;
        flex: 0 0 82px;
        display: grid;
        place-items: center;
        overflow: hidden;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--users-green-dark),
            var(--users-green)
        );
        border: 4px solid #ffffff;
        border-radius: 50%;
        box-shadow: 0 9px 23px rgba(18, 69, 43, 0.14);
        font-size: 26px;
        font-weight: 900;
    }

    .users-photo-preview img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        object-position: center top;
    }

    .users-photo-copy {
        min-width: 0;
        flex: 1;
    }

    .users-photo-copy strong {
        display: block;
        color: var(--users-navy);
        font-size: 12px;
        font-weight: 850;
    }

    .users-photo-copy p {
        margin: 5px 0 9px;
        color: var(--users-muted);
        font-size: 9px;
        line-height: 1.55;
    }

    .users-file-input {
        width: 100%;
        color: var(--users-text);
        background: #ffffff;
        border: 1px solid var(--users-border);
        border-radius: 10px;
        font-size: 9px;
    }

    .users-file-input::file-selector-button {
        min-height: 34px;
        margin-right: 9px;
        padding: 0 11px;
        color: var(--users-green-dark);
        background: var(--users-green-soft);
        border: 0;
        font-size: 9px;
        font-weight: 850;
        cursor: pointer;
    }

    .users-fields {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
    }

    .users-field.full {
        grid-column: 1 / -1;
    }

    .users-field label {
        display: block;
        margin-bottom: 7px;
        color: var(--users-navy);
        font-size: 10px;
        font-weight: 850;
    }

    .users-input-wrap {
        position: relative;
    }

    .users-field input,
    .users-field select {
        width: 100%;
        min-height: 44px;
        padding: 0 12px;
        color: var(--users-text);
        background: #ffffff;
        border: 1px solid var(--users-border);
        border-radius: 10px;
        outline: none;
        font-size: 11px;
    }

    .users-field input.has-action {
        padding-right: 43px;
    }

    .users-field input:focus,
    .users-field select:focus {
        border-color: rgba(22, 131, 79, 0.58);
        box-shadow: 0 0 0 4px rgba(22, 131, 79, 0.08);
    }

    .users-password-toggle {
        position: absolute;
        top: 50%;
        right: 7px;
        width: 32px;
        height: 32px;
        display: grid;
        place-items: center;
        padding: 0;
        color: var(--users-muted);
        background: transparent;
        border: 0;
        border-radius: 8px;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .users-password-toggle:hover {
        color: var(--users-green);
        background: var(--users-green-soft);
    }

    .users-help,
    .users-error {
        display: block;
        margin-top: 6px;
        font-size: 8px;
        line-height: 1.5;
    }

    .users-help {
        color: var(--users-muted);
    }

    .users-error {
        color: #b52a21;
        font-weight: 700;
    }

    .users-form-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 18px;
    }

    .users-button {
        min-height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 9px 14px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 10px;
        font-weight: 850;
        cursor: pointer;
    }

    .users-button.primary {
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--users-green-dark),
            var(--users-green)
        );
        border: 0;
        box-shadow: 0 9px 21px rgba(22, 131, 79, 0.17);
    }

    .users-button.secondary {
        color: var(--users-green-dark);
        background: var(--users-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
    }

    .users-filters {
        display: grid;
        grid-template-columns: minmax(190px, 1fr) 150px auto;
        gap: 9px;
        margin-bottom: 17px;
    }

    .users-filters input,
    .users-filters select {
        width: 100%;
        min-height: 41px;
        padding: 0 11px;
        color: var(--users-text);
        background: #ffffff;
        border: 1px solid var(--users-border);
        border-radius: 9px;
        outline: none;
        font-size: 10px;
    }

    .users-table-wrap {
        overflow-x: auto;
        border: 1px solid var(--users-border);
        border-radius: 13px;
    }

    .users-table {
        width: 100%;
        min-width: 760px;
        border-collapse: collapse;
    }

    .users-table th,
    .users-table td {
        padding: 12px 13px;
        text-align: left;
        border-bottom: 1px solid var(--users-border);
        vertical-align: middle;
    }

    .users-table th {
        color: var(--users-muted);
        background: var(--users-bg);
        font-size: 8px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: 0.07em;
    }

    .users-table td {
        color: var(--users-text);
        background: #ffffff;
        font-size: 10px;
    }

    .users-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .users-account {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .users-avatar {
        width: 39px;
        height: 39px;
        flex: 0 0 39px;
        display: grid;
        place-items: center;
        overflow: hidden;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--users-green-dark),
            var(--users-green)
        );
        border-radius: 11px;
        font-size: 12px;
        font-weight: 900;
    }

    .users-avatar img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .users-account strong {
        display: block;
        color: var(--users-navy);
        font-size: 10px;
        font-weight: 850;
    }

    .users-account span {
        display: block;
        margin-top: 2px;
        color: var(--users-muted);
        font-size: 8px;
    }

    .users-role {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 8px;
        border-radius: 999px;
        font-size: 8px;
        font-weight: 850;
    }

    .users-role.super {
        color: #795300;
        background: #fff4cb;
        border: 1px solid #ecd985;
    }

    .users-role.admin {
        color: #0c6339;
        background: #edf9f2;
        border: 1px solid #ccebd9;
    }

    .users-role.editor {
        color: #345a79;
        background: #eef6ff;
        border: 1px solid #cedff0;
    }

    .users-actions {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .users-action {
        min-height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 7px 10px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 9px;
        font-weight: 850;
        cursor: pointer;
    }

    .users-action.edit {
        color: var(--users-green-dark);
        background: var(--users-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
    }

    .users-action.delete {
        color: #a02720;
        background: #fff1f0;
        border: 1px solid #f3cbc7;
    }

    .users-action.disabled {
        color: #9ba7a0;
        background: #f3f6f4;
        border: 1px solid #e2e8e4;
        cursor: not-allowed;
    }

    .users-empty {
        padding: 48px 20px;
        color: var(--users-muted);
        background: var(--users-bg);
        border: 1px dashed var(--users-border);
        border-radius: 13px;
        text-align: center;
        font-size: 11px;
    }

    .users-pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 19px;
    }

    .users-page {
        min-width: 36px;
        height: 36px;
        display: grid;
        place-items: center;
        padding: 0 10px;
        color: var(--users-green-dark);
        background: #ffffff;
        border: 1px solid var(--users-border);
        border-radius: 9px;
        text-decoration: none;
        font-size: 10px;
        font-weight: 800;
    }

    .users-page.active {
        color: #ffffff;
        background: var(--users-green);
        border-color: var(--users-green);
    }

    .users-page.disabled {
        color: #a9b3ad;
        background: #f4f7f5;
        pointer-events: none;
    }

    @media (max-width: 1120px) {
        .users-layout {
            grid-template-columns: 1fr;
        }

        .users-form-card {
            position: static;
        }
    }

    @media (max-width: 700px) {
        .users-header {
            flex-direction: column;
        }

        .users-fields,
        .users-filters {
            grid-template-columns: 1fr;
        }

        .users-card-body {
            padding: 15px;
        }

        .users-photo-row {
            align-items: flex-start;
        }
    }
</style>
@endpush

<div class="admin-users-page">

    <div class="users-header">
        <div>
            <h1>Manajemen Admin</h1>

            <p>
                Tambahkan, ubah, dan atur hak akses pengelola website desa.
            </p>
        </div>

        <span class="users-header-badge">
            <i class="bi bi-shield-check"></i>
            {{ $users->total() }} Akun
        </span>
    </div>

    @if(session('success'))
        <div class="users-alert success">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="users-alert danger">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div class="users-alert danger">
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

    <div class="users-layout">

        <section class="users-card users-form-card">

            <header class="users-card-header">
                <div class="users-card-heading">

                    <span class="users-card-icon">
                        <i class="bi bi-person-gear"></i>
                    </span>

                    <div>
                        <h2>
                            {{ $isEditing
                                ? 'Perbarui Akun'
                                : 'Tambah Akun'
                            }}
                        </h2>

                        <p>
                            Akun digunakan untuk masuk ke dashboard admin.
                        </p>
                    </div>

                </div>
            </header>

            <div class="users-card-body">

                <form
                    action="{{ $isEditing
                        ? route('admin.users.update', $user)
                        : route('admin.users.store')
                    }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf

                    @if($isEditing)
                        @method('PUT')
                    @endif

                    <div class="users-photo-row">

                        <div
                            class="users-photo-preview"
                            id="user-photo-preview"
                        >
                            @if($editingPhoto)
                                <img
                                    src="{{ $editingPhoto }}"
                                    alt="Foto {{ $user->name }}"
                                >
                            @else
                                <span>
                                    {{ strtoupper(
                                        mb_substr(
                                            old(
                                                'name',
                                                $user->name ?? 'A'
                                            ),
                                            0,
                                            1
                                        )
                                    ) }}
                                </span>
                            @endif
                        </div>

                        <div class="users-photo-copy">
                            <strong>Foto Profil</strong>

                            <p>
                                JPG, PNG, atau WEBP. Maksimal 5 MB.
                            </p>

                            <input
                                id="foto"
                                type="file"
                                name="foto"
                                accept="image/jpeg,image/png,image/webp"
                                class="users-file-input"
                            >

                            @error('foto')
                                <span class="users-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                    </div>

                    <div class="users-fields">

                        <div class="users-field full">
                            <label for="name">Nama Lengkap</label>

                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old(
                                    'name',
                                    $user->name ?? ''
                                ) }}"
                                autocomplete="name"
                                required
                            >

                            @error('name')
                                <span class="users-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="users-field full">
                            <label for="email">Alamat Email</label>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old(
                                    'email',
                                    $user->email ?? ''
                                ) }}"
                                autocomplete="email"
                                required
                            >

                            @error('email')
                                <span class="users-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="users-field full">
                            <label for="role">Hak Akses</label>

                            <select
                                id="role"
                                name="role"
                                required
                            >
                                @foreach($roles as $role)
                                    <option
                                        value="{{ $role }}"
                                        {{ old(
                                            'role',
                                            $user->role ?? 'Admin'
                                        ) === $role
                                            ? 'selected'
                                            : ''
                                        }}
                                    >
                                        {{ $role }}
                                    </option>
                                @endforeach
                            </select>

                            <small class="users-help">
                                Editor untuk pengelola konten, Admin untuk
                                pengelola dashboard, dan Super Admin untuk
                                akses tertinggi.
                            </small>

                            @error('role')
                                <span class="users-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="users-field">
                            <label for="password">
                                {{ $isEditing
                                    ? 'Password Baru'
                                    : 'Password'
                                }}
                            </label>

                            <div class="users-input-wrap">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    autocomplete="new-password"
                                    class="has-action"
                                    {{ $isEditing ? '' : 'required' }}
                                >

                                <button
                                    type="button"
                                    class="users-password-toggle"
                                    data-password-toggle="password"
                                    aria-label="Tampilkan password"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>

                            <small class="users-help">
                                Minimal 8 karakter.
                                {{ $isEditing
                                    ? 'Kosongkan bila tidak ingin mengganti.'
                                    : ''
                                }}
                            </small>

                            @error('password')
                                <span class="users-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="users-field">
                            <label for="password_confirmation">
                                Konfirmasi Password
                            </label>

                            <div class="users-input-wrap">
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    autocomplete="new-password"
                                    class="has-action"
                                    {{ $isEditing ? '' : 'required' }}
                                >

                                <button
                                    type="button"
                                    class="users-password-toggle"
                                    data-password-toggle="password_confirmation"
                                    aria-label="Tampilkan konfirmasi password"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="users-form-actions">

                        <button
                            type="submit"
                            class="users-button primary"
                        >
                            <i class="bi bi-check-circle"></i>

                            {{ $isEditing
                                ? 'Simpan Perubahan'
                                : 'Tambah Akun'
                            }}
                        </button>

                        @if($isEditing)
                            <a
                                href="{{ route('admin.users') }}"
                                class="users-button secondary"
                            >
                                Batal
                            </a>
                        @endif

                    </div>

                </form>

            </div>

        </section>

        <section class="users-card">

            <header class="users-card-header">
                <div class="users-card-heading">

                    <span class="users-card-icon">
                        <i class="bi bi-people"></i>
                    </span>

                    <div>
                        <h2>Daftar Pengelola</h2>

                        <p>
                            Akun yang memiliki akses ke dashboard.
                        </p>
                    </div>

                </div>
            </header>

            <div class="users-card-body">

                <form
                    action="{{ route('admin.users') }}"
                    method="GET"
                    class="users-filters"
                >
                    <input
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama atau email..."
                    >

                    <select name="role">
                        <option value="">Semua hak akses</option>

                        @foreach($roles as $role)
                            <option
                                value="{{ $role }}"
                                {{ request('role') === $role
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                {{ $role }}
                            </option>
                        @endforeach
                    </select>

                    <button
                        type="submit"
                        class="users-button primary"
                    >
                        <i class="bi bi-funnel"></i>
                        Filter
                    </button>
                </form>

                @if($users->isEmpty())

                    <div class="users-empty">
                        Belum ada akun yang sesuai dengan pencarian.
                    </div>

                @else

                    <div class="users-table-wrap">

                        <table class="users-table">

                            <thead>
                                <tr>
                                    <th>Akun</th>
                                    <th>Hak Akses</th>
                                    <th>Dibuat</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($users as $item)

                                    @php
                                        $itemPhoto = filled($item->foto)
                                            ? asset(
                                                'storage/' .
                                                ltrim($item->foto, '/')
                                            ) . '?v=' . (
                                                $item->updated_at?->timestamp
                                                ?? time()
                                            )
                                            : null;

                                        $roleClass = match($item->role) {
                                            'Super Admin' => 'super',
                                            'Editor' => 'editor',
                                            default => 'admin',
                                        };
                                    @endphp

                                    <tr>

                                        <td>
                                            <div class="users-account">

                                                <span class="users-avatar">
                                                    @if($itemPhoto)
                                                        <img
                                                            src="{{ $itemPhoto }}"
                                                            alt="{{ $item->name }}"
                                                        >
                                                    @else
                                                        {{ strtoupper(
                                                            mb_substr(
                                                                $item->name,
                                                                0,
                                                                1
                                                            )
                                                        ) }}
                                                    @endif
                                                </span>

                                                <span>
                                                    <strong>
                                                        {{ $item->name }}

                                                        @if(
                                                            $currentAdmin?->id ===
                                                            $item->id
                                                        )
                                                            (Anda)
                                                        @endif
                                                    </strong>

                                                    <span>
                                                        {{ $item->email }}
                                                    </span>
                                                </span>

                                            </div>
                                        </td>

                                        <td>
                                            <span
                                                class="
                                                    users-role
                                                    {{ $roleClass }}
                                                "
                                            >
                                                <i class="bi bi-shield-check"></i>
                                                {{ $item->role }}
                                            </span>
                                        </td>

                                        <td>
                                            {{ $item->created_at
                                                ->locale('id')
                                                ->translatedFormat(
                                                    'd M Y'
                                                )
                                            }}
                                        </td>

                                        <td>
                                            <div class="users-actions">

                                                <a
                                                    href="{{ route(
                                                        'admin.users.edit',
                                                        $item
                                                    ) }}"
                                                    class="users-action edit"
                                                >
                                                    <i class="bi bi-pencil"></i>
                                                    Edit
                                                </a>

                                                @if(
                                                    $currentAdmin?->id ===
                                                    $item->id
                                                )
                                                    <span
                                                        class="
                                                            users-action
                                                            disabled
                                                        "
                                                        title="Akun aktif tidak dapat dihapus"
                                                    >
                                                        <i class="bi bi-lock"></i>
                                                        Aktif
                                                    </span>
                                                @else
                                                    <form
                                                        action="{{ route(
                                                            'admin.users.destroy',
                                                            $item
                                                        ) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Hapus akun {{ addslashes($item->name) }}?')"
                                                    >
                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="
                                                                users-action
                                                                delete
                                                            "
                                                        >
                                                            <i class="bi bi-trash"></i>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @endif

                                            </div>
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    @if($users->hasPages())
                        @php
                            $startPage = max(
                                1,
                                $users->currentPage() - 2
                            );

                            $endPage = min(
                                $users->lastPage(),
                                $users->currentPage() + 2
                            );
                        @endphp

                        <nav class="users-pagination">

                            <a
                                href="{{ $users->previousPageUrl() ?: '#' }}"
                                class="
                                    users-page
                                    {{ $users->onFirstPage()
                                        ? 'disabled'
                                        : ''
                                    }}
                                "
                            >
                                <i class="bi bi-chevron-left"></i>
                            </a>

                            @for(
                                $page = $startPage;
                                $page <= $endPage;
                                $page++
                            )
                                <a
                                    href="{{ $users->url($page) }}"
                                    class="
                                        users-page
                                        {{ $page ===
                                            $users->currentPage()
                                            ? 'active'
                                            : ''
                                        }}
                                    "
                                >
                                    {{ $page }}
                                </a>
                            @endfor

                            <a
                                href="{{ $users->nextPageUrl() ?: '#' }}"
                                class="
                                    users-page
                                    {{ $users->hasMorePages()
                                        ? ''
                                        : 'disabled'
                                    }}
                                "
                            >
                                <i class="bi bi-chevron-right"></i>
                            </a>

                        </nav>
                    @endif

                @endif

            </div>

        </section>

    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const photoInput = document.getElementById('foto');
    const photoPreview = document.getElementById(
        'user-photo-preview'
    );

    photoInput?.addEventListener('change', function () {
        const file = this.files?.[0];

        if (!file || !photoPreview) {
            return;
        }

        const imageUrl = URL.createObjectURL(file);
        const image = document.createElement('img');

        image.src = imageUrl;
        image.alt = 'Pratinjau foto akun';

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

                const input = document.getElementById(
                    inputId
                );

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
});
</script>
@endpush

@endsection
