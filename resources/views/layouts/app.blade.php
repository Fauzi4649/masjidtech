<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MasjidTech — Smart Mosque Management')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css'])
    <style>
        :root {
            --green-900: #0d3320;
            --green-800: #14532d;
            --green-700: #166534;
            --green-600: #16a34a;
            --green-500: #22c55e;
            --green-400: #4ade80;
            --green-100: #dcfce7;
            --green-50: #f0fdf4;
            --gold: #c9a84c;
            --gold-light: #f0d080;
            --white: #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-400: #94a3b8;
            --gray-600: #475569;
            --gray-800: #1e293b;
            --shadow-sm: 0 1px 3px rgba(0,0,0,.08);
            --shadow-md: 0 4px 20px rgba(0,0,0,.10);
            --shadow-lg: 0 10px 40px rgba(0,0,0,.14);
            --radius: 14px;
            --radius-sm: 8px;
            --transition: .25s cubic-bezier(.4,0,.2,1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; font-size: 16px; }
        body {
            font-family: 'DM Sans', sans-serif;
            color: var(--gray-800);
            background: var(--white);
            line-height: 1.6;
            overflow-x: hidden;
        }
        h1,h2,h3,h4 { font-family: 'Playfair Display', serif; line-height: 1.25; }
        a { text-decoration: none; color: inherit; }
        img { max-width: 100%; display: block; }

        /* ── UTILITY ── */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        .section-label {
            display: inline-flex; align-items: center; gap: 8px;
            font-size: .75rem; font-weight: 600; letter-spacing: .12em;
            text-transform: uppercase; color: var(--green-600);
            background: var(--green-100); padding: 4px 14px; border-radius: 100px;
            margin-bottom: 14px;
        }
        .section-title { font-size: clamp(1.6rem, 3vw, 2.4rem); color: var(--green-900); margin-bottom: 12px; }
        .section-sub   { color: var(--gray-600); max-width: 520px; }
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 11px 24px; border-radius: 100px; font-size: .9rem;
            font-weight: 600; cursor: pointer; transition: var(--transition);
            border: 2px solid transparent; font-family: 'DM Sans', sans-serif;
        }
        .btn-primary {
            background: var(--green-700); color: var(--white);
            box-shadow: 0 4px 16px rgba(22,101,52,.28);
        }
        .btn-primary:hover { background: var(--green-800); transform: translateY(-1px); }
        .btn-outline {
            background: transparent; color: var(--green-700);
            border-color: var(--green-700);
        }
        .btn-outline:hover { background: var(--green-50); }
        .btn-gold {
            background: var(--gold); color: var(--white);
            box-shadow: 0 4px 16px rgba(201,168,76,.30);
        }
        .btn-gold:hover { background: #b8933c; transform: translateY(-1px); }
        .badge {
            display: inline-block; padding: 3px 10px; border-radius: 100px;
            font-size: .72rem; font-weight: 700; letter-spacing: .04em;
        }
        .badge-green  { background: var(--green-100); color: var(--green-700); }
        .badge-gold   { background: #fef3c7; color: #92400e; }
        .badge-gray   { background: var(--gray-100); color: var(--gray-600); }

        /* ── NAV ── */
        nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            background: rgba(255,255,255,.92); backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--gray-100);
            transition: box-shadow var(--transition);
        }
        nav.scrolled { box-shadow: 0 2px 20px rgba(0,0,0,.09); }
        .nav-inner {
            display: flex; align-items: center; justify-content: space-between;
            height: 68px;
        }
        .nav-logo {
            display: flex; align-items: center; gap: 10px;
            font-family: 'Playfair Display', serif; font-size: 1.25rem;
            color: var(--green-900); font-weight: 700;
        }
        .logo-icon {
            width: 38px; height: 38px; background: var(--green-700); border-radius: 10px;
            display: flex; align-items: center; justify-content: center; color: var(--white);
            font-size: 1.1rem;
        }
        .nav-links {
            display: flex; align-items: center; gap: 4px;
            list-style: none;
        }
        .nav-links a {
            padding: 7px 14px; border-radius: 8px; font-size: .88rem; font-weight: 500;
            color: var(--gray-600); transition: var(--transition);
        }
        .nav-links a:hover { color: var(--green-700); background: var(--green-50); }
        .nav-actions { display: flex; align-items: center; gap: 10px; }
        .hamburger {
            display: none; flex-direction: column; gap: 5px;
            background: none; border: none; cursor: pointer; padding: 6px;
        }
        .hamburger span {
            display: block; width: 22px; height: 2px;
            background: var(--green-800); border-radius: 2px; transition: var(--transition);
        }
        .mobile-menu {
            display: none; position: fixed; top: 68px; left: 0; right: 0;
            background: var(--white); border-bottom: 1px solid var(--gray-100);
            padding: 16px 24px 24px; z-index: 999; flex-direction: column; gap: 4px;
            box-shadow: var(--shadow-lg);
        }
        .mobile-menu.open { display: flex; }
        .mobile-menu a {
            display: block; padding: 10px 14px; border-radius: 8px;
            color: var(--gray-700); font-weight: 500; transition: var(--transition);
        }
        .mobile-menu a:hover { background: var(--green-50); color: var(--green-700); }
        .mobile-menu .mobile-actions { display: flex; gap: 10px; margin-top: 12px; }

        /* ── HERO ── (remaining styles from your original file) */
        .hero {
            min-height: 100vh; position: relative; display: flex; align-items: center;
            overflow: hidden; padding-top: 68px;
        }
        .hero-bg {
            position: absolute; inset: 0; z-index: 0;
            background: linear-gradient(135deg, rgba(13,51,32,.97) 0%, rgba(22,101,52,.88) 55%, rgba(13,51,32,.95) 100%);
        }
        .hero-pattern {
            position: absolute; inset: 0; z-index: 1; opacity: .07;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M30 0l5 10-5 10-5-10zm0 40l5 10-5 10-5-10zM0 30l10-5 10 5-10 5zm40 0l10-5 10 5-10 5z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .hero-content { position: relative; z-index: 2; padding: 80px 0; }
        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            color: var(--gold-light); font-size: .8rem; font-weight: 600;
            letter-spacing: .16em; text-transform: uppercase; margin-bottom: 20px;
        }
        .hero-eyebrow::before, .hero-eyebrow::after {
            content: ''; display: block; width: 30px; height: 1px; background: var(--gold);
        }
        .hero h1 {
            font-size: clamp(2.4rem, 6vw, 4.2rem); color: var(--white);
            margin-bottom: 20px; max-width: 680px;
        }
        .hero h1 span { color: var(--gold-light); }
        .hero p {
            color: rgba(255,255,255,.75); font-size: 1.05rem;
            max-width: 520px; margin-bottom: 36px;
        }
        .hero-actions { display: flex; gap: 14px; flex-wrap: wrap; }
        .hero-stats {
            display: flex; gap: 40px; margin-top: 56px; padding-top: 40px;
            border-top: 1px solid rgba(255,255,255,.12); flex-wrap: wrap;
        }
        .hero-stat-num {
            font-family: 'Playfair Display', serif; font-size: 2rem;
            color: var(--white); font-weight: 700;
        }
        .hero-stat-label { font-size: .8rem; color: rgba(255,255,255,.5); margin-top: 2px; letter-spacing: .04em; }
        .hero-card {
            position: absolute; right: 8%; bottom: 12%; z-index: 3;
            background: rgba(255,255,255,.1); backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,.18); border-radius: var(--radius);
            padding: 20px 24px; animation: floatY 4s ease-in-out infinite;
        }
        .hero-card .next-prayer-label { font-size: .7rem; color: rgba(255,255,255,.6); letter-spacing: .08em; margin-bottom: 4px; }
        .hero-card .next-prayer-name { font-size: 1.3rem; color: var(--white); font-family: 'Playfair Display', serif; }
        .hero-card .next-prayer-time { font-size: 2.1rem; color: var(--gold-light); font-family: 'Playfair Display', serif; font-weight: 700; }
        .hero-card .next-prayer-sub { font-size: .72rem; color: rgba(255,255,255,.55); margin-top: 2px; }
        @keyframes floatY { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }

        /* ── PRAYER TIMES ── */
        .prayer-section { padding: 90px 0; background: var(--white); }
        .section-header { margin-bottom: 48px; }
        .prayer-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px;
        }
        .prayer-card {
            background: var(--gray-50); border: 1px solid var(--gray-200);
            border-radius: var(--radius); padding: 28px 20px; text-align: center;
            transition: var(--transition); position: relative; overflow: hidden;
            cursor: default;
        }
        .prayer-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: var(--green-500); transform: scaleX(0); transform-origin: left;
            transition: transform var(--transition);
        }
        .prayer-card:hover { border-color: var(--green-200); box-shadow: var(--shadow-md); transform: translateY(-3px); }
        .prayer-card:hover::before { transform: scaleX(1); }
        .prayer-card.active {
            background: var(--green-800); border-color: var(--green-700);
            color: var(--white); box-shadow: 0 8px 30px rgba(22,101,52,.35);
        }
        .prayer-card.active .prayer-name { color: var(--green-200); }
        .prayer-card.active .prayer-time { color: var(--white); }
        .prayer-card.active .prayer-iqama { color: rgba(255,255,255,.65); }
        .prayer-card.active::before { transform: scaleX(1); background: var(--gold); }
        .prayer-icon { font-size: 1.5rem; color: var(--green-600); margin-bottom: 10px; }
        .prayer-card.active .prayer-icon { color: var(--gold-light); }
        .prayer-name { font-size: .75rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--gray-500); margin-bottom: 8px; }
        .prayer-time { font-family: 'Playfair Display', serif; font-size: 1.7rem; color: var(--green-900); font-weight: 700; }
        .prayer-iqama { font-size: .72rem; color: var(--gray-400); margin-top: 6px; }
        .hijri-bar {
            background: var(--green-900); color: var(--white);
            border-radius: var(--radius); padding: 20px 28px;
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 32px; flex-wrap: wrap; gap: 12px;
        }
        .hijri-date { font-family: 'Playfair Display', serif; font-size: 1.1rem; }
        .hijri-location { font-size: .82rem; color: rgba(255,255,255,.6); }

        /* ── EVENTS ── */
        .events-section { padding: 90px 0; background: var(--green-50); }
        .events-header { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 48px; flex-wrap: wrap; gap: 16px; }
        .events-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px; }
        .event-card {
            background: var(--white); border-radius: var(--radius); overflow: hidden;
            box-shadow: var(--shadow-sm); border: 1px solid var(--gray-100);
            transition: var(--transition);
        }
        .event-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-4px); }
        .event-img {
            height: 180px; position: relative; overflow: hidden;
            background: linear-gradient(135deg, var(--green-700), var(--green-900));
            display: flex; align-items: center; justify-content: center;
        }
        .event-img-icon { font-size: 3rem; color: rgba(255,255,255,.25); }
        .event-img-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(13,51,32,.7) 0%, transparent 50%);
        }
        .event-date-chip {
            position: absolute; top: 14px; left: 14px;
            background: var(--gold); color: var(--white);
            border-radius: 8px; padding: 6px 12px; text-align: center;
            font-weight: 700; font-size: .78rem; line-height: 1.2;
        }
        .event-img-pattern {
            position: absolute; inset: 0; opacity: .08;
            background-image: repeating-linear-gradient(45deg,#fff 0,#fff 1px,transparent 0,transparent 50%);
            background-size: 12px 12px;
        }
        .event-body { padding: 20px; }
        .event-category { margin-bottom: 10px; }
        .event-title { font-size: 1.05rem; color: var(--green-900); margin-bottom: 8px; }
        .event-meta { display: flex; flex-direction: column; gap: 5px; margin-bottom: 16px; }
        .event-meta-row { display: flex; align-items: center; gap: 8px; font-size: .82rem; color: var(--gray-500); }
        .event-meta-row i { color: var(--green-600); width: 14px; }
        .event-footer { display: flex; align-items: center; justify-content: space-between; padding-top: 14px; border-top: 1px solid var(--gray-100); }
        .event-spots { font-size: .78rem; color: var(--gray-400); }
        .event-spots strong { color: var(--green-700); }

        /* ── ANNOUNCEMENTS ── */
        .announcements-section { padding: 90px 0; background: var(--white); }
        .announce-grid { display: grid; grid-template-columns: 1fr 380px; gap: 40px; }
        .announce-feed { display: flex; flex-direction: column; gap: 16px; }
        .announce-card {
            border: 1px solid var(--gray-200); border-radius: var(--radius);
            padding: 22px; transition: var(--transition); position: relative;
            cursor: pointer; overflow: hidden;
        }
        .announce-card::before {
            content: ''; position: absolute; left: 0; top: 0; bottom: 0;
            width: 3px; background: var(--green-500); transform: scaleY(0);
            transform-origin: bottom; transition: transform var(--transition);
        }
        .announce-card:hover { box-shadow: var(--shadow-md); border-color: var(--green-200); }
        .announce-card:hover::before { transform: scaleY(1); }
        .announce-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 8px; }
        .announce-title { font-size: .95rem; font-weight: 600; color: var(--green-900); }
        .announce-date { font-size: .75rem; color: var(--gray-400); white-space: nowrap; }
        .announce-text { font-size: .85rem; color: var(--gray-600); line-height: 1.65; }
        .sidebar-card {
            background: var(--green-900); border-radius: var(--radius); padding: 28px;
            color: var(--white); position: sticky; top: 90px;
        }
        .sidebar-card h3 { font-size: 1.15rem; color: var(--gold-light); margin-bottom: 20px; }
        .quick-link {
            display: flex; align-items: center; gap: 12px;
            padding: 12px; border-radius: 8px; margin-bottom: 8px;
            background: rgba(255,255,255,.07); transition: var(--transition);
            cursor: pointer;
        }
        .quick-link:hover { background: rgba(255,255,255,.14); }
        .quick-link-icon { width: 36px; height: 36px; background: var(--green-700); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--green-300); flex-shrink: 0; }
        .quick-link-text { font-size: .84rem; color: rgba(255,255,255,.85); }
        .quick-link-sub { font-size: .72rem; color: rgba(255,255,255,.45); }

        /* ── COMMUNITY ── */
        .community-section { padding: 90px 0; background: linear-gradient(135deg, var(--green-900) 0%, var(--green-800) 100%); position: relative; overflow: hidden; }
        .community-pattern { position: absolute; inset: 0; opacity: .05; background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff'%3E%3Ccircle cx='40' cy='40' r='2'/%3E%3Ccircle cx='0' cy='0' r='2'/%3E%3Ccircle cx='80' cy='0' r='2'/%3E%3Ccircle cx='0' cy='80' r='2'/%3E%3Ccircle cx='80' cy='80' r='2'/%3E%3C/g%3E%3C/svg%3E"); }
        .community-content { position: relative; z-index: 1; }
        .community-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: center; }
        .community-text .section-label { background: rgba(255,255,255,.1); color: var(--gold-light); }
        .community-text .section-title { color: var(--white); }
        .community-text .section-sub { color: rgba(255,255,255,.65); }
        .feature-list { display: flex; flex-direction: column; gap: 20px; margin-top: 32px; }
        .feature-item { display: flex; align-items: flex-start; gap: 16px; }
        .feature-icon { width: 44px; height: 44px; background: rgba(255,255,255,.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--gold-light); font-size: 1.1rem; flex-shrink: 0; }
        .feature-title { font-size: .9rem; font-weight: 600; color: var(--white); margin-bottom: 3px; }
        .feature-desc { font-size: .8rem; color: rgba(255,255,255,.55); }
        .community-right { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .stat-card {
            background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12);
            border-radius: var(--radius); padding: 28px 20px; text-align: center;
            transition: var(--transition);
        }
        .stat-card:hover { background: rgba(255,255,255,.13); transform: translateY(-3px); }
        .stat-num { font-family: 'Playfair Display', serif; font-size: 2.2rem; color: var(--gold-light); font-weight: 700; }
        .stat-label { font-size: .78rem; color: rgba(255,255,255,.55); margin-top: 4px; }
        .stat-icon { font-size: 1.3rem; color: var(--green-400); margin-bottom: 10px; }

        /* ── ADMIN PREVIEW ── */
        .admin-section { padding: 90px 0; background: var(--gray-50); }
        .admin-preview {
            background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow-lg);
            overflow: hidden; border: 1px solid var(--gray-200);
        }
        .admin-topbar {
            background: var(--green-900); padding: 14px 24px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .admin-topbar-title { color: var(--white); font-weight: 600; font-size: .9rem; display: flex; align-items: center; gap: 10px; }
        .admin-topbar-title i { color: var(--gold-light); }
        .admin-topbar-actions { display: flex; align-items: center; gap: 10px; }
        .admin-dot { width: 10px; height: 10px; border-radius: 50%; }
        .admin-inner { display: grid; grid-template-columns: 220px 1fr; min-height: 440px; }
        .admin-sidebar {
            background: var(--green-800); padding: 20px 0;
        }
        .admin-nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 11px 20px; font-size: .82rem; color: rgba(255,255,255,.65);
            cursor: pointer; transition: var(--transition);
        }
        .admin-nav-item.active, .admin-nav-item:hover { background: rgba(255,255,255,.1); color: var(--white); }
        .admin-nav-item.active { border-right: 2px solid var(--gold); color: var(--gold-light); }
        .admin-main { padding: 24px; background: var(--gray-50); }
        .admin-kpis { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; margin-bottom: 24px; }
        .kpi-card {
            background: var(--white); border-radius: 10px; padding: 18px;
            border: 1px solid var(--gray-200);
        }
        .kpi-label { font-size: .72rem; color: var(--gray-400); letter-spacing: .06em; text-transform: uppercase; margin-bottom: 6px; }
        .kpi-value { font-family: 'Playfair Display', serif; font-size: 1.6rem; color: var(--green-900); font-weight: 700; }
        .kpi-delta { font-size: .72rem; color: var(--green-600); margin-top: 3px; }
        .admin-charts { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .chart-card {
            background: var(--white); border-radius: 10px; padding: 18px;
            border: 1px solid var(--gray-200);
        }
        .chart-title { font-size: .82rem; font-weight: 600; color: var(--green-900); margin-bottom: 14px; }
        .bar-chart { display: flex; align-items: flex-end; gap: 8px; height: 80px; }
        .bar { background: var(--green-500); border-radius: 4px 4px 0 0; flex: 1; transition: var(--transition); }
        .bar:hover { background: var(--green-700); }
        .recent-table { width: 100%; border-collapse: collapse; }
        .recent-table th { font-size: .7rem; text-transform: uppercase; letter-spacing: .06em; color: var(--gray-400); padding: 6px 10px; text-align: left; border-bottom: 1px solid var(--gray-100); }
        .recent-table td { font-size: .8rem; padding: 9px 10px; border-bottom: 1px solid var(--gray-100); }
        .recent-table tr:last-child td { border-bottom: none; }

        /* ── ABOUT ── */
        .about-section { padding: 90px 0; background: var(--white); }
        .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: center; }
        .about-img-wrap {
            border-radius: var(--radius); overflow: hidden; position: relative;
            background: linear-gradient(135deg, var(--green-800), var(--green-600));
            height: 400px; display: flex; align-items: center; justify-content: center;
        }
        .about-img-wrap .mosque-icon { font-size: 5rem; color: rgba(255,255,255,.2); }
        .about-badge-float {
            position: absolute; bottom: 24px; left: 24px;
            background: var(--gold); color: var(--white);
            border-radius: 10px; padding: 12px 18px;
            font-weight: 700; font-size: .9rem;
        }
        .values-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 28px; }
        .value-card { background: var(--green-50); border-radius: 10px; padding: 18px; }
        .value-icon { font-size: 1.2rem; color: var(--green-600); margin-bottom: 8px; }
        .value-title { font-size: .85rem; font-weight: 600; color: var(--green-900); margin-bottom: 4px; }
        .value-desc { font-size: .78rem; color: var(--gray-500); }

        /* ── FOOTER ── */
        footer { background: var(--green-900); color: var(--white); padding: 64px 0 32px; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 40px; margin-bottom: 48px; }
        .footer-brand p { color: rgba(255,255,255,.5); font-size: .85rem; margin-top: 14px; max-width: 260px; line-height: 1.7; }
        .footer-col h4 { font-size: .82rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--gold-light); margin-bottom: 16px; }
        .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 9px; }
        .footer-col ul li a { font-size: .84rem; color: rgba(255,255,255,.5); transition: var(--transition); }
        .footer-col ul li a:hover { color: var(--white); }
        .contact-item { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 10px; }
        .contact-item i { color: var(--green-400); margin-top: 2px; font-size: .85rem; }
        .contact-item span { font-size: .82rem; color: rgba(255,255,255,.55); line-height: 1.5; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,.1); padding-top: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
        .footer-bottom p { font-size: .8rem; color: rgba(255,255,255,.35); }
        .social-links { display: flex; gap: 10px; }
        .social-btn {
            width: 36px; height: 36px; border-radius: 8px; background: rgba(255,255,255,.08);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,.5); font-size: .85rem; transition: var(--transition);
        }
        .social-btn:hover { background: var(--green-700); color: var(--white); }

        /* ── MODAL ── */
        .modal-overlay {
            display: none; position: fixed; inset: 0; z-index: 2000;
            background: rgba(0,0,0,.5); backdrop-filter: blur(6px);
            align-items: center; justify-content: center; padding: 20px;
        }
        .modal-overlay.open { display: flex; }
        .modal {
            background: var(--white); border-radius: 20px; width: 100%; max-width: 440px;
            box-shadow: 0 20px 60px rgba(0,0,0,.25); overflow: hidden;
            animation: modalIn .3s cubic-bezier(.34,1.56,.64,1);
        }
        @keyframes modalIn { from{transform:scale(.92) translateY(20px);opacity:0} to{transform:scale(1) translateY(0);opacity:1} }
        .modal-header {
            background: var(--green-900); padding: 28px 32px 24px;
            text-align: center; position: relative;
        }
        .modal-header h2 { color: var(--white); font-size: 1.4rem; margin-bottom: 4px; }
        .modal-header p { color: rgba(255,255,255,.55); font-size: .84rem; }
        .modal-header .modal-close {
            position: absolute; top: 16px; right: 16px; background: rgba(255,255,255,.1);
            border: none; color: var(--white); width: 32px; height: 32px; border-radius: 8px;
            cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: .9rem;
            transition: var(--transition);
        }
        .modal-header .modal-close:hover { background: rgba(255,255,255,.2); }
        .modal-body { padding: 28px 32px; }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: .82rem; font-weight: 600; color: var(--gray-700); margin-bottom: 6px; }
        .form-input {
            width: 100%; padding: 11px 14px; border: 1.5px solid var(--gray-200); border-radius: 8px;
            font-family: 'DM Sans', sans-serif; font-size: .88rem; color: var(--gray-800);
            transition: var(--transition); outline: none;
        }
        .form-input:focus { border-color: var(--green-500); box-shadow: 0 0 0 3px rgba(34,197,94,.12); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .modal-tabs { display: flex; margin-bottom: 24px; background: var(--gray-100); border-radius: 8px; padding: 4px; }
        .modal-tab {
            flex: 1; text-align: center; padding: 8px; border-radius: 6px; font-size: .84rem;
            font-weight: 600; cursor: pointer; transition: var(--transition); color: var(--gray-500);
        }
        .modal-tab.active { background: var(--white); color: var(--green-700); box-shadow: var(--shadow-sm); }
        .form-check { display: flex; align-items: center; gap: 8px; font-size: .82rem; color: var(--gray-600); }
        .form-link { color: var(--green-700); font-weight: 600; cursor: pointer; }
        .form-divider { display: flex; align-items: center; gap: 12px; margin: 18px 0; color: var(--gray-400); font-size: .78rem; }
        .form-divider::before, .form-divider::after { content:''; flex:1; height:1px; background:var(--gray-200); }
        .oauth-btn {
            width: 100%; display: flex; align-items: center; justify-content: center; gap: 10px;
            padding: 10px; border: 1.5px solid var(--gray-200); border-radius: 8px;
            font-size: .84rem; font-weight: 600; cursor: pointer; background: var(--white);
            transition: var(--transition); color: var(--gray-700); font-family: 'DM Sans', sans-serif;
        }
        .oauth-btn:hover { border-color: var(--gray-400); background: var(--gray-50); }

        /* ── REGISTER MODAL ── */
        #registerModal .modal { max-width: 520px; }

        /* ── EVENT REG MODAL ── */
        .event-reg-info { background: var(--green-50); border-radius: 8px; padding: 14px 16px; margin-bottom: 20px; }
        .event-reg-info h4 { font-size: .9rem; color: var(--green-900); margin-bottom: 4px; }
        .event-reg-info p { font-size: .8rem; color: var(--gray-500); }

        /* ── SCROLL ANIMATIONS ── */
        .reveal { opacity: 0; transform: translateY(28px); transition: opacity .6s ease, transform .6s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: .1s; }
        .reveal-delay-2 { transition-delay: .2s; }
        .reveal-delay-3 { transition-delay: .3s; }
        .reveal-delay-4 { transition-delay: .4s; }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .admin-kpis { grid-template-columns: 1fr 1fr; }
            .admin-charts { grid-template-columns: 1fr; }
            .community-grid { grid-template-columns: 1fr; gap: 40px; }
            .about-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .announce-grid { grid-template-columns: 1fr; }
            .hero-card { display: none; }
        }
        @media (max-width: 700px) {
            .nav-links, .nav-actions { display: none; }
            .hamburger { display: flex; }
            .admin-inner { grid-template-columns: 1fr; }
            .admin-sidebar { display: none; }
            .footer-grid { grid-template-columns: 1fr; }
            .community-right { grid-template-columns: 1fr 1fr; }
            .form-row { grid-template-columns: 1fr; }
            .values-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 480px) {
            .prayer-grid { grid-template-columns: 1fr 1fr; }
            .admin-kpis { grid-template-columns: 1fr 1fr; }
            .events-grid { grid-template-columns: 1fr; }
        }

        /* ── TOAST ── */
        .toast-container { position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; }
        .toast {
            background: var(--green-800); color: var(--white); border-radius: 10px;
            padding: 14px 20px; font-size: .84rem; display: flex; align-items: center; gap: 10px;
            box-shadow: var(--shadow-lg); animation: toastIn .3s ease; min-width: 240px;
        }
        .toast i { color: var(--green-400); }
        @keyframes toastIn { from{opacity:0;transform:translateX(40px)} to{opacity:1;transform:translateX(0)} }
    </style>
    @stack('styles')
</head>
<body>

<!-- NAVBAR -->
<nav id="navbar">
    <div class="container nav-inner">
        <a href="{{ route('home') }}" class="nav-logo">
            <div class="logo-icon"><i class="fas fa-mosque"></i></div>
            MasjidTech
        </a>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('home') }}#about">About</a></li>
            <li><a href="{{ route('home') }}#prayer">Prayer Times</a></li>
            <li><a href="{{ route('events.index') }}">Events</a></li>
            <li><a href="{{ route('home') }}#announcements">Announcements</a></li>
            @auth
                @if(auth()->user()->isAdmin())
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                @else
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                @endif
            @endauth
        </ul>
        <div class="nav-actions">
            @guest
                <button class="btn btn-outline" onclick="openModal('loginModal')">Login</button>
                <button class="btn btn-primary" onclick="openModal('registerModal')">Register</button>
            @else
                <span class="badge badge-green" style="padding:8px 16px;">{{ auth()->user()->name }}</span>
                <a href="{{ route('logout') }}" class="btn btn-outline" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            @endguest
        </div>
        <button class="hamburger" id="hamburger" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

<!-- Mobile menu -->
<div class="mobile-menu" id="mobileMenu">
    <a href="{{ route('home') }}" onclick="closeMobileMenu()">Home</a>
    <a href="{{ route('home') }}#about" onclick="closeMobileMenu()">About</a>
    <a href="{{ route('home') }}#prayer" onclick="closeMobileMenu()">Prayer Times</a>
    <a href="{{ route('events.index') }}" onclick="closeMobileMenu()">Events</a>
    <a href="{{ route('home') }}#announcements" onclick="closeMobileMenu()">Announcements</a>
    @auth
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" onclick="closeMobileMenu()">Dashboard</a>
        @else
            <a href="{{ route('dashboard') }}" onclick="closeMobileMenu()">Dashboard</a>
        @endif
    @endauth
    <div class="mobile-actions">
        @guest
            <button class="btn btn-outline" onclick="closeMobileMenu();openModal('loginModal')">Login</button>
            <button class="btn btn-primary" onclick="closeMobileMenu();openModal('registerModal')">Register</button>
        @else
            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="btn btn-outline">Logout</button></form>
        @endguest
    </div>
</div>

<main>
    @yield('content')
</main>

<!-- FOOTER -->
<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="nav-logo" style="margin-bottom:0">
                    <div class="logo-icon"><i class="fas fa-mosque"></i></div>
                    MasjidTech
                </div>
                <p>Empowering mosques with modern digital tools for better community management and engagement. Built with care for the ummah.</p>
                <div class="social-links" style="margin-top:20px">
                    <a class="social-btn" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="social-btn" href="#"><i class="fab fa-instagram"></i></a>
                    <a class="social-btn" href="#"><i class="fab fa-youtube"></i></a>
                    <a class="social-btn" href="#"><i class="fab fa-telegram-plane"></i></a>
                    <a class="social-btn" href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#prayer">Prayer Times</a></li>
                    <li><a href="{{ route('events.index') }}">Events</a></li>
                    <li><a href="#announcements">Announcements</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Services</h4>
                <ul>
                    <li><a href="#">Nikah Registration</a></li>
                    <li><a href="#">Islamic Classes</a></li>
                    <li><a href="#">Zakat Calculator</a></li>
                    <li><a href="#">Online Donation</a></li>
                    <li><a href="#">Funeral Services</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact Us</h4>
                <div class="contact-item"><i class="fas fa-map-marker-alt"></i><span>Jalan Masjid Al-Noor, 50000 Kuala Lumpur, Malaysia</span></div>
                <div class="contact-item"><i class="fas fa-phone"></i><span>+603-2698 8000</span></div>
                <div class="contact-item"><i class="fas fa-envelope"></i><span>info@masjidalnoor.my</span></div>
                <div class="contact-item"><i class="fas fa-clock"></i><span>Open daily · 24 hours</span></div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 MasjidTech · Masjid Al-Noor. All rights reserved.</p>
            <p style="color:rgba(255,255,255,.2)">Built for Web Development Project · University Technology Malaysia</p>
        </div>
    </div>
</footer>

<!-- MODALS -->
<div class="modal-overlay" id="loginModal">
    <div class="modal">
        <div class="modal-header">
            <h2>Welcome Back</h2>
            <p>Sign in to your MasjidTech account</p>
            <button class="modal-close" onclick="closeModal('loginModal')"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            @if ($errors->any())
                <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="modal-tabs">
                <div class="modal-tab active" onclick="switchTab(this,'login')">Member Login</div>
                <div class="modal-tab" onclick="switchTab(this,'admin')">Admin Login</div>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" placeholder="you@example.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" placeholder="Enter your password" required>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
                    <label class="form-check"><input type="checkbox" name="remember" style="accent-color:var(--green-600)"> Remember me</label>
                    <a href="#" class="form-link" style="font-size:.82rem">Forgot password?</a>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:13px"><i class="fas fa-sign-in-alt"></i> Sign In</button>
            </form>
            <div class="form-divider">or continue with</div>
            <button class="oauth-btn"><img src="https://www.google.com/favicon.ico" width="16"> Continue with Google</button>
            <p style="text-align:center;font-size:.82rem;color:var(--gray-500);margin-top:16px">Don't have an account? <a href="#" class="form-link" onclick="closeModal('loginModal');openModal('registerModal')">Register here</a></p>
        </div>
    </div>
</div>

<div class="modal-overlay" id="registerModal">
    <div class="modal" style="max-width:520px">
        <div class="modal-header">
            <h2>Join Our Community</h2>
            <p>Create your MasjidTech member account</p>
            <button class="modal-close" onclick="closeModal('registerModal')"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            @if ($errors->any())
                <div style="background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 8px; margin-bottom: 16px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-input" placeholder="Ahmad Zaki" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" placeholder="ahmad@example.com" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" name="phone" class="form-input" placeholder="+60 12-345 6789" value="{{ old('phone') }}">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-input" placeholder="Min. 8 characters" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-input" placeholder="Re-enter password" required>
                    </div>
                </div>
                <div style="margin-bottom:20px">
                    <label class="form-check">
                        <input type="checkbox" name="terms" value="1" style="accent-color:var(--green-600)" required>
                        I agree to the <a href="#" class="form-link">Terms & Conditions</a>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:13px"><i class="fas fa-user-plus"></i> Create Account</button>
            </form>
            <p style="text-align:center;font-size:.82rem;color:var(--gray-500);margin-top:16px">Already a member? <a href="#" class="form-link" onclick="closeModal('registerModal');openModal('loginModal')">Sign in</a></p>
        </div>
    </div>
</div>

<div class="modal-overlay" id="eventRegModal">
    <div class="modal">
        <div class="modal-header">
            <h2>Register for Event</h2>
            <p>Complete your registration below</p>
            <button class="modal-close" onclick="closeModal('eventRegModal')"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="event-reg-info">
                <h4 id="eventRegTitle">Loading...</h4>
                <p id="eventRegMeta"></p>
            </div>
            <form id="eventRegForm" method="POST" action="">
                @csrf
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-input" value="{{ auth()->user()->name ?? '' }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" value="{{ auth()->user()->email ?? '' }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" name="phone" class="form-input" value="{{ auth()->user()->phone ?? '' }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Number of Attendees</label>
                    <input type="number" name="attendees_count" class="form-input" min="1" max="10" value="1" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:13px"><i class="fas fa-check-circle"></i> Confirm Registration</button>
            </form>
        </div>
    </div>
</div>

<!-- TOAST CONTAINER -->
<div class="toast-container" id="toastContainer"></div>

<script>
    // NAVBAR SCROLL
    window.addEventListener('scroll', () => {
        document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 10);
    });

    // HAMBURGER MENU
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');
    if (hamburger) {
        hamburger.addEventListener('click', () => mobileMenu.classList.toggle('open'));
    }
    function closeMobileMenu() { mobileMenu.classList.remove('open'); }

    // MODAL CONTROLS
    function openModal(id) {
        document.getElementById(id).classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('open');
        document.body.style.overflow = '';
    }
    document.querySelectorAll('.modal-overlay').forEach(o => {
        o.addEventListener('click', e => { if(e.target === o) closeModal(o.id); });
    });
    document.addEventListener('keydown', e => {
        if(e.key === 'Escape') document.querySelectorAll('.modal-overlay.open').forEach(o => closeModal(o.id));
    });

    function switchTab(el, type) {
        el.parentElement.querySelectorAll('.modal-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
    }

    // Get next prayer info from the HTML (set by Blade)
    const nextPrayerNameElement = document.getElementById('nextPrayerName');
    const nextPrayerTimeElement = document.getElementById('nextPrayerTime');
    const countdownSpan = document.getElementById('prayerCountdown');

    function updateCountdown() {
        if (!nextPrayerTimeElement) return;
        // Expected format from Blade: "HH:MM" e.g. "16:28"
        const timeStr = nextPrayerTimeElement.innerText;
        const [hours, minutes] = timeStr.split(':').map(Number);
        const now = new Date();
        let target = new Date();
        target.setHours(hours, minutes, 0, 0);
        if (now > target) {
            target.setDate(target.getDate() + 1);
        }
        const diff = target - now;
        const h = Math.floor(diff / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);
        if (countdownSpan) {
            countdownSpan.innerText = h > 0 ? `${h}hr ${m}min ${s}s` : `${m}min ${s}s`;
        }
    }

    function updatePrayerState() {
    const prayerCards = document.querySelectorAll('.prayer-card');
    const nextPrayerNameSpan = document.getElementById('nextPrayerName');
    const nextPrayerTimeSpan = document.getElementById('nextPrayerTime');

    // Get current time in HH:MM
    const now = new Date();
    const currentTime = now.getHours() * 60 + now.getMinutes();

    // Prayer times from the DOM (extract from each card)
    let prayers = [];
    prayerCards.forEach(card => {
        const name = card.querySelector('.prayer-name')?.innerText.trim();
        const timeElem = card.querySelector('.prayer-time');
        if (name && timeElem) {
            const [hours, minutes] = timeElem.innerText.split(':').map(Number);
            const totalMinutes = hours * 60 + minutes;
            prayers.push({ name, time: totalMinutes, element: card });
        }
    });
    if (prayers.length === 0) return;

    // Sort by time
    prayers.sort((a,b) => a.time - b.time);

    // Find current and next prayer
    let currentPrayer = null;
    let nextPrayer = null;
    for (let i = 0; i < prayers.length; i++) {
        if (prayers[i].time <= currentTime) {
            currentPrayer = prayers[i];
        } else {
            nextPrayer = prayers[i];
            break;
        }
    }
    // If no next prayer (all passed), take first of tomorrow
    if (!nextPrayer) nextPrayer = prayers[0];

    // Update active class
    prayerCards.forEach(card => card.classList.remove('active'));
    if (currentPrayer) currentPrayer.element.classList.add('active');
    else prayers[0].element.classList.add('active'); // fallback

    // Update next prayer name and time in hero card
    if (nextPrayerNameSpan) nextPrayerNameSpan.innerText = nextPrayer.name;
    if (nextPrayerTimeSpan) {
        const hours = Math.floor(nextPrayer.time / 60);
        const minutes = nextPrayer.time % 60;
        nextPrayerTimeSpan.innerText = `${hours.toString().padStart(2,'0')}:${minutes.toString().padStart(2,'0')}`;
    }
}

    // Run every minute (60000 ms) to update active prayer and next prayer
    setInterval(updatePrayerState, 60000);
    updatePrayerState(); // initial run

    // Run every second for smooth ticking
    setInterval(updateCountdown, 1000);
    updateCountdown();

    // REVEAL ON SCROLL
    function observeReveal() {
        const els = document.querySelectorAll('.reveal:not(.visible)');
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
        }, { threshold: 0.12 });
        els.forEach(el => obs.observe(el));
    }
    observeReveal();

    // TOAST
    function showToast(msg, icon='check-circle') {
        const t = document.createElement('div');
        t.className = 'toast';
        t.innerHTML = `<i class='fas fa-${icon}'></i> ${msg}`;
        document.getElementById('toastContainer').appendChild(t);
        setTimeout(() => t.remove(), 4000);
    }

    // EVENT REGISTRATION MODAL POPULATE (call from event listing)
    window.openEventReg = function(eventId, title, date, location) {
        document.getElementById('eventRegTitle').innerText = title;
        document.getElementById('eventRegMeta').innerHTML = `<i class="fas fa-calendar"></i> ${date} &nbsp;·&nbsp; <i class="fas fa-map-marker-alt"></i> ${location}`;
        const form = document.getElementById('eventRegForm');
        form.action = `/events/${eventId}/register`;
        openModal('eventRegModal');
    }

    // Auto-open login modal if there are validation errors
    if (document.querySelector('#loginModal .modal-body .text-danger, #loginModal .modal-body ul') && !document.querySelector('#loginModal.open')) {
        openModal('loginModal');
    }
</script>

@stack('scripts')
</body>
</html>