<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des annonces - École Eden</title>

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

        /* ── Bandeau succès ── */
        .eden-success {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
        }

        .eden-success svg { width: 22px; height: 22px; stroke: #16a34a; flex-shrink: 0; }

        /* ═══════════════════════════════════════════
           📑 SÉPARATEUR DE SECTION (nouveau)
           ═══════════════════════════════════════════ */
        .eden-section-label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin: 24px 0 14px;
            padding-left: 4px;
        }

        .eden-section-label::before {
            content: "";
            width: 4px;
            height: 16px;
            border-radius: 4px;
            background: var(--eden-primary);
        }

        .eden-section-label.draft::before { background: #ea580c; }

        .eden-section-label span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 3px 10px;
            border-radius: 20px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.3px;
            margin-left: 6px;
        }

        .eden-section-label.draft span {
            background: #fff7ed;
            color: #c2410c;
        }

        /* ── Carte annonce ── */
        .eden-card {
            background: white;
            padding: 22px;
            border-radius: 14px;
            border: 1px solid var(--eden-border);
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
            margin-bottom: 16px;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .eden-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.08);
        }

        /* Carte brouillon : bordure gauche orange */
        .eden-card.draft {
            border-left: 4px solid #ea580c;
        }

        /* Carte publiée : bordure gauche verte */
        .eden-card.published {
            border-left: 4px solid #16a34a;
        }

        .eden-card-title {
            margin: 0;
            font-size: 17px;
            font-weight: 700;
            color: #0f1f3d;
            letter-spacing: -0.2px;
        }

        /* ── Badges ── */
        .badge-eden {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-eden::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .badge-category  { background: #eff6ff; color: #1d4ed8; }
        .badge-category::before { background: var(--eden-primary); }

        .badge-published { background: #dcfce7; color: #166534; }
        .badge-published::before { background: #16a34a; }

        .badge-draft     { background: #fff7ed; color: #c2410c; }
        .badge-draft::before { background: #ea580c; }

        /* ── Contenu ── */
        .eden-content {
            color: #475569;
            font-size: 14px;
            line-height: 1.6;
            margin: 0 0 16px;
        }

        /* ── Meta ── */
        .eden-meta {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
            padding-top: 14px;
            border-top: 1px solid #eef2f8;
            margin-bottom: 14px;
        }

        .eden-meta-item {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #64748b;
            font-size: 12.5px;
            font-weight: 500;
        }

        .eden-meta-item svg { width: 15px; height: 15px; stroke: #94a3b8; flex-shrink: 0; }

        /* ── Bouton supprimer ── */
        .btn-eden-danger {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 15px;
            border-radius: 9px;
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: background 0.15s ease, border-color 0.15s ease;
        }

        .btn-eden-danger:hover {
            background: #fee2e2;
            border-color: #fca5a5;
            color: #dc2626;
        }

        .btn-eden-danger svg { width: 15px; height: 15px; stroke: currentColor; }

        /* ── État vide ── */
        .eden-empty {
            background: white;
            padding: 50px 24px;
            border-radius: 14px;
            border: 1px solid var(--eden-border);
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
            text-align: center;
        }

        .eden-empty-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
        }

        .eden-empty-icon svg { width: 38px; height: 38px; stroke: var(--eden-primary); }

        .eden-empty-title {
            margin: 0 0 8px;
            font-size: 17px;
            font-weight: 700;
            color: #0f1f3d;
        }

        .eden-empty-text {
            margin: 0 auto;
            color: #64748b;
            font-size: 14px;
            line-height: 1.5;
            max-width: 400px;
        }

        /* ── Pagination ── */
        .eden-pagination {
            display: flex;
            justify-content: center;
            margin-top: 24px;
        }

        .eden-pagination .pagination { margin-bottom: 0; gap: 6px; }
        .eden-pagination .page-link {
            color: var(--eden-primary);
            border: 1px solid var(--eden-border);
            border-radius: 9px;
            padding: 8px 13px;
            font-size: 13.5px;
            font-weight: 600;
        }
        .eden-pagination .page-link:hover {
            background: #eff6ff;
            color: var(--eden-primary-dark);
            border-color: var(--eden-primary);
        }
        .eden-pagination .page-item.active .page-link {
            background: var(--eden-primary);
            border-color: var(--eden-primary);
            color: white;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
        }
        .eden-pagination .page-item.disabled .page-link {
            color: #94a3b8;
            background: #f8fafc;
            border-color: var(--eden-border);
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .eden-header { padding: 18px; }
            .eden-header h1 { font-size: 18px; }
            .eden-card { padding: 18px; }
            .eden-meta { gap: 10px; }
        }
    </style>
</head>

<body>

    <!-- ═══════════════════════════════════════════
         HEADER
         ═══════════════════════════════════════════ -->
    <header class="eden-header">
        <div class="container-fluid" style="max-width: 1100px;">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

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
                            <path d="m3 11 18-5v12L3 14v-3z"/>
                            <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>
                        </svg>
                    </div>
                    <div>
                        <h1>Annonces et activités</h1>
                        <p>Administration de l'École Eden</p>
                    </div>
                </div>

                <a class="btn-eden text-decoration-none" href="{{ route('admin.annonces.create') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Nouvelle annonce
                </a>
            </div>
        </div>
    </header>

    <div class="container" style="max-width: 1100px;">

        {{-- ── Succès ── --}}
        @if(session('success'))
            <div class="eden-success mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- ═══════════════════════════════════════════
             SÉPARATION BROUILLONS / PUBLIÉES
             ═══════════════════════════════════════════ --}}
        @php
            $drafts    = $announcements->where('status', '!=', 'published');
            $published = $announcements->where('status', '==', 'published');
        @endphp

        @if($announcements->isEmpty())

            {{-- État vide global --}}
            <div class="eden-empty">
                <div class="eden-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 11 18-5v12L3 14v-3z"/>
                        <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>
                    </svg>
                </div>
                <p class="eden-empty-title">Aucune annonce pour le moment</p>
                <p class="eden-empty-text">
                    Créez votre première annonce pour informer les parents et les élèves.
                </p>
            </div>

        @else

            {{-- ═══════════════════════════════════════
                 SECTION 1 : BROUILLONS (en haut)
                 ═══════════════════════════════════════ --}}
            @if($drafts->isNotEmpty())
                <div class="eden-section-label draft">
                    Brouillons
                    <span>{{ $drafts->count() }}</span>
                </div>

                @foreach($drafts as $announcement)
                    <div class="eden-card draft">

                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3 flex-wrap">
                            <h2 class="eden-card-title flex-grow-1">{{ $announcement->title }}</h2>

                            <div class="d-flex gap-2 flex-wrap flex-shrink-0">
                                <span class="badge-eden badge-category">
                                    {{ $announcement->category }}
                                </span>
                                <span class="badge-eden badge-draft">Brouillon</span>
                            </div>
                        </div>

                        <p class="eden-content">{{ $announcement->content }}</p>

                        <div class="eden-meta">
                            <div class="eden-meta-item">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                Créée le {{ $announcement->created_at?->format('d/m/Y à H:i') }}
                            </div>
                        </div>

                        <div class="d-flex gap-2 flex-wrap">
                            <form method="POST"
                                  action="{{ route('admin.annonces.destroy', $announcement) }}"
                                  onsubmit="return confirm('Supprimer cette annonce ?')"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn-eden-danger" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                        <line x1="10" y1="11" x2="10" y2="17"/>
                                        <line x1="14" y1="11" x2="14" y2="17"/>
                                    </svg>
                                    Supprimer
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            @endif

            {{-- ═══════════════════════════════════════
                 SECTION 2 : PUBLIÉES (en bas)
                 ═══════════════════════════════════════ --}}
            @if($published->isNotEmpty())
                <div class="eden-section-label">
                    Publiées
                    <span>{{ $published->count() }}</span>
                </div>

                @foreach($published as $announcement)
                    <div class="eden-card published">

                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3 flex-wrap">
                            <h2 class="eden-card-title flex-grow-1">{{ $announcement->title }}</h2>

                            <div class="d-flex gap-2 flex-wrap flex-shrink-0">
                                <span class="badge-eden badge-category">
                                    {{ $announcement->category }}
                                </span>
                                <span class="badge-eden badge-published">Publiée</span>
                            </div>
                        </div>

                        <p class="eden-content">{{ $announcement->content }}</p>

                        <div class="eden-meta">
                            <div class="eden-meta-item">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                Créée le {{ $announcement->created_at?->format('d/m/Y à H:i') }}
                            </div>

                            @if($announcement->published_at)
                                <div class="eden-meta-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                        <polyline points="22 4 12 14.01 9 11.01"/>
                                    </svg>
                                    Publiée le {{ $announcement->published_at->format('d/m/Y à H:i') }}
                                </div>
                            @endif
                        </div>

                        <div class="d-flex gap-2 flex-wrap">
                            <form method="POST"
                                  action="{{ route('admin.annonces.destroy', $announcement) }}"
                                  onsubmit="return confirm('Supprimer cette annonce ?')"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn-eden-danger" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                        <line x1="10" y1="11" x2="10" y2="17"/>
                                        <line x1="14" y1="11" x2="14" y2="17"/>
                                    </svg>
                                    Supprimer
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            @endif

        @endif

        {{-- ── Pagination ── --}}
        @if($announcements->hasPages())
            <div class="eden-pagination">
                {{ $announcements->links() }}
            </div>
        @endif

    </div>

    <!-- ═══════════════════════════════════════════
         BOOTSTRAP JS (CDN)
         ═══════════════════════════════════════════ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>