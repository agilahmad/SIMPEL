<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CSIRT MKRI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors.min.css') }}">
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
            --warning: #F59E0B;
            --text-dark: #0F172A;
            --text-mid: #334155;
            --text-muted: #64748B;
            --text-light: #94A3B8;
            --border: #E2E8F0;
            --border-light: #F1F5F9;
            --bg: #F8FAFF;
            --shadow: 0 4px 20px rgba(37, 99, 235, .08), 0 1px 4px rgba(0, 0, 0, .04);
            --shadow-lg: 0 12px 40px rgba(37, 99, 235, .12), 0 4px 12px rgba(0, 0, 0, .06);
            --shadow-xl: 0 24px 64px rgba(37, 99, 235, .14), 0 8px 24px rgba(0, 0, 0, .07);
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

        .sms-nav .container-fluid {
            height: 100%;
            display: flex;
            align-items: center;
            padding: 0 32px;
            gap: 24px;
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
            margin: 0;
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

        .sms-nav-list a.active {
            color: var(--primary);
            font-weight: 600;
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

        .sms-hero-slider {
            position: relative;
            width: 100%;
            height: 100vh;
            min-height: 560px;
            overflow: hidden;
            margin-top: 68px;
        }

        .sms-slide {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            opacity: 0;
            transition: opacity .8s ease;
            pointer-events: none;
        }

        .sms-slide.active {
            opacity: 1;
            pointer-events: auto;
        }

        .sms-slide-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
        }

        .sms-slide-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(10, 30, 70, .78) 0%, rgba(10, 30, 70, .42) 60%, transparent 100%);
        }

        .sms-slide-1 .sms-slide-bg {
            background-image: url('assets/images/banner/landing1.png');
            background-color: #0A3272;
        }

        .sms-slide-2 .sms-slide-bg {
            background-image: url('assets/images/banner/landing2.jpg');
            background-color: #0C2A50;
        }

        .sms-slide-3 .sms-slide-bg {
            background-image: url('assets/images/banner/landing3.png');
            background-color: #082448;
        }

        .sms-slide-content {
            position: relative;
            z-index: 2;
            padding: 0 64px;
            max-width: 680px;
            animation: smsSlideIn .7s ease both;
        }

        @keyframes smsSlideIn {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .sms-slide-title {
            font-size: clamp(30px, 4.5vw, 58px);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -1px;
            color: #fff;
            margin-bottom: 18px;
        }

        .sms-slide-title span {
            color: #93C5FD;
        }

        .sms-slider-controls {
            position: absolute;
            bottom: 36px;
            left: 64px;
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sms-slider-dot {
            width: 8px;
            height: 8px;
            border-radius: 100px;
            background: rgba(255, 255, 255, .4);
            border: none;
            cursor: pointer;
            transition: all .3s;
            padding: 0;
        }

        .sms-slider-dot.active {
            width: 28px;
            background: #fff;
        }

        .sms-slider-arrows {
            position: absolute;
            bottom: 28px;
            right: 64px;
            z-index: 10;
            display: flex;
            gap: 8px;
        }

        .sms-slider-arr {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .25);
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .25s;
        }

        .sms-slider-arr:hover {
            background: rgba(255, 255, 255, .25);
        }

        .sms-slider-arr svg {
            pointer-events: none;
        }

        .sms-section {
            padding: 88px 0;
            background: var(--bg);
        }

        .sms-section-w {
            padding: 88px 0;
            background: #fff;
        }

        .sms-section-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--primary);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .sms-section-tag::before {
            content: '';
            width: 16px;
            height: 2px;
            background: var(--primary);
            border-radius: 2px;
        }

        .sms-section-title {
            font-size: clamp(24px, 3.5vw, 40px);
            font-weight: 800;
            line-height: 1.12;
            letter-spacing: -.8px;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .sms-section-desc {
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.75;
        }

        .sms-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary);
            color: #fff;
            padding: 12px 24px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background .2s, transform .2s, box-shadow .2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .sms-btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 99, 235, .32);
            color: #fff;
        }

        .sms-btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            color: var(--text-mid);
            padding: 12px 24px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: 1.5px solid var(--border);
            transition: all .25s;
        }

        .sms-btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .sms-rcf-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 64px;
            align-items: center;
        }

        .sms-rcf-img-wrap {
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            aspect-ratio: 4/3;
            background: linear-gradient(135deg, var(--primary-mid) 0%, var(--accent-light) 100%);
            box-shadow: var(--shadow-xl);
        }

        .sms-rcf-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .sms-rcf-img-fallback {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 16px;
        }

        .sms-rcf-img-badge {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background: rgba(255, 255, 255, .92);
            backdrop-filter: blur(10px);
            border-radius: 14px;
            padding: 14px 18px;
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sms-rcf-img-badge-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sms-rcf-img-badge-icon svg {
            width: 20px;
            height: 20px;
            stroke: #fff;
            fill: none;
            stroke-width: 2;
        }

        .sms-rcf-img-badge-text strong {
            display: block;
            font-size: 14px;
            font-weight: 800;
            color: var(--text-dark);
        }

        .sms-rcf-img-badge-text span {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .sms-rcf-content {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .sms-ped-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .sms-ped-grid>*:nth-child(4) {
            grid-column: 1 / 2;
        }

        .sms-ped-grid>*:nth-child(5) {
            grid-column: 2 / 3;
        }

        .sms-ped-link-card {
            display: flex;
            flex-direction: column;
            gap: 20px;
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            text-decoration: none;
            transition: border-color .25s, box-shadow .25s, transform .25s;
        }

        .sms-ped-link-card:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-lg);
            transform: translateY(-3px);
        }

        .sms-ped-link-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sms-ped-link-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            flex-shrink: 0;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .25s;
        }

        .sms-ped-link-card:hover .sms-ped-link-icon {
            background: var(--primary);
        }

        .sms-ped-link-icon svg {
            width: 22px;
            height: 22px;
            stroke: var(--primary);
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            transition: stroke .25s;
        }

        .sms-ped-link-card:hover .sms-ped-link-icon svg {
            stroke: #fff;
        }

        .sms-ped-link-arr {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            flex-shrink: 0;
            border: 1.5px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .25s;
        }

        .sms-ped-link-arr svg {
            width: 14px;
            height: 14px;
            stroke: var(--text-light);
            fill: none;
            stroke-width: 2.5;
            transition: all .25s;
        }

        .sms-ped-link-card:hover .sms-ped-link-arr {
            background: var(--primary);
            border-color: var(--primary);
            transform: rotate(45deg);
        }

        .sms-ped-link-card:hover .sms-ped-link-arr svg {
            stroke: #fff;
        }

        .sms-ped-link-tag {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .sms-ped-link-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            line-height: 1.45;
            transition: color .25s;
        }

        .sms-ped-link-card:hover .sms-ped-link-title {
            color: var(--primary);
        }

        .sms-news-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
            height: 100%;
            transition: border-color .25s, box-shadow .25s, transform .25s;
        }

        .sms-news-card:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
        }

        .sms-news-img {
            height: 160px;
            background: linear-gradient(135deg, var(--primary-light), var(--accent-light));
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sms-news-card.featured .sms-news-img {
            height: 210px;
        }

        .sms-news-img-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow);
        }

        .sms-news-img-icon svg {
            width: 26px;
            height: 26px;
            stroke: var(--primary);
            fill: none;
            stroke-width: 1.8;
        }

        .sms-news-body {
            padding: 20px;
        }

        .sms-news-title {
            font-size: 14px;
            font-weight: 700;
            line-height: 1.45;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .sms-news-card.featured .sms-news-title {
            font-size: 17px;
        }

        .sms-news-excerpt {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.65;
            margin-bottom: 14px;
        }

        .sms-news-meta {
            font-size: 11px;
            color: var(--text-light);
            font-weight: 500;
        }

        .sms-con-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .sms-con-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 20px;
            padding: 28px 24px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
            transition: border-color .25s, box-shadow .25s, transform .25s;
        }

        .sms-con-card:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
        }

        .sms-con-card-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .25s;
        }

        .sms-con-card:hover .sms-con-card-icon {
            background: var(--primary);
        }

        .sms-con-card-icon svg {
            width: 24px;
            height: 24px;
            stroke: var(--primary);
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            transition: stroke .25s;
        }

        .sms-con-card:hover .sms-con-card-icon svg {
            stroke: #fff;
        }

        .sms-con-card-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-muted);
            margin-bottom: 5px;
        }

        .sms-con-card-value {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            line-height: 1.5;
        }

        .sms-con-card-sub {
            font-size: 12px;
            color: var(--text-muted);
            margin: 4px 0 0;
        }

        .sms-footer {
            padding: 60px 0 36px;
            background: #fff;
            border-top: 1px solid var(--border);
        }

        .sms-footer-brand-desc {
            font-size: 13.5px;
            color: var(--text-muted);
            line-height: 1.75;
            max-width: 280px;
            margin-top: 14px;
        }

        .sms-fcol-title {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: var(--text-dark);
            margin-bottom: 18px;
        }

        .sms-flinks {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .sms-flinks a {
            text-decoration: none;
            font-size: 13.5px;
            color: var(--text-muted);
            font-weight: 500;
            transition: color .2s;
        }

        .sms-flinks a:hover {
            color: var(--primary);
        }

        .sms-footer-bottom {
            border-top: 1px solid var(--border);
            padding-top: 28px;
            margin-top: 48px;
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

        .sms-dot-online {
            width: 7px;
            height: 7px;
            background: var(--success);
            border-radius: 50%;
            display: inline-block;
            animation: smsBlink 2s infinite;
        }

        @keyframes smsBlink {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .35
            }
        }

        .sms-reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity .6s ease, transform .6s ease;
        }

        .sms-reveal.on {
            opacity: 1;
            transform: translateY(0);
        }

        .gt-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
        }

        .gt-label {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 600;
        }

        #google_translate_element .goog-te-gadget-simple {
            border: 1.5px solid var(--border) !important;
            border-radius: 8px !important;
            padding: 6px 10px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 13px !important;
            cursor: pointer;
            background: #fff !important;
        }

        #google_translate_element .goog-te-gadget-simple span {
            color: var(--text-dark) !important;
            font-weight: 600 !important;
        }

        #google_translate_element .goog-te-gadget-simple .goog-te-menu-value span:last-child {
            display: none;
        }

        .goog-te-banner-frame {
            display: none !important;
        }

        body {
            top: 0 !important;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -12px;
        }

        .row>* {
            padding: 0 12px;
        }

        .col-lg-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }

        .col-lg-4 {
            flex: 0 0 33.333%;
            max-width: 33.333%;
        }

        .col-lg-5 {
            flex: 0 0 41.666%;
            max-width: 41.666%;
        }

        .col-lg-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-lg-7 {
            flex: 0 0 58.333%;
            max-width: 58.333%;
        }

        .g-3 {
            gap: 16px;
            margin: 0;
        }

        .g-3>* {
            padding: 0;
        }

        .g-4 {
            gap: 24px;
            margin: 0;
        }

        .g-4>* {
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .container-fluid {
            max-width: 100%;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-2 {
            margin-bottom: 8px;
        }

        .mb-5 {
            margin-bottom: 48px;
        }

        .mt-3 {
            margin-top: 16px;
        }

        .text-center {
            text-align: center;
        }

        .d-flex {
            display: flex;
        }

        .d-none {
            display: none;
        }

        .align-items-center {
            align-items: center;
        }

        .align-items-end {
            align-items: flex-end;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .flex-wrap {
            flex-wrap: wrap;
        }

        .gap-3 {
            gap: 16px;
        }

        @media (min-width: 992px) {
            .d-lg-flex {
                display: flex !important;
            }

            .d-lg-inline-flex {
                display: inline-flex !important;
            }
        }

        @media (max-width: 991.98px) {

            .sms-nav-list,
            .sms-btn-login {
                display: none !important;
            }

            .sms-hamburger {
                display: flex;
            }

            .sms-slide-content {
                padding: 0 32px;
            }

            .sms-slider-controls {
                left: 32px;
            }

            .sms-slider-arrows {
                right: 32px;
            }

            .sms-rcf-layout {
                grid-template-columns: 1fr;
            }

            .sms-con-grid {
                grid-template-columns: 1fr 1fr;
            }

            .sms-ped-grid {
                grid-template-columns: 1fr 1fr;
            }

            .sms-ped-grid>*:nth-child(4) {
                grid-column: auto;
            }

            .sms-ped-grid>*:nth-child(5) {
                grid-column: auto;
            }

            .col-lg-3,
            .col-lg-4,
            .col-lg-5,
            .col-lg-6,
            .col-lg-7 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }

        @media (max-width: 767.98px) {

            .sms-section,
            .sms-section-w {
                padding: 60px 0;
            }

            .sms-hero-slider {
                height: 92vh;
                min-height: 500px;
            }

            .sms-slide-content {
                padding: 0 20px;
                max-width: 100%;
            }

            .sms-slide-title {
                font-size: clamp(26px, 7vw, 40px);
            }

            .sms-slider-controls {
                left: 20px;
                bottom: 28px;
            }

            .sms-slider-arrows {
                right: 20px;
                bottom: 24px;
            }

            .sms-con-grid {
                grid-template-columns: 1fr;
            }

            .sms-ped-grid {
                grid-template-columns: 1fr;
            }

            .sms-ped-grid>*:nth-child(4) {
                grid-column: auto;
            }

            .sms-ped-grid>*:nth-child(5) {
                grid-column: auto;
            }
        }
    </style>
</head>

<body>

    <nav class="sms-nav" id="smsNav">
        <div class="container-fluid"
            style="max-width:100%;padding:0 32px;height:100%;display:flex;align-items:center;gap:24px;">
            <a href="/" class="sms-logo">
                <img src="assets/images/logo.png" alt="Logo" class="sms-logo-img">
                <div class="sms-logo-text">
                    <strong>CSIRT</strong>
                    <small>Mahkamah Konstitusi</small>
                </div>
            </a>
            <ul class="sms-nav-list d-none d-lg-flex" style="margin-left:auto;margin-right:auto;">
                <li><a href="/" class="active">Home</a></li>
                <li><a href="#beranda">Beranda</a></li>
                <li><a href="#tentang">Tentang</a></li>
                <li><a href="#rcf">RCF</a></li>
                <li><a href="#pedoman">Pedoman</a></li>
                <li><a href="#berita">Berita</a></li>
                <li><a href="#hubungi">Hubungi Kami</a></li>
            </ul>
            @guest
                <a href="{{ route('login') }}" class="sms-btn-login d-none d-lg-inline-flex align-items-center justify-content-center text-dark" title="Login">
                    Login 
                </a>
            @endguest

            @auth
                <a href="{{ route('dashboard') }}" class="sms-btn-login d-none d-lg-inline-flex align-items-center justify-content-center text-dark" title="Dashboard">
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
        <a href="#beranda" onclick="smsClose()">Beranda</a>
        <a href="#tentang" onclick="smsClose()">Tentang</a>
        <a href="#rcf" onclick="smsClose()">RCF</a>
        <a href="#pedoman" onclick="smsClose()">Pedoman</a>
        <a href="#berita" onclick="smsClose()">Berita</a>
        <a href="#hubungi" onclick="smsClose()">Hubungi Kami</a>
        <a href="/login" onclick="smsClose()" class="sms-mobile-login">Login</a>
    </div>

    <section id="beranda">
        <div class="sms-hero-slider" id="smsSlider">
            <div class="sms-slide sms-slide-1 active">
                <div class="sms-slide-bg"></div>
                <div class="sms-slide-overlay"></div>
                <div class="sms-slide-content">
                    <h1 class="sms-slide-title">MK Ikuti VVIP Program BSSN<br><span>untuk Penguatan &amp; Keamanan
                            Aplikasi</span></h1>
                </div>
            </div>
            <div class="sms-slide sms-slide-2">
                <div class="sms-slide-bg"></div>
                <div class="sms-slide-overlay"></div>
                <div class="sms-slide-content">
                    <h1 class="sms-slide-title">Benchmarking Kementerian Agama ke PUSTIK Mahkamah
                        Konstitusi;<br><span>Penguatan Pengelolaan TIK dan CSIRT</span></h1>
                </div>
            </div>
            <div class="sms-slide sms-slide-3">
                <div class="sms-slide-bg"></div>
                <div class="sms-slide-overlay"></div>
                <div class="sms-slide-content">
                    <h1 class="sms-slide-title">MK Hadiri &amp; Seminar Internasional<br><span>"Cybersecurity for
                            Indonesia's Public Sector"</span></h1>
                </div>
            </div>
            <div class="sms-slider-controls">
                <button class="sms-slider-dot active" onclick="smsGoTo(0)"></button>
                <button class="sms-slider-dot" onclick="smsGoTo(1)"></button>
                <button class="sms-slider-dot" onclick="smsGoTo(2)"></button>
            </div>
            <div class="sms-slider-arrows">
                <button class="sms-slider-arr" onclick="smsPrev()" aria-label="Previous">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M15 18l-6-6 6-6" />
                    </svg>
                </button>
                <button class="sms-slider-arr" onclick="smsNext()" aria-label="Next">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <section id="tentang" class="sms-section">
        <div class="container">
            <div class="sms-reveal mb-2">
                <div style="max-width:640px;">
                    <div class="sms-section-tag">Tentang Kami</div>
                    <h2 class="sms-section-title">MK-CSIRT Mahkamah Konstitusi</h2>
                    <p class="sms-section-desc">Computer Security Insident Response Team (CSIRT), disingkat MK-CSIRT
                        merupakan CSIRT sektor Pemerintahan Pusat yang ditetapkan oleh Sekretaris Jenderal Mahkamah
                        Konstitusi Republik Indonesia (MKRI) dalam Keputusan Nomor 4.1 Tahun 2025 tentang Penetapan
                        Computer Security Insident Response Team Mahkamah Konstitusi.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="rcf" class="sms-section-w">
        <div class="container">
            <div class="sms-rcf-layout sms-reveal">
                <div class="sms-rcf-img-wrap">
                    <img src="{{ asset('assets/images/features-4.svg') }}" alt="RCF Illustration"
                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div class="sms-rcf-img-fallback" style="display:none;position:absolute;inset:0;">
                        <svg viewBox="0 0 64 64"
                            style="width:80px;height:80px;opacity:.25;stroke:var(--primary);fill:none;stroke-width:1.5">
                            <path d="M32 6L6 16v16c0 14 11 26 26 28 15-2 26-14 26-28V16L32 6z" />
                            <polyline points="22 32 28 38 42 24" />
                        </svg>
                    </div>
                    <div class="sms-rcf-img-badge">
                        <div class="sms-rcf-img-badge-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg>
                        </div>
                        <div class="sms-rcf-img-badge-text">
                            <strong>RCF-2350</strong>
                            <span>Risk Control Framework</span>
                        </div>
                    </div>
                </div>
                <div class="sms-rcf-content">
                    <div class="sms-section-tag">Risk Control Framework</div>
                    <h2 class="sms-section-title">RCF-2350</h2>
                    <p class="sms-section-desc mx-auto" style="max-width:520px">Informasi dasar mengenai MK-CSIRT
                        dalam bahasa Indonesia, menjelaskan tanggung jawab, layanan, dan cara menghubungi MK-CSIRT.</p>
                    <div style="margin-top:32px;">
                        <a href="{{ asset('uploads/documents/RFC-2350 TTIS MK CSIRT 2025.pdf') }}" target="_blank"
                            class="sms-btn-primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="7 10 12 15 17 10" />
                                <line x1="12" y1="15" x2="12" y2="3" />
                            </svg>
                            Unduh Dokumen RCF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="pedoman" class="sms-section">
        <div class="container">
            <div class="sms-reveal mb-5">
                <div class="sms-section-tag">Pedoman Teknis</div>
                <h2 class="sms-section-title">Panduan Pedoman Teknis</h2>
                <p class="sms-section-desc" style="max-width:520px">Dokumen panduan teknis penanganan insiden keamanan
                    siber sebagai acuan dalam proses identifikasi, mitigasi, dan pemulihan insiden.</p>
            </div>
            <div class="sms-ped-grid sms-reveal">
                <a href="{{ asset('uploads/documents/Panduan-Penanganan-Insiden-Web-Defacement.pdf') }}"
                    target="_blank" class="sms-ped-link-card">
                    <div class="sms-ped-link-top">
                        <div class="sms-ped-link-icon">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="2" y1="12" x2="22" y2="12" />
                                <path d="M12 2a15 15 0 0 1 0 20" />
                                <path d="M12 2a15 15 0 0 0 0 20" />
                            </svg>
                        </div>
                        <div class="sms-ped-link-arr"><svg viewBox="0 0 24 24">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg></div>
                    </div>
                    <div>
                        <div class="sms-ped-link-tag">Insiden · Web</div>
                        <h3 class="sms-ped-link-title">Panduan Penanganan Insiden Web Defacement</h3>
                    </div>
                </a>
                <a href="{{ asset('uploads/documents/Panduan-Penanganan-Insiden-Serangan-SQL-Injection.pdf') }}"
                    target="_blank" class="sms-ped-link-card">
                    <div class="sms-ped-link-top">
                        <div class="sms-ped-link-icon">
                            <svg viewBox="0 0 24 24">
                                <ellipse cx="12" cy="5" rx="9" ry="3" />
                                <path d="M3 5v6c0 1.7 4 3 9 3s9-1.3 9-3V5" />
                                <path d="M3 11v6c0 1.7 4 3 9 3s9-1.3 9-3v-6" />
                            </svg>
                        </div>
                        <div class="sms-ped-link-arr"><svg viewBox="0 0 24 24">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg></div>
                    </div>
                    <div>
                        <div class="sms-ped-link-tag">Serangan · Database</div>
                        <h3 class="sms-ped-link-title">Panduan Penanganan Insiden Serangan SQL Injection</h3>
                    </div>
                </a>
                <a href="{{ asset('uploads/documents/Panduan-Penanganan-Insiden-Serangan-Phishing.pdf') }}"
                    target="_blank" class="sms-ped-link-card">
                    <div class="sms-ped-link-top">
                        <div class="sms-ped-link-icon">
                            <svg viewBox="0 0 24 24">
                                <rect x="2" y="4" width="20" height="16" rx="2" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                        </div>
                        <div class="sms-ped-link-arr"><svg viewBox="0 0 24 24">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg></div>
                    </div>
                    <div>
                        <div class="sms-ped-link-tag">Serangan · Email</div>
                        <h3 class="sms-ped-link-title">Panduan Penanganan Insiden Serangan Phishing</h3>
                    </div>
                </a>
                <a href="{{ asset('uploads/documents/Panduan-Penanganan-Insiden-Serangan-DDoS.pdf') }}"
                    target="_blank" class="sms-ped-link-card">
                    <div class="sms-ped-link-top">
                        <div class="sms-ped-link-icon">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="6" rx="2" />
                                <rect x="3" y="14" width="18" height="6" rx="2" />
                                <circle cx="7" cy="7" r="1" />
                                <circle cx="7" cy="17" r="1" />
                            </svg>
                        </div>
                        <div class="sms-ped-link-arr"><svg viewBox="0 0 24 24">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg></div>
                    </div>
                    <div>
                        <div class="sms-ped-link-tag">Serangan · Jaringan</div>
                        <h3 class="sms-ped-link-title">Panduan Penanganan Insiden Serangan DDoS</h3>
                    </div>
                </a>
                <a href="{{ asset('uploads/documents/Panduan-Penanganan-Insiden-Malware.pdf') }}" target="_blank"
                    class="sms-ped-link-card">
                    <div class="sms-ped-link-top">
                        <div class="sms-ped-link-icon">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <circle cx="12" cy="16" r="1" />
                            </svg>
                        </div>
                        <div class="sms-ped-link-arr"><svg viewBox="0 0 24 24">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg></div>
                    </div>
                    <div>
                        <div class="sms-ped-link-tag">Ancaman · Sistem</div>
                        <h3 class="sms-ped-link-title">Panduan Penanganan Insiden Malware</h3>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <section id="berita" class="sms-section-w">
        <div class="container">
            <div class="d-flex align-items-end justify-content-between flex-wrap gap-3 mb-5 sms-reveal">
                <div>
                    <div class="sms-section-tag">Berita</div>
                    <h2 class="sms-section-title mb-0">Update Terkini</h2>
                </div>
                <a href="{{ route('news.index') }}" class="sms-btn-outline">
                    Lihat Semua
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            @if ($news->count() > 0)
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;" class="sms-reveal">
                    @foreach ($news as $item)
                        <a href="{{ route('news.show', $item->slug) }}" class="sms-news-card"
                            style="text-decoration:none;display:flex;flex-direction:column;">
                            @if ($item->image)
                                <img src="{{ $item->image }}" alt="{{ $item->title }}"
                                    style="width:100%;height:180px;object-fit:cover;display:block;">
                            @else
                                <div
                                    style="height:180px;background:linear-gradient(135deg,var(--primary-light),var(--accent-light));display:flex;align-items:center;justify-content:center;">
                                    <div class="sms-news-img-icon">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                            <polyline points="14 2 14 8 20 8" />
                                            <line x1="16" y1="13" x2="8" y2="13" />
                                            <line x1="16" y1="17" x2="8" y2="17" />
                                        </svg>
                                    </div>
                                </div>
                            @endif
                            <div class="sms-news-body" style="flex:1;">
                                <div class="sms-news-title">{{ $item->title }}</div>
                                <p class="sms-news-excerpt">{{ Str::limit(strip_tags($item->content), 100) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div style="text-align:center;padding:48px 0;color:var(--text-muted);">
                    <p style="font-size:15px;font-weight:600;">Belum ada berita tersedia.</p>
                </div>
            @endif
        </div>
    </section>

    <section id="hubungi" class="sms-section">
        <div class="container">
            <div class="sms-reveal mb-5">
                <div class="sms-section-tag">Hubungi Kami</div>
                <h2 class="sms-section-title">Ada Pertanyaan?</h2>
                <p class="sms-section-desc" style="max-width:480px">Tim kami siap membantu Anda.</p>
            </div>
            <div class="sms-con-grid sms-reveal">
                <div class="sms-con-card">
                    <div class="sms-con-card-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <div>
                        <div class="sms-con-card-label">Alamat</div>
                        <p class="sms-con-card-value">Gd. Mahkamah Konstitusi 3 Lantai 8 Jl. Medan Merdeka Barat No.5-6
                        </p>
                        <p class="sms-con-card-sub">Jakarta Pusat, Indonesia, 10110.</p>
                    </div>
                </div>
                <div class="sms-con-card">
                    <div class="sms-con-card-icon">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.32 2 2 0 0 1 3.6 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.6a16 16 0 0 0 6 6l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.72 16z" />
                        </svg>
                    </div>
                    <div>
                        <div class="sms-con-card-label">Telepon</div>
                        <p class="sms-con-card-value">+6221 23529000</p>
                    </div>
                </div>
                <div class="sms-con-card">
                    <div class="sms-con-card-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                    </div>
                    <div>
                        <div class="sms-con-card-label">Email</div>
                        <p class="sms-con-card-value">csirt@mkri.id</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="sms-footer">
        <div class="container">
            <div style="display:grid;grid-template-columns:1fr 1.3fr 1fr;gap:40px;">
                <div>
                    <h3 style="margin-bottom:12px;font-weight:800;font-size:16px;">MKRI</h3>
                    <p style="font-size:13.5px;color:var(--text-muted);line-height:1.75;">
                        Jl. Medan Merdeka Barat No.6.<br>
                        Jakarta Pusat, 10110<br>
                        Indonesia
                    </p>
                    <p style="margin-top:12px;font-size:13.5px;color:var(--text-muted);line-height:1.75;">
                        <strong>Telepon:</strong> +6221 23529000<br>
                        <strong>Email:</strong> office@mkri.id
                    </p>

                </div>
                <div>
                    <h5 class="sms-fcol-title">UNIT KERJA</h5>
                    <ul class="sms-flinks">
                        <li><a href="https://kepaniteraan.mkri.id/" target="_blank">Kepaniteraan</a></li>
                        <li><a href="https://perencanaan.mkri.id/" target="_blank">Biro Perencanaan dan Keuangan</a>
                        </li>
                        <li><a href="https://sdm.mkri.id/" target="_blank">Biro Sumber Daya Manusia dan Organisasi</a>
                        </li>
                        <li><a href="https://hukum.mkri.id/" target="_blank">Biro Hukum dan Administrasi
                                Kepaniteraan</a></li>
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
                <p class="sms-footer-copy">© 2025 MKRI. All Rights Reserved</p>
            </div>
        </div>
    </footer>



    <script>
        var smsIdx = 0;
        var smsTotal = 3;
        var smsTimer;

        function smsGoTo(n) {
            var slides = document.querySelectorAll('.sms-slide');
            var dots = document.querySelectorAll('.sms-slider-dot');
            slides[smsIdx].classList.remove('active');
            dots[smsIdx].classList.remove('active');
            smsIdx = (n + smsTotal) % smsTotal;
            slides[smsIdx].classList.add('active');
            dots[smsIdx].classList.add('active');
        }

        function smsNext() {
            smsGoTo(smsIdx + 1);
            smsResetTimer();
        }

        function smsPrev() {
            smsGoTo(smsIdx - 1);
            smsResetTimer();
        }

        function smsResetTimer() {
            clearInterval(smsTimer);
            smsTimer = setInterval(smsNext, 6000);
        }
        smsResetTimer();

        window.addEventListener('scroll', function() {
            document.getElementById('smsNav').classList.toggle('scrolled', window.scrollY > 20);
            document.querySelectorAll('.sms-reveal').forEach(function(el) {
                if (el.getBoundingClientRect().top < window.innerHeight - 60) el.classList.add('on');
            });
        });

        function smsToggle() {
            document.getElementById('smsMM').classList.toggle('open');
        }

        function smsClose() {
            document.getElementById('smsMM').classList.remove('open');
        }
        document.querySelectorAll('a[href^="#"]').forEach(function(a) {
            a.addEventListener('click', function(e) {
                var t = document.querySelector(a.getAttribute('href'));
                if (t) {
                    e.preventDefault();
                    t.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
        window.dispatchEvent(new Event('scroll'));
    </script>
</body>

</html>
