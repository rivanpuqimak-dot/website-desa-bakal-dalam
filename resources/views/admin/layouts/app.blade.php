<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <meta
        name="robots"
        content="noindex,nofollow,noarchive"
    >

    <title>
        @yield('title', 'Dashboard Admin')
        | Desa Bakal Dalam
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        :root {
            --admin-green: #16834f;
            --admin-green-dark: #0d6139;
            --admin-green-deep: #09472b;
            --admin-green-soft: #eef7f2;
            --admin-navy: #12251c;
            --admin-text: #34463c;
            --admin-muted: #6e7d74;
            --admin-border: #dfe9e3;
            --admin-white: #ffffff;
            --admin-bg: #f5f8f6;
            --admin-sidebar-width: 286px;
            --admin-navbar-height: 92px;
        }

        * {
            box-sizing: border-box;
        }

        html {
            min-height: 100%;
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            margin: 0;
            color: var(--admin-text);
            background: var(--admin-bg);
            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
        }

        body.admin-overlay-open {
            overflow: hidden;
        }

        button,
        input {
            font: inherit;
        }

        .wrapper {
            min-height: 100vh;
            display: flex;
            align-items: stretch;
        }

        .content {
            min-width: 0;
            flex: 1;
            margin-left: var(--admin-sidebar-width);
            transition: margin-left 0.25s ease;
        }

        .admin-main {
            min-height: calc(100vh - var(--admin-navbar-height));
            padding: 30px;
        }

        /* =====================================================
           SIDEBAR
        ===================================================== */

        body .admin-sidebar {
            position: fixed !important;
            inset: 0 auto 0 0;
            z-index: 1040;
            width: var(--admin-sidebar-width) !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
            color: #ffffff !important;
            background:
                radial-gradient(
                    circle at 15% 4%,
                    rgba(255, 255, 255, 0.09),
                    transparent 23%
                ),
                linear-gradient(
                    180deg,
                    var(--admin-green-deep) 0%,
                    var(--admin-green-dark) 54%,
                    #083b24 100%
                ) !important;
            border-right: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 12px 0 36px rgba(7, 45, 27, 0.13);
            transition: transform 0.25s ease;
        }

        .sidebar-close {
            display: none;
            position: absolute;
            top: 16px;
            right: 14px;
            z-index: 4;
            width: 38px;
            height: 38px;
            place-items: center;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 11px;
            cursor: pointer;
        }

        .sidebar-top {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 22px 18px 17px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .village-logo {
            width: 52px;
            height: 52px;
            flex: 0 0 52px;
            display: grid;
            place-items: center;
            overflow: hidden;
            background: #ffffff;
            border: 2px solid rgba(255, 255, 255, 0.72);
            border-radius: 15px;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.14);
        }

        .village-logo img {
            width: 100%;
            height: 100%;
            display: block;
            padding: 5px;
            object-fit: contain;
        }

        .logo-default {
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            color: var(--admin-green-dark);
            background: var(--admin-green-soft);
            font-size: 22px;
            font-weight: 900;
        }

        .village-info {
            min-width: 0;
        }

        .village-info h5 {
            margin: 0;
            overflow: hidden;
            color: #ffffff;
            font-size: 15px;
            font-weight: 850;
            line-height: 1.35;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .village-info small {
            display: block;
            margin-top: 3px;
            overflow: hidden;
            color: rgba(255, 255, 255, 0.65);
            font-size: 10px;
            line-height: 1.4;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .admin-card {
            display: flex;
            align-items: center;
            gap: 11px;
            margin: 15px 14px 11px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.09);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 15px;
        }

        .admin-card img,
        .admin-avatar-fallback {
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            border-radius: 12px;
        }

        .admin-card img {
            display: block;
            object-fit: cover;
            object-position: center top;
        }

        .admin-avatar-fallback {
            display: grid;
            place-items: center;
            color: var(--admin-green-dark);
            background: #ffffff;
            font-size: 16px;
            font-weight: 900;
        }

        .admin-card div {
            min-width: 0;
        }

        .admin-card h6 {
            margin: 0;
            overflow: hidden;
            color: #ffffff;
            font-size: 13px;
            font-weight: 850;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .admin-card span {
            display: block;
            margin-top: 3px;
            color: rgba(255, 255, 255, 0.65);
            font-size: 10px;
            text-transform: capitalize;
        }

        .admin-sidebar .sidebar-menu-scroll,
        .admin-sidebar .admin-side-menu-scroll {
            min-height: 0 !important;
            height: auto !important;
            flex: 1 1 auto !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            padding: 5px 10px 12px !important;
            scrollbar-width: thin;
            scrollbar-color:
                rgba(255, 255, 255, 0.22)
                transparent;
        }

        .admin-sidebar .admin-side-menu-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .admin-sidebar .admin-side-menu-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 999px;
        }

        .admin-sidebar .admin-side-section-label {
            position: static !important;
            width: auto !important;
            height: auto !important;
            display: block !important;
            margin: 6px 0 3px !important;
            padding: 4px 10px !important;
            color: rgba(255, 255, 255, 0.48) !important;
            font-size: 8px !important;
            font-weight: 900 !important;
            line-height: 1.25 !important;
            letter-spacing: 0.11em !important;
            text-transform: uppercase !important;
            transform: none !important;
        }

        .admin-sidebar .admin-side-menu {
            width: 100% !important;
            height: auto !important;
            min-height: 0 !important;
            max-height: none !important;
            display: block !important;
            margin: 0 !important;
            padding: 0 !important;
            list-style: none !important;
            gap: 0 !important;
            justify-content: flex-start !important;
            align-content: start !important;
        }

        .admin-sidebar .admin-side-menu-item {
            position: static !important;
            width: 100% !important;
            height: auto !important;
            min-height: 0 !important;
            display: block !important;
            margin: 0 0 3px !important;
            padding: 0 !important;
            transform: none !important;
        }

        .admin-sidebar .admin-side-menu-link {
            position: relative !important;
            width: 100% !important;
            height: auto !important;
            min-height: 42px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
            gap: 10px !important;
            margin: 0 !important;
            padding: 9px 11px !important;
            color: rgba(255, 255, 255, 0.78) !important;
            background: transparent !important;
            border: 0 !important;
            border-radius: 11px !important;
            box-shadow: none !important;
            text-decoration: none !important;
            font-size: 11px !important;
            font-weight: 750 !important;
            line-height: 1.25 !important;
            transform: none !important;
            transition:
                color 0.2s ease,
                background 0.2s ease,
                transform 0.2s ease !important;
        }

        .admin-sidebar .admin-side-menu-link i {
            width: 20px !important;
            min-width: 20px !important;
            flex: 0 0 20px !important;
            display: inline-grid !important;
            place-items: center !important;
            margin: 0 !important;
            color: inherit !important;
            font-size: 15px !important;
            line-height: 1 !important;
        }

        .admin-sidebar .admin-side-menu-link span {
            display: block !important;
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1.25 !important;
        }

        .admin-sidebar .admin-side-menu-link:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.09) !important;
            transform: translateX(2px) !important;
        }

        .admin-sidebar .admin-side-menu-item.active
        > .admin-side-menu-link {
            color: var(--admin-green-dark) !important;
            background: #ffffff !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12) !important;
        }

        .admin-sidebar .admin-side-menu-item.active
        > .admin-side-menu-link::before {
            content: "";
            position: absolute;
            top: 9px;
            bottom: 9px;
            left: -10px;
            width: 3px;
            background: #83d6a7;
            border-radius: 999px;
        }

        .sidebar-bottom {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            padding: 13px;
            background: rgba(2, 24, 14, 0.2);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-bottom a,
        .sidebar-bottom button {
            width: 100%;
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 8px 9px;
            border-radius: 11px;
            text-decoration: none;
            font-size: 10px;
            font-weight: 800;
            cursor: pointer;
        }

        .sidebar-bottom a {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.14);
        }

        .sidebar-bottom form {
            margin: 0;
        }

        .sidebar-bottom .logout {
            color: #ffd6d6;
            background: rgba(211, 47, 47, 0.14);
            border: 1px solid rgba(255, 130, 130, 0.2);
        }

        .sidebar-bottom a:hover,
        .sidebar-bottom button:hover {
            filter: brightness(1.12);
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            z-index: 1030;
            display: none;
            background: rgba(5, 28, 17, 0.52);
            backdrop-filter: blur(2px);
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* =====================================================
           NAVBAR
        ===================================================== */

        .navbar {
            position: sticky;
            top: 0;
            z-index: 1020;
            min-height: var(--admin-navbar-height);
            display: grid;
            grid-template-columns:
                minmax(200px, 260px)
                minmax(260px, 500px)
                max-content;
            justify-content: start;
            gap: 16px;
            align-items: center;
            padding: 16px 24px;
            background: rgba(255, 255, 255, 0.94);
            border-bottom: 1px solid var(--admin-border);
            box-shadow: 0 8px 24px rgba(18, 69, 43, 0.04);
            backdrop-filter: blur(14px);
        }

        .navbar-menu-toggle {
            display: none;
            width: 42px;
            height: 42px;
            place-items: center;
            color: var(--admin-green-dark);
            background: var(--admin-green-soft);
            border: 1px solid var(--admin-border);
            border-radius: 12px;
            font-size: 18px;
            cursor: pointer;
        }

        .navbar-left {
            min-width: 0;
        }

        .navbar-breadcrumb {
            display: flex;
            align-items: center;
            gap: 7px;
            color: var(--admin-muted);
            font-size: 10px;
            font-weight: 700;
        }

        .breadcrumb-separator {
            color: #a4afa8;
        }

        .navbar-title {
            margin: 4px 0 0;
            overflow: hidden;
            color: var(--admin-navy);
            font-size: 22px;
            font-weight: 850;
            line-height: 1.2;
            letter-spacing: -0.03em;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .navbar-center {
            min-width: 0;
        }

        .search-box {
            position: relative;
            min-width: 0;
        }

        .search-box > i {
            position: absolute;
            top: 50%;
            left: 15px;
            z-index: 2;
            color: var(--admin-green);
            font-size: 15px;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .search-box input {
            width: 100%;
            height: 46px;
            padding: 0 16px 0 43px;
            color: var(--admin-navy);
            background: var(--admin-bg);
            border: 1px solid var(--admin-border);
            border-radius: 13px;
            outline: none;
            font-size: 12px;
            transition:
                background 0.2s ease,
                border-color 0.2s ease,
                box-shadow 0.2s ease;
        }

        .search-box input:focus {
            background: #ffffff;
            border-color: rgba(22, 131, 79, 0.6);
            box-shadow: 0 0 0 4px rgba(22, 131, 79, 0.1);
        }

        .search-suggestions {
            position: absolute;
            top: calc(100% + 9px);
            right: 0;
            left: 0;
            z-index: 1050;
            max-height: 300px;
            display: none;
            overflow-y: auto;
            margin: 0;
            padding: 7px;
            background: #ffffff;
            border: 1px solid var(--admin-border);
            border-radius: 14px;
            box-shadow: 0 18px 44px rgba(18, 37, 28, 0.14);
            list-style: none;
        }

        .search-suggestions.show {
            display: block;
        }

        .search-suggestions li {
            margin: 0;
        }

        .search-suggestions a,
        .search-suggestions .search-empty {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 10px 11px;
            color: var(--admin-text);
            border-radius: 10px;
            text-decoration: none;
            font-size: 12px;
        }

        .search-suggestions a:hover,
        .search-suggestions a.is-selected {
            color: var(--admin-green-dark);
            background: var(--admin-green-soft);
        }

        .search-suggestions .search-empty {
            color: var(--admin-muted);
        }

        .navbar-right {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 9px;
            margin-left: 0;
        }

        .navbar-meta {
            padding-right: 2px;
        }

        .date-label {
            text-align: right;
        }

        .date-label span {
            display: block;
        }

        #navbar-date {
            color: var(--admin-navy);
            font-size: 10px;
            font-weight: 800;
        }

        #navbar-time {
            margin-top: 3px;
            color: var(--admin-muted);
            font-size: 10px;
        }

        .notif {
            position: relative;
            width: 43px;
            height: 43px;
            flex: 0 0 43px;
            display: grid;
            place-items: center;
            color: var(--admin-green-dark);
            background: var(--admin-green-soft);
            border: 1px solid var(--admin-border);
            border-radius: 12px;
            font-size: 16px;
            cursor: pointer;
        }

        .notif-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 18px;
            height: 18px;
            display: grid;
            place-items: center;
            padding: 0 4px;
            color: #ffffff;
            background: #d93c3c;
            border: 2px solid #ffffff;
            border-radius: 999px;
            font-size: 8px;
            font-weight: 900;
        }

        .admin-profile {
            position: relative;
        }

        .profile-trigger {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 5px 8px 5px 5px;
            color: var(--admin-text);
            background: #ffffff;
            border: 1px solid var(--admin-border);
            border-radius: 13px;
            cursor: pointer;
        }

        .profile-trigger img,
        .profile-trigger .profile-avatar-fallback {
            width: 37px;
            height: 37px;
            flex: 0 0 37px;
            border-radius: 10px;
        }

        .profile-trigger img {
            display: block;
            object-fit: cover;
            object-position: center top;
        }

        .profile-avatar-fallback {
            display: grid;
            place-items: center;
            color: #ffffff;
            background: var(--admin-green);
            font-size: 13px;
            font-weight: 900;
        }

        .profile-info {
            min-width: 0;
            text-align: left;
        }

        .profile-info strong {
            display: block;
            max-width: 120px;
            overflow: hidden;
            color: var(--admin-navy);
            font-size: 11px;
            line-height: 1.3;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .profile-badge {
            display: block;
            margin-top: 2px;
            color: var(--admin-green);
            font-size: 9px;
            font-weight: 800;
        }

        .profile-trigger > i {
            color: var(--admin-muted);
            font-size: 11px;
            transition: transform 0.2s ease;
        }

        .profile-trigger[aria-expanded="true"] > i {
            transform: rotate(180deg);
        }

        .profile-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            z-index: 1050;
            width: 210px;
            display: none;
            padding: 7px;
            background: #ffffff;
            border: 1px solid var(--admin-border);
            border-radius: 14px;
            box-shadow: 0 18px 44px rgba(18, 37, 28, 0.15);
        }

        .profile-menu.show {
            display: block;
        }

        .profile-menu a,
        .profile-menu button {
            width: 100%;
            display: flex;
            align-items: center;
            padding: 10px 11px;
            color: var(--admin-text);
            background: transparent;
            border: 0;
            border-radius: 10px;
            text-align: left;
            text-decoration: none;
            font-size: 12px;
            cursor: pointer;
        }

        .profile-menu a:hover,
        .profile-menu button:hover {
            color: var(--admin-green-dark);
            background: var(--admin-green-soft);
        }

        .profile-menu form {
            margin: 0;
            padding-top: 4px;
            border-top: 1px solid var(--admin-border);
        }

        /* =====================================================
           FOOTER DAN KONTEN UMUM
        ===================================================== */

        .admin-footer {
            padding: 18px 30px;
            color: var(--admin-muted);
            background: #ffffff;
            border-top: 1px solid var(--admin-border);
            font-size: 11px;
        }

        .admin-main .card,
        .admin-main .table-responsive,
        .admin-main .form-card {
            border-color: var(--admin-border);
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(18, 69, 43, 0.05);
        }


        /* =====================================================
           PERBAIKAN KONTRAS IDENTITAS SIDEBAR
        ===================================================== */

        body .admin-sidebar .village-info h5,
        body .admin-sidebar .admin-card h6 {
            color: #ffffff !important;
            opacity: 1 !important;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.08);
        }

        body .admin-sidebar .village-info small,
        body .admin-sidebar .admin-card span {
            color: rgba(255, 255, 255, 0.76) !important;
            opacity: 1 !important;
        }

        body .admin-sidebar .village-info h5 {
            font-size: 15px !important;
            font-weight: 850 !important;
        }

        body .admin-sidebar .village-info small {
            font-size: 10px !important;
            font-weight: 600 !important;
        }

        body .admin-sidebar .admin-card h6 {
            font-size: 13px !important;
            font-weight: 850 !important;
        }

        body .admin-sidebar .admin-card span {
            font-size: 10px !important;
            font-weight: 700 !important;
        }

        body .admin-sidebar .admin-card {
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: rgba(255, 255, 255, 0.16) !important;
        }

        body .admin-sidebar .village-info,
        body .admin-sidebar .admin-card > div {
            color: #ffffff !important;
        }


        /* =====================================================
           PERBAIKAN TOMBOL WEBSITE PUBLIK DAN LOGOUT
        ===================================================== */

        body .admin-sidebar .sidebar-bottom {
            background: rgba(3, 35, 20, 0.38) !important;
            border-top: 1px solid rgba(255, 255, 255, 0.14) !important;
        }

        body .admin-sidebar .sidebar-bottom a {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.12) !important;
            border: 1px solid rgba(255, 255, 255, 0.22) !important;
            opacity: 1 !important;
        }

        body .admin-sidebar .sidebar-bottom a,
        body .admin-sidebar .sidebar-bottom a span,
        body .admin-sidebar .sidebar-bottom a i {
            color: #ffffff !important;
            opacity: 1 !important;
        }

        body .admin-sidebar .sidebar-bottom .logout {
            color: #ffffff !important;
            background: rgba(200, 48, 48, 0.34) !important;
            border: 1px solid rgba(255, 145, 145, 0.38) !important;
            opacity: 1 !important;
        }

        body .admin-sidebar .sidebar-bottom .logout span,
        body .admin-sidebar .sidebar-bottom .logout i {
            color: #ffffff !important;
            opacity: 1 !important;
        }

        body .admin-sidebar .sidebar-bottom a:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.2) !important;
        }

        body .admin-sidebar .sidebar-bottom .logout:hover {
            color: #ffffff !important;
            background: rgba(220, 53, 69, 0.5) !important;
        }

        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 1199px) {
            .navbar {
                grid-template-columns:
                    minmax(175px, 220px)
                    minmax(220px, 420px)
                    max-content;
                gap: 12px;
                padding-inline: 18px;
            }

            .profile-info {
                display: none;
            }

            .profile-trigger {
                padding-right: 6px;
            }

            .date-label {
                display: none;
            }
        }

        @media (max-width: 991px) {
            :root {
                --admin-navbar-height: 126px;
            }

            body .admin-sidebar {
                width: min(86vw, 300px) !important;
                transform: translateX(-100%) !important;
            }

            body .admin-sidebar.show {
                transform: translateX(0) !important;
            }

            .sidebar-close {
                display: grid;
            }

            .content {
                margin-left: 0;
            }

            .navbar {
                grid-template-columns: 44px minmax(0, 1fr) auto;
                grid-template-rows: 44px 44px;
                gap: 8px 10px;
                min-height: 126px;
                padding: 10px 12px;
            }

            .navbar-menu-toggle {
                display: grid;
                grid-column: 1;
                grid-row: 1;
            }

            .navbar-left {
                display: block;
                grid-column: 2;
                grid-row: 1;
                min-width: 0;
            }

            .navbar-breadcrumb {
                display: none;
            }

            .navbar-title {
                margin: 0;
                font-size: 17px;
                line-height: 44px;
            }

            .navbar-center {
                grid-column: 1 / -1;
                grid-row: 2;
                min-width: 0;
            }

            .navbar-right {
                grid-column: 3;
                grid-row: 1;
                justify-content: flex-end;
                gap: 6px;
            }

            .navbar-meta,
            .notif {
                display: none;
            }

            .search-box input {
                height: 44px;
                font-size: 12px;
            }

            .profile-trigger {
                padding: 3px;
                border: 0;
                background: transparent;
            }

            .profile-trigger img,
            .profile-trigger .profile-avatar-fallback {
                width: 38px;
                height: 38px;
                flex-basis: 38px;
            }

            .profile-info,
            .profile-trigger > i {
                display: none;
            }

            .profile-menu {
                top: calc(100% + 8px);
                right: 0;
                width: min(230px, calc(100vw - 24px));
            }

            .admin-main {
                padding: 18px 12px;
            }

            .sidebar-bottom {
                grid-template-columns: 1fr;
            }

            .sidebar-bottom a,
            .sidebar-bottom button {
                justify-content: flex-start;
                padding-inline: 13px;
                font-size: 11px;
            }
        }

        @media (max-width: 480px) {
            .navbar {
                padding-inline: 10px;
            }

            .admin-main {
                padding: 14px 10px;
            }

            .admin-sidebar .admin-side-section-label {
                margin-top: 4px !important;
                padding-top: 3px !important;
                padding-bottom: 3px !important;
            }

            .admin-sidebar .admin-side-menu-item {
                margin-bottom: 2px !important;
            }

            .admin-sidebar .admin-side-menu-link {
                min-height: 41px !important;
                padding: 8px 10px !important;
                font-size: 11px !important;
            }

            .sidebar-top {
                padding-right: 56px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

<div class="wrapper">

    @include('admin.components.sidebar')

    <div
        class="sidebar-overlay"
        data-sidebar-overlay
    ></div>

    <div class="content">

        @include('admin.components.navbar')

        <main class="admin-main">
            @yield('content')
        </main>

        @include('admin.components.footer')

    </div>

</div>

@stack('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;

    /* =====================================================
       SIDEBAR MOBILE
    ===================================================== */

    const sidebar = document.querySelector('.sidebar');
    const sidebarToggle = document.querySelector(
        '[data-sidebar-toggle]'
    );
    const sidebarClose = document.querySelector(
        '[data-sidebar-close]'
    );
    const sidebarOverlay = document.querySelector(
        '[data-sidebar-overlay]'
    );

    function openSidebar() {
        if (!sidebar) {
            return;
        }

        sidebar.classList.add('show');
        sidebarOverlay?.classList.add('show');
        body.classList.add('admin-overlay-open');
        sidebarToggle?.setAttribute('aria-expanded', 'true');
    }

    function closeSidebar() {
        if (!sidebar) {
            return;
        }

        sidebar.classList.remove('show');
        sidebarOverlay?.classList.remove('show');
        body.classList.remove('admin-overlay-open');
        sidebarToggle?.setAttribute('aria-expanded', 'false');
    }

    sidebarToggle?.addEventListener('click', openSidebar);
    sidebarClose?.addEventListener('click', closeSidebar);
    sidebarOverlay?.addEventListener('click', closeSidebar);

    sidebar
        ?.querySelectorAll('.admin-side-menu-link')
        .forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 991) {
                    closeSidebar();
                }
            });
        });

    /* =====================================================
       DROPDOWN PROFIL
    ===================================================== */

    const profileDropdown = document.querySelector('.js-dropdown');
    const profileTrigger = document.querySelector(
        '.js-profile-trigger'
    );
    const profileMenu = document.querySelector('.js-profile-menu');

    function closeProfileMenu() {
        profileMenu?.classList.remove('show');
        profileTrigger?.setAttribute('aria-expanded', 'false');
    }

    profileTrigger?.addEventListener('click', function (event) {
        event.stopPropagation();

        const opened = profileMenu?.classList.toggle('show');

        profileTrigger.setAttribute(
            'aria-expanded',
            opened ? 'true' : 'false'
        );
    });

    /* =====================================================
       PENCARIAN MENU
    ===================================================== */

    const searchBox = document.querySelector('.search-box');
    const searchInput = document.getElementById('navbar-search');
    const searchResults = document.getElementById(
        'navbar-search-results'
    );

    let searchItems = [];

    try {
        searchItems = JSON.parse(
            searchBox?.dataset.searchItems || '[]'
        );
    } catch (error) {
        searchItems = [];
    }

    function hideSearchResults() {
        searchResults?.classList.remove('show');

        if (searchResults) {
            searchResults.innerHTML = '';
        }
    }

    function renderSearchResults(keyword) {
        if (!searchResults) {
            return;
        }

        const normalizedKeyword = keyword
            .trim()
            .toLowerCase();

        if (!normalizedKeyword) {
            hideSearchResults();
            return;
        }

        const matches = searchItems
            .filter(function (item) {
                return item.label
                    .toLowerCase()
                    .includes(normalizedKeyword);
            })
            .slice(0, 8);

        searchResults.innerHTML = '';

        if (!matches.length) {
            const emptyItem = document.createElement('li');

            emptyItem.innerHTML = `
                <span class="search-empty">
                    <i class="bi bi-search"></i>
                    Menu tidak ditemukan
                </span>
            `;

            searchResults.appendChild(emptyItem);
            searchResults.classList.add('show');
            return;
        }

        matches.forEach(function (item) {
            const listItem = document.createElement('li');
            const link = document.createElement('a');

            link.href = item.url;
            link.innerHTML = `
                <i class="bi bi-arrow-right-circle"></i>
                <span>${item.label}</span>
            `;

            listItem.appendChild(link);
            searchResults.appendChild(listItem);
        });

        searchResults.classList.add('show');
    }

    searchInput?.addEventListener('input', function () {
        renderSearchResults(this.value);
    });

    searchInput?.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            const firstLink = searchResults?.querySelector('a');

            if (firstLink) {
                event.preventDefault();
                window.location.href = firstLink.href;
            }
        }
    });

    /* =====================================================
       TANGGAL DAN WAKTU
    ===================================================== */

    const dateElement = document.getElementById('navbar-date');
    const timeElement = document.getElementById('navbar-time');

    function updateDateTime() {
        const now = new Date();

        if (dateElement) {
            dateElement.textContent = new Intl.DateTimeFormat(
                'id-ID',
                {
                    weekday: 'long',
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                }
            ).format(now);
        }

        if (timeElement) {
            timeElement.textContent = new Intl.DateTimeFormat(
                'id-ID',
                {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                }
            ).format(now);
        }
    }

    updateDateTime();
    window.setInterval(updateDateTime, 1000);

    /* =====================================================
       KLIK DI LUAR DAN ESCAPE
    ===================================================== */

    document.addEventListener('click', function (event) {
        if (
            profileDropdown &&
            !profileDropdown.contains(event.target)
        ) {
            closeProfileMenu();
        }

        if (
            searchBox &&
            !searchBox.contains(event.target)
        ) {
            hideSearchResults();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeProfileMenu();
            hideSearchResults();
            closeSidebar();
        }
    });
});
</script>

</body>
</html>
