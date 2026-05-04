<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VOLTEX — Backoffice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;600&display=swap" rel="stylesheet" />
    <style>
        :root {
            --volt:     #C8FF00;
            --volt-dim: #9FCC00;
            --night:    #080A0F;
            --surface:  #0D1017;
            --card:     #111520;
            --border:   rgba(200,255,0,.12);
            --muted:    #6B7280;
            --white:    #F4F6F8;
            --sidebar:  180px;
            --font-d:   'Bebas Neue', sans-serif;
            --font-b:   'DM Sans', sans-serif;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; overflow-x: hidden; }
        body { font-family: var(--font-b); background: var(--night); color: var(--white); display: flex; }

        /* ── Sidebar ── */
        .bo-sidebar {
            width: var(--sidebar);
            min-height: 100vh;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
        }
        .bo-logo {
            padding: 1.5rem 1.2rem;
            border-bottom: 1px solid var(--border);
        }
        .bo-logo-text {
            font-family: var(--font-d);
            font-size: 1.5rem;
            letter-spacing: .1em;
            color: var(--white);
            display: block;
            text-decoration: none;
        }
        .bo-logo-text span { color: var(--volt); }
        .bo-logo-sub { font-size: .6rem; letter-spacing: .2em; text-transform: uppercase; color: var(--muted); margin-top: .1rem; }

        .bo-nav { padding: 1rem 0; flex: 1; }
        .bo-nav-label { font-size: .55rem; letter-spacing: .25em; text-transform: uppercase; color: var(--muted); padding: .8rem 1.2rem .3rem; }
        .bo-nav-link {
            display: flex; align-items: center; gap: .65rem;
            padding: .65rem 1.2rem;
            color: var(--muted);
            text-decoration: none;
            font-size: .8rem;
            font-weight: 600;
            letter-spacing: .05em;
            transition: all .15s ease;
            border-left: 2px solid transparent;
            position: relative;
        }
        .bo-nav-link i { font-size: 1rem; }
        .bo-nav-link:hover { color: var(--white); background: rgba(200,255,0,.05); }
        .bo-nav-link.active { color: var(--volt); border-left-color: var(--volt); background: rgba(200,255,0,.07); }

        .bo-sidebar-footer {
            padding: 1rem 1.2rem;
            border-top: 1px solid var(--border);
            font-size: .7rem;
            color: var(--muted);
        }

        /* ── Main ── */
        .bo-main {
            margin-left: var(--sidebar);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Topbar ── */
        .bo-topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: .9rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .bo-topbar-title { font-family: var(--font-d); font-size: 1.4rem; letter-spacing: .06em; }
        .bo-topbar-right { display: flex; align-items: center; gap: .8rem; }
        .bo-badge-env {
            font-size: .58rem; font-weight: 700; letter-spacing: .15em; text-transform: uppercase;
            background: rgba(200,255,0,.12); color: var(--volt);
            border: 1px solid rgba(200,255,0,.25);
            padding: .2rem .6rem; border-radius: 2px;
        }
        .bo-btn {
            background: var(--volt); color: var(--night);
            font-size: .72rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
            border: none; padding: .45rem 1rem; border-radius: 2px;
            text-decoration: none; cursor: pointer;
            transition: background .15s;
        }
        .bo-btn:hover { background: var(--volt-dim); color: var(--night); }
        .bo-btn-outline {
            background: transparent; color: var(--muted);
            font-size: .72rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase;
            border: 1px solid var(--border); padding: .45rem 1rem; border-radius: 2px;
            text-decoration: none; cursor: pointer;
            transition: all .15s;
        }
        .bo-btn-outline:hover { border-color: var(--volt); color: var(--volt); }

        /* ── Content ── */
        .bo-content { padding: 2rem; flex: 1; }

        /* ── Cards ── */
        .bo-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .bo-card-title {
            font-size: .62rem; font-weight: 700; letter-spacing: .22em;
            text-transform: uppercase; color: var(--volt);
            margin-bottom: 1.2rem;
            display: flex; align-items: center; gap: .5rem;
        }

        /* ── Stat cards ── */
        .bo-stat {
            background: var(--card); border: 1px solid var(--border); border-radius: 4px;
            padding: 1.4rem 1.6rem;
            position: relative; overflow: hidden;
        }
        .bo-stat::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
            background: var(--volt);
        }
        .bo-stat-label { font-size: .62rem; letter-spacing: .2em; text-transform: uppercase; color: var(--muted); margin-bottom: .4rem; }
        .bo-stat-value { font-family: var(--font-d); font-size: 2.2rem; color: var(--volt); line-height: 1; }
        .bo-stat-icon { position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); font-size: 2rem; opacity: .08; color: var(--volt); }

        /* ── Table ── */
        .bo-table { width: 100%; border-collapse: collapse; font-size: .82rem; }
        .bo-table th {
            font-size: .58rem; letter-spacing: .2em; text-transform: uppercase;
            color: var(--muted); font-weight: 700;
            padding: .65rem 1rem; border-bottom: 1px solid var(--border);
            text-align: left; white-space: nowrap;
        }
        .bo-table td {
            padding: .85rem 1rem;
            border-bottom: 1px solid rgba(200,255,0,.05);
            color: var(--muted);
            vertical-align: middle;
        }
        .bo-table tr:hover td { background: rgba(200,255,0,.02); color: var(--white); }
        .bo-table tr:last-child td { border-bottom: none; }

        /* ── Badges statut ── */
        .bo-badge {
            font-size: .58rem; font-weight: 700; letter-spacing: .15em; text-transform: uppercase;
            padding: .2rem .6rem; border-radius: 2px; white-space: nowrap;
        }
        .bo-badge-payee, .bo-badge-accepte { background: rgba(200,255,0,.12); color: var(--volt); border: 1px solid rgba(200,255,0,.25); }
        .bo-badge-attente, .bo-badge-en_attente { background: rgba(255,179,71,.1); color: #FFB347; border: 1px solid rgba(255,179,71,.25); }
        .bo-badge-refuse, .bo-badge-refusee { background: rgba(255,68,68,.1); color: #FF4444; border: 1px solid rgba(255,68,68,.25); }
        .bo-badge-annule, .bo-badge-annulee { background: rgba(107,114,128,.12); color: var(--muted); border: 1px solid rgba(107,114,128,.2); }

        /* ── Info row ── */
        .bo-info-row { display: flex; justify-content: space-between; align-items: center; padding: .65rem 0; border-bottom: 1px solid rgba(200,255,0,.05); font-size: .83rem; }
        .bo-info-row:last-child { border-bottom: none; }
        .bo-info-row .label { color: var(--muted); font-size: .75rem; }
        .bo-info-row .value { color: var(--white); font-weight: 600; text-align: right; }

        /* ── Breadcrumb ── */
        .bo-breadcrumb { display: flex; align-items: center; gap: .4rem; font-size: .72rem; color: var(--muted); margin-bottom: 1.5rem; }
        .bo-breadcrumb a { color: var(--muted); text-decoration: none; transition: color .15s; }
        .bo-breadcrumb a:hover { color: var(--volt); }
        .bo-breadcrumb i { font-size: .6rem; }
        .bo-breadcrumb span { color: var(--white); }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: var(--night); }
        ::-webkit-scrollbar-thumb { background: var(--volt); border-radius: 2px; }
    </style>
</head>
<body>

<!-- ── SIDEBAR ── -->
<aside class="bo-sidebar">
    <div class="bo-logo">
        <a href="/backoffice/" class="bo-logo-text">VOLT<span>EX</span></a>
        <div class="bo-logo-sub">Backoffice</div>
    </div>

    <nav class="bo-nav">
        <div class="bo-nav-label">Navigation</div>
        <a href="/backoffice/"
           class="bo-nav-link <?php echo (!isset($_GET['pageBO']) || $_GET['pageBO'] === 'dashboard') ? 'active' : ''; ?>">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>
        <a href="/backoffice/commande/"
           class="bo-nav-link <?php echo (($_GET['pageBO'] ?? '') === 'commande') ? 'active' : ''; ?>">
            <i class="bi bi-receipt"></i> Commandes
        </a>
        <a href="/backoffice/paiement/"
           class="bo-nav-link <?php echo (($_GET['pageBO'] ?? '') === 'paiement') ? 'active' : ''; ?>">
            <i class="bi bi-credit-card"></i> Paiements
        </a>

        <div class="bo-nav-label" style="margin-top:.5rem;">API</div>
        <a href="/api/liste/" target="_blank" class="bo-nav-link">
            <i class="bi bi-braces"></i> Documentation
        </a>

        <div class="bo-nav-label" style="margin-top:.5rem;">Site</div>
        <a href="/" target="_blank" class="bo-nav-link">
            <i class="bi bi-box-arrow-up-right"></i> Voir le site
        </a>
    </nav>

    <div class="bo-sidebar-footer">
        <div style="font-size:.6rem; letter-spacing:.15em; text-transform:uppercase; color:var(--muted);">VOLTEX SAS</div>
        <div style="font-size:.65rem; color:rgba(107,114,128,.5); margin-top:.2rem;">v1.0 — Backoffice</div>
    </div>
</aside>

<!-- ── MAIN ── -->
<div class="bo-main">