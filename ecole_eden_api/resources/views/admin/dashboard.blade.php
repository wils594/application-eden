<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration | École Eden</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            background: #f4f7fb;
            color: #172033;
            -webkit-font-smoothing: antialiased;
        }

        .layout { display: flex; min-height: 100vh; }

        /* ── Sidebar ── */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #142b52 0%, #0f1f3d 100%);
            color: white;
            padding: 26px 18px;
            display: flex;
            flex-direction: column;
        }

        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 6px;
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.35);
            flex-shrink: 0;
        }

        .brand-logo svg { width: 22px; height: 22px; stroke: white; }

        .brand {
            font-size: 17px;
            font-weight: 700;
            letter-spacing: -0.3px;
            line-height: 1.1;
        }

        .subtitle {
            color: #c6d4ed;
            font-size: 11px;
            margin-left: 52px;
            margin-bottom: 35px;
            font-weight: 500;
        }

        .menu-title {
            color: #7d92b8;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin: 22px 10px 10px;
            font-weight: 700;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 12px;
            margin-bottom: 5px;
            color: #dbe5f7;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 500;
            transition: background 0.18s ease, color 0.18s ease, transform 0.18s ease;
        }

        .menu a svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            flex-shrink: 0;
            opacity: 0.85;
        }

        .menu a.active,
        .menu a:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            transform: translateX(2px);
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.35);
        }

        .menu a.active svg,
        .menu a:hover svg { opacity: 1; }

        /* ── Main ── */
        .main { flex: 1; min-width: 0; }

        .topbar {
            background: white;
            padding: 16px 30px;
            border-bottom: 1px solid #e5eaf2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.4px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .admin-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
            display: none;
        }

        .bell-btn {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #f4f7fb;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.18s ease;
        }

        .bell-btn:hover { background: #e8eefb; }

        .bell-btn svg {
            width: 20px;
            height: 20px;
            stroke: #172033;
        }

        .bell-dot {
            position: absolute;
            top: 9px;
            right: 10px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid #f4f7fb;
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
            cursor: pointer;
        }

        /* ── Content ── */
        .content { padding: 30px; }

        .welcome {
            padding: 28px;
            border-radius: 18px;
            color: white;
            background: linear-gradient(120deg, #2563eb 0%, #173b83 100%);
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 18px 40px rgba(37, 99, 235, 0.25);
        }

        .welcome-icon {
            width: 62px;
            height: 62px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.18);
            border: 1.5px solid rgba(255, 255, 255, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .welcome-icon svg {
            width: 30px;
            height: 30px;
            stroke: white;
        }

        .welcome-text h2 {
            margin: 0 0 8px;
            font-size: 20px;
            letter-spacing: -0.4px;
        }

        .welcome-text p {
            margin: 0;
            line-height: 1.6;
            color: #dbe7ff;
            font-size: 14px;
        }

        .section-title {
            margin: 0 0 17px;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: "";
            width: 4px;
            height: 20px;
            background: #2563eb;
            border-radius: 4px;
        }

        /* ── Cards ── */
        .cards {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 28px;
        }

        .card {
            background: white;
            padding: 22px;
            border: 1px solid #e5eaf2;
            border-radius: 15px;
            box-shadow: 0 4px 14px rgba(15, 31, 61, 0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.12);
        }

        .card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .card-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-icon svg { width: 22px; height: 22px; }

        .card-icon.blue { background: #eff6ff; }
        .card-icon.blue svg { stroke: #2563eb; }

        .card-icon.orange { background: #fff7ed; }
        .card-icon.orange svg { stroke: #ea580c; }

        .card-icon.purple { background: #f5f3ff; }
        .card-icon.purple svg { stroke: #7c3aed; }

        .card-icon.green { background: #dcfce7; }
        .card-icon.green svg { stroke: #16a34a; }

        .card-icon.pink { background: #fce7f3; }
        .card-icon.pink svg { stroke: #db2777; }

        .card-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
        }

        .card-number {
            font-size: 30px;
            font-weight: 700;
            margin: 6px 0 10px;
            letter-spacing: -0.8px;
            color: #0f1f3d;
        }

        .card-note {
            color: #64748b;
            font-size: 12px;
            line-height: 1.5;
        }

        .card-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 12px;
            color: #2563eb;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            transition: gap 0.15s ease;
        }

        .card-link svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
        }

        .card-link:hover { gap: 10px; }

        /* ── Actions rapides ── */
        .quick-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .action {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 13px 18px;
            background: white;
            border: 1px solid #dce4f0;
            border-radius: 11px;
            text-decoration: none;
            color: #1d4ed8;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.18s ease;
            box-shadow: 0 3px 10px rgba(15, 31, 61, 0.03);
        }

        .action svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
        }

        .action .arrow {
            width: 15px;
            height: 15px;
            opacity: 0.6;
            transition: transform 0.18s ease, opacity 0.18s ease;
        }

        .action:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.3);
        }

        .action:hover .arrow {
            transform: translateX(4px);
            opacity: 1;
        }

        /* ── Responsive ── */
        @media (max-width: 1050px) {
            .cards { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 850px) {
            .sidebar { width: 200px; }
            .content { padding: 20px; }
            .welcome { flex-direction: column; text-align: center; }
        }

        @media (max-width: 600px) {
            .layout { display: block; }
            .sidebar {
                width: 100%;
                padding: 16px;
                flex-direction: column;
            }
            .subtitle { margin-bottom: 15px; margin-left: 52px; }
            .menu { display: flex; flex-wrap: wrap; gap: 6px; }
            .menu-title { display: none; }
            .menu a {
                padding: 9px 12px;
                margin: 0;
                font-size: 12px;
            }
            .menu a svg { width: 15px; height: 15px; }
            .menu a.active, .menu a:hover { transform: none; }

            .topbar { padding: 14px 16px; }
            .topbar h1 { font-size: 17px; }
            .admin-label { display: none; }
            .content { padding: 16px; }
            .welcome { padding: 22px; }
            .welcome-text h2 { font-size: 17px; }
            .section-title { font-size: 16px; }
            .cards { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="brand-wrap">
            <div class="brand-logo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                </svg>
            </div>
            <div class="brand">ÉCOLE EDEN</div>
        </div>
        <div class="subtitle">Espace d'administration</div>

        <nav class="menu">
            <div class="menu-title">Principal</div>
            <a href="/admin" class="active">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="9"/>
                    <rect x="14" y="3" width="7" height="5"/>
                    <rect x="14" y="12" width="7" height="9"/>
                    <rect x="3" y="16" width="7" height="5"/>
                </svg>
                Tableau de bord
            </a>
            <a href="/admin/eleves">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Gestion des élèves
            </a>

            <div class="menu-title">Scolarité</div>
            <a href="/admin/classes">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                </svg>
                Gestion des classes
            </a>

            <a href="/admin/notes">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                Gestion des notes
            </a>

            <a href="/admin/bulletins">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                Bulletins scolaires
            </a>

            <a href="/admin/annonces">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 11 18-5v12L3 14v-3z"/>
                    <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>
                </svg>
                Annonces
            </a>

            <div class="menu-title">Familles</div>
            <a href="/admin/parents">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Gestion des parents
            </a>
            <a href="/admin/parents/associer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                </svg>
                Associer parents ↔ élèves
            </a>

            <div class="menu-title">Communication</div>
            <a href="/admin/messages">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                Messagerie
            </a>
        </nav>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="topbar-left">
                <h1>Tableau de bord</h1>
            </div>
            <div class="topbar-right">
                <span class="admin-label">Administration École Eden</span>

                <div class="bell-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/>
                        <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
                    </svg>
                    <span class="bell-dot"></span>
                </div>

                <div class="admin-avatar">AD</div>
            </div>
        </header>

        <div class="content">
            <section class="welcome">
                <div class="welcome-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                </div>
                <div class="welcome-text">
                    <h2>Bienvenue dans votre espace d'administration</h2>
                    <p>
                        Gérez les élèves, les classes, les bulletins et les
                        informations destinées aux parents depuis cet espace.
                    </p>
                </div>
            </section>

            <h2 class="section-title">Vue d'ensemble</h2>

            <section class="cards">
                <div class="card">
                    <div class="card-top">
                        <div class="card-icon blue">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-label">Élèves inscrits</div>
                    <div class="card-number">{{ $totalEleves }}</div>
                    <div class="card-note">Élèves enregistrés dans la base de données.</div>
                </div>

                <div class="card">
                    <div class="card-top">
                        <div class="card-icon orange">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-label">Classes</div>
                    <div class="card-number">—</div>
                    <div class="card-note">Données à charger depuis la base de données.</div>
                </div>

                <div class="card">
                    <div class="card-top">
                        <div class="card-icon green">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-label">Parents enregistrés</div>
                    <div class="card-number">{{ $totalParents }}</div>
                    <div class="card-note">Parents enregistrés dans la base de données.</div>

                    <a href="/admin/parents/associer" class="card-link">
                        Associer aux élèves
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </a>
                </div>

                <div class="card">
                    <div class="card-top">
                        <div class="card-icon pink">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-label">Notes enregistrées</div>
                    <div class="card-number">{{ $totalNotes ?? '—' }}</div>
                    <div class="card-note">Notes saisies dans la base de données.</div>

                    <a href="/admin/notes" class="card-link">
                        Gérer les notes
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </a>
                </div>
            </section>

            <h2 class="section-title">Actions rapides</h2>

            <div class="quick-actions">
                <a class="action" href="/admin/eleves">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Gérer les élèves
                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>

                <a class="action" href="/admin/parents">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    Gérer les parents
                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>

                <a class="action" href="/admin/parents/associer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                    </svg>
                    Associer parents ↔ élèves
                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>

                <a class="action" href="/admin/notes">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    Gérer les notes
                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>

                <a class="action" href="/admin/bulletins">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                    Gérer les bulletins
                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>

                <a class="action" href="/admin/annonces">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 11 18-5v12L3 14v-3z"/>
                        <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>
                    </svg>
                    Publier une annonce
                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
            </div>
        </div>
    </main>
</div>
</body>
</html>