@extends('admin.layouts.app')

@section('title', 'Layanan Desa')

@section('content')

@php
    $editingService = $service ?? null;

    $iconOptions = [
        'bi-file-earmark-text' => 'Dokumen Umum',
        'bi-person-vcard' => 'KTP / Identitas',
        'bi-people' => 'Kependudukan',
        'bi-house-check' => 'Domisili',
        'bi-shop' => 'Usaha',
        'bi-file-earmark-check' => 'Surat Keterangan',
        'bi-heart' => 'Pernikahan',
        'bi-chat-square-dots' => 'Pengaduan',
        'bi-briefcase' => 'Pekerjaan',
        'bi-mortarboard' => 'Pendidikan',
        'bi-heart-pulse' => 'Kesehatan',
        'bi-shield-check' => 'Keamanan',
    ];

    $requirementsValue = old(
        'requirements_text',
        $editingService
            ? collect($editingService->requirements ?? [])
                ->implode("\n")
            : ''
    );
@endphp

@push('styles')
<style>
    .service-admin-page {
        --sa-green: var(--admin-green, #16834f);
        --sa-green-dark: var(--admin-green-dark, #0d6139);
        --sa-soft: var(--admin-green-soft, #eef7f2);
        --sa-navy: var(--admin-navy, #12251c);
        --sa-text: var(--admin-text, #34463c);
        --sa-muted: var(--admin-muted, #6e7d74);
        --sa-border: var(--admin-border, #dfe9e3);
        --sa-bg: var(--admin-bg, #f5f8f6);
        width: 100%;
        min-width: 0;
        padding-bottom: 30px;
    }

    .service-admin-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 19px;
    }

    .service-admin-header h1 {
        margin: 0;
        color: var(--sa-navy);
        font-size: 27px;
        font-weight: 900;
        line-height: 1.2;
        letter-spacing: -0.035em;
    }

    .service-admin-header p {
        max-width: 760px;
        margin: 6px 0 0;
        color: var(--sa-muted);
        font-size: 11px;
        line-height: 1.65;
    }

    .service-admin-public-link {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 38px;
        padding: 8px 12px;
        color: var(--sa-green-dark);
        background: var(--sa-soft);
        border: 1px solid rgba(22, 131, 79, 0.17);
        border-radius: 999px;
        text-decoration: none;
        font-size: 9px;
        font-weight: 850;
    }

    .service-admin-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 15px;
        padding: 13px 15px;
        border-radius: 13px;
        font-size: 10px;
        line-height: 1.6;
    }

    .service-admin-alert.success {
        color: #0c6339;
        background: #edf9f2;
        border: 1px solid #ccebd9;
    }

    .service-admin-alert.danger {
        color: #842029;
        background: #fff1f2;
        border: 1px solid #f2c8cc;
    }

    .service-admin-alert ul {
        margin: 6px 0 0;
        padding-left: 17px;
    }

    .service-admin-layout {
        display: grid;
        grid-template-columns: minmax(330px, 0.78fr) minmax(0, 1.22fr);
        gap: 18px;
        align-items: start;
    }

    .service-admin-card {
        min-width: 0;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--sa-border);
        border-radius: 19px;
        box-shadow: 0 11px 32px rgba(18, 69, 43, 0.055);
    }

    .service-admin-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 13px;
        padding: 16px 18px;
        border-bottom: 1px solid var(--sa-border);
    }

    .service-admin-heading {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 0;
    }

    .service-admin-heading-icon {
        width: 41px;
        height: 41px;
        flex: 0 0 41px;
        display: grid;
        place-items: center;
        color: var(--sa-green);
        background: var(--sa-soft);
        border: 1px solid rgba(22, 131, 79, 0.15);
        border-radius: 12px;
        font-size: 16px;
    }

    .service-admin-card-header h2 {
        margin: 0;
        color: var(--sa-navy);
        font-size: 14px;
        font-weight: 850;
        line-height: 1.4;
    }

    .service-admin-card-header p {
        margin: 3px 0 0;
        color: var(--sa-muted);
        font-size: 9px;
        line-height: 1.45;
    }

    .service-admin-card-body {
        padding: 18px;
    }

    .service-admin-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .service-admin-field {
        min-width: 0;
    }

    .service-admin-field.full {
        grid-column: 1 / -1;
    }

    .service-admin-field label {
        display: block;
        margin-bottom: 7px;
        color: var(--sa-navy);
        font-size: 9px;
        font-weight: 850;
    }

    .service-admin-required {
        color: #c63f49;
    }

    .service-admin-field input,
    .service-admin-field select,
    .service-admin-field textarea {
        width: 100%;
        min-height: 43px;
        padding: 10px 12px;
        color: var(--sa-text);
        background: #ffffff;
        border: 1px solid var(--sa-border);
        border-radius: 11px;
        outline: 0;
        font: inherit;
        font-size: 10px;
        transition:
            border-color 0.2s ease,
            box-shadow 0.2s ease;
    }

    .service-admin-field textarea {
        min-height: 108px;
        resize: vertical;
        line-height: 1.6;
    }

    .service-admin-field input:focus,
    .service-admin-field select:focus,
    .service-admin-field textarea:focus {
        border-color: var(--sa-green);
        box-shadow: 0 0 0 3px rgba(22, 131, 79, 0.1);
    }

    .service-admin-field .is-invalid {
        border-color: #dc5962;
    }

    .service-admin-help {
        display: block;
        margin-top: 6px;
        color: var(--sa-muted);
        font-size: 8.5px;
        line-height: 1.5;
    }

    .service-admin-error {
        display: block;
        margin-top: 5px;
        color: #b02a37;
        font-size: 8.5px;
        font-weight: 700;
    }

    .service-admin-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 16px;
    }

    .service-admin-button {
        min-height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 9px 14px;
        border: 0;
        border-radius: 10px;
        text-decoration: none;
        cursor: pointer;
        font-size: 9px;
        font-weight: 850;
    }

    .service-admin-button.primary {
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--sa-green-dark),
            var(--sa-green)
        );
        box-shadow: 0 9px 20px rgba(13, 97, 57, 0.16);
    }

    .service-admin-button.secondary {
        color: var(--sa-text);
        background: #ffffff;
        border: 1px solid var(--sa-border);
    }

    .service-admin-toolbar {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 145px auto;
        gap: 9px;
        margin-bottom: 14px;
    }

    .service-admin-toolbar input,
    .service-admin-toolbar select {
        width: 100%;
        min-height: 40px;
        padding: 9px 11px;
        color: var(--sa-text);
        background: #ffffff;
        border: 1px solid var(--sa-border);
        border-radius: 10px;
        outline: 0;
        font-size: 9px;
    }

    .service-admin-toolbar button {
        min-height: 40px;
        padding: 9px 13px;
        color: #ffffff;
        background: var(--sa-green);
        border: 0;
        border-radius: 10px;
        cursor: pointer;
        font-size: 9px;
        font-weight: 850;
    }

    .service-admin-list {
        display: grid;
        gap: 11px;
    }

    .service-admin-item {
        display: grid;
        grid-template-columns: 48px minmax(0, 1fr) auto;
        align-items: center;
        gap: 12px;
        padding: 13px;
        background: #ffffff;
        border: 1px solid var(--sa-border);
        border-radius: 14px;
    }

    .service-admin-item-icon {
        width: 48px;
        height: 48px;
        display: grid;
        place-items: center;
        color: var(--sa-green);
        background: var(--sa-soft);
        border-radius: 13px;
        font-size: 18px;
    }

    .service-admin-item-content {
        min-width: 0;
    }

    .service-admin-item-title-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;
    }

    .service-admin-item h3 {
        margin: 0;
        color: var(--sa-navy);
        font-size: 11px;
        font-weight: 850;
        line-height: 1.4;
        overflow-wrap: anywhere;
    }

    .service-admin-status {
        padding: 5px 7px;
        border-radius: 999px;
        font-size: 7.5px;
        font-weight: 850;
    }

    .service-admin-status.public {
        color: #0c6339;
        background: #edf9f2;
        border: 1px solid #ccebd9;
    }

    .service-admin-status.draft {
        color: #725717;
        background: #fff8df;
        border: 1px solid #f1dfa6;
    }

    .service-admin-item p {
        display: -webkit-box;
        overflow: hidden;
        margin: 5px 0 0;
        color: var(--sa-muted);
        font-size: 9px;
        line-height: 1.55;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .service-admin-item-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin-top: 7px;
        color: var(--sa-muted);
        font-size: 8px;
        font-weight: 700;
    }

    .service-admin-item-meta span {
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .service-admin-item-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .service-admin-icon-button {
        width: 34px;
        height: 34px;
        display: grid;
        place-items: center;
        color: var(--sa-green-dark);
        background: var(--sa-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
        border-radius: 9px;
        text-decoration: none;
        cursor: pointer;
        font-size: 12px;
    }

    .service-admin-icon-button.delete {
        color: #a62f39;
        background: #fff1f2;
        border-color: #f2c8cc;
    }

    .service-admin-empty {
        padding: 38px 20px;
        color: var(--sa-muted);
        background: var(--sa-bg);
        border: 1px dashed #c8d8cf;
        border-radius: 14px;
        text-align: center;
        font-size: 10px;
        line-height: 1.6;
    }

    .service-admin-pagination {
        margin-top: 15px;
    }

    @media (max-width: 1050px) {
        .service-admin-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 680px) {
        .service-admin-header {
            flex-direction: column;
        }

        .service-admin-public-link {
            width: 100%;
            justify-content: center;
        }

        .service-admin-form-grid,
        .service-admin-toolbar {
            grid-template-columns: 1fr;
        }

        .service-admin-item {
            grid-template-columns: 42px minmax(0, 1fr);
        }

        .service-admin-item-icon {
            width: 42px;
            height: 42px;
        }

        .service-admin-item-actions {
            grid-column: 1 / -1;
            justify-content: flex-end;
        }
    }
</style>
@endpush

<div class="service-admin-page">

    <header class="service-admin-header">
        <div>
            <h1>Layanan Desa</h1>

            <p>
                Tambah dan perbarui jenis layanan, persyaratan,
                estimasi proses, biaya, urutan, serta status yang
                ditampilkan pada website publik.
            </p>
        </div>

        <a
            href="{{ route('public.services.index') }}"
            target="_blank"
            rel="noopener"
            class="service-admin-public-link"
        >
            <i class="bi bi-box-arrow-up-right"></i>
            Lihat Halaman Publik
        </a>
    </header>

    @if(session('success'))
        <div class="service-admin-alert success">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div class="service-admin-alert danger">
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

    <div class="service-admin-layout">

        <section class="service-admin-card">

            <div class="service-admin-card-header">
                <div class="service-admin-heading">

                    <span class="service-admin-heading-icon">
                        <i class="bi bi-ui-checks-grid"></i>
                    </span>

                    <div>
                        <h2>
                            {{ $editingService
                                ? 'Edit Layanan'
                                : 'Tambah Layanan'
                            }}
                        </h2>

                        <p>
                            Data berstatus Publik akan langsung tampil.
                        </p>
                    </div>

                </div>
            </div>

            <div class="service-admin-card-body">

                <form
                    method="POST"
                    action="{{ $editingService
                        ? route(
                            'admin.layanan.update',
                            $editingService
                        )
                        : route('admin.layanan.store')
                    }}"
                >
                    @csrf

                    @if($editingService)
                        @method('PUT')
                    @endif

                    <div class="service-admin-form-grid">

                        <div class="service-admin-field full">
                            <label for="title">
                                Nama Layanan
                                <span class="service-admin-required">*</span>
                            </label>

                            <input
                                id="title"
                                name="title"
                                type="text"
                                value="{{ old(
                                    'title',
                                    $editingService?->title
                                ) }}"
                                placeholder="Contoh: Surat Keterangan Domisili"
                                class="@error('title') is-invalid @enderror"
                            >

                            @error('title')
                                <span class="service-admin-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="service-admin-field">
                            <label for="icon">
                                Ikon
                            </label>

                            <select
                                id="icon"
                                name="icon"
                                class="@error('icon') is-invalid @enderror"
                            >
                                @foreach($iconOptions as $icon => $label)
                                    <option
                                        value="{{ $icon }}"
                                        @selected(
                                            old(
                                                'icon',
                                                $editingService?->icon
                                                    ?? 'bi-file-earmark-text'
                                            ) === $icon
                                        )
                                    >
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            @error('icon')
                                <span class="service-admin-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="service-admin-field">
                            <label for="sort_order">
                                Urutan
                                <span class="service-admin-required">*</span>
                            </label>

                            <input
                                id="sort_order"
                                name="sort_order"
                                type="number"
                                min="0"
                                max="9999"
                                value="{{ old(
                                    'sort_order',
                                    $editingService?->sort_order
                                        ?? 0
                                ) }}"
                                class="@error('sort_order') is-invalid @enderror"
                            >

                            @error('sort_order')
                                <span class="service-admin-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="service-admin-field full">
                            <label for="description">
                                Deskripsi
                                <span class="service-admin-required">*</span>
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                placeholder="Jelaskan fungsi dan tujuan layanan."
                                class="@error('description') is-invalid @enderror"
                            >{{ old(
                                'description',
                                $editingService?->description
                            ) }}</textarea>

                            @error('description')
                                <span class="service-admin-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="service-admin-field full">
                            <label for="requirements_text">
                                Persyaratan
                                <span class="service-admin-required">*</span>
                            </label>

                            <textarea
                                id="requirements_text"
                                name="requirements_text"
                                placeholder="Kartu Keluarga&#10;KTP pemohon&#10;Dokumen pendukung"
                                class="@error('requirements_text') is-invalid @enderror"
                            >{{ $requirementsValue }}</textarea>

                            <small class="service-admin-help">
                                Tulis satu persyaratan pada setiap baris.
                            </small>

                            @error('requirements_text')
                                <span class="service-admin-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="service-admin-field">
                            <label for="processing_time">
                                Estimasi Proses
                            </label>

                            <input
                                id="processing_time"
                                name="processing_time"
                                type="text"
                                value="{{ old(
                                    'processing_time',
                                    $editingService?->processing_time
                                ) }}"
                                placeholder="Contoh: 1 hari kerja"
                            >
                        </div>

                        <div class="service-admin-field">
                            <label for="cost">
                                Biaya
                            </label>

                            <input
                                id="cost"
                                name="cost"
                                type="text"
                                value="{{ old(
                                    'cost',
                                    $editingService?->cost
                                ) }}"
                                placeholder="Contoh: Gratis"
                            >
                        </div>

                        <div class="service-admin-field full">
                            <label for="status">
                                Status
                                <span class="service-admin-required">*</span>
                            </label>

                            <select
                                id="status"
                                name="status"
                            >
                                <option
                                    value="Publik"
                                    @selected(
                                        old(
                                            'status',
                                            $editingService?->status
                                                ?? 'Publik'
                                        ) === 'Publik'
                                    )
                                >
                                    Publik
                                </option>

                                <option
                                    value="Draft"
                                    @selected(
                                        old(
                                            'status',
                                            $editingService?->status
                                                ?? 'Publik'
                                        ) === 'Draft'
                                    )
                                >
                                    Draft
                                </option>
                            </select>
                        </div>

                    </div>

                    <div class="service-admin-actions">

                        @if($editingService)
                            <a
                                href="{{ route('admin.layanan') }}"
                                class="service-admin-button secondary"
                            >
                                Batal Edit
                            </a>
                        @endif

                        <button
                            type="submit"
                            class="service-admin-button primary"
                        >
                            <i class="bi bi-save"></i>

                            {{ $editingService
                                ? 'Simpan Perubahan'
                                : 'Tambah Layanan'
                            }}
                        </button>

                    </div>

                </form>

            </div>
        </section>

        <section class="service-admin-card">

            <div class="service-admin-card-header">
                <div class="service-admin-heading">

                    <span class="service-admin-heading-icon">
                        <i class="bi bi-list-check"></i>
                    </span>

                    <div>
                        <h2>Daftar Layanan</h2>
                        <p>Atur informasi yang tampil di website publik.</p>
                    </div>

                </div>
            </div>

            <div class="service-admin-card-body">

                <form
                    method="GET"
                    action="{{ route('admin.layanan') }}"
                    class="service-admin-toolbar"
                >
                    <input
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari layanan..."
                    >

                    <select name="status">
                        <option value="">Semua Status</option>
                        <option
                            value="Publik"
                            @selected(request('status') === 'Publik')
                        >
                            Publik
                        </option>
                        <option
                            value="Draft"
                            @selected(request('status') === 'Draft')
                        >
                            Draft
                        </option>
                    </select>

                    <button type="submit">
                        <i class="bi bi-search"></i>
                        Cari
                    </button>
                </form>

                <div class="service-admin-list">

                    @forelse($services as $item)

                        <article class="service-admin-item">

                            <span class="service-admin-item-icon">
                                <i class="bi {{ $item->icon }}"></i>
                            </span>

                            <div class="service-admin-item-content">

                                <div class="service-admin-item-title-row">

                                    <h3>{{ $item->title }}</h3>

                                    <span
                                        class="
                                            service-admin-status
                                            {{ $item->status === 'Publik'
                                                ? 'public'
                                                : 'draft'
                                            }}
                                        "
                                    >
                                        {{ $item->status }}
                                    </span>

                                </div>

                                <p>{{ $item->description }}</p>

                                <div class="service-admin-item-meta">
                                    <span>
                                        <i class="bi bi-list-ol"></i>
                                        Urutan {{ $item->sort_order }}
                                    </span>

                                    <span>
                                        <i class="bi bi-card-checklist"></i>
                                        {{ count($item->requirements ?? []) }}
                                        persyaratan
                                    </span>

                                    @if(filled($item->processing_time))
                                        <span>
                                            <i class="bi bi-clock"></i>
                                            {{ $item->processing_time }}
                                        </span>
                                    @endif

                                    @if(filled($item->cost))
                                        <span>
                                            <i class="bi bi-cash"></i>
                                            {{ $item->cost }}
                                        </span>
                                    @endif
                                </div>

                            </div>

                            <div class="service-admin-item-actions">

                                <a
                                    href="{{ route(
                                        'admin.layanan.edit',
                                        $item
                                    ) }}"
                                    class="service-admin-icon-button"
                                    title="Edit layanan"
                                >
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.layanan.destroy',
                                        $item
                                    ) }}"
                                    onsubmit="return confirm(
                                        'Hapus layanan ini?'
                                    )"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="
                                            service-admin-icon-button
                                            delete
                                        "
                                        title="Hapus layanan"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            </div>

                        </article>

                    @empty

                        <div class="service-admin-empty">
                            <i class="bi bi-inbox"></i>
                            <div>
                                Belum ada layanan yang sesuai pencarian.
                            </div>
                        </div>

                    @endforelse

                </div>

                @if($services->hasPages())
                    <div class="service-admin-pagination">
                        {{ $services->links() }}
                    </div>
                @endif

            </div>
        </section>

    </div>
</div>

@endsection
