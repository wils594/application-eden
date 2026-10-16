<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des parents - École Eden</title>

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
            --eden-bg:           #f3f6fb;
            --eden-border:       #e5eaf2;
        }

        body {
            background: var(--eden-bg);
            color: #1e293b;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Header ── */
        .eden-header {
            background: linear-gradient(120deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 22px 30px;
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.25);
            margin-bottom: 25px;
        }

        .eden-header-logo {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.18);
            border: 1.5px solid rgba(255, 255, 255, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .eden-header-logo svg { width: 24px; height: 24px; stroke: white; }

        .eden-header h1 {
            margin: 0 0 4px;
            font-size: 22px;
            letter-spacing: -0.4px;
            font-weight: 700;
        }

        .eden-header p {
            margin: 0;
            color: #dbeafe;
            font-size: 13px;
            font-weight: 500;
        }

        /* ── 🔙 Bouton retour ── */
        .eden-back-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.18);
            border: 1.5px solid rgba(255, 255, 255, 0.25);
            color: white;
            text-decoration: none;
            flex-shrink: 0;
            transition: background 0.18s ease, transform 0.18s ease;
        }

        .eden-back-btn svg { width: 22px; height: 22px; stroke: currentColor; }
        .eden-back-btn:hover { background: rgba(255, 255, 255, 0.28); transform: translateX(-2px); color: white; }

        /* ── Bouton principal ── */
        .btn-eden {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
            color: white;
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.3);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .btn-eden:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.4);
        }

        .btn-eden svg { width: 16px; height: 16px; stroke: currentColor; }

        /* ── Statistique ── */
        .eden-stat {
            background: white;
            border: 1px solid var(--eden-border);
            border-radius: 14px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .eden-stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.1);
        }

        .eden-stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .eden-stat-icon svg { width: 24px; height: 24px; stroke: var(--eden-primary); }

        .eden-stat-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
        }

        .eden-stat-number {
            margin-top: 4px;
            font-size: 26px;
            font-weight: 700;
            color: #0f1f3d;
            letter-spacing: -0.5px;
        }

        /* ── Carte tableau ── */
        .eden-card {
            background: white;
            border: 1px solid var(--eden-border);
            border-radius: 16px;
            padding: 8px;
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
            overflow-x: auto;
        }

        /* ── Recherche ── */
        .eden-search {
            position: relative;
            padding: 12px;
            padding-bottom: 4px;
        }

        .eden-search > svg {
            position: absolute;
            left: 26px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            stroke: #94a3b8;
            pointer-events: none;
            z-index: 2;
        }

        .eden-search input {
            width: 100%;
            max-width: 400px;
            padding: 12px 14px 12px 42px;
            border: 1px solid #dce4f0;
            border-radius: 10px;
            font-size: 14px;
            background: white;
            color: #1e293b;
            outline: none;
            transition: border-color 0.18s ease, box-shadow 0.18s ease;
        }

        .eden-search input:focus {
            border-color: var(--eden-primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .eden-search input::placeholder { color: #94a3b8; }

        /* ── Table ── */
        .eden-table table { margin-bottom: 0; min-width: 600px; }

        .eden-table thead th {
            background: #f8fafc;
            color: #475569;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            border-bottom: 1px solid #eef2f8;
            padding: 15px 14px;
            white-space: nowrap;
        }

        .eden-table tbody td {
            padding: 15px 14px;
            font-size: 14px;
            vertical-align: middle;
            border-bottom: 1px solid #eef2f8;
        }

        .eden-table tbody tr:hover { background: #f8fafc; }
        .eden-table tbody tr:last-child td { border-bottom: none; }

        /* ── Badge "À associer" ── */
        .badge-eden-warning {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff7ed;
            color: #c2410c;
            padding: 5px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-eden-warning::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #ea580c;
        }

        /* ── État vide ── */
        .eden-empty-icon {
            width: 76px;
            height: 76px;
            border-radius: 50%;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .eden-empty-icon svg { width: 36px; height: 36px; stroke: var(--eden-primary); }

        /* ── Responsive ── */
        @media (max-width: 700px) {
            .eden-header { padding: 18px; }
            .eden-header h1 { font-size: 18px; }
        }
    </style>
</head>

<body>

    <!-- ═══════════════════════════════════════════
         HEADER
         ═══════════════════════════════════════════ -->
    <header class="eden-header">
        <div class="container-fluid" style="max-width: 1200px;">
            <div class="d-flex align-items-center gap-3">

                <!-- 🔙 BOUTON RETOUR -->
                <a href="{{ url('/admin') }}" class="eden-back-btn" title="Retour au tableau de bord">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"/>
                        <polyline points="12 19 5 12 12 5"/>
                    </svg>
                </a>

                <div class="eden-header-logo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                </div>
                <div>
                    <h1>École Eden</h1>
                    <p>Administration — Gestion des parents</p>
                </div>
            </div>
        </div>
    </header>

    <main class="container-fluid" style="max-width: 1200px; padding-top: 5px; padding-bottom: 30px;">

        {{-- ── Titre + description ── --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1" style="color:#0f1f3d;font-size:20px;letter-spacing:-0.3px;">Liste des parents</h2>
                <p class="text-muted mb-0" style="font-size:13.5px;">
                    Consultez les comptes et préparez l'association avec les élèves.
                </p>
            </div>
        </div>

        {{-- ── Statistiques ── --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4 col-12">
                <div class="eden-stat">
                    <div class="eden-stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <div>
                        <div class="eden-stat-label">Comptes affichés</div>
                        <div class="eden-stat-number">{{ $parents->count() }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Carte avec recherche + tableau ── --}}
        <div class="eden-card">

            {{-- Recherche --}}
            <div class="eden-search">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input
                    type="search"
                    id="recherche"
                    placeholder="Rechercher par nom ou e-mail..."
                    oninput="filtrerParents()"
                >
            </div>

            {{-- Tableau --}}
            <div class="eden-table table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>E-mail</th>
                            <th>Association</th>
                        </tr>
                    </thead>

                    <tbody id="listeParents">
                        @forelse ($parents as $parent)
                            <tr>
                                <td>{{ $parent->name }}</td>
                                <td>{{ $parent->email }}</td>
                                <td>
                                    <span class="badge-eden-warning">À associer</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center gap-3">
                                        <div class="eden-empty-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                                <circle cx="9" cy="7" r="4"/>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                            </svg>
                                        </div>
                                        <p class="fw-semibold mb-0" style="color:#0f1f3d;">Aucun compte utilisateur trouvé.</p>
                                        <p class="text-muted mb-0" style="font-size:13px;max-width:320px;">
                                            Les parents enregistrés apparaîtront ici automatiquement.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- ═══════════════════════════════════════════
         BOOTSTRAP JS (CDN)
         ═══════════════════════════════════════════ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function filtrerParents() {
            const recherche = document.getElementById('recherche').value.toLowerCase();

            document.querySelectorAll('#listeParents tr').forEach(ligne => {
                ligne.style.display = ligne.textContent.toLowerCase().includes(recherche)
                    ? ''
                    : 'none';
            });
        }
    </script>
</body>
</html>