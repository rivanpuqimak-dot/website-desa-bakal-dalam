@php
    $maintenanceSiteName = $settings?->nama_website
        ?? $profile?->nama_desa
        ?? 'Website Desa';

    $maintenanceSlogan = $settings?->slogan
        ?? 'Pelayanan informasi desa akan segera kembali.';

    $maintenanceLogoPath = $settings?->logo
        ?? $profile?->logo;

    $maintenanceLogoUrl = filled($maintenanceLogoPath)
        ? asset(
            'storage/' .
            ltrim($maintenanceLogoPath, '/')
        )
        : null;

    $maintenanceFaviconUrl = filled($settings?->favicon)
        ? asset(
            'storage/' .
            ltrim($settings->favicon, '/')
        )
        : asset('favicon.ico');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="robots"
        content="noindex,nofollow"
    >

    <title>
        Sedang Pemeliharaan | {{ $maintenanceSiteName }}
    </title>

    <link
        rel="icon"
        href="{{ $maintenanceFaviconUrl }}"
    >

    <style>
        :root {
            --green: #16834f;
            --green-dark: #0d6139;
            --green-soft: #eef7f2;
            --navy: #12251c;
            --text: #34463c;
            --muted: #6e7d74;
            --border: #dfe9e3;
            --bg: #f5f8f6;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: grid;
            place-items: center;
            margin: 0;
            padding: 24px;
            color: var(--text);
            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(22, 131, 79, 0.14),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 90% 90%,
                    rgba(13, 97, 57, 0.1),
                    transparent 30%
                ),
                var(--bg);
            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
        }

        .maintenance-card {
            width: min(100%, 680px);
            padding: clamp(28px, 6vw, 52px);
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 26px;
            box-shadow: 0 28px 90px rgba(12, 72, 42, 0.13);
            text-align: center;
        }

        .maintenance-logo {
            width: 86px;
            height: 86px;
            display: grid;
            place-items: center;
            margin: 0 auto 22px;
            overflow: hidden;
            padding: 10px;
            color: #ffffff;
            background: linear-gradient(
                135deg,
                var(--green-dark),
                var(--green)
            );
            border-radius: 23px;
            font-size: 30px;
            font-weight: 900;
        }

        .maintenance-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #ffffff;
            border-radius: 14px;
        }

        .maintenance-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            color: var(--green-dark);
            background: var(--green-soft);
            border: 1px solid rgba(22, 131, 79, 0.16);
            border-radius: 999px;
            font-size: 11px;
            font-weight: 850;
            letter-spacing: 0.07em;
            text-transform: uppercase;
        }

        h1 {
            margin: 17px 0 0;
            color: var(--navy);
            font-size: clamp(30px, 6vw, 48px);
            line-height: 1.1;
            letter-spacing: -0.045em;
        }

        p {
            max-width: 520px;
            margin: 15px auto 0;
            color: var(--muted);
            font-size: 15px;
            line-height: 1.75;
        }

        .maintenance-contact {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 9px;
            margin-top: 24px;
        }

        .maintenance-contact span,
        .maintenance-contact a {
            min-height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 13px;
            color: var(--green-dark);
            background: var(--green-soft);
            border: 1px solid rgba(22, 131, 79, 0.16);
            border-radius: 10px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 800;
        }

        .maintenance-login {
            display: inline-flex;
            margin-top: 26px;
            color: var(--muted);
            font-size: 11px;
            text-decoration: none;
        }

        .maintenance-login:hover {
            color: var(--green);
        }
    </style>
</head>

<body>

    <main class="maintenance-card">

        <div class="maintenance-logo">
            @if($maintenanceLogoUrl)
                <img
                    src="{{ $maintenanceLogoUrl }}"
                    alt="Logo {{ $maintenanceSiteName }}"
                >
            @else
                !
            @endif
        </div>

        <span class="maintenance-label">
            Sedang Pemeliharaan
        </span>

        <h1>
            Website Akan Segera Kembali
        </h1>

        <p>
            {{ $maintenanceSlogan }}
            Saat ini website sedang diperbarui agar layanan informasi
            kepada masyarakat menjadi lebih baik.
        </p>

        <div class="maintenance-contact">
            @if(filled($contact?->telepon))
                <span>
                    Telepon: {{ $contact->telepon }}
                </span>
            @endif

            @if(filled($contact?->email))
                <a href="mailto:{{ $contact->email }}">
                    {{ $contact->email }}
                </a>
            @endif
        </div>

        <a
            href="{{ route('login') }}"
            class="maintenance-login"
        >
            Masuk sebagai pengelola website
        </a>

    </main>

</body>
</html>
