<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des annonces - École Eden</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            background: #f3f6fb;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }

        .container { max-width: 1100px; margin: auto; }

        /* ── Header ── */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .page-logo {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.3);
            flex-shrink: 0;
        }

        .page-logo svg { width: 24px; height: 24px; stroke: white; }

        .page-header h1 {
            margin: 0 0 3px;
            font-size: 22px;
            letter-spacing: -0.4px;
            color: #0f1f3d;
        }

        .page-header .subtitle {
            margin: 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
        }

        /* ── Bouton principal ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 18px;
            border-radius: 10px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            text-decoration: none;
            border: 0;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.3);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.4);
        }

        .btn svg { width: 16px; height: 16px; stroke: currentColor; }

        /* ── Bandeau succès ── */
        .alert-success {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 18px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-success svg {
            width: 22px;
            height: 22px;
            stroke: #16a34a;
            flex-shrink: 0;
        }

        /* ── Carte annonce ── */
        .card {
            background: white;
            padding: 22px;
            border-radius: 14px;
            border: 1px solid #e5eaf2;
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
            margin-bottom: 16px;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.08);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 14px;
            flex-wrap: wrap;
        }

        .card-title {
            margin: 0;
            font-size: 17px;
            font-weight: 700;
            color: #0f1f3d;
            letter-spacing: -0.2px;
            flex: 1;
            min-width: 0;
        }

        /* ── Badges ── */
        .badges {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            flex-shrink: 0;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .badge-category {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .badge-category::before { background: #2563eb; }

        .badge-published {
            background: #dcfce7;
            color: #166534;
        }

        .badge-published::before { background: #16a34a; }

        .badge-draft {
            background: #fff7ed;
            color: #c2410c;
        }

        .badge-draft::before { background: #ea580c; }

        /* ── Contenu ── */
        .card-content {
            color: #475569;
            font-size: 14px;
            line-height: 1.6;
            margin: 0 0 16px;
        }

        /* ── Meta (dates) ── */
        .card-meta {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
            padding-top: 14px;
            border-top: 1px solid #eef2f8;
            margin-bottom: 14px;
        }

        .meta-item {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #64748b;
            font-size: 12.5px;
            font-weight: 500;
        }

        .meta-item svg {
            width: 15px;
            height: 15px;
            stroke: #94a3b8;
            flex-shrink: 0;
        }

        /* ── Actions ── */
        .actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-danger {
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
            font-family: inherit;
            transition: background 0.15s ease, border-color 0.15s ease;
        }

        .btn-danger:hover {
            background: #fee2e2;
            border-color: #fca5a5;
        }

        .btn-danger svg {
            width: 15px;
            height: 15px;
            stroke: currentColor;
        }

        /* ── État vide ── */
        .empty-card {
            background: white;
            padding: 50px 24px;
            border-radius: 14px;
            border: 1px solid #e5eaf2;
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
            text-align: center;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
        }

        .empty-icon svg {
            width: 38px;
            height: 38px;
            stroke: #2563eb;
        }

        .empty-title {
            margin: 0 0 8px;
            font-size: 17px;
            font-weight: 700;
            color: #0f1f3d;
        }

        .empty-text {
            margin: 0;
            color: #64748b;
            font-size: 14px;
            line-height: 1.5;
            max-width: 400px;
            margin-inline: auto;
        }

        /* ── Pagination ── */
        .pagination-wrap {
            margin-top: 24px;
            display: flex;
            justify-content: center;
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            body { padding: 16px; }
            .page-header { flex-direction: column; align-items: stretch; }
            .btn { justify-content: center; }
            .card-header { flex-direction: column; }
            .badges { width: 100%; }
            .actions form { width: 100%; }
            .btn-danger { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
<div class="container">

    {{-- ── Header ── --}}
    <div class="page-header">
        <div class="header-left">
            <div class="page-logo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 11 18-5v12L3 14v-3z"/>
                    <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>
                </svg>
            </div>
            <div>
                <h1>Annonces et activités</h1>
                <p class="subtitle">Administration de l'École Eden</p>
            </div>
        </div>

        <a class="btn" href="{{ route('admin.annonces.create') }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Nouvelle annonce
        </a>
    </div>

    {{-- ── Succès ── --}}
    @if(session('success'))
        <div class="alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Liste des annonces ── --}}
    @forelse($announcements as $announcement)
        <div class="card">

            {{-- En-tête de carte : titre + badges --}}
            <div class="card-header">
                <h2 class="card-title">{{ $announcement->title }}</h2>

                <div class="badges">
                    <span class="badge badge-category">
                        {{ $announcement->category }}
                    </span>

                    @if($announcement->status === 'published')
                        <span class="badge badge-published">Publiée</span>
                    @else
                        <span class="badge badge-draft">Brouillon</span>
                    @endif
                </div>
            </div>

            {{-- Contenu --}}
            <p class="card-content">{{ $announcement->content }}</p>

            {{-- Meta : dates --}}
            <div class="card-meta">
                <div class="meta-item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    Créée le {{ $announcement->created_at?->format('d/m/Y à H:i') }}
                </div>

                @if($announcement->published_at)
                    <div class="meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        Publiée le {{ $announcement->published_at->format('d/m/Y à H:i') }}
                    </div>
                @endif
            </div>

            {{-- Actions --}}
            <div class="actions">
                <form method="POST" action="{{ route('admin.annonces.destroy', $announcement) }}"
                      onsubmit="return confirm('Supprimer cette annonce ?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn-danger" type="submit">
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
    @empty
        <div class="empty-card">
            <div class="empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 11 18-5v12L3 14v-3z"/>
                    <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>
                </svg>
            </div>
            <p class="empty-title">Aucune annonce pour le moment</p>
            <p class="empty-text">
                Créez votre première annonce pour informer les parents et les élèves.
            </p>
        </div>
    @endforelse

    {{-- ── Pagination ── --}}
    <div class="pagination-wrap">
        {{ $announcements->links() }}
    </div>

</div>
</body>
</html>