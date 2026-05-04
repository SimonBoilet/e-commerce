<!DOCTYPE html>
<html lang="fr">
<head>
    <base href="/" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="VOLTEX — Boissons énergisantes haut de gamme. Formulées pour les esprits d'exception." />
    <meta name="keywords" content="boisson énergisante, haut de gamme, premium, VOLTEX, énergie" />
    <meta name="author" content="VOLTEX" />
    <title>VOLTEX — Énergie Premium</title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet" />

    <style>
        /* ── ROOT & VARIABLES ── */
        :root {
            --volt:       #C8FF00;
            --volt-dim:   #9FCC00;
            --night:      #080A0F;
            --surface:    #0D1017;
            --card-bg:    #111520;
            --border:     rgba(200,255,0,.12);
            --muted:      #6B7280;
            --white:      #F4F6F8;
            --font-display: 'Bebas Neue', sans-serif;
            --font-body:    'DM Sans', sans-serif;
            --transition:   .20s cubic-bezier(.4,0,.2,1);
        }

        /* ── BASE ── */
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-body);
            background: var(--night);
            color: var(--white);
            overflow-x: hidden;
        }

        .navbar-logo {
            height: 60px;
            width: auto;
            object-fit: contain;
            transition: opacity .2s ease;
        }
        .qty-update-btn { display: none; }
        .navbar-logo:hover { opacity: .85; }

        @media (max-width: 767.98px) {
            .navbar-logo { height: 60px; }
        }

        /* ── NOISE OVERLAY ── */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            background-size: 160px;
            pointer-events: none;
            z-index: 9000;
            opacity: .55;
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: var(--night); }
        ::-webkit-scrollbar-thumb { background: var(--volt); border-radius: 2px; }

        /* ── TYPOGRAPHY ── */
        h1, h2, h3, h4, h5, h6 { font-family: var(--font-display); letter-spacing: .04em; }
        .display-hero {
            font-family: var(--font-display);
            font-size: clamp(4rem, 12vw, 10.5rem);
            line-height: .92;
            letter-spacing: .02em;
        }
        .volt-text { color: var(--volt); }
        .muted-text { color: var(--muted); font-size: .85rem; }
        .section-label {
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: .25em;
            text-transform: uppercase;
            color: var(--volt);
        }

        /* ── HEADER / NAVBAR ── */
        header {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1050;
            transition: background var(--transition), backdrop-filter var(--transition);
        }
        header.scrolled {
            background: rgba(8,10,15,.85);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--border);
        }
        .navbar { padding: 1.1rem 0; }
        .navbar-brand {
            font-family: var(--font-display);
            font-size: 1.9rem;
            letter-spacing: .12em;
            color: var(--white) !important;
        }
        .navbar-brand span { color: var(--volt); }
        .nav-link {
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--muted) !important;
            padding: .4rem .9rem !important;
            transition: color var(--transition);
        }
        .nav-link:hover, .nav-link.active { color: var(--white) !important; }
        .nav-icon-btn {
            background: none;
            border: none;
            color: var(--muted);
            font-size: 1.15rem;
            padding: .35rem .5rem;
            transition: color var(--transition);
        }
        .nav-icon-btn:hover { color: var(--volt); }
        .cart-badge {
            position: absolute;
            top: 0; right: 0;
            background: var(--volt);
            color: var(--night);
            font-size: .5rem;
            font-weight: 800;
            border-radius: 50%;
            width: 14px; height: 14px;
            display: flex; align-items: center; justify-content: center;
        }
        .btn-nav-cta {
            background: var(--volt);
            color: var(--night);
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
            border: none;
            padding: .55rem 1.4rem;
            border-radius: 2px;
            transition: background var(--transition), transform var(--transition);
        }
        .btn-nav-cta:hover { background: var(--volt-dim); transform: translateY(-1px); }
        .navbar-toggler {
            border: 1px solid var(--border);
            padding: .3rem .6rem;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28200,255,0,0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .product-overlay { position:absolute; inset:0; background:rgba(8,10,15,.7); display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity var(--transition); z-index:3; }
        .product-card:hover .product-overlay { opacity:1; }
        .product-overlay-btn { background:var(--volt); color:var(--night); font-size:.72rem; font-weight:800; letter-spacing:.14em; text-transform:uppercase; padding:.65rem 1.4rem; border-radius:2px; text-decoration:none; }
        .product-real-img { height:180px; object-fit:contain; filter:drop-shadow(0 8px 24px rgba(200,255,0,.15)); transition:transform var(--transition); }
        .product-card:hover .product-real-img { transform:scale(1.06) rotate(-3deg); }

        /* ── HERO ── */
        #hero {
            min-height: 100svh;
            display: flex; align-items: center;
            position: relative;
            overflow: hidden;
            padding-top: 5rem;
        }
        .hero-bg {
            position: absolute; inset: 0;
            background:
                    radial-gradient(ellipse 60% 60% at 70% 50%, rgba(200,255,0,.07) 0%, transparent 70%),
                    radial-gradient(ellipse 40% 80% at 20% 30%, rgba(200,255,0,.04) 0%, transparent 60%),
                    var(--night);
        }
        .hero-grid-lines {
            position: absolute; inset: 0;
            background-image:
                    linear-gradient(rgba(200,255,0,.04) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(200,255,0,.04) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse 80% 80% at 60% 50%, black 0%, transparent 70%);
        }
        .hero-glow {
            position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(200,255,0,.13) 0%, transparent 65%);
            border-radius: 50%;
            right: 5%; top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            animation: pulseGlow 4s ease-in-out infinite;
        }
        @keyframes pulseGlow {
            0%, 100% { opacity: .8; transform: translateY(-50%) scale(1); }
            50%       { opacity: 1;  transform: translateY(-50%) scale(1.08); }
        }
        .hero-eyebrow {
            font-size: .68rem;
            font-weight: 600;
            letter-spacing: .3em;
            text-transform: uppercase;
            color: var(--volt);
            display: flex; align-items: center; gap: .6rem;
            margin-bottom: 1.2rem;
            opacity: 0;
            animation: fadeUp .7s ease forwards .2s;
        }
        .hero-eyebrow::before {
            content: '';
            display: block;
            width: 32px; height: 1px;
            background: var(--volt);
        }
        .display-hero {
            opacity: 0;
            animation: fadeUp .9s ease forwards .4s;
        }
        .hero-sub {
            font-size: 1.05rem;
            font-weight: 300;
            color: var(--muted);
            max-width: 420px;
            line-height: 1.7;
            opacity: 0;
            animation: fadeUp .9s ease forwards .6s;
        }
        .hero-actions {
            opacity: 0;
            animation: fadeUp .9s ease forwards .8s;
        }
        .btn-volt {
            background: var(--volt);
            color: var(--night);
            font-weight: 700;
            font-size: .82rem;
            letter-spacing: .14em;
            text-transform: uppercase;
            border: none;
            padding: .9rem 2.2rem;
            border-radius: 2px;
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
        }
        .btn-volt::after {
            content: '';
            position: absolute; inset: 0;
            background: rgba(255,255,255,.15);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .3s ease;
        }
        .btn-volt:hover::after { transform: scaleX(1); }
        .btn-volt:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(200,255,0,.3); }
        .btn-outline-volt {
            background: transparent;
            color: var(--white);
            font-weight: 600;
            font-size: .82rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            border: 1px solid rgba(200,255,0,.4);
            padding: .9rem 2.2rem;
            border-radius: 2px;
            transition: all var(--transition);
        }
        .btn-outline-volt:hover {
            border-color: var(--volt);
            color: var(--volt);
            transform: translateY(-2px);
        }
        .hero-stats {
            opacity: 0;
            animation: fadeUp .9s ease forwards 1s;
        }
        .hero-stat-value {
            font-family: var(--font-display);
            font-size: 2.2rem;
            color: var(--volt);
            line-height: 1;
        }
        .hero-stat-label { font-size: .72rem; color: var(--muted); letter-spacing: .1em; text-transform: uppercase; }
        .hero-stat-divider { width: 1px; height: 40px; background: var(--border); }

        /* Can mockup */
        .hero-can-wrap {
            position: relative;
            display: flex; align-items: center; justify-content: center;
            opacity: 0;
            animation: fadeIn 1.2s ease forwards .5s;
        }
        .hero-can-wrap::before {
            content: '';
            position: absolute;
            width: 320px; height: 320px;
            background: radial-gradient(circle, rgba(200,255,0,.18) 0%, transparent 65%);
            border-radius: 50%;
            animation: pulseGlow 3s ease-in-out infinite;
        }
        .can-svg { position: relative; z-index: 1; filter: drop-shadow(0 20px 60px rgba(200,255,0,.25)); animation: floatCan 5s ease-in-out infinite; }
        @keyframes floatCan {
            0%, 100% { transform: translateY(0) rotate(-2deg); }
            50%       { transform: translateY(-18px) rotate(2deg); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        /* Scroll hint */
        .scroll-hint {
            position: absolute;
            bottom: 2.5rem; left: 50%;
            transform: translateX(-50%);
            display: flex; flex-direction: column; align-items: center; gap: .5rem;
            font-size: .62rem; letter-spacing: .2em; text-transform: uppercase; color: var(--muted);
            animation: fadeIn 1s ease forwards 1.5s;
            opacity: 0;
        }
        .scroll-dot {
            width: 1px; height: 50px;
            background: linear-gradient(to bottom, var(--volt), transparent);
            animation: scrollDot 1.8s ease-in-out infinite;
        }
        @keyframes scrollDot {
            0%   { transform: scaleY(0); transform-origin: top; }
            50%  { transform: scaleY(1); transform-origin: top; }
            51%  { transform: scaleY(1); transform-origin: bottom; }
            100% { transform: scaleY(0); transform-origin: bottom; }
        }

        /* ── TICKER BAND ── */
        .ticker-band {
            background: var(--volt);
            overflow: hidden;
            padding: .55rem 0;
            border-top: none;
        }
        .ticker-track {
            display: flex;
            width: max-content;
            animation: ticker 20s linear infinite;
        }
        .ticker-item {
            font-family: var(--font-display);
            font-size: 1rem;
            letter-spacing: .2em;
            color: var(--night);
            padding: 0 2rem;
            display: flex; align-items: center; gap: 1.5rem;
            white-space: nowrap;
        }
        .ticker-sep { font-size: .5rem; opacity: .5; }
        @keyframes ticker {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* ── SECTION DEFAULTS ── */
        section { padding: 6rem 0; position: relative; }

        /* ── PRODUCTS ── */
        #products { background: var(--surface); }
        .section-heading {
            font-family: var(--font-display);
            font-size: clamp(2.8rem, 6vw, 5rem);
            line-height: 1;
            margin-bottom: .4rem;
        }

        .product-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 4px;
            overflow: hidden;
            transition: transform var(--transition), border-color var(--transition), box-shadow var(--transition);
            cursor: pointer;
        }
        .product-card:hover {
            transform: translateY(-6px);
            border-color: rgba(200,255,0,.35);
            box-shadow: 0 20px 60px rgba(200,255,0,.1);
        }
        .product-card:hover .product-add-btn { opacity: 1; transform: translateY(0); }
        .product-img-wrap {
            position: relative;
            background: linear-gradient(135deg, #0a0d14 0%, #131826 100%);
            display: flex; align-items: center; justify-content: center;
            height: 280px;
            overflow: hidden;
        }
        .product-badge {
            position: absolute;
            top: 1rem; left: 1rem;
            background: var(--volt);
            color: var(--night);
            font-size: .6rem;
            font-weight: 800;
            letter-spacing: .15em;
            text-transform: uppercase;
            padding: .2rem .6rem;
            border-radius: 1px;
        }
        .product-badge.new-badge { background: #00C8FF; }
        .product-flavour-tag {
            position: absolute;
            bottom: 1rem; right: 1rem;
            font-size: .62rem; letter-spacing: .18em; text-transform: uppercase;
            color: var(--muted);
            border: 1px solid var(--border);
            padding: .2rem .6rem;
            border-radius: 2px;
            background: rgba(8,10,15,.6);
        }
        .product-can-img {
            height: 180px;
            filter: drop-shadow(0 8px 24px rgba(200,255,0,.2));
            transition: transform var(--transition);
        }
        .product-card:hover .product-can-img { transform: scale(1.06) rotate(-3deg); }
        .product-body { padding: 1.4rem; }
        .product-name { font-family: var(--font-display); font-size: 1.4rem; letter-spacing: .06em; margin-bottom: .25rem; }
        .product-desc { font-size: .82rem; color: var(--muted); line-height: 1.6; margin-bottom: 1rem; }
        .product-meta { display: flex; align-items: center; justify-content: space-between; }
        .product-price { font-family: var(--font-display); font-size: 1.5rem; color: var(--volt); }
        .product-price small { font-family: var(--font-body); font-size: .68rem; color: var(--muted); letter-spacing: .1em; }
        .product-add-btn {
            background: var(--volt);
            color: var(--night);
            border: none;
            font-size: .7rem;
            font-weight: 800;
            letter-spacing: .14em;
            text-transform: uppercase;
            padding: .55rem 1.1rem;
            border-radius: 2px;
            opacity: 0;
            transform: translateY(4px);
            transition: all var(--transition);
        }
        .product-add-btn:hover { background: var(--volt-dim); }
        .product-stars { color: var(--volt); font-size: .75rem; }

        /* ── INGREDIENTS ── */
        #ingredients { background: var(--night); }
        .ingr-card {
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 1.8rem 1.5rem;
            background: var(--card-bg);
            height: 100%;
            transition: border-color var(--transition), transform var(--transition);
            position: relative;
            overflow: hidden;
        }
        .ingr-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: var(--volt);
            transform: scaleX(0);
            transition: transform var(--transition);
        }
        .ingr-card:hover { border-color: rgba(200,255,0,.3); transform: translateY(-4px); }
        .ingr-card:hover::before { transform: scaleX(1); }
        .ingr-icon { font-size: 2rem; color: var(--volt); margin-bottom: 1rem; display: block; }
        .ingr-title { font-family: var(--font-display); font-size: 1.3rem; letter-spacing: .05em; margin-bottom: .5rem; }
        .ingr-text { font-size: .83rem; color: var(--muted); line-height: 1.7; }

        /* ── MARQUEE SPLIT ── */
        .marquee-split {
            background: var(--night);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            overflow: hidden;
            padding: 1.2rem 0;
        }
        .marquee-track {
            display: flex;
            width: max-content;
            animation: ticker 25s linear infinite;
        }
        .marquee-item {
            font-family: var(--font-display);
            font-size: 1.1rem;
            letter-spacing: .25em;
            color: var(--muted);
            padding: 0 2.5rem;
            display: flex; align-items: center; gap: 2rem;
            white-space: nowrap;
            transition: color .2s;
        }
        .marquee-item:hover { color: var(--volt); }
        .marquee-dot { width: 4px; height: 4px; background: var(--volt); border-radius: 50%; }

        /* ── FEATURE BAND ── */
        #features { background: var(--surface); }
        .feature-item {
            display: flex; align-items: flex-start; gap: 1.2rem;
            padding: 2rem;
            border: 1px solid var(--border);
            border-radius: 4px;
            background: var(--card-bg);
            height: 100%;
            transition: border-color var(--transition);
        }
        .feature-item:hover { border-color: rgba(200,255,0,.3); }
        .feature-icon-wrap {
            width: 46px; height: 46px;
            background: rgba(200,255,0,.1);
            border: 1px solid rgba(200,255,0,.2);
            border-radius: 2px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 1.2rem;
            color: var(--volt);
        }
        .feature-title { font-family: var(--font-display); font-size: 1.1rem; letter-spacing: .05em; margin-bottom: .3rem; }
        .feature-text { font-size: .82rem; color: var(--muted); line-height: 1.65; margin: 0; }

        /* ── TESTIMONIALS ── */
        #testimonials { background: var(--night); }
        .testi-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 2rem;
            height: 100%;
            position: relative;
        }
        .testi-quote {
            font-family: var(--font-display);
            font-size: 4rem;
            line-height: .6;
            color: var(--volt);
            opacity: .35;
            position: absolute;
            top: 1.2rem; right: 1.5rem;
        }
        .testi-text { font-size: .9rem; color: var(--white); line-height: 1.8; margin-bottom: 1.4rem; font-style: italic; font-weight: 300; }
        .testi-avatar {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--volt), #00C8FF);
            display: flex; align-items: center; justify-content: center;
            font-family: var(--font-display);
            font-size: 1rem;
            color: var(--night);
            flex-shrink: 0;
        }
        .testi-name { font-weight: 600; font-size: .88rem; }
        .testi-role { font-size: .75rem; color: var(--muted); }

        /* ── NEWSLETTER ── */
        #newsletter {
            background:
                    linear-gradient(135deg, rgba(200,255,0,.06) 0%, transparent 50%),
                    var(--surface);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }
        .newsletter-heading { font-family: var(--font-display); font-size: clamp(2.2rem, 5vw, 4rem); line-height: 1.05; }
        .input-volt {
            background: rgba(255,255,255,.05);
            border: 1px solid var(--border);
            color: var(--white);
            border-radius: 2px;
            padding: .85rem 1.3rem;
            font-family: var(--font-body);
            font-size: .88rem;
            flex: 1;
            transition: border-color var(--transition);
        }
        .input-volt:focus {
            outline: none;
            border-color: var(--volt);
            background: rgba(200,255,0,.04);
            color: var(--white);
        }
        .input-volt::placeholder { color: var(--muted); }

        /* ── FOOTER ── */
        footer {
            background: #050709;
            border-top: 1px solid var(--border);
            padding: 4rem 0 2rem;
        }
        .footer-brand {
            font-family: var(--font-display);
            font-size: 2.2rem;
            letter-spacing: .14em;
            color: var(--white);
        }
        .footer-brand span { color: var(--volt); }
        .footer-tagline { font-size: .8rem; color: var(--muted); margin-top: .3rem; letter-spacing: .1em; text-transform: uppercase; }
        .footer-col-title {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .28em;
            text-transform: uppercase;
            color: var(--volt);
            margin-bottom: 1.2rem;
        }
        .footer-link {
            display: block;
            color: var(--muted);
            font-size: .83rem;
            text-decoration: none;
            padding: .25rem 0;
            transition: color var(--transition);
        }
        .footer-link:hover { color: var(--white); }
        .social-btn {
            width: 36px; height: 36px;
            border: 1px solid var(--border);
            border-radius: 2px;
            display: flex; align-items: center; justify-content: center;
            color: var(--muted);
            font-size: 1rem;
            text-decoration: none;
            transition: all var(--transition);
        }
        .social-btn:hover { border-color: var(--volt); color: var(--volt); }
        .footer-bottom { border-top: 1px solid var(--border); margin-top: 3rem; padding-top: 1.5rem; font-size: .75rem; color: var(--muted); }
        .footer-bottom a { color: var(--muted); text-decoration: none; transition: color var(--transition); }
        .footer-bottom a:hover { color: var(--volt); }

        /* ── BACK TO TOP ── */
        #back-top {
            position: fixed;
            bottom: 2rem; right: 2rem;
            width: 42px; height: 42px;
            background: var(--volt);
            color: var(--night);
            border: none;
            border-radius: 2px;
            font-size: 1rem;
            display: flex; align-items: center; justify-content: center;
            opacity: 0; pointer-events: none;
            transition: opacity var(--transition), transform var(--transition);
            z-index: 800;
        }
        #back-top.show { opacity: 1; pointer-events: all; }
        #back-top:hover { transform: translateY(-3px); }

        /* ── RESPONSIVE ── */
        @media (max-width: 991.98px) {
            .hero-can-wrap { margin-top: 3rem; }
            .product-add-btn { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 767.98px) {
            section { padding: 4rem 0; }
            .hero-stat-divider { display: none; }
        }


    </style>
</head>
