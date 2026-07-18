@extends('admin.layouts.app')

@section('title', 'Sejarah Desa')

@section('content')

@php
    $historyImage = isset($history) && filled($history->gambar)
        ? asset('storage/' . ltrim($history->gambar, '/'))
        : null;
@endphp

@push('styles')
<style>
    .admin-history-page {
        --page-green: var(--admin-green, #16834f);
        --page-green-dark: var(--admin-green-dark, #0d6139);
        --page-soft: var(--admin-green-soft, #eef7f2);
        --page-navy: var(--admin-navy, #12251c);
        --page-text: var(--admin-text, #34463c);
        --page-muted: var(--admin-muted, #6e7d74);
        --page-border: var(--admin-border, #dfe9e3);
        --page-bg: var(--admin-bg, #f5f8f6);
    }

    .admin-history-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 20px;
    }

    .admin-history-header h1 {
        margin: 0;
        color: var(--page-navy);
        font-size: 27px;
        font-weight: 850;
        line-height: 1.25;
        letter-spacing: -0.035em;
    }

    .admin-history-header p {
        margin: 6px 0 0;
        color: var(--page-muted);
        font-size: 12px;
        line-height: 1.6;
    }

    .admin-history-badge {
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
    }

    .admin-history-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 16px;
        padding: 13px 15px;
        color: #0c6339;
        background: #edf9f2;
        border: 1px solid #ccebd9;
        border-radius: 13px;
        font-size: 11px;
        line-height: 1.55;
    }

    .admin-history-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(280px, 0.8fr);
        gap: 18px;
        align-items: start;
    }

    .admin-history-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--page-border);
        border-radius: 20px;
        box-shadow: 0 12px 34px rgba(18, 69, 43, 0.055);
    }

    .admin-history-card + .admin-history-card {
        margin-top: 18px;
    }

    .admin-history-card-header {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 18px 20px;
        border-bottom: 1px solid var(--page-border);
    }

    .admin-history-icon {
        width: 39px;
        height: 39px;
        display: grid;
        place-items: center;
        color: var(--page-green);
        background: var(--page-soft);
        border: 1px solid rgba(22, 131, 79, 0.15);
        border-radius: 11px;
        font-size: 15px;
    }

    .admin-history-card-header h2 {
        margin: 0;
        color: var(--page-navy);
        font-size: 15px;
        font-weight: 850;
    }

    .admin-history-card-header p {
        margin: 3px 0 0;
        color: var(--page-muted);
        font-size: 9px;
        line-height: 1.5;
    }

    .admin-history-card-body {
        padding: 20px;
    }

    .admin-history-field + .admin-history-field {
        margin-top: 16px;
    }

    .admin-history-field label {
        display: block;
        margin-bottom: 7px;
        color: var(--page-navy);
        font-size: 11px;
        font-weight: 800;
    }

    .admin-history-field input,
    .admin-history-field textarea {
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

    .admin-history-field input {
        min-height: 45px;
        padding: 0 13px;
    }

    .admin-history-field textarea {
        padding: 12px 13px;
        resize: vertical;
    }

    .admin-history-field input:focus,
    .admin-history-field textarea:focus {
        border-color: rgba(22, 131, 79, 0.55);
        box-shadow: 0 0 0 4px rgba(22, 131, 79, 0.09);
    }

    .admin-history-help {
        display: block;
        margin-top: 6px;
        color: var(--page-muted);
        font-size: 9px;
        line-height: 1.5;
    }

    .admin-history-field input[type="file"] {
        min-height: 46px;
        padding: 8px;
    }

    .admin-history-field input[type="file"]::file-selector-button {
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

    .admin-history-preview {
        width: 100%;
        min-height: 260px;
        display: grid;
        place-items: center;
        margin-top: 15px;
        overflow: hidden;
        color: var(--page-green);
        background: var(--page-bg);
        border: 1px dashed #c9d8cf;
        border-radius: 14px;
    }

    .admin-history-preview img {
        width: 100%;
        height: 260px;
        display: block;
        object-fit: cover;
    }

    .admin-history-preview i {
        font-size: 32px;
    }

    .admin-history-action {
        display: flex;
        justify-content: flex-end;
        margin-top: 18px;
    }

    .admin-history-submit {
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 17px;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--page-green-dark),
            var(--page-green)
        );
        border: 0;
        border-radius: 11px;
        box-shadow: 0 10px 22px rgba(22, 131, 79, 0.2);
        font-size: 11px;
        font-weight: 850;
        cursor: pointer;
    }

    @media (max-width: 900px) {
        .admin-history-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 620px) {
        .admin-history-header {
            flex-direction: column;
        }

        .admin-history-header h1 {
            font-size: 23px;
        }

        .admin-history-card-body,
        .admin-history-card-header {
            padding: 16px;
        }

        .admin-history-action {
            display: block;
        }

        .admin-history-submit {
            width: 100%;
        }
    }
</style>
@endpush

<div class="admin-history-page">

    <div class="admin-history-header">

        <div>
            <h1>Sejarah Desa</h1>

            <p>
                Kelola ringkasan dan cerita sejarah desa.
            </p>
        </div>

        <span class="admin-history-badge">
            <i class="bi bi-clock-history"></i>
            Profil Desa
        </span>

    </div>

    @if(session('success'))

        <div class="admin-history-alert">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
        </div>

    @endif

    <form
        action="{{ route('admin.sejarah.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        <div class="admin-history-grid">

            <div>

                <section class="admin-history-card">

                    <div class="admin-history-card-header">

                        <span class="admin-history-icon">
                            <i class="bi bi-info-circle"></i>
                        </span>

                        <div>
                            <h2>Informasi Sejarah</h2>
                            <p>Judul, tahun berdiri, dan ringkasan.</p>
                        </div>

                    </div>

                    <div class="admin-history-card-body">

                        <div class="admin-history-field">

                            <label for="judul">
                                Judul Sejarah
                            </label>

                            <input
                                id="judul"
                                type="text"
                                name="judul"
                                value="{{ old(
                                    'judul',
                                    $history->judul ?? ''
                                ) }}"
                            >

                            <small class="admin-history-help">
                                Masukkan judul sejarah desa.
                            </small>

                        </div>

                        <div class="admin-history-field">

                            <label for="year_established">
                                Tahun Berdiri Desa
                            </label>

                            <input
                                id="year_established"
                                type="text"
                                name="year_established"
                                value="{{ old(
                                    'year_established',
                                    $history->year_established ?? ''
                                ) }}"
                                placeholder="Contoh: 1982"
                            >

                        </div>

                        <div class="admin-history-field">

                            <label for="excerpt">
                                Ringkasan Sejarah
                            </label>

                            <textarea
                                id="excerpt"
                                name="excerpt"
                                rows="5"
                            >{{ old(
                                'excerpt',
                                $history->excerpt ?? ''
                            ) }}</textarea>

                            <small class="admin-history-help">
                                Ringkasan singkat untuk halaman publik.
                            </small>

                        </div>

                    </div>

                </section>

                <section class="admin-history-card">

                    <div class="admin-history-card-header">

                        <span class="admin-history-icon">
                            <i class="bi bi-file-text"></i>
                        </span>

                        <div>
                            <h2>Isi Sejarah</h2>
                            <p>Cerita sejarah desa secara lengkap.</p>
                        </div>

                    </div>

                    <div class="admin-history-card-body">

                        <div class="admin-history-field">

                            <label for="sejarah">
                                Sejarah Desa
                            </label>

                            <textarea
                                id="sejarah"
                                name="sejarah"
                                rows="15"
                            >{{ old(
                                'sejarah',
                                $history->sejarah ?? ''
                            ) }}</textarea>

                        </div>

                    </div>

                </section>

            </div>

            <aside class="admin-history-card">

                <div class="admin-history-card-header">

                    <span class="admin-history-icon">
                        <i class="bi bi-image"></i>
                    </span>

                    <div>
                        <h2>Foto Sejarah</h2>
                        <p>Media pendukung halaman sejarah.</p>
                    </div>

                </div>

                <div class="admin-history-card-body">

                    <div class="admin-history-field">

                        <label for="gambar">
                            Unggah Foto
                        </label>

                        <input
                            id="gambar"
                            type="file"
                            name="gambar"
                            accept=".jpg,.jpeg,.png,.webp"
                        >

                        <small class="admin-history-help">
                            Gunakan foto yang berkaitan dengan sejarah desa.
                        </small>

                    </div>

                    <div
                        class="admin-history-preview"
                        id="history-image-preview"
                    >

                        @if($historyImage)

                            <img
                                src="{{ $historyImage }}"
                                alt="Foto sejarah desa"
                            >

                        @else

                            <i class="bi bi-image"></i>

                        @endif

                    </div>

                </div>

            </aside>

        </div>

        <div class="admin-history-action">

            <button
                type="submit"
                class="admin-history-submit"
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
    const imageInput = document.getElementById('gambar');
    const preview = document.getElementById(
        'history-image-preview'
    );

    imageInput?.addEventListener('change', function () {
        const file = this.files?.[0];

        if (!file || !preview) {
            return;
        }

        const imageUrl = URL.createObjectURL(file);
        const image = document.createElement('img');

        image.src = imageUrl;
        image.alt = 'Pratinjau foto sejarah';

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
