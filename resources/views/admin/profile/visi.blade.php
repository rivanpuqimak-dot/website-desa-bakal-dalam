@extends('admin.layouts.app')

@section('title', 'Visi & Misi')

@section('content')

@push('styles')
<style>
    .admin-vision-page {
        --page-green: var(--admin-green, #16834f);
        --page-green-dark: var(--admin-green-dark, #0d6139);
        --page-soft: var(--admin-green-soft, #eef7f2);
        --page-navy: var(--admin-navy, #12251c);
        --page-text: var(--admin-text, #34463c);
        --page-muted: var(--admin-muted, #6e7d74);
        --page-border: var(--admin-border, #dfe9e3);
        --page-bg: var(--admin-bg, #f5f8f6);
    }

    .admin-vision-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 20px;
    }

    .admin-vision-header h1 {
        margin: 0;
        color: var(--page-navy);
        font-size: 27px;
        font-weight: 850;
        line-height: 1.25;
        letter-spacing: -0.035em;
    }

    .admin-vision-header p {
        margin: 6px 0 0;
        color: var(--page-muted);
        font-size: 12px;
        line-height: 1.6;
    }

    .admin-vision-badge {
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

    .admin-vision-alert {
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

    .admin-vision-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .admin-vision-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--page-border);
        border-radius: 20px;
        box-shadow: 0 12px 34px rgba(18, 69, 43, 0.055);
    }

    .admin-vision-card.full {
        grid-column: 1 / -1;
    }

    .admin-vision-card-header {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 18px 20px;
        border-bottom: 1px solid var(--page-border);
    }

    .admin-vision-icon {
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

    .admin-vision-card-header h2 {
        margin: 0;
        color: var(--page-navy);
        font-size: 15px;
        font-weight: 850;
    }

    .admin-vision-card-header p {
        margin: 3px 0 0;
        color: var(--page-muted);
        font-size: 9px;
        line-height: 1.5;
    }

    .admin-vision-card-body {
        padding: 20px;
    }

    .admin-vision-field label {
        display: block;
        margin-bottom: 7px;
        color: var(--page-navy);
        font-size: 11px;
        font-weight: 800;
    }

    .admin-vision-field input,
    .admin-vision-field textarea {
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

    .admin-vision-field input {
        min-height: 45px;
        padding: 0 13px;
    }

    .admin-vision-field textarea {
        padding: 12px 13px;
        resize: vertical;
    }

    .admin-vision-field input:focus,
    .admin-vision-field textarea:focus {
        border-color: rgba(22, 131, 79, 0.55);
        box-shadow: 0 0 0 4px rgba(22, 131, 79, 0.09);
    }

    .admin-vision-help {
        display: block;
        margin-top: 6px;
        color: var(--page-muted);
        font-size: 9px;
        line-height: 1.5;
    }

    .admin-vision-action {
        display: flex;
        justify-content: flex-end;
        margin-top: 18px;
    }

    .admin-vision-submit {
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

    @media (max-width: 760px) {
        .admin-vision-grid {
            grid-template-columns: 1fr;
        }

        .admin-vision-card.full {
            grid-column: auto;
        }
    }

    @media (max-width: 620px) {
        .admin-vision-header {
            flex-direction: column;
        }

        .admin-vision-header h1 {
            font-size: 23px;
        }

        .admin-vision-card-header,
        .admin-vision-card-body {
            padding: 16px;
        }

        .admin-vision-action {
            display: block;
        }

        .admin-vision-submit {
            width: 100%;
        }
    }
</style>
@endpush

<div class="admin-vision-page">

    <div class="admin-vision-header">

        <div>
            <h1>Visi & Misi</h1>

            <p>
                Kelola arah pembangunan dan tujuan pemerintah desa.
            </p>
        </div>

        <span class="admin-vision-badge">
            <i class="bi bi-bullseye"></i>
            Profil Desa
        </span>

    </div>

    @if(session('success'))

        <div class="admin-vision-alert">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
        </div>

    @endif

    <form
        action="{{ route('admin.visi.store') }}"
        method="POST"
    >

        @csrf

        <div class="admin-vision-grid">

            <section class="admin-vision-card">

                <div class="admin-vision-card-header">

                    <span class="admin-vision-icon">
                        <i class="bi bi-eye"></i>
                    </span>

                    <div>
                        <h2>Visi Desa</h2>
                        <p>Arah utama pembangunan desa.</p>
                    </div>

                </div>

                <div class="admin-vision-card-body">

                    <div class="admin-vision-field">

                        <label for="visi">
                            Visi Desa
                        </label>

                        <textarea
                            id="visi"
                            name="visi"
                            rows="8"
                        >{{ old(
                            'visi',
                            $visi->visi ?? ''
                        ) }}</textarea>

                        <small class="admin-vision-help">
                            Tuliskan visi secara singkat, jelas, dan inspiratif.
                        </small>

                    </div>

                </div>

            </section>

            <section class="admin-vision-card">

                <div class="admin-vision-card-header">

                    <span class="admin-vision-icon">
                        <i class="bi bi-flag"></i>
                    </span>

                    <div>
                        <h2>Tujuan Desa</h2>
                        <p>Hasil yang ingin dicapai.</p>
                    </div>

                </div>

                <div class="admin-vision-card-body">

                    <div class="admin-vision-field">

                        <label for="tujuan">
                            Tujuan Desa
                        </label>

                        <textarea
                            id="tujuan"
                            name="tujuan"
                            rows="8"
                        >{{ old(
                            'tujuan',
                            $visi->tujuan ?? ''
                        ) }}</textarea>

                        <small class="admin-vision-help">
                            Jelaskan tujuan yang menjadi sasaran pembangunan desa.
                        </small>

                    </div>

                </div>

            </section>

            <section class="admin-vision-card full">

                <div class="admin-vision-card-header">

                    <span class="admin-vision-icon">
                        <i class="bi bi-list-check"></i>
                    </span>

                    <div>
                        <h2>Misi Desa</h2>
                        <p>Langkah untuk mewujudkan visi.</p>
                    </div>

                </div>

                <div class="admin-vision-card-body">

                    <div class="admin-vision-field">

                        <label for="misi">
                            Misi Desa
                        </label>

                        <textarea
                            id="misi"
                            name="misi"
                            rows="12"
                        >{{ old(
                            'misi',
                            $visi->misi ?? ''
                        ) }}</textarea>

                        <small class="admin-vision-help">
                            Pisahkan setiap misi pada baris baru.
                        </small>

                    </div>

                </div>

            </section>

            <section class="admin-vision-card full">

                <div class="admin-vision-card-header">

                    <span class="admin-vision-icon">
                        <i class="bi bi-quote"></i>
                    </span>

                    <div>
                        <h2>Motto Desa</h2>
                        <p>Semboyan singkat yang mewakili semangat desa.</p>
                    </div>

                </div>

                <div class="admin-vision-card-body">

                    <div class="admin-vision-field">

                        <label for="motto">
                            Motto Desa
                        </label>

                        <input
                            id="motto"
                            type="text"
                            name="motto"
                            value="{{ old(
                                'motto',
                                $visi->motto ?? ''
                            ) }}"
                            placeholder="Contoh: Bersatu, Maju, dan Sejahtera"
                        >

                    </div>

                </div>

            </section>

        </div>

        <div class="admin-vision-action">

            <button
                type="submit"
                class="admin-vision-submit"
            >
                <i class="bi bi-check-circle"></i>
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection
