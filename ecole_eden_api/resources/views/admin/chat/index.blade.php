<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie | École Eden</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            background: #f3f6fb;
            color: #0f172a;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
        }

        /* ═════════════════════════════════════════════
           HEADER
           ═════════════════════════════════════════════ */
        header {
            background: linear-gradient(120deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 20px 30px;
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

        .header-logo svg {
            width: 24px;
            height: 24px;
            stroke: white;
        }

        header h2 {
            margin: 0 0 4px;
            font-size: 19px;
            font-weight: 700;
            letter-spacing: -0.4px;
        }

        header p {
            margin: 0;
            color: #dbeafe;
            font-size: 12.5px;
            font-weight: 500;
        }

        /* ═════════════════════════════════════════════
           MAIN
           ═════════════════════════════════════════════ */
        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
        }

        /* ── Bouton retour ── */
        .back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            color: #2563eb;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            padding: 8px 14px;
            border-radius: 10px;
            background: white;
            border: 1px solid #dce4f0;
            box-shadow: 0 3px 10px rgba(15, 31, 61, 0.04);
            transition: all 0.18s ease;
        }

        .back svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
        }

        .back:hover {
            background: #eff6ff;
            border-color: #2563eb;
            transform: translateX(-3px);
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.15);
        }

        /* ── Panel ── */
        .panel {
            background: white;
            padding: 26px;
            border-radius: 16px;
            border: 1px solid #e5eaf2;
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
        }

        .panel-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 22px;
            padding-bottom: 18px;
            border-bottom: 1px solid #eef2f8;
        }

        .panel-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.3);
            flex-shrink: 0;
        }

        .panel-icon svg {
            width: 26px;
            height: 26px;
            stroke: white;
        }

        .panel-header-text h1 {
            margin: 0 0 4px;
            font-size: 20px;
            font-weight: 700;
            color: #0f1f3d;
            letter-spacing: -0.4px;
        }

        .panel-header-text p {
            margin: 0;
            color: #64748b;
            font-size: 13.5px;
            font-weight: 500;
        }

        /* ═════════════════════════════════════════════
           CONVERSATION ROW
           ═════════════════════════════════════════════ */
        .conversation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 8px;
            border: 1px solid transparent;
            transition: all 0.18s ease;
        }

        .conversation:hover {
            background: #f8fafc;
            border-color: #e5eaf2;
            transform: translateX(3px);
        }

        .conversation:last-child {
            margin-bottom: 0;
        }

        /* ── Côté gauche : avatar + infos ── */
        .conversation-left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
            flex: 1;
        }

        .avatar {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 15px;
            letter-spacing: 0.3px;
            box-shadow: 0 6px 12px rgba(37, 99, 235, 0.25);
            flex-shrink: 0;
        }

        .details {
            min-width: 0;
            flex: 1;
        }

        .details strong {
            display: block;
            color: #0f1f3d;
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 5px;
            letter-spacing: -0.2px;
        }

        .detail-row {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #64748b;
            font-size: 12.5px;
            font-weight: 500;
            margin-bottom: 3px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .detail-row svg {
            width: 13px;
            height: 13px;
            stroke: #94a3b8;
            flex-shrink: 0;
        }

        .detail-row.messages {
            color: #2563eb;
        }

        .detail-row.messages svg {
            stroke: #2563eb;
        }

        /* ── Bouton "Ouvrir" ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            text-decoration: none;
            padding: 11px 18px;
            border-radius: 10px;
            white-space: nowrap;
            font-size: 13.5px;
            font-weight: 600;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.3);
            transition: all 0.18s ease;
        }

        .btn svg {
            width: 15px;
            height: 15px;
            stroke: currentColor;
            transition: transform 0.18s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.4);
        }

        .btn:hover svg {
            transform: translateX(3px);
        }

        /* ═════════════════════════════════════════════
           ÉTAT VIDE
           ═════════════════════════════════════════════ */
        .empty {
            padding: 45px 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .empty-illustration {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 6px;
        }

        .empty-illustration svg {
            width: 40px;
            height: 40px;
            stroke: #2563eb;
        }

        .empty h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: #0f1f3d;
            letter-spacing: -0.2px;
        }

        .empty p {
            margin: 0;
            color: #64748b;
            font-size: 13.5px;
            line-height: 1.6;
            font-weight: 500;
            max-width: 380px;
        }

        /* ═════════════════════════════════════════════
           RESPONSIVE
           ═════════════════════════════════════════════ */
        @media (max-width: 600px) {
            header {
                padding: 16px 20px;
            }

            header h2 {
                font-size: 16px;
            }

            header p {
                font-size: 11.5px;
            }

            .header-logo {
                width: 40px;
                height: 40px;
            }

            .header-logo svg {
                width: 20px;
                height: 20px;
            }

            .container {
                padding: 0 16px;
                margin: 20px auto;
            }

            .panel {
                padding: 20px;
            }

            .panel-header {
                gap: 12px;
            }

            .panel-icon {
                width: 44px;
                height: 44px;
            }

            .panel-icon svg {
                width: 22px;
                height: 22px;
            }

            .panel-header-text h1 {
                font-size: 17px;
            }

            .conversation {
                flex-direction: column;
                align-items: stretch;
                padding: 14px;
            }

            .conversation-left {
                width: 100%;
            }

            .btn {
                justify-content: center;
                width: 100%;
            }
        }
    </style>
</head>
<body>

    {{-- ═════════════════════════════════════════════
         HEADER
         ═════════════════════════════════════════════ --}}
    <header>
        <div class="header-inner">
            <div class="header-logo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                </svg>
            </div>
            <div>
                <h2>École Eden — Administration</h2>
                <p>Messagerie interne</p>
            </div>
        </div>
    </header>

    <main class="container">

        {{-- ── Bouton retour ── --}}
        <a class="back" href="{{ url('/admin') }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/>
                <polyline points="12 19 5 12 12 5"/>
            </svg>
            Retour au tableau de bord
        </a>

        {{-- ── Panel Messagerie ── --}}
        <section class="panel">

            <div class="panel-header">
                <div class="panel-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                </div>
                <div class="panel-header-text">
                    <h1>Messagerie des parents</h1>
                    <p>Conversations privées avec les parents d’élèves.</p>
                </div>
            </div>

            {{-- ── Liste des conversations ── --}}
            @forelse ($conversations as $conversation)
                <div class="conversation">

                    <div class="conversation-left">

                        {{-- Avatar avec initiales --}}
                        <div class="avatar">
                            @php
                                $nom = $conversation->parent?->name ?? 'Parent inconnu';
                                $initiales = collect(explode(' ', $nom))
                                    ->map(fn($mot) => mb_substr($mot, 0, 1))
                                    ->take(2)
                                    ->join('');
                            @endphp
                            {{ mb_strtoupper($initiales) }}
                        </div>

                        {{-- Détails --}}
                        <div class="details">
                            <strong>
                                {{ $conversation->parent?->name ?? 'Parent inconnu' }}
                            </strong>

                            <div class="detail-row">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                                    <path d="m22 7-10 6L2 7"/>
                                </svg>
                                {{ $conversation->parent?->email ?? 'Aucun e-mail' }}
                            </div>

                            <div class="detail-row messages">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                </svg>
                                {{ $conversation->messages_count }} message(s)
                            </div>

                            <div class="detail-row">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                Dernière activité :
                                {{ $conversation->last_message_at?->format('d/m/Y H:i') ?? 'Aucune' }}
                            </div>
                        </div>
                    </div>

                    {{-- Bouton "Ouvrir" --}}
                    <a class="btn"
                       href="{{ url('/admin/messages/' . $conversation->id) }}">
                        Ouvrir
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </a>
                </div>
            @empty
                <div class="empty">
                    <div class="empty-illustration">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <h3>Aucune conversation</h3>
                    <p>Aucune conversation enregistrée pour le moment.</p>
                </div>
            @endforelse

        </section>
    </main>

</body>
</html>