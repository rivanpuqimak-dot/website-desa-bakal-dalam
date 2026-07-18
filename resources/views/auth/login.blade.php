@php
    $loginSettings =
        \App\Models\Setting::query()->first();

    $loginProfile =
        \App\Models\VillageProfile::query()->first();

    $loginSiteName = $loginSettings?->nama_website
        ?? $loginProfile?->nama_desa
        ?? 'Desa Bakal Dalam';

    $loginSlogan = $loginSettings?->slogan
        ?? 'Kelola informasi desa dalam satu tempat.';

    $loginLogoPath = $loginSettings?->logo
        ?? $loginProfile?->logo;

    $loginLogoUrl = filled($loginLogoPath)
        ? asset(
            'storage/' .
            ltrim($loginLogoPath, '/')
        ) . '?v=' . (
            $loginSettings?->updated_at?->timestamp
            ?? $loginProfile?->updated_at?->timestamp
            ?? time()
        )
        : null;

    $loginFaviconUrl = filled($loginSettings?->favicon)
        ? asset(
            'storage/' .
            ltrim($loginSettings->favicon, '/')
        ) . '?v=' . (
            $loginSettings?->updated_at?->timestamp
            ?? time()
        )
        : asset('favicon.ico');

    $loginRegion = collect([
        $loginProfile?->kecamatan
            ? 'Kecamatan ' . $loginProfile->kecamatan
            : null,
        $loginProfile?->kabupaten
            ? 'Kabupaten ' . $loginProfile->kabupaten
            : null,
    ])->filter()->implode(', ');

    $loginInitials = collect(
        preg_split(
            '/\s+/',
            trim($loginSiteName)
        )
    )
        ->filter()
        ->take(3)
        ->map(
            fn ($word) => mb_strtoupper(
                mb_substr($word, 0, 1)
            )
        )
        ->implode('');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login Admin | {{ $loginSiteName }}</title>

    <meta
        name="robots"
        content="noindex,nofollow"
    >

    <link
        rel="icon"
        href="{{ $loginFaviconUrl }}"
    >

    <style>
        :root {
            --login-green: #16834f;
            --login-green-dark: #0d6139;
            --login-green-deep: #09472b;
            --login-green-soft: #eef7f2;
            --login-navy: #12251c;
            --login-text: #34463c;
            --login-muted: #6e7d74;
            --login-border: #dfe9e3;
            --login-white: #ffffff;
            --login-bg: #f5f8f6;
            --login-danger: #b42318;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
            margin: 0;
        }

        body {
            min-height: 100vh;
            color: var(--login-text);
            background:
                radial-gradient(
                    circle at 15% 15%,
                    rgba(22, 131, 79, 0.11),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 88% 85%,
                    rgba(13, 97, 57, 0.09),
                    transparent 30%
                ),
                var(--login-bg);
            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
        }

        button,
        input {
            font: inherit;
        }

        .login-page {
            min-height: 100vh;
            display: grid;
            grid-template-columns:
                minmax(360px, 0.95fr)
                minmax(440px, 1.05fr);
        }

        .login-identity {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            padding: clamp(34px, 5vw, 72px);
            color: #ffffff;
            background:
                linear-gradient(
                    145deg,
                    rgba(9, 71, 43, 0.96),
                    rgba(22, 131, 79, 0.91)
                );
        }

        .login-identity::before,
        .login-identity::after {
            position: absolute;
            content: "";
            border-radius: 50%;
            pointer-events: none;
        }

        .login-identity::before {
            width: 360px;
            height: 360px;
            top: -170px;
            right: -130px;
            background: rgba(255, 255, 255, 0.08);
        }

        .login-identity::after {
            width: 260px;
            height: 260px;
            bottom: -130px;
            left: -90px;
            border: 48px solid rgba(255, 255, 255, 0.07);
        }

        .login-brand,
        .login-welcome,
        .login-identity-footer {
            position: relative;
            z-index: 1;
        }

        .login-brand {
            display: inline-flex;
            align-items: center;
            gap: 14px;
        }

        .login-brand-logo {
            width: 60px;
            height: 60px;
            flex: 0 0 60px;
            display: grid;
            place-items: center;
            overflow: hidden;
            padding: 7px;
            color: var(--login-green-dark);
            background: #ffffff;
            border-radius: 17px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.13);
            font-size: 16px;
            font-weight: 900;
            letter-spacing: -0.04em;
        }

        .login-brand-logo img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: contain;
        }

        .login-brand-copy strong {
            display: block;
            font-size: 18px;
            font-weight: 850;
            line-height: 1.3;
        }

        .login-brand-copy span {
            display: block;
            margin-top: 4px;
            color: rgba(255, 255, 255, 0.76);
            font-size: 12px;
            line-height: 1.5;
        }

        .login-welcome {
            max-width: 540px;
            margin: clamp(60px, 10vh, 120px) 0;
        }

        .login-welcome-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 11px;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.11);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 999px;
            font-size: 10px;
            font-weight: 850;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .login-welcome-kicker::before {
            width: 7px;
            height: 7px;
            content: "";
            border-radius: 50%;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.12);
        }

        .login-welcome h1 {
            margin: 22px 0 0;
            color: #ffffff;
            font-size: clamp(38px, 5vw, 68px);
            font-weight: 900;
            line-height: 1.03;
            letter-spacing: -0.055em;
        }

        .login-welcome p {
            max-width: 500px;
            margin: 20px 0 0;
            color: rgba(255, 255, 255, 0.78);
            font-size: 15px;
            line-height: 1.8;
        }

        .login-identity-footer {
            color: rgba(255, 255, 255, 0.66);
            font-size: 11px;
            line-height: 1.6;
        }

        .login-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(28px, 5vw, 72px);
        }

        .login-card {
            width: min(100%, 470px);
            padding: clamp(27px, 4vw, 42px);
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid var(--login-border);
            border-radius: 24px;
            box-shadow: 0 24px 65px rgba(18, 69, 43, 0.11);
            backdrop-filter: blur(14px);
        }

        .login-card-header {
            margin-bottom: 27px;
        }

        .login-card-header h2 {
            margin: 0;
            color: var(--login-navy);
            font-size: 31px;
            font-weight: 900;
            line-height: 1.2;
            letter-spacing: -0.04em;
        }

        .login-card-header p {
            margin: 8px 0 0;
            color: var(--login-muted);
            font-size: 13px;
            line-height: 1.65;
        }

        .login-alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 18px;
            padding: 12px 13px;
            color: var(--login-danger);
            background: #fff2f1;
            border: 1px solid #f3cfcb;
            border-radius: 11px;
            font-size: 11px;
            line-height: 1.6;
        }

        .login-alert strong {
            display: block;
            margin-bottom: 3px;
        }

        .login-alert ul {
            margin: 5px 0 0;
            padding-left: 18px;
        }

        .login-field {
            margin-bottom: 17px;
        }

        .login-field label {
            display: block;
            margin-bottom: 7px;
            color: var(--login-navy);
            font-size: 11px;
            font-weight: 850;
        }

        .login-input-wrap {
            position: relative;
        }

        .login-field input {
            width: 100%;
            min-height: 49px;
            padding: 0 14px 0 44px;
            color: var(--login-text);
            background: #ffffff;
            border: 1px solid var(--login-border);
            border-radius: 12px;
            outline: none;
            font-size: 13px;
            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease;
        }

        .login-field input.has-action {
            padding-right: 46px;
        }

        .login-field input:focus {
            border-color: rgba(22, 131, 79, 0.65);
            box-shadow: 0 0 0 4px rgba(22, 131, 79, 0.09);
        }

        .login-field input.is-invalid {
            border-color: #d75d53;
            box-shadow: 0 0 0 4px rgba(215, 93, 83, 0.08);
        }

        .login-input-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            width: 17px;
            height: 17px;
            color: var(--login-muted);
            transform: translateY(-50%);
            pointer-events: none;
        }

        .login-input-icon svg {
            width: 100%;
            height: 100%;
            display: block;
        }

        .login-password-toggle {
            position: absolute;
            top: 50%;
            right: 8px;
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            padding: 0;
            color: var(--login-muted);
            background: transparent;
            border: 0;
            border-radius: 8px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .login-password-toggle:hover {
            color: var(--login-green);
            background: var(--login-green-soft);
        }

        .login-password-toggle svg {
            width: 17px;
            height: 17px;
        }

        .login-error {
            display: block;
            margin-top: 6px;
            color: var(--login-danger);
            font-size: 10px;
            line-height: 1.45;
        }

        .login-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin: 2px 0 20px;
        }

        .login-remember {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--login-muted);
            font-size: 11px;
            cursor: pointer;
        }

        .login-remember input {
            width: 16px;
            height: 16px;
            margin: 0;
            accent-color: var(--login-green);
        }

        .login-forgot {
            color: var(--login-green-dark);
            text-decoration: none;
            font-size: 11px;
            font-weight: 800;
        }

        .login-forgot:hover {
            color: var(--login-green);
            text-decoration: underline;
        }

        .login-submit {
            width: 100%;
            min-height: 49px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 11px 16px;
            color: #ffffff;
            background: linear-gradient(
                135deg,
                var(--login-green-dark),
                var(--login-green)
            );
            border: 0;
            border-radius: 12px;
            box-shadow: 0 12px 25px rgba(22, 131, 79, 0.22);
            font-size: 12px;
            font-weight: 850;
            cursor: pointer;
            transition:
                transform 0.2s ease,
                filter 0.2s ease;
        }

        .login-submit:hover {
            filter: brightness(1.04);
            transform: translateY(-1px);
        }

        .login-submit svg {
            width: 17px;
            height: 17px;
        }

        .login-card-footer {
            margin-top: 22px;
            padding-top: 20px;
            color: var(--login-muted);
            border-top: 1px solid var(--login-border);
            font-size: 10px;
            line-height: 1.65;
            text-align: center;
        }

        .login-card-footer a {
            color: var(--login-green-dark);
            text-decoration: none;
            font-weight: 850;
        }

        .login-card-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 900px) {
            .login-page {
                grid-template-columns: 1fr;
            }

            .login-identity {
                min-height: auto;
                padding: 26px 28px;
            }

            .login-welcome {
                margin: 42px 0 18px;
            }

            .login-welcome h1 {
                font-size: clamp(34px, 8vw, 52px);
            }

            .login-identity-footer {
                display: none;
            }

            .login-panel {
                padding: 32px 22px 48px;
            }
        }

        @media (max-width: 575.98px) {
            .login-brand-logo {
                width: 50px;
                height: 50px;
                flex-basis: 50px;
                border-radius: 14px;
                font-size: 14px;
            }

            .login-welcome p {
                font-size: 13px;
            }

            .login-panel {
                padding-inline: 14px;
            }

            .login-card {
                padding: 25px 18px;
                border-radius: 19px;
            }

            .login-card-header h2 {
                font-size: 27px;
            }

            .login-options {
                align-items: flex-start;
                flex-direction: column;
                gap: 11px;
            }
        }
    </style>
</head>
<body>

<div class="login-page">

    <section class="login-identity">

        <div class="login-brand">

            <div class="login-brand-logo">
                @if($loginLogoUrl)
                    <img
                        src="{{ $loginLogoUrl }}"
                        alt="Logo {{ $loginSiteName }}"
                    >
                @else
                    {{ $loginInitials ?: 'D' }}
                @endif
            </div>

            <div class="login-brand-copy">
                <strong>{{ $loginSiteName }}</strong>

                <span>
                    {{ $loginRegion ?: 'Pemerintah Desa' }}
                </span>
            </div>

        </div>

        <div class="login-welcome">

            <span class="login-welcome-kicker">
                Sistem Informasi Desa
            </span>

            <h1>
                {{ $loginSlogan }}
            </h1>

            <p>
                Masuk ke dashboard administrator untuk mengelola profil desa,
                pemerintahan, berita, galeri, agenda, dan layanan informasi
                masyarakat.
            </p>

        </div>

        <div class="login-identity-footer">
            &copy; {{ date('Y') }} {{ $loginSiteName }}.
            Seluruh hak dilindungi.
        </div>

    </section>

    <main class="login-panel">

        <div class="login-card">

            <header class="login-card-header">
                <h2>Masuk ke Admin</h2>

                <p>
                    Gunakan email dan password akun administrator.
                </p>
            </header>

            @if(session('error'))
                <div class="login-alert">
                    <span>!</span>

                    <div>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="login-alert">

                    <span>!</span>

                    <div>
                        <strong>Login belum berhasil.</strong>

                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            @endif

            <form
                action="{{ route('login.proses') }}"
                method="POST"
            >

                @csrf

                <div class="login-field">

                    <label for="email">
                        Email
                    </label>

                    <div class="login-input-wrap">

                        <span class="login-input-icon">
                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path d="M4 5h16v14H4z"></path>
                                <path d="m4 7 8 6 8-6"></path>
                            </svg>
                        </span>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            placeholder="nama@desa.com"
                            class="@error('email') is-invalid @enderror"
                            required
                            autofocus
                        >

                    </div>

                    @error('email')
                        <span class="login-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <div class="login-field">

                    <label for="password">
                        Password
                    </label>

                    <div class="login-input-wrap">

                        <span class="login-input-icon">
                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <rect
                                    x="5"
                                    y="10"
                                    width="14"
                                    height="10"
                                    rx="2"
                                ></rect>
                                <path d="M8 10V7a4 4 0 0 1 8 0v3"></path>
                            </svg>
                        </span>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            autocomplete="current-password"
                            placeholder="Masukkan password"
                            class="
                                has-action
                                @error('password') is-invalid @enderror
                            "
                            required
                        >

                        <button
                            type="button"
                            class="login-password-toggle"
                            id="toggle-password"
                            aria-label="Tampilkan password"
                        >
                            <svg
                                id="password-eye"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"
                                ></path>
                                <circle cx="12" cy="12" r="2.7"></circle>
                            </svg>
                        </button>

                    </div>

                    @error('password')
                        <span class="login-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <div class="login-options">

                    <label class="login-remember">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                        >

                        Ingat saya
                    </label>

                    @if(Route::has('password.forgot'))
                        <a
                            href="{{ route('password.forgot') }}"
                            class="login-forgot"
                        >
                            Lupa password?
                        </a>
                    @endif

                </div>

                <button
                    type="submit"
                    class="login-submit"
                >
                    Masuk ke Dashboard

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M5 12h14"></path>
                        <path d="m14 7 5 5-5 5"></path>
                    </svg>
                </button>

            </form>

            <div class="login-card-footer">
                Halaman ini khusus administrator desa.

                @if(Route::has('home'))
                    <a href="{{ route('home') }}">
                        Kembali ke website
                    </a>
                @endif
            </div>

        </div>

    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('toggle-password');
    const password = document.getElementById('password');

    toggle?.addEventListener('click', function () {
        if (!password) {
            return;
        }

        const showPassword =
            password.type === 'password';

        password.type = showPassword
            ? 'text'
            : 'password';

        this.setAttribute(
            'aria-label',
            showPassword
                ? 'Sembunyikan password'
                : 'Tampilkan password'
        );
    });
});
</script>

</body>
</html>
