<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>École Eden | Accueil</title>

    <!-- ═══════════════════════════════════════════
         BOOTSTRAP 5 (CDN)
         ═══════════════════════════════════════════ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════════
           🎨 THÈME ÉCOLE EDEN
           ═══════════════════════════════════════════ */
        :root {
            --eden-primary:      #2563eb;
            --eden-primary-dark: #1d4ed8;
            --eden-border:       #e5eaf2;
        }

        * { box-sizing: border-box; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            background: #f1f5f9;
            color: #0f172a;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ═══════════════════════════════════════════
           HEADER
           ═══════════════════════════════════════════ */
        .eden-header {
            background: white;
            border-bottom: 1px solid var(--eden-border);
            padding: 16px 8%;
            position: sticky;
            top: 0;
            z-index: 10;
            backdrop-filter: blur(10px);
        }

        .eden-header-logo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.3);
            flex-shrink: 0;
        }

        .eden-header-logo svg { width: 22px; height: 22px; stroke: white; }

        .eden-brand-name {
            font-size: 20px;
            font-weight: 700;
            color: #0f1f3d;
            letter-spacing: -0.3px;
            margin: 0;
            line-height: 1.2;
        }

        .eden-brand-name small {
            display: block;
            font-size: 11px;
            font-weight: 500;
            color: #64748b;
            margin-top: 2px;
            letter-spacing: 0;
        }

        .eden-header-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #eff6ff;
            color: #1d4ed8;
            text-decoration: none;
            font-weight: 600;
            font-size: 13.5px;
            padding: 10px 16px;
            border-radius: 10px;
            border: 1px solid #dbeafe;
            transition: all 0.18s ease;
        }

        .eden-header-link:hover {
            background: var(--eden-primary);
            color: white;
            border-color: var(--eden-primary);
            transform: translateY(-1px);
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.25);
        }

        .eden-header-link svg { width: 16px; height: 16px; stroke: currentColor; }

        /* ═══════════════════════════════════════════
           MAIN / HERO
           ═══════════════════════════════════════════ */
        .eden-main {
            flex: 1;
            padding: 60px 8%;
            display: flex;
            justify-content: center;
            align-items: center;
            background:
                radial-gradient(circle at 20% 20%, rgba(37, 99, 235, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(124, 58, 237, 0.06) 0%, transparent 50%),
                #f1f5f9;
        }

        .eden-hero {
            max-width: 900px;
            width: 100%;
            text-align: center;
        }

        /* ── Badge "Plateforme active" ── */
        .eden-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: var(--eden-primary);
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            border: 1px solid #dbeafe;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.08);
            margin-bottom: 24px;
        }

        .eden-badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #16a34a;
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.15);
        }

        /* ── Illustration ── */
        .eden-illustration {
            width: 110px;
            height: 110px;
            margin: 0 auto 26px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.3);
            position: relative;
        }

        .eden-illustration::before {
            content: "";
            position: absolute;
            inset: -10px;
            border-radius: 50%;
            border: 2px dashed rgba(37, 99, 235, 0.3);
            animation: edenRotate 20s linear infinite;
        }

        @keyframes edenRotate {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        .eden-illustration svg { width: 52px; height: 52px; stroke: white; }

        /* ── Titre principal ── */
        .eden-hero-title {
            font-size: 42px;
            line-height: 1.15;
            font-weight: 800;
            color: #0f1f3d;
            letter-spacing: -1.2px;
            margin-bottom: 20px;
        }

        .eden-hero-title span {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* ── Description ── */
        .eden-hero-text {
            font-size: 17px;
            line-height: 1.7;
            color: #475569;
            margin: 0 auto 34px;
            max-width: 620px;
        }

        /* ── Bouton principal ── */
        .btn-eden {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 16px 30px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 0.2px;
            border: none;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.35);
            transition: all 0.2s ease;
        }

        .btn-eden:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 16px 32px rgba(37, 99, 235, 0.45);
        }

        .btn-eden svg { width: 18px; height: 18px; stroke: currentColor; }

        /* ═══════════════════════════════════════════
           FEATURES
           ═══════════════════════════════════════════ */
        .eden-features {
            margin-top: 50px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .eden-feature {
            background: white;
            padding: 20px 16px;
            border-radius: 14px;
            border: 1px solid var(--eden-border);
            text-align: center;
            height: 100%;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .eden-feature:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 32px rgba(37, 99, 235, 0.1);
        }

        .eden-feature-icon {
            width: 44px;
            height: 44px;
            margin: 0 auto 12px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .eden-feature-icon svg { width: 22px; height: 22px; }

        .eden-feature.blue   .eden-feature-icon { background: #eff6ff; }
        .eden-feature.blue   .eden-feature-icon svg { stroke: var(--eden-primary); }

        .eden-feature.green  .eden-feature-icon { background: #f0fdf4; }
        .eden-feature.green  .eden-feature-icon svg { stroke: #16a34a; }

        .eden-feature.purple .eden-feature-icon { background: #f5f3ff; }
        .eden-feature.purple .eden-feature-icon svg { stroke: #7c3aed; }

        .eden-feature h3 {
            font-size: 14px;
            font-weight: 700;
            color: #0f1f3d;
            margin-bottom: 6px;
            letter-spacing: -0.2px;
        }

        .eden-feature p {
            font-size: 12px;
            color: #64748b;
            line-height: 1.5;
            font-weight: 500;
            margin: 0;
        }

        /* ═══════════════════════════════════════════
           FOOTER
           ═══════════════════════════════════════════ */
        .eden-footer {
            text-align: center;
            padding: 24px;
            color: #64748b;
            font-size: 13px;
            border-top: 1px solid var(--eden-border);
            background: white;
            font-weight: 500;
        }

        .eden-footer strong {
            color: #0f1f3d;
            font-weight: 700;
        }

        /* ═══════════════════════════════════════════
           RESPONSIVE
           ═══════════════════════════════════════════ */
        @media (max-width: 780px) {
            .eden-hero-title { font-size: 32px; }
            .eden-hero-text { font-size: 15px; }
            .eden-main { padding: 40px 6%; }
            .eden-header { padding: 14px 6%; }
            .eden-brand-name { font-size: 17px; }
            .eden-illustration { width: 90px; height: 90px; }
            .eden-illustration svg { width: 42px; height: 42px; }
        }
    </style>
</head>

<body>

    <!-- ═══════════════════════════════════════════
         HEADER
         ═══════════════════════════════════════════ -->
    <header class="eden-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div class="d-flex align-items-center gap-3">
                <div class="eden-header-logo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                </div>
                <h1 class="eden-brand-name">
                    École Eden
                    <small>Plateforme scolaire</small>
                </h1>
            </div>

            <a href="{{ url('/admin/login') }}" class="eden-header-link">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                Espace Administration
            </a>
        </div>
    </header>

    <!-- ═══════════════════════════════════════════
         MAIN / HERO
         ═══════════════════════════════════════════ -->
    <main class="eden-main">
        <div class="eden-hero">

            {{-- Badge --}}
            <div class="eden-badge">
                <span class="eden-badge-dot"></span>
                Plateforme active
            </div>

            {{-- Illustration --}}
            <div class="eden-illustration">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                </svg>
            </div>

            {{-- Titre --}}
            <h2 class="eden-hero-title">
                Bienvenue à <span>École Eden</span>
            </h2>

            {{-- Description --}}
            <p class="eden-hero-text">
                La plateforme scolaire qui facilite la communication
                entre les parents et l'établissement, et permet de suivre
                la scolarité des élèves.
            </p>

            {{-- Bouton principal --}}
            <div class="mb-2">
                <a class="btn-eden" href="{{ url('/admin/login') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                    Accéder à l'administration
                </a>
            </div>

            {{-- ═══════════════════════════════════════
                 FEATURES (Bootstrap grid)
                 ═══════════════════════════════════════ --}}
            <div class="row g-3 eden-features">

                {{-- Feature 1 : Parents --}}
                <div class="col-md-4">
                    <div class="eden-feature blue">
                        <div class="eden-feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                        <h3>Parents</h3>
                        <p>Un espace dédié pour suivre la scolarité</p>
                    </div>
                </div>

                {{-- Feature 2 : Suivi scolaire --}}
                <div class="col-md-4">
                    <div class="eden-feature green">
                        <div class="eden-feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                            </svg>
                        </div>
                        <h3>Suivi scolaire</h3>
                        <p>Notes, bulletins et résultats en temps réel</p>
                    </div>
                </div>

                {{-- Feature 3 : Communication --}}
                <div class="col-md-4">
                    <div class="eden-feature purple">
                        <div class="eden-feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                            </svg>
                        </div>
                        <h3>Communication</h3>
                        <p>Échangez facilement avec l'administration</p>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- ═══════════════════════════════════════════
         FOOTER
         ═══════════════════════════════════════════ -->
    <footer class="eden-footer">
        &copy; {{ date('Y') }} <strong>École Eden</strong>. Tous droits réservés.
    </footer>

    <!-- ═══════════════════════════════════════════
         BOOTSTRAP JS (CDN)
         ═══════════════════════════════════════════ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>