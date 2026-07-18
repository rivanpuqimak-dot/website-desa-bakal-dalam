@extends('admin.layouts.app')

@section('title', 'Aparat Desa')

@section('content')

@php
    $isEditing = isset($official);

    $officialPhoto = $isEditing && filled($official->foto)
        ? asset('storage/' . ltrim($official->foto, '/'))
        : null;

    $officialInitial = strtoupper(
        mb_substr($official->nama ?? 'A', 0, 1)
    );
@endphp

@push('styles')
<style>

    .admin-data-page {
        --page-green: var(--admin-green, #16834f);
        --page-green-dark: var(--admin-green-dark, #0d6139);
        --page-soft: var(--admin-green-soft, #eef7f2);
        --page-navy: var(--admin-navy, #12251c);
        --page-text: var(--admin-text, #34463c);
        --page-muted: var(--admin-muted, #6e7d74);
        --page-border: var(--admin-border, #dfe9e3);
        --page-bg: var(--admin-bg, #f5f8f6);
    }

    .admin-data-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 20px;
    }

    .admin-data-header h1 {
        margin: 0;
        color: var(--page-navy);
        font-size: 27px;
        font-weight: 850;
        line-height: 1.25;
        letter-spacing: -0.035em;
    }

    .admin-data-header p {
        margin: 6px 0 0;
        color: var(--page-muted);
        font-size: 12px;
        line-height: 1.6;
    }

    .admin-data-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 11px;
        color: var(--page-green-dark);
        background: var(--page-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 999px;
        font-size: 10px;
        font-weight: 850;
        white-space: nowrap;
    }

    .admin-data-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 16px;
        padding: 13px 15px;
        border-radius: 13px;
        font-size: 11px;
        line-height: 1.55;
    }

    .admin-data-alert.success {
        color: #0c6339;
        background: #edf9f2;
        border: 1px solid #ccebd9;
    }

    .admin-data-alert.danger {
        color: #842029;
        background: #fff1f2;
        border: 1px solid #f2c8cc;
    }

    .admin-data-alert ul {
        margin: 7px 0 0;
        padding-left: 18px;
    }

    .admin-data-layout {
        display: grid;
        grid-template-columns: minmax(320px, 0.72fr) minmax(0, 1.28fr);
        gap: 18px;
        align-items: start;
    }

    .admin-data-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--page-border);
        border-radius: 20px;
        box-shadow: 0 12px 34px rgba(18, 69, 43, 0.055);
    }

    .admin-data-card + .admin-data-card {
        margin-top: 18px;
    }

    .admin-data-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 17px 19px;
        border-bottom: 1px solid var(--page-border);
    }

    .admin-data-card-heading {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 0;
    }

    .admin-data-icon {
        width: 39px;
        height: 39px;
        flex: 0 0 39px;
        display: grid;
        place-items: center;
        color: var(--page-green);
        background: var(--page-soft);
        border: 1px solid rgba(22, 131, 79, 0.15);
        border-radius: 11px;
        font-size: 15px;
    }

    .admin-data-card-header h2 {
        margin: 0;
        color: var(--page-navy);
        font-size: 15px;
        font-weight: 850;
        line-height: 1.35;
    }

    .admin-data-card-header p {
        margin: 3px 0 0;
        color: var(--page-muted);
        font-size: 9px;
        line-height: 1.5;
    }

    .admin-data-card-count {
        flex: 0 0 auto;
        padding: 6px 9px;
        color: var(--page-green-dark);
        background: var(--page-soft);
        border-radius: 999px;
        font-size: 9px;
        font-weight: 850;
    }

    .admin-data-card-body {
        padding: 19px;
    }

    .admin-data-fields {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px 17px;
    }

    .admin-data-field.full {
        grid-column: 1 / -1;
    }

    .admin-data-field label {
        display: block;
        margin-bottom: 7px;
        color: var(--page-navy);
        font-size: 11px;
        font-weight: 800;
    }

    .admin-data-field input,
    .admin-data-field select,
    .admin-data-field textarea {
        width: 100%;
        color: var(--page-text);
        background: #ffffff;
        border: 1px solid var(--page-border);
        border-radius: 11px;
        outline: none;
        font-size: 12px;
        transition:
            border-color 0.2s ease,
            box-shadow 0.2s ease,
            background 0.2s ease;
    }

    .admin-data-field input,
    .admin-data-field select {
        min-height: 45px;
        padding: 0 13px;
    }

    .admin-data-field textarea {
        min-height: 105px;
        padding: 12px 13px;
        resize: vertical;
    }

    .admin-data-field input:focus,
    .admin-data-field select:focus,
    .admin-data-field textarea:focus {
        border-color: rgba(22, 131, 79, 0.55);
        box-shadow: 0 0 0 4px rgba(22, 131, 79, 0.09);
    }

    .admin-data-field .is-invalid {
        border-color: #dc5b65;
    }

    .admin-data-help {
        display: block;
        margin-top: 6px;
        color: var(--page-muted);
        font-size: 9px;
        line-height: 1.5;
    }

    .admin-data-error {
        display: block;
        margin-top: 5px;
        color: #c03542;
        font-size: 9px;
        font-weight: 700;
    }

    .admin-data-field input[type="file"] {
        min-height: 46px;
        padding: 8px;
    }

    .admin-data-field input[type="file"]::file-selector-button {
        height: 30px;
        margin-right: 10px;
        padding: 0 11px;
        color: var(--page-green-dark);
        background: var(--page-soft);
        border: 0;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 800;
        cursor: pointer;
    }

    .admin-data-photo-preview {
        width: 130px;
        height: 130px;
        display: grid;
        place-items: center;
        margin: 4px auto 17px;
        overflow: hidden;
        color: var(--page-green);
        background: var(--page-soft);
        border: 4px solid #ffffff;
        border-radius: 24px;
        box-shadow: 0 12px 26px rgba(18, 69, 43, 0.1);
    }

    .admin-data-photo-preview img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        object-position: center top;
    }

    .admin-data-photo-placeholder {
        width: 100%;
        height: 100%;
        display: grid;
        place-items: center;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--page-green-dark),
            var(--page-green)
        );
        font-size: 38px;
        font-weight: 900;
    }

    .admin-data-form-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 18px;
    }

    .admin-data-button {
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

    .admin-data-button.primary {
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--page-green-dark),
            var(--page-green)
        );
        border: 0;
        box-shadow: 0 10px 22px rgba(22, 131, 79, 0.2);
    }

    .admin-data-button.secondary {
        color: var(--page-text);
        background: #ffffff;
        border: 1px solid var(--page-border);
    }

    .admin-data-list {
        display: grid;
        gap: 12px;
    }

    .admin-data-person-card {
        display: grid;
        grid-template-columns: 78px minmax(0, 1fr) auto;
        gap: 13px;
        align-items: center;
        padding: 13px;
        background: #ffffff;
        border: 1px solid var(--page-border);
        border-radius: 15px;
        transition:
            transform 0.2s ease,
            border-color 0.2s ease,
            box-shadow 0.2s ease;
    }

    .admin-data-person-card:hover {
        border-color: rgba(22, 131, 79, 0.25);
        box-shadow: 0 10px 24px rgba(18, 69, 43, 0.07);
        transform: translateY(-2px);
    }

    .admin-data-person-photo {
        width: 78px;
        height: 78px;
        display: grid;
        place-items: center;
        overflow: hidden;
        color: var(--page-green);
        background: var(--page-soft);
        border-radius: 14px;
        font-size: 24px;
        font-weight: 900;
    }

    .admin-data-person-photo img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        object-position: center top;
    }

    .admin-data-person-content {
        min-width: 0;
    }

    .admin-data-person-content h3 {
        margin: 0;
        color: var(--page-navy);
        font-size: 13px;
        font-weight: 850;
        line-height: 1.4;
    }

    .admin-data-person-role {
        display: block;
        margin-top: 3px;
        color: var(--page-green-dark);
        font-size: 10px;
        font-weight: 800;
    }

    .admin-data-person-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 8px;
    }

    .admin-data-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 8px;
        border-radius: 999px;
        font-size: 8px;
        font-weight: 850;
    }

    .admin-data-status.active {
        color: #0c6339;
        background: #edf9f2;
        border: 1px solid #ccebd9;
    }

    .admin-data-status.inactive {
        color: #8a2831;
        background: #fff1f2;
        border: 1px solid #f2c8cc;
    }

    .admin-data-description {
        display: -webkit-box;
        margin: 8px 0 0;
        overflow: hidden;
        color: var(--page-muted);
        font-size: 9px;
        line-height: 1.55;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .admin-data-actions {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .admin-data-action {
        width: 34px;
        height: 34px;
        display: grid;
        place-items: center;
        border-radius: 9px;
        text-decoration: none;
        font-size: 12px;
        cursor: pointer;
    }

    .admin-data-action.edit {
        color: #9a650f;
        background: #fff7e8;
        border: 1px solid #f2d7a6;
    }

    .admin-data-action.delete {
        color: #b9343f;
        background: #fff1f2;
        border: 1px solid #f2c8cc;
    }

    .admin-data-empty {
        display: grid;
        place-items: center;
        min-height: 260px;
        padding: 28px;
        text-align: center;
    }

    .admin-data-empty-icon {
        width: 56px;
        height: 56px;
        display: grid;
        place-items: center;
        margin: 0 auto 12px;
        color: var(--page-green);
        background: var(--page-soft);
        border-radius: 15px;
        font-size: 22px;
    }

    .admin-data-empty h3 {
        margin: 0;
        color: var(--page-navy);
        font-size: 14px;
        font-weight: 850;
    }

    .admin-data-empty p {
        margin: 6px 0 0;
        color: var(--page-muted);
        font-size: 10px;
        line-height: 1.55;
    }

    @media (max-width: 1050px) {
        .admin-data-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 620px) {
        .admin-data-header {
            flex-direction: column;
        }

        .admin-data-header h1 {
            font-size: 23px;
        }

        .admin-data-card-header,
        .admin-data-card-body {
            padding: 15px;
        }

        .admin-data-fields {
            grid-template-columns: 1fr;
        }

        .admin-data-field.full {
            grid-column: auto;
        }

        .admin-data-person-card {
            grid-template-columns: 64px minmax(0, 1fr);
        }

        .admin-data-person-photo {
            width: 64px;
            height: 64px;
        }

        .admin-data-actions {
            grid-column: 1 / -1;
            justify-content: flex-end;
            padding-top: 9px;
            border-top: 1px solid var(--page-border);
        }

        .admin-data-form-actions {
            display: grid;
            grid-template-columns: 1fr;
        }

        .admin-data-button {
            width: 100%;
        }
    }

</style>
@endpush

<div class="admin-data-page">

    <div class="admin-data-header">

        <div>
            <h1>Aparat Desa</h1>

            <p>
                Kelola data perangkat dan aparatur pemerintah desa.
            </p>
        </div>

        <span class="admin-data-badge">
            <i class="bi bi-person-badge"></i>
            Pemerintahan
        </span>

    </div>

    @if(session('success'))

        <div class="admin-data-alert success">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
        </div>

    @endif

    @if($errors->any())

        <div class="admin-data-alert danger">
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

    <div class="admin-data-layout">

        <section class="admin-data-card">

            <div class="admin-data-card-header">

                <div class="admin-data-card-heading">

                    <span class="admin-data-icon">
                        <i class="bi bi-person-plus"></i>
                    </span>

                    <div>
                        <h2>
                            {{ $isEditing
                                ? 'Perbarui Aparatur'
                                : 'Tambah Aparatur'
                            }}
                        </h2>

                        <p>
                            Isi informasi aparatur desa.
                        </p>
                    </div>

                </div>

            </div>

            <div class="admin-data-card-body">

                <div
                    class="admin-data-photo-preview"
                    id="official-photo-preview"
                >

                    @if($officialPhoto)

                        <img
                            src="{{ $officialPhoto }}"
                            alt="Foto {{ $official->nama }}"
                        >

                    @else

                        <div class="admin-data-photo-placeholder">
                            {{ $officialInitial }}
                        </div>

                    @endif

                </div>

                <form
                    action="{{ $isEditing
                        ? route('admin.aparat.update', $official->id)
                        : route('admin.aparat.store')
                    }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf

                    @if($isEditing)
                        @method('PUT')
                    @endif

                    <div class="admin-data-fields">

                        <div class="admin-data-field">

                            <label for="nama">
                                Nama Lengkap
                            </label>

                            <input
                                id="nama"
                                type="text"
                                name="nama"
                                value="{{ old(
                                    'nama',
                                    $official->nama ?? ''
                                ) }}"
                                class="@error('nama') is-invalid @enderror"
                                required
                            >

                            @error('nama')
                                <span class="admin-data-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                        <div class="admin-data-field">

                            <label for="nip">
                                NIP
                            </label>

                            <input
                                id="nip"
                                type="text"
                                name="nip"
                                value="{{ old(
                                    'nip',
                                    $official->nip ?? ''
                                ) }}"
                                placeholder="Opsional"
                                class="@error('nip') is-invalid @enderror"
                            >

                        </div>

                        <div class="admin-data-field">

                            <label for="jabatan">
                                Jabatan
                            </label>

                            <input
                                id="jabatan"
                                type="text"
                                name="jabatan"
                                value="{{ old(
                                    'jabatan',
                                    $official->jabatan ?? ''
                                ) }}"
                                placeholder="Contoh: Kepala Desa"
                                class="@error('jabatan') is-invalid @enderror"
                                required
                            >

                        </div>

                        <div class="admin-data-field">

                            <label for="status">
                                Status
                            </label>

                            <select
                                id="status"
                                name="status"
                                class="@error('status') is-invalid @enderror"
                                required
                            >
                                <option
                                    value="Aktif"
                                    @selected(
                                        old(
                                            'status',
                                            $official->status ?? 'Aktif'
                                        ) === 'Aktif'
                                    )
                                >
                                    Aktif
                                </option>

                                <option
                                    value="Tidak Aktif"
                                    @selected(
                                        old(
                                            'status',
                                            $official->status ?? ''
                                        ) === 'Tidak Aktif'
                                    )
                                >
                                    Tidak Aktif
                                </option>
                            </select>

                        </div>

                        <div class="admin-data-field">

                            <label for="sort_order">
                                Urutan Tampilan
                            </label>

                            <input
                                id="sort_order"
                                type="number"
                                name="sort_order"
                                min="0"
                                value="{{ old(
                                    'sort_order',
                                    $official->sort_order ?? 0
                                ) }}"
                                class="@error('sort_order') is-invalid @enderror"
                            >

                        </div>

                        <div class="admin-data-field">

                            <label for="foto">
                                Foto
                            </label>

                            <input
                                id="foto"
                                type="file"
                                name="foto"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="@error('foto') is-invalid @enderror"
                            >

                            <small class="admin-data-help">
                                Gunakan foto tegak dengan latar yang rapi.
                            </small>

                        </div>

                        <div class="admin-data-field full">

                            <label for="deskripsi">
                                Deskripsi Kepala Desa/Aparat
                            </label>

                            <textarea
                                id="deskripsi"
                                name="deskripsi"
                                class="@error('deskripsi') is-invalid @enderror"
                                placeholder="Profil singkat, tugas, pengalaman, atau informasi tentang aparat."
                            >{{ old(
                                'deskripsi',
                                $official->deskripsi ?? ''
                            ) }}</textarea>

                            <small class="admin-data-help">
                                Deskripsi ini tampil pada halaman
                                Pemerintahan, bukan sebagai kata sambutan.
                            </small>

                            @error('deskripsi')
                                <span class="admin-data-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                        <div class="admin-data-field full">

                            <label for="kata_sambutan">
                                Kata Sambutan Kepala Desa
                            </label>

                            <textarea
                                id="kata_sambutan"
                                name="kata_sambutan"
                                class="@error('kata_sambutan') is-invalid @enderror"
                                placeholder="Tuliskan sambutan yang akan tampil di halaman Beranda."
                            >{{ old(
                                'kata_sambutan',
                                $official->kata_sambutan ?? ''
                            ) }}</textarea>

                            <small class="admin-data-help">
                                Kolom ini hanya digunakan untuk aparat yang
                                menjabat sebagai Kepala Desa dan ditampilkan
                                pada bagian Sambutan di halaman Beranda.
                            </small>

                            @error('kata_sambutan')
                                <span class="admin-data-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>

                    <div class="admin-data-form-actions">

                        <button
                            type="submit"
                            class="admin-data-button primary"
                        >
                            <i class="bi bi-check-circle"></i>

                            {{ $isEditing
                                ? 'Perbarui Data'
                                : 'Simpan Data'
                            }}
                        </button>

                        @if($isEditing)

                            <a
                                href="{{ route('admin.aparat') }}"
                                class="admin-data-button secondary"
                            >
                                <i class="bi bi-x-circle"></i>
                                Batal
                            </a>

                        @endif

                    </div>

                </form>

            </div>

        </section>

        <section class="admin-data-card">

            <div class="admin-data-card-header">

                <div class="admin-data-card-heading">

                    <span class="admin-data-icon">
                        <i class="bi bi-people"></i>
                    </span>

                    <div>
                        <h2>Daftar Aparat Desa</h2>
                        <p>Data aparatur yang telah ditambahkan.</p>
                    </div>

                </div>

                <span class="admin-data-card-count">
                    {{ collect($officials ?? [])->count() }} Data
                </span>

            </div>

            <div class="admin-data-card-body">

                @forelse($officials as $item)

                    @if($loop->first)
                        <div class="admin-data-list">
                    @endif

                        @php
                            $itemPhoto = filled($item->foto)
                                ? asset(
                                    'storage/' .
                                    ltrim($item->foto, '/')
                                )
                                : null;

                            $itemInitial = strtoupper(
                                mb_substr($item->nama ?? 'A', 0, 1)
                            );
                        @endphp

                        <article class="admin-data-person-card">

                            <div class="admin-data-person-photo">

                                @if($itemPhoto)

                                    <img
                                        src="{{ $itemPhoto }}"
                                        alt="Foto {{ $item->nama }}"
                                        loading="lazy"
                                    >

                                @else

                                    {{ $itemInitial }}

                                @endif

                            </div>

                            <div class="admin-data-person-content">

                                <h3>{{ $item->nama }}</h3>

                                <span class="admin-data-person-role">
                                    {{ $item->jabatan }}
                                </span>

                                <div class="admin-data-person-meta">

                                    <span
                                        class="
                                            admin-data-status
                                            {{ $item->status === 'Aktif'
                                                ? 'active'
                                                : 'inactive'
                                            }}
                                        "
                                    >
                                        <i class="bi bi-circle-fill"></i>
                                        {{ $item->status }}
                                    </span>

                                    @if(filled($item->nip))

                                        <span class="admin-data-status active">
                                            NIP: {{ $item->nip }}
                                        </span>

                                    @endif

                                </div>

                                @if(filled($item->deskripsi))

                                    <p class="admin-data-description">
                                        <strong>Deskripsi:</strong>
                                        {{ \Illuminate\Support\Str::limit(
                                            $item->deskripsi,
                                            120
                                        ) }}
                                    </p>

                                @endif

                                @if(filled($item->kata_sambutan))

                                    <p class="admin-data-description">
                                        <strong>Kata Sambutan:</strong>
                                        {{ \Illuminate\Support\Str::limit(
                                            $item->kata_sambutan,
                                            120
                                        ) }}
                                    </p>

                                @endif

                            </div>

                            <div class="admin-data-actions">

                                <a
                                    href="{{ route(
                                        'admin.aparat.edit',
                                        $item->id
                                    ) }}"
                                    class="admin-data-action edit"
                                    title="Edit"
                                    aria-label="Edit {{ $item->nama }}"
                                >
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form
                                    action="{{ route(
                                        'admin.aparat.destroy',
                                        $item->id
                                    ) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="admin-data-action delete"
                                        title="Hapus"
                                        aria-label="Hapus {{ $item->nama }}"
                                        onclick="
                                            return confirm(
                                                'Yakin ingin menghapus data ini?'
                                            )
                                        "
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            </div>

                        </article>

                    @if($loop->last)
                        </div>
                    @endif

                @empty

                    <div class="admin-data-empty">

                        <div>
                            <div class="admin-data-empty-icon">
                                <i class="bi bi-person-plus"></i>
                            </div>

                            <h3>Belum ada aparatur</h3>

                            <p>
                                Data aparatur akan tampil setelah ditambahkan.
                            </p>
                        </div>

                    </div>

                @endforelse

            </div>

        </section>

    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const photoInput = document.getElementById('foto');
    const preview = document.getElementById(
        'official-photo-preview'
    );

    photoInput?.addEventListener('change', function () {
        const file = this.files?.[0];

        if (!file || !preview) {
            return;
        }

        const imageUrl = URL.createObjectURL(file);
        const image = document.createElement('img');

        image.src = imageUrl;
        image.alt = 'Pratinjau foto aparatur';

        image.addEventListener('load', function () {
            URL.revokeObjectURL(imageUrl);
        });

        preview.innerHTML = '';
        preview.appendChild(image);
    });
});
</script>
@endpush

@endsection
