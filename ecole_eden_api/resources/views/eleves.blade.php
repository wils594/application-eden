<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des élèves - École Eden</title>

    <!-- ═══════════════════════════════════════════
         BOOTSTRAP 5 (CDN)
         ═══════════════════════════════════════════ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════════
           🎨 THÈME ÉCOLE EDEN (par-dessus Bootstrap)
           ═══════════════════════════════════════════ */
        :root {
            --eden-primary:        #2563eb;
            --eden-primary-dark:   #1d4ed8;
            --eden-bg:             #f3f6fb;
            --eden-text:           #1e293b;
            --eden-text-muted:     #64748b;
            --eden-border:         #e5eaf2;
        }

        body {
            background: var(--eden-bg);
            color: var(--eden-text);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Header personnalisé ── */
        .eden-header {
            background: linear-gradient(120deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 22px 30px;
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.25);
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

        /* ── Bouton principal ── */
        .btn-eden {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
            color: white;
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.3);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-eden:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.4);
        }

        .btn-eden svg { width: 17px; height: 17px; stroke: currentColor; }

        /* ── Bouton secondaire ── */
        .btn-eden-outline {
            background: white;
            color: #334155;
            border: 1px solid var(--eden-border);
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 3px 10px rgba(15, 31, 61, 0.04);
            transition: all 0.18s ease;
        }

        .btn-eden-outline:hover {
            background: #f1f5f9;
            color: #1e293b;
            border-color: #cbd5e1;
            box-shadow: 0 8px 18px rgba(15, 31, 61, 0.08);
        }

        .btn-eden-outline svg { width: 17px; height: 17px; stroke: currentColor; }

        /* ── Champ recherche ── */
        .eden-search {
            position: relative;
            flex: 1;
            max-width: 420px;
        }

        .eden-search > svg {
            position: absolute;
            left: 14px;
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
            padding: 12px 42px 12px 42px;
            border: 1px solid var(--eden-border);
            border-radius: 10px;
            font-size: 14px;
            background: white;
            color: var(--eden-text);
            outline: none;
            transition: border-color 0.18s ease, box-shadow 0.18s ease;
        }

        .eden-search input:focus {
            border-color: var(--eden-primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .eden-search input::placeholder { color: #94a3b8; }

        /* ── Bouton reset dans la recherche ── */
        .eden-search-reset {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: transparent;
            border: none;
            padding: 0;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            z-index: 3;
        }

        .eden-search-reset:hover { background: #f1f5f9; color: #475569; }
        .eden-search-reset.visible { display: flex; }
        .eden-search-reset svg { width: 16px; height: 16px; stroke: currentColor; }

        /* ── Badge compteur dans le header ── */
        .eden-header-count {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            color: white;
        }

        .eden-header-count svg { width: 16px; height: 16px; stroke: currentColor; }

        /* ── Table ── */
        .eden-table {
            background: white;
            border-radius: 16px;
            border: 1px solid var(--eden-border);
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
            overflow: hidden;
        }

        .eden-table table { margin-bottom: 0; }

        .eden-table thead th {
            background: #f8fafc;
            color: #475569;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            border-bottom: 1px solid #eef2f8;
            padding: 15px;
        }

        .eden-table tbody td {
            padding: 15px;
            font-size: 14px;
            vertical-align: middle;
            border-bottom: 1px solid #eef2f8;
        }

        .eden-table tbody tr:hover { background: #f8fafc; }
        .eden-table tbody tr:last-child td { border-bottom: none; }

        /* ── Badges ── */
        .badge-eden {
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

        .badge-eden::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #16a34a;
        }

        /* ── Boutons d'action ── */
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 9px;
            border: 1px solid var(--eden-border);
            background: white;
            color: #475569;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
            padding: 0;
        }

        .action-btn svg { width: 16px; height: 16px; stroke: currentColor; }

        .action-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(15, 31, 61, 0.08); }

        .action-btn.edit:hover { background: #eff6ff; border-color: #2563eb; color: #1d4ed8; }
        .action-btn.delete:hover { background: #fef2f2; border-color: #dc2626; color: #dc2626; }

        /* ── État vide ── */
        .empty-icon {
            width: 76px;
            height: 76px;
            border-radius: 50%;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-icon svg { width: 36px; height: 36px; stroke: #2563eb; }
    </style>
</head>

<body>
    <!-- ═══════════════════════════════════════════
         HEADER
         ═══════════════════════════════════════════ -->
    <header class="eden-header">
        <div class="container-fluid" style="max-width: 1200px;">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="eden-header-logo">
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

                <!-- ✅ Compteur d'élèves -->
                <div class="eden-header-count">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    {{ $eleves->count() }} élève(s)
                </div>
            </div>
        </div>
    </header>

    <!-- ═══════════════════════════════════════════
         MAIN
         ═══════════════════════════════════════════ -->
    <main class="container-fluid py-4" style="max-width: 1200px;">

        {{-- ✅ Bandeau de succès Bootstrap --}}
        @if (session('success'))
            <div class="alert alert-success d-flex align-items-center gap-3 border-0 rounded-3 mb-4"
                 style="background:#dcfce7;color:#166534;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span class="fw-semibold">{{ session('success') }}</span>
            </div>
        @endif

        {{-- ── Titre + bouton ajouter ── --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1" style="color:#0f1f3d;font-size:20px;">Liste des élèves</h2>
                <p class="text-muted mb-0" style="font-size:13.5px;">Consulte et recherche les élèves de l'établissement.</p>
            </div>

            <a href="{{ url('/admin/eleves/ajouter') }}" class="btn-eden text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Ajouter un élève
            </a>
        </div>

        {{-- ── recherche  retour ── --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div class="eden-search">
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
                <button type="button" class="eden-search-reset" id="resetRecherche" onclick="resetRecherche()" title="Effacer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            <a href="/admin" class="btn-eden-outline text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"/>
                    <polyline points="12 19 5 12 12 5"/>
                </svg>
                Retour au tableau de bord
            </a>
        </div>

        {{-- ── Tableau ── --}}
        <div class="eden-table table-responsive">
            <table class="table align-middle mb-0">
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
                                <div class="d-flex gap-2">
                                    <a href="{{ url('/admin/eleves/' . $eleve->id . '/modifier') }}"
                                       class="action-btn edit"
                                       title="Modifier">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9"/>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                        </svg>
                                    </a>

                                    <form action="{{ url('/admin/eleves/' . $eleve->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Supprimer cet élève ?');"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="action-btn delete"
                                                title="Supprimer">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                                <path d="M10 11v6"/>
                                                <path d="M14 11v6"/>
                                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center gap-3">
                                    <div class="empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                            <circle cx="9" cy="7" r="4"/>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                        </svg>
                                    </div>
                                    <p class="fw-semibold mb-0" style="color:#0f1f3d;">Aucun élève enregistré pour le moment.</p>
                                    <p class="text-muted mb-0" style="font-size:13px;max-width:320px;">
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

    <!-- ═══════════════════════════════════════════
         BOOTSTRAP JS (CDN)
         ═══════════════════════════════════════════ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function filtrerEleves() {
            const recherche = document
                .getElementById('recherche')
                .value
                .toLowerCase();

            let visible = 0;

            document.querySelectorAll('#listeEleves tr').forEach(ligne => {
                const match = ligne.textContent.toLowerCase().includes(recherche);
                ligne.style.display = match ? '' : 'none';
                if (match) visible++;
            });

            // Affiche / masque le bouton reset
            const resetBtn = document.getElementById('resetRecherche');
            resetBtn.classList.toggle('visible', recherche.length > 0);

            // Gestion du message "aucun résultat"
            const tbody = document.getElementById('listeEleves');
            const emptyRow = document.getElementById('emptySearchRow');

            if (visible === 0 && recherche !== '' && !emptyRow) {
                const tr = document.createElement('tr');
                tr.id = 'emptySearchRow';
                tr.innerHTML = `
                    <td colspan="5" class="text-center py-5">
                        <div class="d-flex flex-column align-items-center gap-3">
                            <div class="empty-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"/>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                </svg>
                            </div>
                            <p class="fw-semibold mb-0" style="color:#0f1f3d;">Aucun élève ne correspond à votre recherche.</p>
                            <p class="text-muted mb-0" style="font-size:13px;">Essayez avec un autre mot-clé.</p>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            } else if ((visible > 0 || recherche === '') && emptyRow) {
                emptyRow.remove();
            }
        }

        function resetRecherche() {
            document.getElementById('recherche').value = '';
            filtrerEleves();
            document.getElementById('recherche').focus();
        }
    </script>
</body>
</html>