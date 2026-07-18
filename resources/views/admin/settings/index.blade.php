@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')

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

    .admin-editor-preview.favicon-preview {
        width: 128px;
        min-height: 128px;
        height: 128px;
        border-radius: 22px;
    }

    .admin-editor-preview.favicon-preview img {
        width: 100%;
        height: 100%;
        padding: 8px;
        object-fit: cover;
        background: #ffffff;
    }

    .admin-editor-file-help {
        display: block;
        margin-top: 8px;
        color: var(--page-muted);
        font-size: 9px;
        line-height: 1.55;
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
    $logoUrl = isset($setting) && filled($setting->logo)
        ? asset('storage/' . ltrim($setting->logo, '/'))
        : null;

    $faviconUrl = isset($setting) && filled($setting->favicon)
        ? asset('storage/' . ltrim($setting->favicon, '/'))
        : null;
@endphp

<div class="admin-editor-page">

    <div class="admin-editor-header">
        <div>
            <h1>Pengaturan Website</h1>
            <p>Kelola identitas website, SEO, footer, dan mode pemeliharaan.</p>
        </div>

        <span class="admin-editor-badge">
            <i class="bi bi-gear"></i>
            Sistem
        </span>
    </div>

    @if(session('success'))
        <div class="admin-editor-alert success">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div class="admin-editor-alert danger">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>
                <strong>Pengaturan belum dapat disimpan.</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form
        action="{{ route('admin.pengaturan.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="admin-editor-columns">

            <div class="admin-editor-stack">

                <section class="admin-editor-card">
                    <div class="admin-editor-card-header">
                        <div class="admin-editor-heading">
                            <span class="admin-editor-icon">
                                <i class="bi bi-globe2"></i>
                            </span>
                            <div>
                                <h2>Informasi Website</h2>
                                <p>Nama dan slogan utama website.</p>
                            </div>
                        </div>
                    </div>

                    <div class="admin-editor-card-body">
                        <div class="admin-editor-fields">
                            <div class="admin-editor-field full">
                                <label for="nama_website">Nama Website</label>
                                <input
                                    id="nama_website"
                                    type="text"
                                    name="nama_website"
                                    value="{{ old(
                                        'nama_website',
                                        $setting->nama_website ?? ''
                                    ) }}"
                                    class="@error('nama_website') is-invalid @enderror"
                                    required
                                >
                            </div>

                            <div class="admin-editor-field full">
                                <label for="slogan">Slogan</label>
                                <input
                                    id="slogan"
                                    type="text"
                                    name="slogan"
                                    value="{{ old(
                                        'slogan',
                                        $setting->slogan ?? ''
                                    ) }}"
                                    class="@error('slogan') is-invalid @enderror"
                                >
                            </div>
                        </div>
                    </div>
                </section>

                <section class="admin-editor-card">
                    <div class="admin-editor-card-header">
                        <div class="admin-editor-heading">
                            <span class="admin-editor-icon">
                                <i class="bi bi-image"></i>
                            </span>
                            <div>
                                <h2>Logo dan Favicon</h2>
                                <p>Identitas visual website.</p>
                            </div>
                        </div>
                    </div>

                    <div class="admin-editor-card-body">
                        <div class="admin-editor-fields">

                            <div class="admin-editor-field">
                                <label for="logo">Logo Website</label>
                                <input
                                    id="logo"
                                    type="file"
                                    name="logo"
                                    accept=".jpg,.jpeg,.png,.webp,.svg"
                                    class="@error('logo') is-invalid @enderror"
                                >

                                <div
                                    class="admin-editor-preview contain"
                                    id="setting-logo-preview"
                                >
                                    @if($logoUrl)
                                        <img src="{{ $logoUrl }}" alt="Logo website">
                                    @else
                                        <i class="bi bi-image"></i>
                                    @endif
                                </div>
                            </div>

                            <div class="admin-editor-field">
                                <label for="favicon">Favicon</label>
                                <input
                                    id="favicon"
                                    type="file"
                                    name="favicon"
                                    accept=".jpg,.jpeg,.png,.webp,.ico,image/jpeg,image/png,image/webp,image/x-icon"
                                    class="@error('favicon') is-invalid @enderror"
                                >

                                <small class="admin-editor-file-help">
                                    JPG, JPEG, PNG, WEBP, atau ICO. Maksimal 5 MB.
                                    Gambar persegi akan terlihat paling bagus; ukuran 512×512 disarankan.
                                </small>

                                <div
                                    class="admin-editor-preview favicon-preview"
                                    id="setting-favicon-preview"
                                >
                                    @if($faviconUrl)
                                        <img src="{{ $faviconUrl }}" alt="Favicon">
                                    @else
                                        <i class="bi bi-app-indicator"></i>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </section>

            </div>

            <div class="admin-editor-stack">

                <section class="admin-editor-card">
                    <div class="admin-editor-card-header">
                        <div class="admin-editor-heading">
                            <span class="admin-editor-icon">
                                <i class="bi bi-search"></i>
                            </span>
                            <div>
                                <h2>SEO</h2>
                                <p>Informasi untuk mesin pencari.</p>
                            </div>
                        </div>
                    </div>

                    <div class="admin-editor-card-body">
                        <div class="admin-editor-fields">
                            <div class="admin-editor-field full">
                                <label for="meta_title">Meta Title</label>
                                <input
                                    id="meta_title"
                                    type="text"
                                    name="meta_title"
                                    value="{{ old(
                                        'meta_title',
                                        $setting->meta_title ?? ''
                                    ) }}"
                                    class="@error('meta_title') is-invalid @enderror"
                                >
                            </div>

                            <div class="admin-editor-field full">
                                <label for="meta_description">Meta Description</label>
                                <textarea
                                    id="meta_description"
                                    name="meta_description"
                                    rows="4"
                                    class="@error('meta_description') is-invalid @enderror"
                                >{{ old(
                                    'meta_description',
                                    $setting->meta_description ?? ''
                                ) }}</textarea>
                            </div>

                            <div class="admin-editor-field full">
                                <label for="meta_keywords">Meta Keywords</label>
                                <textarea
                                    id="meta_keywords"
                                    name="meta_keywords"
                                    rows="4"
                                    class="@error('meta_keywords') is-invalid @enderror"
                                >{{ old(
                                    'meta_keywords',
                                    $setting->meta_keywords ?? ''
                                ) }}</textarea>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="admin-editor-card">
                    <div class="admin-editor-card-header">
                        <div class="admin-editor-heading">
                            <span class="admin-editor-icon">
                                <i class="bi bi-layout-text-window-reverse"></i>
                            </span>
                            <div>
                                <h2>Footer</h2>
                                <p>Teks pada bagian bawah website.</p>
                            </div>
                        </div>
                    </div>

                    <div class="admin-editor-card-body">
                        <div class="admin-editor-field">
                            <label for="footer">Footer Website</label>
                            <textarea
                                id="footer"
                                name="footer"
                                rows="4"
                                class="@error('footer') is-invalid @enderror"
                            >{{ old('footer', $setting->footer ?? '') }}</textarea>
                        </div>
                    </div>
                </section>

                <section class="admin-editor-card">
                    <div class="admin-editor-card-header">
                        <div class="admin-editor-heading">
                            <span class="admin-editor-icon">
                                <i class="bi bi-tools"></i>
                            </span>
                            <div>
                                <h2>Mode Website</h2>
                                <p>Aktifkan saat website sedang diperbaiki.</p>
                            </div>
                        </div>
                    </div>

                    <div class="admin-editor-card-body">
                        <div class="admin-editor-check">
                            <input
                                id="maintenance_mode"
                                type="checkbox"
                                name="maintenance_mode"
                                value="1"
                                {{ old(
                                    'maintenance_mode',
                                    $setting->maintenance_mode ?? false
                                ) ? 'checked' : '' }}
                            >

                            <label for="maintenance_mode">
                                Aktifkan Maintenance Mode
                            </label>
                        </div>
                    </div>
                </section>

            </div>

        </div>

        <div class="admin-editor-actions">
            <button type="submit" class="admin-editor-button primary">
                <i class="bi bi-check-circle"></i>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>



@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function bindPreview(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);

        input?.addEventListener('change', function () {
            const file = this.files?.[0];

            if (!file || !preview) {
                return;
            }

            const url = URL.createObjectURL(file);
            const image = document.createElement('img');

            image.src = url;
            image.alt = 'Pratinjau gambar';

            image.addEventListener('load', function () {
                URL.revokeObjectURL(url);
            });

            preview.innerHTML = '';
            preview.appendChild(image);
        });
    }

    bindPreview('logo', 'setting-logo-preview');
    bindPreview('favicon', 'setting-favicon-preview');
});
</script>
@endpush


@endsection
