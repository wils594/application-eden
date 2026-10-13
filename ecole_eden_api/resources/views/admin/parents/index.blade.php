<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des parents - École Eden</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            background: #f3f6fb;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Header ── */
        header {
            background: linear-gradient(120deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 22px 30px;
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.25);
        }

        .header-inner {
            max-width: 1200px;
            margin: auto;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .header-logo {
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

        .header-logo svg { width: 24px; height: 24px; stroke: white; }

        header h1 {
            margin: 0 0 4px;
            font-size: 22px;
            letter-spacing: -0.4px;
            font-weight: 700;
        }

        header p {
            margin: 0;
            color: #dbeafe;
            font-size: 13px;
            font-weight: 500;
        }

        /* ── Main ── */
        main {
            max-width: 1200px;
            margin: auto;
            padding: 30px;
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        h2 {
            margin: 0 0 7px;
            font-size: 20px;
            letter-spacing: -0.3px;
            color: #0f1f3d;
        }

        .description {
            margin: 0;
            color: #64748b;
            font-size: 13.5px;
        }

        /* ── Boutons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 18px;
            border-radius: 10px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            border: none;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.3);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .btn svg { width: 17px; height: 17px; stroke: currentColor; }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.4);
        }

        .btn-secondary {
            background: white;
            color: #334155;
            border: 1px solid #dce4f0;
            box-shadow: 0 3px 10px rgba(15, 31, 61, 0.04);
        }

        .btn-secondary:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            box-shadow: 0 8px 18px rgba(15, 31, 61, 0.08);
        }

        /* ── Statistique ── */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .stat {
            background: white;
            border: 1px solid #e5eaf2;
            border-radius: 14px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.1);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon svg { width: 24px; height: 24px; stroke: #2563eb; }

        .stat-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
        }

        .stat-number {
            margin-top: 4px;
            font-size: 26px;
            font-weight: 700;
            color: #0f1f3d;
            letter-spacing: -0.5px;
        }

        /* ── Carte tableau ── */
        .card {
            background: white;
            border: 1px solid #e5eaf2;
            border-radius: 16px;
            padding: 8px;
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
            overflow-x: auto;
        }

        /* ── Recherche ── */
        .search-wrapper {
            position: relative;
            padding: 12px;
            padding-bottom: 4px;
        }

        .search-wrapper svg {
            position: absolute;
            left: 26px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            stroke: #94a3b8;
            pointer-events: none;
        }

        input[type="search"] {
            width: 100%;
            max-width: 400px;
            padding: 12px 14px 12px 42px;
            border: 1px solid #dce4f0;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            background: white;
            color: #1e293b;
            outline: none;
            transition: border-color 0.18s ease, box-shadow 0.18s ease;
        }

        input[type="search"]:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        input[type="search"]::placeholder { color: #94a3b8; }

        /* ── Tableau ── */
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        th, td {
            padding: 15px 14px;
            text-align: left;
            border-bottom: 1px solid #eef2f8;
            font-size: 14px;
        }

        th {
            background: #f8fafc;
            color: #475569;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        tbody tr { transition: background 0.15s ease; }
        tbody tr:hover { background: #f8fafc; }
        tbody tr:last-child td { border-bottom: none; }

        /* ── Badge "À associer" ── */
        .badge-warning {
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

        .badge-warning::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #ea580c;
        }

        /* ── État vide ── */
        .empty {
            text-align: center;
            color: #64748b;
            padding: 45px 20px !important;
        }

        .empty-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .empty-icon {
            width: 76px;
            height: 76px;
            border-radius: 50%;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 6px;
        }

        .empty-icon svg { width: 36px; height: 36px; stroke: #2563eb; }

        .empty-title {
            color: #0f1f3d;
            font-size: 15px;
            font-weight: 600;
            margin: 0;
        }

        .empty-sub {
            color: #64748b;
            font-size: 13px;
            margin: 0;
            max-width: 320px;
            line-height: 1.5;
        }

        /* ── Responsive ── */
        @media (max-width: 700px) {
            main { padding: 18px; }
            .top { flex-direction: column; align-items: stretch; }
            .top .btn { width: 100%; justify-content: center; }
            header { padding: 18px; }
            header h1 { font-size: 18px; }
        }
    </style>
</head>

<body>
    <header>
        <div class="header-inner">
            <div class="header-logo">
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
    </header>

    <main>
        <div class="top">
            <div>
                <h2>Liste des parents</h2>
                <p class="description">Consultez les comptes et préparez l'association avec les élèves.</p>
            </div>

            <a href="{{ url('/admin') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"/>
                    <polyline points="12 19 5 12 12 5"/>
                </svg>
                Retour au tableau de bord
            </a>
        </div>

        <div class="stats">
            <div class="stat">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div>
                    <div class="stat-label">Comptes affichés</div>
                    <div class="stat-number">{{ $parents->count() }}</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="search-wrapper">
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

            <table>
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
                                <span class="badge-warning">À associer</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="empty">
                                <div class="empty-content">
                                    <div class="empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                            <circle cx="9" cy="7" r="4"/>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                        </svg>
                                    </div>
                                    <p class="empty-title">Aucun compte utilisateur trouvé.</p>
                                    <p class="empty-sub">
                                        Les parents enregistrés apparaîtront ici automatiquement.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

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