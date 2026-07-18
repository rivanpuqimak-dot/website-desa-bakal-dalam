<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Akses Ditolak</title>

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
                    circle at top left,
                    rgba(22, 131, 79, 0.12),
                    transparent 34%
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

        .access-card {
            width: min(100%, 540px);
            padding: 38px;
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 22px;
            box-shadow: 0 24px 70px rgba(18, 69, 43, 0.1);
            text-align: center;
        }

        .access-icon {
            width: 78px;
            height: 78px;
            display: grid;
            place-items: center;
            margin: 0 auto 20px;
            color: var(--green-dark);
            background: var(--green-soft);
            border-radius: 22px;
            font-size: 34px;
            font-weight: 900;
        }

        .access-code {
            margin: 0 0 5px;
            color: var(--green);
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 0.13em;
        }

        h1 {
            margin: 0;
            color: var(--navy);
            font-size: clamp(26px, 5vw, 36px);
            line-height: 1.15;
        }

        p {
            margin: 14px auto 0;
            max-width: 410px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.75;
        }

        .access-role {
            display: inline-flex;
            margin-top: 17px;
            padding: 8px 12px;
            color: var(--green-dark);
            background: var(--green-soft);
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
        }

        .access-actions {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 27px;
        }

        .access-button {
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 17px;
            border-radius: 11px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 850;
        }

        .access-button.primary {
            color: #ffffff;
            background: linear-gradient(
                135deg,
                var(--green-dark),
                var(--green)
            );
        }

        .access-button.secondary {
            color: var(--green-dark);
            background: var(--green-soft);
            border: 1px solid rgba(22, 131, 79, 0.16);
        }

        @media (max-width: 520px) {
            .access-card {
                padding: 29px 20px;
            }

            .access-actions {
                flex-direction: column;
            }

            .access-button {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <main class="access-card">

        <div class="access-icon">
            !
        </div>

        <div class="access-code">
            ERROR 403
        </div>

        <h1>Akses Ditolak</h1>

        <p>
            Akun yang sedang digunakan tidak memiliki izin untuk
            membuka halaman ini. Hubungi Super Admin apabila akses
            tersebut memang dibutuhkan.
        </p>

        @auth
            <span class="access-role">
                Role Anda: {{ auth()->user()->role ?? '-' }}
            </span>
        @endauth

        <div class="access-actions">

            @auth
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="access-button primary"
                >
                    Kembali ke Dashboard
                </a>
            @else
                <a
                    href="{{ route('login') }}"
                    class="access-button primary"
                >
                    Masuk sebagai Admin
                </a>
            @endauth

            <a
                href="{{ route('home') }}"
                class="access-button secondary"
            >
                Website Publik
            </a>

        </div>

    </main>

</body>
</html>
