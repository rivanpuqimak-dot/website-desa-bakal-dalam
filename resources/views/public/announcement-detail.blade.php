@extends('layouts.public')

@section('title', $announcement->judul ?? 'Pengumuman Desa')

@php
    $publishedDate = $announcement?->published_at
        ?? $announcement?->created_at;

    $attachmentUrl = null;

    if (filled($announcement?->lampiran)) {
        $attachmentUrl = \Illuminate\Support\Str::startsWith(
            $announcement->lampiran,
            [
                'http://',
                'https://',
            ]
        )
            ? $announcement->lampiran
            : asset(
                'storage/' .
                ltrim($announcement->lampiran, '/')
            );
    }
@endphp

@push('styles')
<style>
    :root {
        --announcement-green: #16834f;
        --announcement-green-dark: #0d6139;
        --announcement-green-soft: #eef7f2;
        --announcement-navy: #12251c;
        --announcement-text: #34463c;
        --announcement-muted: #6e7d74;
        --announcement-border: #dfe9e3;
        --announcement-bg: #f5f8f6;
    }

    .announcement-page,
    .announcement-page * {
        box-sizing: border-box;
    }

    .announcement-page {
        min-height: 70vh;
        color: var(--announcement-text);
        background: var(--announcement-bg);
    }

    .announcement-container {
        width: min(920px, calc(100% - 48px));
        margin-inline: auto;
    }

    .announcement-header {
        padding: 38px 0 31px;
        background:
            radial-gradient(
                circle at 88% 12%,
                rgba(22, 131, 79, 0.12),
                transparent 28%
            ),
            #ffffff;
        border-bottom: 1px solid var(--announcement-border);
    }

    .announcement-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 39px;
        padding: 8px 12px;
        color: var(--announcement-green-dark);
        background: #ffffff;
        border: 1px solid var(--announcement-border);
        border-radius: 10px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 850;
    }

    .announcement-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-top: 24px;
        padding: 7px 11px;
        color: var(--announcement-green-dark);
        background: var(--announcement-green-soft);
        border-radius: 999px;
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.07em;
    }

    .announcement-title {
        margin: 14px 0 0;
        color: var(--announcement-navy);
        font-size: clamp(31px, 5vw, 52px);
        font-weight: 900;
        line-height: 1.08;
        letter-spacing: -0.045em;
        overflow-wrap: anywhere;
    }

    .announcement-date {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-top: 16px;
        color: var(--announcement-muted);
        font-size: 12px;
        font-weight: 750;
    }

    .announcement-main {
        padding: 31px 0 72px;
    }

    .announcement-card {
        padding: clamp(24px, 5vw, 46px);
        background: #ffffff;
        border: 1px solid var(--announcement-border);
        border-radius: 21px;
        box-shadow: 0 17px 42px rgba(19, 69, 43, 0.07);
    }

    .announcement-summary {
        margin: 0 0 25px;
        padding: 17px 18px;
        color: var(--announcement-green-dark);
        background: var(--announcement-green-soft);
        border-left: 4px solid var(--announcement-green);
        border-radius: 0 12px 12px 0;
        font-size: 15px;
        font-weight: 750;
        line-height: 1.75;
    }

    .announcement-body {
        color: var(--announcement-text);
        font-size: 15px;
        line-height: 1.9;
        overflow-wrap: anywhere;
    }

    .announcement-attachment {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-top: 29px;
        padding: 16px 18px;
        background: #f8fbf9;
        border: 1px solid var(--announcement-border);
        border-radius: 13px;
    }

    .announcement-attachment-copy {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 0;
    }

    .announcement-attachment-icon {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        display: grid;
        place-items: center;
        color: var(--announcement-green);
        background: var(--announcement-green-soft);
        border-radius: 11px;
        font-size: 17px;
    }

    .announcement-attachment strong {
        display: block;
        color: var(--announcement-navy);
        font-size: 12px;
        font-weight: 850;
    }

    .announcement-attachment span {
        display: block;
        margin-top: 3px;
        color: var(--announcement-muted);
        font-size: 10px;
    }

    .announcement-download {
        min-height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 8px 13px;
        color: #ffffff;
        background: var(--announcement-green);
        border-radius: 10px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 850;
        white-space: nowrap;
    }

    @media (max-width: 560px) {
        .announcement-container {
            width: min(100% - 28px, 920px);
        }

        .announcement-header {
            padding: 29px 0 25px;
        }

        .announcement-main {
            padding: 23px 0 55px;
        }

        .announcement-attachment {
            align-items: stretch;
            flex-direction: column;
        }

        .announcement-download {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="announcement-page">

    <header class="announcement-header">
        <div class="announcement-container">

            <a
                href="{{ route('home') }}"
                class="announcement-back"
            >
                <i class="bi bi-arrow-left"></i>
                Kembali ke Beranda
            </a>

            <div>
                <span class="announcement-label">
                    <i class="bi bi-megaphone"></i>
                    Pengumuman Resmi
                </span>

                <h1 class="announcement-title">
                    {{ $announcement->judul }}
                </h1>

                @if($publishedDate)
                    <span class="announcement-date">
                        <i class="bi bi-calendar3"></i>

                        {{ $publishedDate
                            ->locale('id')
                            ->translatedFormat('d F Y')
                        }}
                    </span>
                @endif
            </div>

        </div>
    </header>

    <main class="announcement-main">
        <div class="announcement-container">

            <article class="announcement-card">

                @if(filled($announcement->ringkasan))
                    <p class="announcement-summary">
                        {{ $announcement->ringkasan }}
                    </p>
                @endif

                <div class="announcement-body">
                    {!! nl2br(e(
                        $announcement->isi
                            ?: 'Isi pengumuman belum tersedia.'
                    )) !!}
                </div>

                @if($attachmentUrl)
                    <div class="announcement-attachment">

                        <div class="announcement-attachment-copy">

                            <span class="announcement-attachment-icon">
                                <i class="bi bi-paperclip"></i>
                            </span>

                            <span>
                                <strong>Lampiran Pengumuman</strong>
                                <span>
                                    Buka dokumen pendukung pengumuman.
                                </span>
                            </span>

                        </div>

                        <a
                            href="{{ $attachmentUrl }}"
                            target="_blank"
                            rel="noopener"
                            class="announcement-download"
                        >
                            <i class="bi bi-box-arrow-up-right"></i>
                            Buka Lampiran
                        </a>

                    </div>
                @endif

            </article>

        </div>
    </main>

</div>
@endsection
