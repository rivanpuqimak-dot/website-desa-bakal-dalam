@extends('admin.layouts.app')

@section('title', 'Potensi Desa')

@section('content')

@push('styles')
<style>

    .admin-editor-page {
        --page-green: var(--admin-green, #16834f);
        --page-green-dark: var(--admin-green-dark, #0d6139);
        --page-soft: var(--admin-green-soft, #eef7f2);
        --page-navy: var(--admin-navy, #12251c);
        --page-text: var(--admin-text, #34463c);
        --page-muted: var(--admin-muted, #6e7d74);
        --page-border: var(--admin-border, #dfe9e3);
        --page-bg: var(--admin-bg, #f5f8f6);
    }

    .admin-editor-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 20px;
    }

    .admin-editor-header h1 {
        margin: 0;
        color: var(--page-navy);
        font-size: 27px;
        font-weight: 850;
        line-height: 1.25;
        letter-spacing: -0.035em;
    }

    .admin-editor-header p {
        margin: 6px 0 0;
        color: var(--page-muted);
        font-size: 12px;
        line-height: 1.6;
    }

    .admin-editor-badge {
        flex: 0 0 auto;
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

    .admin-editor-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 16px;
        padding: 13px 15px;
        border-radius: 13px;
        font-size: 11px;
        line-height: 1.55;
    }

    .admin-editor-alert.success {
        color: #0c6339;
        background: #edf9f2;
        border: 1px solid #ccebd9;
    }

    .admin-editor-alert.danger {
        color: #842029;
        background: #fff1f2;
        border: 1px solid #f2c8cc;
    }

    .admin-editor-alert ul {
        margin: 7px 0 0;
        padding-left: 18px;
    }

    .admin-editor-layout {
        display: grid;
        grid-template-columns: minmax(330px, 0.72fr) minmax(0, 1.28fr);
        gap: 18px;
        align-items: start;
    }

    .admin-editor-columns {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        align-items: start;
    }

    .admin-editor-stack {
        display: grid;
        gap: 18px;
    }

    .admin-editor-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--page-border);
        border-radius: 20px;
        box-shadow: 0 12px 34px rgba(18, 69, 43, 0.055);
    }

    .admin-editor-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 17px 19px;
        border-bottom: 1px solid var(--page-border);
    }

    .admin-editor-heading {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 0;
    }

    .admin-editor-icon {
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

    .admin-editor-card-header h2 {
        margin: 0;
        color: var(--page-navy);
        font-size: 15px;
        font-weight: 850;
        line-height: 1.35;
    }

    .admin-editor-card-header p {
        margin: 3px 0 0;
        color: var(--page-muted);
        font-size: 9px;
        line-height: 1.5;
    }

    .admin-editor-count {
        flex: 0 0 auto;
        padding: 6px 9px;
        color: var(--page-green-dark);
        background: var(--page-soft);
        border-radius: 999px;
        font-size: 9px;
        font-weight: 850;
    }

    .admin-editor-card-body {
        padding: 19px;
    }

    .admin-editor-fields {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px 17px;
    }

    .admin-editor-field.full {
        grid-column: 1 / -1;
    }

    .admin-editor-field label {
        display: block;
        margin-bottom: 7px;
        color: var(--page-navy);
        font-size: 11px;
        font-weight: 800;
    }

    .admin-editor-field input,
    .admin-editor-field select,
    .admin-editor-field textarea {
        width: 100%;
        color: var(--page-text);
        background: #ffffff;
        border: 1px solid var(--page-border);
        border-radius: 11px;
        outline: none;
        font-size: 12px;
        transition:
            border-color 0.2s ease,
            box-shadow 0.2s ease;
    }

    .admin-editor-field input,
    .admin-editor-field select {
        min-height: 45px;
        padding: 0 13px;
    }

    .admin-editor-field textarea {
        min-height: 105px;
        padding: 12px 13px;
        resize: vertical;
    }

    .admin-editor-field input:focus,
    .admin-editor-field select:focus,
    .admin-editor-field textarea:focus {
        border-color: rgba(22, 131, 79, 0.55);
        box-shadow: 0 0 0 4px rgba(22, 131, 79, 0.09);
    }

    .admin-editor-field .is-invalid {
        border-color: #dc5b65;
    }

    .admin-editor-help {
        display: block;
        margin-top: 6px;
        color: var(--page-muted);
        font-size: 9px;
        line-height: 1.5;
    }

    .admin-editor-error {
        display: block;
        margin-top: 5px;
        color: #c03542;
        font-size: 9px;
        font-weight: 700;
    }

    .admin-editor-field input[type="file"] {
        min-height: 46px;
        padding: 8px;
    }

    .admin-editor-field input[type="file"]::file-selector-button {
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

    .admin-editor-check {
        display: flex;
        align-items: center;
        gap: 9px;
        min-height: 45px;
        padding: 10px 12px;
        background: var(--page-bg);
        border: 1px solid var(--page-border);
        border-radius: 11px;
    }

    .admin-editor-check input {
        width: 17px;
        height: 17px;
        accent-color: var(--page-green);
    }

    .admin-editor-check label {
        margin: 0;
        color: var(--page-text);
        font-size: 10px;
        font-weight: 750;
    }

    .admin-editor-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 18px;
    }

    .admin-editor-button {
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

    .admin-editor-button.primary {
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--page-green-dark),
            var(--page-green)
        );
        border: 0;
        box-shadow: 0 10px 22px rgba(22, 131, 79, 0.2);
    }

    .admin-editor-button.secondary {
        color: var(--page-text);
        background: #ffffff;
        border: 1px solid var(--page-border);
    }

    .admin-editor-preview {
        width: 100%;
        min-height: 190px;
        display: grid;
        place-items: center;
        margin-top: 13px;
        overflow: hidden;
        color: var(--page-green);
        background: var(--page-bg);
        border: 1px dashed #c9d8cf;
        border-radius: 14px;
    }

    .admin-editor-preview img {
        width: 100%;
        height: 220px;
        display: block;
        object-fit: cover;
    }

    .admin-editor-preview.contain img {
        object-fit: contain;
        padding: 10px;
        background: #ffffff;
    }

    .admin-editor-preview i {
        font-size: 30px;
    }

    .admin-editor-filter {
        display: grid;
        grid-template-columns: minmax(130px, 0.65fr) minmax(180px, 1fr) auto;
        gap: 8px;
        width: min(100%, 520px);
    }

    .admin-editor-filter input,
    .admin-editor-filter select {
        min-width: 0;
        height: 39px;
        padding: 0 11px;
        color: var(--page-text);
        background: #ffffff;
        border: 1px solid var(--page-border);
        border-radius: 9px;
        outline: none;
        font-size: 10px;
    }

    .admin-editor-filter button {
        min-height: 39px;
        padding: 0 13px;
        color: #ffffff;
        background: var(--page-green);
        border: 0;
        border-radius: 9px;
        font-size: 10px;
        font-weight: 850;
        cursor: pointer;
    }

    .admin-editor-list {
        display: grid;
        gap: 12px;
    }

    .admin-editor-item {
        display: grid;
        grid-template-columns: 104px minmax(0, 1fr) auto;
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

    .admin-editor-item:hover {
        border-color: rgba(22, 131, 79, 0.25);
        box-shadow: 0 10px 24px rgba(18, 69, 43, 0.07);
        transform: translateY(-2px);
    }

    .admin-editor-item-image {
        width: 104px;
        height: 82px;
        display: grid;
        place-items: center;
        overflow: hidden;
        color: var(--page-green);
        background: var(--page-soft);
        border-radius: 12px;
        font-size: 24px;
    }

    .admin-editor-item-image img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .admin-editor-item-content {
        min-width: 0;
    }

    .admin-editor-item-content h3 {
        margin: 0;
        color: var(--page-navy);
        font-size: 13px;
        font-weight: 850;
        line-height: 1.4;
    }

    .admin-editor-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 7px;
    }

    .admin-editor-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 8px;
        color: var(--page-green-dark);
        background: var(--page-soft);
        border: 1px solid rgba(22, 131, 79, 0.13);
        border-radius: 999px;
        font-size: 8px;
        font-weight: 850;
    }

    .admin-editor-pill.gray {
        color: #5e6b64;
        background: #f1f4f2;
        border-color: #e1e8e4;
    }

    .admin-editor-pill.warning {
        color: #94600c;
        background: #fff7e8;
        border-color: #f2d7a6;
    }

    .admin-editor-description {
        display: -webkit-box;
        margin: 8px 0 0;
        overflow: hidden;
        color: var(--page-muted);
        font-size: 9px;
        line-height: 1.55;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .admin-editor-item-actions {
        display: flex;
        gap: 7px;
    }

    .admin-editor-action {
        width: 34px;
        height: 34px;
        display: grid;
        place-items: center;
        border-radius: 9px;
        text-decoration: none;
        font-size: 12px;
        cursor: pointer;
    }

    .admin-editor-action.edit {
        color: #9a650f;
        background: #fff7e8;
        border: 1px solid #f2d7a6;
    }

    .admin-editor-action.delete {
        color: #b9343f;
        background: #fff1f2;
        border: 1px solid #f2c8cc;
    }

    .admin-editor-empty {
        display: grid;
        place-items: center;
        min-height: 250px;
        padding: 28px;
        text-align: center;
    }

    .admin-editor-empty i {
        display: grid;
        place-items: center;
        width: 56px;
        height: 56px;
        margin: 0 auto 12px;
        color: var(--page-green);
        background: var(--page-soft);
        border-radius: 15px;
        font-size: 22px;
    }

    .admin-editor-empty h3 {
        margin: 0;
        color: var(--page-navy);
        font-size: 14px;
        font-weight: 850;
    }

    .admin-editor-empty p {
        margin: 6px 0 0;
        color: var(--page-muted);
        font-size: 10px;
        line-height: 1.55;
    }

    .admin-editor-map {
        overflow: hidden;
        min-height: 250px;
        border: 1px solid var(--page-border);
        border-radius: 14px;
    }

    .admin-editor-map iframe {
        width: 100% !important;
        min-height: 250px !important;
        border: 0 !important;
    }

    @media (max-width: 1050px) {
        .admin-editor-layout,
        .admin-editor-columns {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 700px) {
        .admin-editor-card-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .admin-editor-filter {
            grid-template-columns: 1fr;
            width: 100%;
        }
    }

    @media (max-width: 620px) {
        .admin-editor-header {
            flex-direction: column;
        }

        .admin-editor-header h1 {
            font-size: 23px;
        }

        .admin-editor-card-header,
        .admin-editor-card-body {
            padding: 15px;
        }

        .admin-editor-fields {
            grid-template-columns: 1fr;
        }

        .admin-editor-field.full {
            grid-column: auto;
        }

        .admin-editor-item {
            grid-template-columns: 76px minmax(0, 1fr);
        }

        .admin-editor-item-image {
            width: 76px;
            height: 72px;
        }

        .admin-editor-item-actions {
            grid-column: 1 / -1;
            justify-content: flex-end;
            padding-top: 9px;
            border-top: 1px solid var(--page-border);
        }

        .admin-editor-actions {
            display: grid;
            grid-template-columns: 1fr;
        }

        .admin-editor-button {
            width: 100%;
        }
    }

</style>
@endpush


@php
    $isEditing = isset($potential);

    $potentialImage = $isEditing && filled($potential->gambar)
        ? asset('storage/' . ltrim($potential->gambar, '/'))
        : null;

    $categories = [
        'Pertanian',
        'Perkebunan',
        'Peternakan',
        'Perikanan',
        'UMKM',
        'Wisata',
        'Budaya',
        'Pendidikan',
        'Kesehatan',
        'Lainnya',
    ];
@endphp

<div class="admin-editor-page">

    <div class="admin-editor-header">
        <div>
            <h1>Potensi Desa</h1>
            <p>Kelola potensi unggulan dan sumber daya desa.</p>
        </div>

        <span class="admin-editor-badge">
            <i class="bi bi-tree"></i>
            Potensi
        </span>
    </div>

    @if(session('success'))
        <div class="admin-editor-alert success">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <div class="admin-editor-layout">

        <section class="admin-editor-card">
            <div class="admin-editor-card-header">
                <div class="admin-editor-heading">
                    <span class="admin-editor-icon">
                        <i class="bi bi-tree"></i>
                    </span>
                    <div>
                        <h2>{{ $isEditing ? 'Perbarui Potensi' : 'Tambah Potensi' }}</h2>
                        <p>Isi informasi potensi desa.</p>
                    </div>
                </div>
            </div>

            <div class="admin-editor-card-body">
                <form
                    action="{{ $isEditing
                        ? route('admin.potensi.update', $potential->id)
                        : route('admin.potensi.store')
                    }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @if($isEditing)
                        @method('PUT')
                    @endif

                    <div class="admin-editor-fields">

                        <div class="admin-editor-field full">
                            <label for="nama">Nama Potensi</label>
                            <input
                                id="nama"
                                type="text"
                                name="nama"
                                value="{{ old(
                                    'nama',
                                    $potential->nama ?? ''
                                ) }}"
                                required
                            >
                        </div>

                        <div class="admin-editor-field">
                            <label for="kategori">Kategori</label>
                            <select id="kategori" name="kategori" required>
                                @foreach($categories as $category)
                                    <option
                                        value="{{ $category }}"
                                        {{ old(
                                            'kategori',
                                            $potential->kategori ?? ''
                                        ) === $category ? 'selected' : '' }}
                                    >
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="admin-editor-field">
                            <label for="lokasi">Lokasi</label>
                            <input
                                id="lokasi"
                                type="text"
                                name="lokasi"
                                value="{{ old(
                                    'lokasi',
                                    $potential->lokasi ?? ''
                                ) }}"
                            >
                        </div>

                        <div class="admin-editor-field full">
                            <label for="excerpt">Ringkasan</label>
                            <textarea
                                id="excerpt"
                                name="excerpt"
                                rows="4"
                            >{{ old(
                                'excerpt',
                                $potential->excerpt ?? ''
                            ) }}</textarea>
                        </div>

                        <div class="admin-editor-field full">
                            <label for="deskripsi">Deskripsi Lengkap</label>
                            <textarea
                                id="deskripsi"
                                name="deskripsi"
                                rows="8"
                            >{{ old(
                                'deskripsi',
                                $potential->deskripsi ?? ''
                            ) }}</textarea>
                        </div>

                        <div class="admin-editor-field full">
                            <label for="gambar">Gambar</label>
                            <input
                                id="gambar"
                                type="file"
                                name="gambar"
                                accept=".jpg,.jpeg,.png,.webp"
                            >
                        </div>

                        <div class="admin-editor-field">
                            <label for="status">Status</label>
                            <select id="status" name="status" required>
                                @foreach(['Publik', 'Draft'] as $status)
                                    <option
                                        value="{{ $status }}"
                                        {{ old(
                                            'status',
                                            $potential->status ?? 'Publik'
                                        ) === $status ? 'selected' : '' }}
                                    >
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="admin-editor-field">
                            <label>Penayangan</label>
                            <div class="admin-editor-check">
                                <input
                                    id="featured"
                                    type="checkbox"
                                    name="featured"
                                    value="1"
                                    {{ old(
                                        'featured',
                                        $potential->featured ?? false
                                    ) ? 'checked' : '' }}
                                >
                                <label for="featured">
                                    Tampilkan di halaman utama
                                </label>
                            </div>
                        </div>

                    </div>

                    <div
                        class="admin-editor-preview"
                        id="potential-image-preview"
                    >
                        @if($potentialImage)
                            <img src="{{ $potentialImage }}" alt="Gambar potensi">
                        @else
                            <i class="bi bi-tree"></i>
                        @endif
                    </div>

                    <div class="admin-editor-actions">
                        <button type="submit" class="admin-editor-button primary">
                            <i class="bi bi-check-circle"></i>
                            {{ $isEditing ? 'Perbarui Data' : 'Simpan Data' }}
                        </button>

                        @if($isEditing)
                            <a
                                href="{{ route('admin.potensi') }}"
                                class="admin-editor-button secondary"
                            >
                                <i class="bi bi-x-circle"></i>
                                Batal
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </section>

        <section class="admin-editor-card">
            <div class="admin-editor-card-header">
                <div class="admin-editor-heading">
                    <span class="admin-editor-icon">
                        <i class="bi bi-grid"></i>
                    </span>
                    <div>
                        <h2>Daftar Potensi</h2>
                        <p>Potensi desa yang telah ditambahkan.</p>
                    </div>
                </div>

                <span class="admin-editor-count">
                    {{ collect($potentials ?? [])->count() }} Data
                </span>
            </div>

            <div class="admin-editor-card-body">
                @forelse($potentials as $item)
                    @if($loop->first)
                        <div class="admin-editor-list">
                    @endif

                    <article class="admin-editor-item">
                        <div class="admin-editor-item-image">
                            @if(filled($item->gambar))
                                <img
                                    src="{{ asset(
                                        'storage/' .
                                        ltrim($item->gambar, '/')
                                    ) }}"
                                    alt="{{ $item->nama }}"
                                    loading="lazy"
                                >
                            @else
                                <i class="bi bi-tree"></i>
                            @endif
                        </div>

                        <div class="admin-editor-item-content">
                            <h3>{{ $item->nama }}</h3>

                            <div class="admin-editor-meta">
                                <span class="admin-editor-pill">
                                    {{ $item->kategori }}
                                </span>

                                <span class="admin-editor-pill gray">
                                    {{ $item->status }}
                                </span>

                                @if($item->featured)
                                    <span class="admin-editor-pill warning">
                                        Unggulan
                                    </span>
                                @endif
                            </div>

                            <p class="admin-editor-description">
                                <strong>{{ $item->lokasi ?: 'Lokasi belum ditentukan' }}</strong>
                                — {{ \Illuminate\Support\Str::limit(
                                    $item->excerpt,
                                    100
                                ) }}
                            </p>
                        </div>

                        <div class="admin-editor-item-actions">
                            <a
                                href="{{ route(
                                    'admin.potensi.edit',
                                    $item->id
                                ) }}"
                                class="admin-editor-action edit"
                                title="Edit"
                            >
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form
                                action="{{ route(
                                    'admin.potensi.destroy',
                                    $item->id
                                ) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="admin-editor-action delete"
                                    title="Hapus"
                                    onclick="return confirm(
                                        'Yakin ingin menghapus data ini?'
                                    )"
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
                    <div class="admin-editor-empty">
                        <div>
                            <i class="bi bi-tree"></i>
                            <h3>Belum ada data potensi</h3>
                            <p>Data potensi akan tampil setelah ditambahkan.</p>
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
    const input = document.getElementById('gambar');
    const preview = document.getElementById('potential-image-preview');

    input?.addEventListener('change', function () {
        const file = this.files?.[0];

        if (!file || !preview) {
            return;
        }

        const url = URL.createObjectURL(file);
        const image = document.createElement('img');

        image.src = url;
        image.alt = 'Pratinjau gambar potensi';

        image.addEventListener('load', function () {
            URL.revokeObjectURL(url);
        });

        preview.innerHTML = '';
        preview.appendChild(image);
    });
});
</script>
@endpush


@endsection
