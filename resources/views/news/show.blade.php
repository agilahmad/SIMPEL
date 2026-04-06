<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $news->title }} — CSIRT MKRI</title>
     
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors.min.css') }}">
   
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #2563EB;
            --primary-hover: #1D4ED8;
            --primary-light: #EFF6FF;
            --primary-mid: #DBEAFE;
            --accent: #0EA5E9;
            --accent-light: #E0F2FE;
            --success: #10B981;
            --text-dark: #0F172A;
            --text-mid: #334155;
            --text-muted: #64748B;
            --text-light: #94A3B8;
            --border: #E2E8F0;
            --border-light: #F1F5F9;
            --bg: #F8FAFF;
            --shadow: 0 4px 20px rgba(37, 99, 235, .08), 0 1px 4px rgba(0, 0, 0, .04);
            --shadow-lg: 0 12px 40px rgba(37, 99, 235, .12), 0 4px 12px rgba(0, 0, 0, .06);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text-dark);
            overflow-x: hidden;
            line-height: 1.6;
        }

        .sms-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            height: 68px;
            background: rgba(255, 255, 255, .93);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--border);
            transition: box-shadow .3s;
        }

        .sms-nav.scrolled {
            box-shadow: var(--shadow);
        }

        .sms-nav-inner {
            height: 100%;
            display: flex;
            align-items: center;
            padding: 0 32px;
            gap: 24px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .sms-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .sms-logo-img {
            height: 36px;
            width: auto;
            display: block;
        }

        .sms-logo-text {
            line-height: 1;
        }

        .sms-logo-text strong {
            display: block;
            font-size: 14px;
            font-weight: 800;
            color: var(--text-dark);
        }

        .sms-logo-text small {
            display: block;
            font-size: 9px;
            font-weight: 500;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .sms-nav-list {
            list-style: none;
            margin: 0 auto;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .sms-nav-list a {
            display: block;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 13.5px;
            font-weight: 500;
            padding: 7px 12px;
            border-radius: 8px;
            transition: color .2s, background .2s;
        }

        .sms-nav-list a:hover {
            color: var(--primary);
            background: var(--primary-light);
        }

        .sms-btn-login {
            flex-shrink: 0;
            background: var(--primary);
            color: #fff;
            padding: 8px 20px;
            border-radius: 9px;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            transition: background .2s, box-shadow .2s, transform .2s;
            white-space: nowrap;
        }

        .sms-btn-login:hover {
            background: var(--primary-hover);
            box-shadow: 0 6px 20px rgba(37, 99, 235, .35);
            transform: translateY(-1px);
            color: #fff;
        }

        .sms-hamburger {
            display: none;
            flex-direction: column;
            justify-content: center;
            gap: 5px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 4px;
            flex-shrink: 0;
            margin-left: auto;
        }

        .sms-hamburger span {
            display: block;
            width: 22px;
            height: 2px;
            background: var(--text-dark);
            border-radius: 2px;
            transition: all .3s;
        }

        .sms-mobile-nav {
            display: none;
            position: fixed;
            top: 68px;
            left: 0;
            right: 0;
            bottom: 0;
            background: #fff;
            z-index: 1049;
            padding: 24px 20px;
            flex-direction: column;
            gap: 4px;
            border-top: 1px solid var(--border);
            overflow-y: auto;
        }

        .sms-mobile-nav.open {
            display: flex;
        }

        .sms-mobile-nav a {
            display: block;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 15px;
            font-weight: 600;
            padding: 12px 16px;
            border-radius: 10px;
            transition: color .2s, background .2s;
        }

        .sms-mobile-nav a:hover {
            color: var(--primary);
            background: var(--primary-light);
        }

        .sms-mobile-nav .sms-mobile-login {
            margin-top: 12px;
            background: var(--primary);
            color: #fff;
            text-align: center;
            border-radius: 10px;
        }

        .sms-mobile-nav .sms-mobile-login:hover {
            background: var(--primary-hover);
            color: #fff;
        }

        .page-wrap {
            padding-top: 68px;
            min-height: 100vh;
        }

        .hero-banner {
            position: relative;
            width: 100%;
            height: 420px;
            overflow: hidden;
            background: linear-gradient(135deg, #0F172A 0%, #1E3A8A 50%, #0C2A50 100%);
        }

        .hero-banner-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            opacity: .35;
        }

        .hero-banner-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(15, 23, 42, .3) 0%, rgba(15, 23, 42, .75) 100%);
        }

        .hero-banner-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, .03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .03) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        .hero-banner-content {
            position: relative;
            z-index: 2;
            height: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 32px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding-bottom: 52px;
        }

        .hero-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .hero-breadcrumb a {
            font-size: 12px;
            font-weight: 600;
            color: rgba(255, 255, 255, .6);
            text-decoration: none;
            transition: color .2s;
        }

        .hero-breadcrumb a:hover {
            color: #fff;
        }

        .hero-breadcrumb-sep {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .3);
            flex-shrink: 0;
        }

        .hero-breadcrumb span {
            font-size: 12px;
            font-weight: 600;
            color: rgba(255, 255, 255, .4);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 300px;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(37, 99, 235, .35);
            border: 1px solid rgba(37, 99, 235, .5);
            color: #93C5FD;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 100px;
            margin-bottom: 16px;
            width: fit-content;
        }

        .hero-tag-dot {
            width: 6px;
            height: 6px;
            background: #60A5FA;
            border-radius: 50%;
            animation: blink 2s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .3
            }
        }

        .hero-title {
            font-size: clamp(22px, 3.5vw, 40px);
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            letter-spacing: -.8px;
            max-width: 780px;
            margin-bottom: 20px;
        }

        .hero-meta-row {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .hero-meta-item {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 12.5px;
            color: rgba(255, 255, 255, .6);
            font-weight: 500;
        }

        .hero-meta-item svg {
            width: 14px;
            height: 14px;
            stroke: rgba(255, 255, 255, .5);
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
        }

        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 56px 32px 80px;
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 40px;
            align-items: start;
        }

        .article-body {
            min-width: 0;
        }

        .article-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .article-cover {
            width: 100%;
            max-height: 460px;
            object-fit: cover;
            display: block;
        }

        .article-cover-placeholder {
            width: 100%;
            height: 280px;
            background: linear-gradient(135deg, var(--primary-mid), var(--accent-light));
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .article-cover-placeholder svg {
            width: 56px;
            height: 56px;
            stroke: var(--primary);
            fill: none;
            stroke-width: 1.5;
            opacity: .4;
        }

        .article-prose {
            padding: 40px 44px 44px;
        }

        .article-prose h1,
        .article-prose h2,
        .article-prose h3,
        .article-prose h4 {
            font-weight: 800;
            line-height: 1.25;
            color: var(--text-dark);
            margin-top: 32px;
            margin-bottom: 12px;
            letter-spacing: -.4px;
        }

        .article-prose h1 {
            font-size: 26px;
        }

        .article-prose h2 {
            font-size: 22px;
        }

        .article-prose h3 {
            font-size: 18px;
        }

        .article-prose h4 {
            font-size: 15px;
        }

        .article-prose p {
            font-size: 15.5px;
            color: var(--text-mid);
            line-height: 1.85;
            margin-bottom: 20px;
        }

        .article-prose ul,
        .article-prose ol {
            padding-left: 22px;
            margin-bottom: 20px;
            color: var(--text-mid);
            font-size: 15.5px;
            line-height: 1.85;
        }

        .article-prose li {
            margin-bottom: 6px;
        }

        .article-prose a {
            color: var(--primary);
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .article-prose a:hover {
            color: var(--primary-hover);
        }

        .article-prose blockquote {
            border-left: 3px solid var(--primary);
            padding: 14px 20px;
            margin: 24px 0;
            background: var(--primary-light);
            border-radius: 0 10px 10px 0;
            color: var(--text-mid);
            font-size: 15px;
            font-style: italic;
            line-height: 1.75;
        }

        .article-prose img {
            max-width: 100%;
            border-radius: 12px;
            margin: 24px 0;
            display: block;
        }

        .article-prose strong {
            color: var(--text-dark);
            font-weight: 700;
        }

        .article-prose hr {
            border: none;
            border-top: 1px solid var(--border);
            margin: 32px 0;
        }

        .article-prose code {
            background: var(--border-light);
            padding: 2px 7px;
            border-radius: 5px;
            font-size: 13.5px;
            color: var(--primary);
            font-family: monospace;
        }

        .article-prose pre {
            background: #0F172A;
            color: #E2E8F0;
            padding: 20px 24px;
            border-radius: 12px;
            overflow-x: auto;
            margin: 24px 0;
            font-size: 13.5px;
            line-height: 1.7;
        }

        .article-prose pre code {
            background: transparent;
            color: inherit;
            padding: 0;
        }

        .share-strip {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 44px;
            border-top: 1px solid var(--border-light);
            background: var(--bg);
            flex-wrap: wrap;
        }

        .share-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            margin-right: 4px;
        }

        .share-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            border: 1.5px solid var(--border);
            color: var(--text-mid);
            background: #fff;
            cursor: pointer;
            transition: all .2s;
        }

        .share-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }

        .share-btn svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .share-btn.copy-done {
            border-color: var(--success);
            color: var(--success);
            background: #D1FAE5;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 9px;
            border: 1.5px solid var(--border);
            background: #fff;
            color: var(--text-mid);
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            margin-bottom: 28px;
            transition: all .2s;
        }

        .back-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }

        .back-btn svg {
            width: 15px;
            height: 15px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 24px;
            position: sticky;
            top: 88px;
        }

        .sidebar-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .sidebar-card-header {
            padding: 18px 22px 14px;
            border-bottom: 1px solid var(--border-light);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sidebar-card-header::before {
            content: '';
            width: 14px;
            height: 2px;
            background: var(--primary);
            border-radius: 2px;
            display: block;
        }

        .info-row {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 16px 22px;
            border-bottom: 1px solid var(--border-light);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-row-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .info-row-icon svg {
            width: 15px;
            height: 15px;
            stroke: var(--primary);
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .info-row-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            margin-bottom: 3px;
        }

        .info-row-value {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-dark);
            line-height: 1.4;
        }

        .related-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 14px 22px;
            text-decoration: none;
            border-bottom: 1px solid var(--border-light);
            transition: background .2s;
        }

        .related-item:last-child {
            border-bottom: none;
        }

        .related-item:hover {
            background: var(--primary-light);
        }

        .related-thumb {
            width: 52px;
            height: 52px;
            border-radius: 10px;
            flex-shrink: 0;
            overflow: hidden;
            background: linear-gradient(135deg, var(--primary-mid), var(--accent-light));
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .related-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .related-thumb svg {
            width: 22px;
            height: 22px;
            stroke: var(--primary);
            fill: none;
            stroke-width: 1.8;
            opacity: .5;
        }

        .related-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.4;
            margin-bottom: 4px;
            transition: color .2s;
        }

        .related-item:hover .related-title {
            color: var(--primary);
        }

        .related-date {
            font-size: 11px;
            color: var(--text-light);
            font-weight: 500;
        }

        .toc-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .toc-list li {
            border-bottom: 1px solid var(--border-light);
        }

        .toc-list li:last-child {
            border-bottom: none;
        }

        .toc-list a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 22px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            transition: all .2s;
        }

        .toc-list a:hover {
            color: var(--primary);
            background: var(--primary-light);
        }

        .toc-list a::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--border);
            flex-shrink: 0;
            transition: background .2s;
        }

        .toc-list a:hover::before {
            background: var(--primary);
        }

        .sms-footer {
            padding: 48px 0 28px;
            background: #fff;
            border-top: 1px solid var(--border);
            margin-top: 24px;
        }

        .sms-footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 32px;
            display: grid;
            grid-template-columns: 1fr 1.3fr 1fr;
            gap: 40px;
        }

        .sms-fcol-title {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: var(--text-dark);
            margin-bottom: 14px;
        }

        .sms-flinks {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sms-flinks a {
            text-decoration: none;
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
            transition: color .2s;
        }

        .sms-flinks a:hover {
            color: var(--primary);
        }

        .sms-footer-bottom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 32px 0;
            border-top: 1px solid var(--border);
            margin-top: 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .sms-footer-copy {
            font-size: 12.5px;
            color: var(--text-muted);
        }

        @media (max-width: 1023px) {
            .main-content {
                grid-template-columns: 1fr;
                gap: 32px;
                padding: 40px 24px 64px;
            }

            .sidebar {
                position: static;
            }
        }

        @media (max-width: 767px) {
            .hero-banner {
                height: 340px;
            }

            .hero-title {
                font-size: clamp(18px, 5vw, 28px);
            }

            .hero-banner-content {
                padding: 0 20px 36px;
            }

            .article-prose {
                padding: 24px 22px 28px;
            }

            .share-strip {
                padding: 16px 22px;
            }

            .main-content {
                padding: 28px 16px 56px;
            }

            .sms-nav-inner {
                padding: 0 20px;
            }

            .sms-nav-list,
            .sms-btn-login {
                display: none !important;
            }

            .sms-hamburger {
                display: flex;
            }

            .sms-footer-inner {
                grid-template-columns: 1fr;
                gap: 28px;
            }

            .back-btn {
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>

    <nav class="sms-nav" id="smsNav">
        <div class="sms-nav-inner">
            <a href="/" class="sms-logo">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="sms-logo-img">
                <div class="sms-logo-text">
                    <strong>CSIRT</strong>
                    <small>Mahkamah Konstitusi</small>
                </div>
            </a>
            <ul class="sms-nav-list">
                <li><a href="/">Home</a></li>
                <li><a href="/#beranda">Beranda</a></li>
                <li><a href="/#tentang">Tentang</a></li>
                <li><a href="/#rcf">RCF</a></li>
                <li><a href="/#pedoman">Pedoman</a></li>
                <li><a href="/#berita" style="color:var(--primary);font-weight:600;">Berita</a></li>
                <li><a href="/#hubungi">Hubungi Kami</a></li>
            </ul>
            @guest
                <a href="{{ route('login') }}"
                    class="sms-btn-login d-none d-lg-inline-flex align-items-center justify-content-center text-dark"
                    title="Login">
                    Login
                </a>
            @endguest

            @auth
                <a href="{{ route('dashboard') }}"
                    class="sms-btn-login d-none d-lg-inline-flex align-items-center justify-content-center text-dark"
                    title="Dashboard">
                    Dashboard
                </a>
            @endauth
            <button class="sms-hamburger" id="smsHbg" onclick="smsToggle()" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    <div class="sms-mobile-nav" id="smsMM">
        <a href="/" onclick="smsClose()">Home</a>
        <a href="/#beranda" onclick="smsClose()">Beranda</a>
        <a href="/#tentang" onclick="smsClose()">Tentang</a>
        <a href="/#rcf" onclick="smsClose()">RCF</a>
        <a href="/#pedoman" onclick="smsClose()">Pedoman</a>
        <a href="/#berita" onclick="smsClose()">Berita</a>
        <a href="/#hubungi" onclick="smsClose()">Hubungi Kami</a>
        <a href="{{ route('login') }}" onclick="smsClose()" class="sms-mobile-login">Login</a>
    </div>

    <div class="page-wrap">

        <div class="hero-banner">
            @if ($news->image)
                <img src="{{ asset($news->image) }}" alt="{{ $news->title }}" class="hero-banner-img">
            @endif
            <div class="hero-banner-grid"></div>
            <div class="hero-banner-overlay"></div>
            <div class="hero-banner-content">
                <div class="hero-breadcrumb">
                    <a href="/">Home</a>
                    <div class="hero-breadcrumb-sep"></div>
                    <a href="/#berita">Berita</a>
                    <div class="hero-breadcrumb-sep"></div>
                    <span>{{ Str::limit($news->title, 40) }}</span>
                </div>
                <div class="hero-tag">
                    <div class="hero-tag-dot"></div>
                    Berita
                </div>
                <h1 class="hero-title">{{ $news->title }}</h1>
                <div class="hero-meta-row">
                    {{-- <div class="hero-meta-item">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ $news->created_at->translatedFormat('d F Y') }}
                </div> --}}
                    <div class="hero-meta-item">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                        {{ max(1, (int) (str_word_count(strip_tags($news->content)) / 200)) }} menit baca
                    </div>
                </div>
            </div>
        </div>

        <div class="main-content">

            <div class="article-body">
                <a href="{{ url()->previous() }}" class="back-btn">
                    <svg viewBox="0 0 24 24">
                        <path d="M19 12H5M12 5l-7 7 7 7" />
                    </svg>
                    Kembali
                </a>

                <div class="article-card">
                    @if ($news->image)
                        <img src="{{ asset($news->image) }}" alt="{{ $news->title }}" class="article-cover">
                    @else
                        <div class="article-cover-placeholder">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                            </svg>
                        </div>
                    @endif
                    <div class="article-prose">
                        {!! $news->content !!}
                    </div>
                    <div class="share-strip">
                        <span class="share-label">Bagikan</span>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($news->title) }}&url={{ urlencode(request()->url()) }}"
                            target="_blank" rel="noopener" class="share-btn">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M23 3a10.9 10.9 0 0 1-3.14 1.53A4.48 4.48 0 0 0 22.43.36a9 9 0 0 1-2.88 1.1 4.52 4.52 0 0 0-7.69 4.12A12.81 12.81 0 0 1 2.5.67a4.52 4.52 0 0 0 1.4 6.03A4.42 4.42 0 0 1 1.64 6v.06a4.51 4.51 0 0 0 3.62 4.42 4.56 4.56 0 0 1-2.04.08 4.52 4.52 0 0 0 4.22 3.13A9.06 9.06 0 0 1 2 19.54 12.8 12.8 0 0 0 8.94 21.5c8.3 0 12.84-6.88 12.84-12.85 0-.2 0-.39-.02-.58A9.16 9.16 0 0 0 24 5.56z" />
                            </svg>
                            Twitter
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                            target="_blank" rel="noopener" class="share-btn">
                            <svg viewBox="0 0 24 24">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                            </svg>
                            Facebook
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($news->title . ' ' . request()->url()) }}"
                            target="_blank" rel="noopener" class="share-btn">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                            </svg>
                            WhatsApp
                        </a>
                        <button class="share-btn" id="copyBtn" onclick="copyLink()">
                            <svg viewBox="0 0 24 24">
                                <rect x="9" y="9" width="13" height="13" rx="2" />
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                            </svg>
                            Salin Tautan
                        </button>
                    </div>
                </div>
            </div>

            <aside class="sidebar">

                {{-- <div class="sidebar-card">
                <div class="sidebar-card-header">Informasi Artikel</div>
                <div class="info-row">
                    <div class="info-row-icon">
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <div>
                        <div class="info-row-label">Diterbitkan</div>
                        <div class="info-row-value">{{ $news->created_at->translatedFormat('d F Y') }}</div>
                    </div>
                </div>
                @if ($news->updated_at->ne($news->created_at))
                <div class="info-row">
                    <div class="info-row-icon">
                        <svg viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                    </div>
                    <div>
                        <div class="info-row-label">Diperbarui</div>
                        <div class="info-row-value">{{ $news->updated_at->translatedFormat('d F Y') }}</div>
                    </div>
                </div>
                @endif
                <div class="info-row">
                    <div class="info-row-icon">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </div>
                    <div>
                        <div class="info-row-label">Estimasi Baca</div>
                        <div class="info-row-value">{{ max(1, (int)(str_word_count(strip_tags($news->content)) / 200)) }} menit</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-row-icon">
                        <svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                    </div>
                    <div>
                        <div class="info-row-label">Slug</div>
                        <div class="info-row-value" style="font-size:12px;word-break:break-all;color:var(--text-muted);">{{ $news->slug }}</div>
                    </div>
                </div>
            </div> --}}

                @php
                    $related = \App\Models\News::where('id', '!=', $news->id)->latest()->take(4)->get();
                @endphp
                @if ($related->count() > 0)
                    <div class="sidebar-card">
                        <div class="sidebar-card-header">Berita Lainnya</div>
                        @foreach ($related as $item)
                            <a href="{{ route('news.show', $item->slug) }}" class="related-item">
                                <div class="related-thumb">
                                    @if ($item->image)
                                        <img src="{{ asset($item->image) }}" alt="{{ $item->title }}">
                                    @else
                                        <svg viewBox="0 0 24 24">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                            <polyline points="14 2 14 8 20 8" />
                                        </svg>
                                    @endif
                                </div>
                                <div style="min-width:0;">
                                    <div class="related-title">{{ Str::limit($item->title, 60) }}</div>
                                    <div class="related-date">{{ $item->created_at->translatedFormat('d M Y') }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

            </aside>

        </div>

    </div>

    <footer class="sms-footer">
        <div class="sms-footer-inner">
            <div>
                <h3 style="margin-bottom:12px;font-weight:800;font-size:16px;">MKRI</h3>
                <p style="font-size:13px;color:var(--text-muted);line-height:1.75;">
                    Jl. Medan Merdeka Barat No.6.<br>
                    Jakarta Pusat, 10110<br>
                    Indonesia
                </p>
                <p style="margin-top:10px;font-size:13px;color:var(--text-muted);line-height:1.75;">
                    <strong>Telepon:</strong> +6221 23529000<br>
                    <strong>Email:</strong> office@mkri.id
                </p>
            </div>
            <div>
                <h5 class="sms-fcol-title">UNIT KERJA</h5>
                <ul class="sms-flinks">
                    <li><a href="https://kepaniteraan.mkri.id/" target="_blank">Kepaniteraan</a></li>
                    <li><a href="https://perencanaan.mkri.id/" target="_blank">Biro Perencanaan dan Keuangan</a></li>
                    <li><a href="https://sdm.mkri.id/" target="_blank">Biro Sumber Daya Manusia dan Organisasi</a>
                    </li>
                    <li><a href="https://hukum.mkri.id/" target="_blank">Biro Hukum dan Administrasi Kepaniteraan</a>
                    </li>
                    <li><a href="https://humas.mkri.id/" target="_blank">Biro Hubungan Masyarakat dan Protokol</a>
                    </li>
                    <li><a href="https://umum.mkri.id/" target="_blank">Biro Umum</a></li>
                    <li><a href="https://pusdik.mkri.id/" target="_blank">Pusat Pendidikan Pancasila dan
                            Konstitusi</a></li>
                    <li><a href="https://puslit.mkri.id/" target="_blank">Pusat Penelitian Pengkajian Perkara, dan
                            Pengelolaan Pustaka</a></li>
                    <li><a href="https://inspektorat.mkri.id/" target="_blank">Inspektorat</a></li>
                </ul>
            </div>
            <div>
                <h5 class="sms-fcol-title">MEDIA SOSIAL</h5>
                <ul class="sms-flinks">
                    <li><a href="https://x.com/officialMKRI" target="_blank">Twitter</a></li>
                    <li><a href="https://www.facebook.com/officialMKRI" target="_blank">Facebook</a></li>
                    <li><a href="https://www.instagram.com/mahkamahkonstitusi/" target="_blank">Instagram</a></li>
                    <li><a href="https://www.youtube.com/mahkamahkonstitusi" target="_blank">YouTube</a></li>
                </ul>
            </div>
        </div>
        <div class="sms-footer-bottom">
            <p class="sms-footer-copy">© {{ date('Y') }} MKRI. All Rights Reserved</p>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', function() {
            document.getElementById('smsNav').classList.toggle('scrolled', window.scrollY > 20);
        });

        function smsToggle() {
            document.getElementById('smsMM').classList.toggle('open');
        }

        function smsClose() {
            document.getElementById('smsMM').classList.remove('open');
        }

        function copyLink() {
            navigator.clipboard.writeText(window.location.href).then(function() {
                var btn = document.getElementById('copyBtn');
                btn.classList.add('copy-done');
                btn.innerHTML =
                    '<svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><polyline points="20 6 9 17 4 12"/></svg> Tersalin!';
                setTimeout(function() {
                    btn.classList.remove('copy-done');
                    btn.innerHTML =
                        '<svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg> Salin Tautan';
                }, 2500);
            });
        }
    </script>
</body>

</html>
