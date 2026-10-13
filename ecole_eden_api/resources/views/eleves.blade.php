<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des élèves - École Eden</title>

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
            padding: 30px;
            max-width: 1200px;
            margin: auto;
        }

        /* ── Bandeau de succès ── */
        .alert-success {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 22px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-success svg {
            width: 22px;
            height: 22px;
            stroke: #16a34a;
            flex-shrink: 0;
        }

        /* ── Ligne d'outils ── */
        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }

        .top h2 {
            margin: 0 0 6px;
            font-size: 20px;
            letter-spacing: -0.3px;
            color: #0f1f3d;
        }

        .top p {
            margin: 0;
            color: #64748b;
            font-size: 13.5px;
        }

        /* ── Boutons ── */
        button,
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px 18px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            text-decoration: none;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.3);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        button:hover,
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.4);
        }

        button svg,
        .btn svg { width: 17px; height: 17px; stroke: currentColor; }

        .btn-secondary {
            background: white;
            color: #334155;
            border: 1px solid #dce4f0;
            box-shadow: 0 3px 10px rgba(15, 31, 61, 0.04);
        }

        .btn-secondary:hover {
            background: #f1f5f9;
            color: #1e293b;
            border-color: #cbd5e1;
            box-shadow: 0 8px 18px rgba(15, 31, 61, 0.08);
        }

        /* ── Champ de recherche ── */
        .search-wrapper {
            position: relative;
            flex: 1;
            min-width: 240px;
            max-width: 420px;
        }

        .search-wrapper svg {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            stroke: #94a3b8;
            pointer-events: none;
        }

        input[type="search"] {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1px solid #dce4f0;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            background: white;
            color: #1e293b;
            transition: border-color 0.18s ease, box-shadow 0.18s ease;
            outline: none;
        }

        input[type="search"]:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        input[type="search"]::placeholder { color: #94a3b8; }

        /* ── Carte tableau ── */
        .card {
            background: white;
            padding: 8px;
            border-radius: 16px;
            border: 1px solid #e5eaf2;
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        th, td {
            padding: 15px;
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

        th:first-child { border-top-left-radius: 10px; }
        th:last-child { border-top-right-radius: 10px; }

        tbody tr { transition: background 0.15s ease; }
        tbody tr:hover { background: #f8fafc; }
        tbody tr:last-child td { border-bottom: none; }

        /* ── Badge "Enregistré" ── */
        .badge-success {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #dcfce7;
            color: #166534;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #16a34a;
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
            .top .btn, .top button { width: 100%; justify-content: center; }
            .search-wrapper { max-width: none; }
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
                <p>Administration — Gestion des élèves</p>
            </div>
        </div>
    </header>

    <main>
        {{-- ✅ Bandeau de succès remonté au bon endroit --}}
        @if (session('success'))
            <div class="alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="top">
            <div>
                <h2>Liste des élèves</h2>
                <p>Consulte et recherche les élèves de l'établissement.</p>
            </div>

            <a href="{{ url('/admin/eleves/ajouter') }}" class="btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Ajouter un élève
            </a>
        </div>

        <div class="top">
            <div class="search-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input
                    type="search"
                    id="recherche"
                    placeholder="Rechercher un élève..."
                    oninput="filtrerEleves()"
                />
            </div>

            <a href="/admin" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"/>
                    <polyline points="12 19 5 12 12 5"/>
                </svg>
                Retour au tableau de bord
            </a>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Matricule</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Classe</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody id="listeEleves">
                    @forelse ($eleves as $eleve)
                        <tr>
                            <td>{{ $eleve->matricule }}</td>
                            <td>{{ $eleve->last_name }}</td>
                            <td>{{ $eleve->first_name }}</td>
                            <td>{{ $eleve->class_name }}</td>
                            <td>
                                <span class="badge-success">Enregistré</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">
                                <div class="empty-content">
                                    <div class="empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                            <circle cx="9" cy="7" r="4"/>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                        </svg>
                                    </div>
                                    <p class="empty-title">Aucun élève enregistré pour le moment.</p>
                                    <p class="empty-sub">
                                        Les élèves ajoutés apparaîtront ici automatiquement.
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
        function filtrerEleves() {
            const recherche = document
                .getElementById('recherche')
                .value
                .toLowerCase();

            document.querySelectorAll('#listeEleves tr').forEach(ligne => {
                ligne.style.display =
                    ligne.textContent.toLowerCase().includes(recherche)
                    ? ''
                    : 'none';
            });
        }
    </script>
</body>
</html>