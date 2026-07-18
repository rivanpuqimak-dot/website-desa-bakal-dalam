@extends('layouts.public')

@section('title', $agenda->judul ?? 'Detail Agenda')

@php
    $startDate = filled($agenda->tanggal_mulai)
        ? \Illuminate\Support\Carbon::parse(
            $agenda->tanggal_mulai
        )
        : null;

    $endDate = filled($agenda->tanggal_selesai)
        ? \Illuminate\Support\Carbon::parse(
            $agenda->tanggal_selesai
        )
        : null;

    $posterUrl = filled($agenda->poster)
        ? asset(
            'storage/' .
            ltrim($agenda->poster, '/')
        )
        : null;

    $backUrl = url('/');

    $isUpcoming = $startDate
        ? $startDate->copy()->endOfDay()->isFuture()
        : false;
@endphp

@push('styles')
<style>
    :root {
        --agenda-green: #16834f;
        --agenda-green-dark: #0d6139;
        --agenda-green-soft: #eef7f2;
        --agenda-navy: #12251c;
        --agenda-text: #34463c;
        --agenda-muted: #6e7d74;
        --agenda-border: #dfe9e3;
        --agenda-white: #ffffff;
        --agenda-bg: #f5f8f6;
    }

    .agenda-detail-page,
    .agenda-detail-page * {
        box-sizing: border-box;
    }

    .agenda-detail-page {
        min-height: 70vh;
        color: var(--agenda-text);
        background: var(--agenda-bg);
    }

    .agenda-detail-container {
        width: min(1180px, calc(100% - 48px));
        margin-inline: auto;
    }

    .agenda-detail-section {
        padding: 46px 0 72px;
    }

    .agenda-detail-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 18px;
        color: var(--agenda-green-dark);
        text-decoration: none;
        font-size: 12px;
        font-weight: 800;
    }

    .agenda-detail-back:hover {
        color: var(--agenda-green);
    }

    .agenda-detail-card {
        display: grid;
        grid-template-columns:
            minmax(320px, 0.82fr)
            minmax(0, 1.18fr);
        overflow: hidden;
        background: var(--agenda-white);
        border: 1px solid var(--agenda-border);
        border-radius: 24px;
        box-shadow: 0 18px 48px rgba(18, 69, 43, 0.09);
    }

    .agenda-detail-poster {
        min-height: 570px;
        display: grid;
        place-items: center;
        overflow: hidden;
        color: var(--agenda-green);
        background:
            radial-gradient(
                circle at center,
                rgba(22, 131, 79, 0.12),
                transparent 45%
            ),
            var(--agenda-green-soft);
        border-right: 1px solid var(--agenda-border);
    }

    .agenda-detail-poster img {
        width: 100%;
        height: 100%;
        min-height: 570px;
        display: block;
        object-fit: cover;
    }

    .agenda-detail-poster-placeholder {
        padding: 38px;
        text-align: center;
    }

    .agenda-detail-poster-placeholder i {
        display: grid;
        place-items: center;
        width: 72px;
        height: 72px;
        margin: 0 auto 14px;
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--agenda-green-dark),
            var(--agenda-green)
        );
        border-radius: 20px;
        font-size: 30px;
        box-shadow: 0 14px 30px rgba(22, 131, 79, 0.18);
    }

    .agenda-detail-poster-placeholder strong {
        display: block;
        color: var(--agenda-navy);
        font-size: 17px;
        font-weight: 850;
    }

    .agenda-detail-content {
        padding: clamp(26px, 4vw, 48px);
    }

    .agenda-detail-kicker {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 10px;
        color: var(--agenda-green-dark);
        background: var(--agenda-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.15);
        border-radius: 999px;
        font-size: 9px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: 0.07em;
    }

    .agenda-detail-title {
        margin: 17px 0 0;
        color: var(--agenda-navy);
        font-size: clamp(30px, 4vw, 48px);
        font-weight: 900;
        line-height: 1.12;
        letter-spacing: -0.045em;
    }

    .agenda-detail-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 15px;
        padding: 6px 9px;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 850;
    }

    .agenda-detail-status.upcoming {
        color: #0c6339;
        background: #edf9f2;
        border: 1px solid #ccebd9;
    }

    .agenda-detail-status.finished {
        color: #626e67;
        background: #f1f4f2;
        border: 1px solid #e0e7e3;
    }

    .agenda-detail-information {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-top: 25px;
    }

    .agenda-detail-info {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        min-width: 0;
        padding: 14px;
        background: var(--agenda-bg);
        border: 1px solid var(--agenda-border);
        border-radius: 14px;
    }

    .agenda-detail-info i {
        width: 37px;
        height: 37px;
        flex: 0 0 37px;
        display: grid;
        place-items: center;
        color: var(--agenda-green);
        background: var(--agenda-white);
        border-radius: 10px;
        font-size: 15px;
    }

    .agenda-detail-info small {
        display: block;
        color: var(--agenda-muted);
        font-size: 8px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: 0.07em;
    }

    .agenda-detail-info strong {
        display: block;
        margin-top: 4px;
        color: var(--agenda-navy);
        font-size: 12px;
        font-weight: 800;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .agenda-detail-description {
        margin-top: 27px;
        padding-top: 24px;
        border-top: 1px solid var(--agenda-border);
    }

    .agenda-detail-description h2 {
        margin: 0;
        color: var(--agenda-navy);
        font-size: 19px;
        font-weight: 850;
    }

    .agenda-detail-description-text {
        margin-top: 12px;
        color: var(--agenda-text);
        font-size: 14px;
        line-height: 1.85;
        white-space: pre-line;
    }

    .agenda-detail-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 27px;
    }

    .agenda-detail-button {
        min-height: 43px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 15px;
        border-radius: 11px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 850;
    }

    .agenda-detail-button.primary {
        color: #ffffff;
        background: linear-gradient(
            135deg,
            var(--agenda-green-dark),
            var(--agenda-green)
        );
        box-shadow: 0 10px 24px rgba(22, 131, 79, 0.18);
    }

    .agenda-detail-button.secondary {
        color: var(--agenda-green-dark);
        background: var(--agenda-green-soft);
        border: 1px solid rgba(22, 131, 79, 0.16);
    }

    @media (max-width: 850px) {
        .agenda-detail-card {
            grid-template-columns: 1fr;
        }

        .agenda-detail-poster {
            min-height: 400px;
            border-right: 0;
            border-bottom: 1px solid var(--agenda-border);
        }

        .agenda-detail-poster img {
            min-height: 400px;
            max-height: 520px;
            object-fit: contain;
            background: #ffffff;
        }
    }

    @media (max-width: 575.98px) {
        .agenda-detail-container {
            width: min(100% - 28px, 1180px);
        }

        .agenda-detail-section {
            padding: 30px 0 50px;
        }

        .agenda-detail-card {
            border-radius: 18px;
        }

        .agenda-detail-poster,
        .agenda-detail-poster img {
            min-height: 300px;
        }

        .agenda-detail-content {
            padding: 21px 17px;
        }

        .agenda-detail-information {
            grid-template-columns: 1fr;
        }

        .agenda-detail-actions {
            display: grid;
            grid-template-columns: 1fr;
        }

        .agenda-detail-button {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

<div class="agenda-detail-page">

    <section class="agenda-detail-section">
        <div class="agenda-detail-container">

            <a href="{{ $backUrl }}" class="agenda-detail-back">
                <i class="bi bi-arrow-left"></i>
                Kembali ke Beranda
            </a>

            <article class="agenda-detail-card">

                <div class="agenda-detail-poster">

                    @if($posterUrl)

                        <img
                            src="{{ $posterUrl }}"
                            alt="Poster {{ $agenda->judul }}"
                        >

                    @else

                        <div class="agenda-detail-poster-placeholder">
                            <i class="bi bi-calendar-event-fill"></i>

                            <strong>
                                Agenda Desa
                            </strong>
                        </div>

                    @endif

                </div>

                <div class="agenda-detail-content">

                    <span class="agenda-detail-kicker">
                        <i class="bi bi-calendar-event"></i>
                        Agenda Pemerintah Desa
                    </span>

                    <h1 class="agenda-detail-title">
                        {{ $agenda->judul }}
                    </h1>

                    <span
                        class="
                            agenda-detail-status
                            {{ $isUpcoming
                                ? 'upcoming'
                                : 'finished'
                            }}
                        "
                    >
                        <i class="bi bi-circle-fill"></i>

                        {{ $isUpcoming
                            ? 'Akan Datang'
                            : 'Selesai'
                        }}
                    </span>

                    <div class="agenda-detail-information">

                        <div class="agenda-detail-info">
                            <i class="bi bi-calendar3"></i>

                            <div>
                                <small>Tanggal Mulai</small>

                                <strong>
                                    {{ $startDate
                                        ? $startDate
                                            ->locale('id')
                                            ->translatedFormat(
                                                'l, d F Y'
                                            )
                                        : '-'
                                    }}
                                </strong>
                            </div>
                        </div>

                        @if($endDate)
                            <div class="agenda-detail-info">
                                <i class="bi bi-calendar-check"></i>

                                <div>
                                    <small>Tanggal Selesai</small>

                                    <strong>
                                        {{ $endDate
                                            ->locale('id')
                                            ->translatedFormat(
                                                'l, d F Y'
                                            )
                                        }}
                                    </strong>
                                </div>
                            </div>
                        @endif

                        <div class="agenda-detail-info">
                            <i class="bi bi-clock"></i>

                            <div>
                                <small>Waktu</small>

                                <strong>
                                    {{ $agenda->waktu ?: '-' }}
                                </strong>
                            </div>
                        </div>

                        <div class="agenda-detail-info">
                            <i class="bi bi-geo-alt-fill"></i>

                            <div>
                                <small>Lokasi</small>

                                <strong>
                                    {{ $agenda->lokasi ?: '-' }}
                                </strong>
                            </div>
                        </div>

                    </div>

                    <div class="agenda-detail-description">

                        <h2>Deskripsi Kegiatan</h2>

                        <div class="agenda-detail-description-text">
                            {{ $agenda->deskripsi
                                ?: 'Belum ada deskripsi tambahan.'
                            }}
                        </div>

                    </div>

                    <div class="agenda-detail-actions">

                        <a
                            href="{{ $backUrl }}"
                            class="agenda-detail-button secondary"
                        >
                            <i class="bi bi-house"></i>
                            Kembali ke Beranda
                        </a>

                        @if(filled($contact?->whatsapp))
                            @php
                                $agendaWhatsapp = preg_replace(
                                    '/[^0-9]/',
                                    '',
                                    $contact->whatsapp
                                );

                                if (
                                    str_starts_with(
                                        $agendaWhatsapp,
                                        '0'
                                    )
                                ) {
                                    $agendaWhatsapp =
                                        '62' .
                                        substr(
                                            $agendaWhatsapp,
                                            1
                                        );
                                }

                                $agendaMessage = rawurlencode(
                                    'Halo, saya ingin menanyakan agenda: ' .
                                    $agenda->judul
                                );
                            @endphp

                            <a
                                href="https://wa.me/{{ $agendaWhatsapp }}?text={{ $agendaMessage }}"
                                target="_blank"
                                rel="noopener"
                                class="agenda-detail-button primary"
                            >
                                <i class="bi bi-whatsapp"></i>
                                Tanyakan Agenda
                            </a>
                        @endif

                    </div>

                </div>

            </article>

        </div>
    </section>

</div>

@endsection
