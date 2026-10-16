<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion | École Eden</title>

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
            max-width: 900px;
            margin: 30px auto;
            padding: 0 16px;
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

        /* ── Panel (conteneur type chat) ── */
        .panel {
            background: white;
            border-radius: 16px;
            border: 1px solid #e5eaf2;
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            max-height: calc(100vh - 200px);
        }

        /* ═════════════════════════════════════════════
           EN-TÊTE PARENT (fixe en haut du panel)
           ═════════════════════════════════════════════ */
        .parent-info {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 18px 22px;
            background: #f8fafc;
            border-bottom: 1px solid #eef2f8;
            flex-shrink: 0;
        }

        .parent-avatar {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 17px;
            letter-spacing: 0.5px;
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.3);
            flex-shrink: 0;
        }

        .parent-info-text { min-width: 0; flex: 1; }

        .parent-info-text h1 {
            margin: 0 0 6px;
            font-size: 17px;
            font-weight: 700;
            color: #0f1f3d;
            letter-spacing: -0.3px;
        }

        .parent-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .meta-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #64748b;
            font-size: 12px;
            font-weight: 500;
        }

        .meta-item svg {
            width: 13px;
            height: 13px;
            stroke: #94a3b8;
            flex-shrink: 0;
        }

        /* ═════════════════════════════════════════════
           BANDEAU SUCCÈS
           ═════════════════════════════════════════════ */
        .success {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            margin: 14px 22px 0;
            border-radius: 10px;
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            font-size: 13.5px;
            font-weight: 500;
            flex-shrink: 0;
        }

        .success svg {
            width: 20px;
            height: 20px;
            stroke: #16a34a;
            flex-shrink: 0;
        }

        /* ═════════════════════════════════════════════
           MESSAGES (BULLES) — conteneur scrollable
           ═════════════════════════════════════════════ */
        .messages {
            flex: 1;
            padding: 20px 22px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            overflow-y: auto;
            scroll-behavior: smooth;
            background: #ffffff;
        }

        .messages::-webkit-scrollbar {
            width: 6px;
        }

        .messages::-webkit-scrollbar-thumb {
            background: #dce4f0;
            border-radius: 10px;
        }

        .messages::-webkit-scrollbar-thumb:hover {
            background: #b6c4d9;
        }

        /* ── Chaque message (ligne) ── */
        .message {
            display: flex;
            gap: 10px;
            align-items: flex-end;
            max-width: 85%;
            margin-bottom: 4px;
        }

        /* Groupe : pas de margin si même auteur consécutif */
        .message.grouped {
            margin-bottom: 0;
        }

        /* Parent (gauche) */
        .parent-message {
            align-self: flex-start;
        }

        /* Admin (droite) */
        .admin-message {
            align-self: flex-end;
            flex-direction: row-reverse;
        }

        /* ── Avatar ── */
        .bubble-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
            letter-spacing: 0.3px;
        }

        .parent-message .bubble-avatar {
            background: linear-gradient(135deg, #64748b, #475569);
        }

        .admin-message .bubble-avatar {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }

        /* Avatar masqué si groupé */
        .message.grouped .bubble-avatar {
            visibility: hidden;
        }

        /* ── Bulle ── */
        .bubble {
            padding: 10px 14px;
            border-radius: 16px;
            overflow-wrap: anywhere;
            max-width: 100%;
            position: relative;
        }

        .parent-message .bubble {
            background: #f1f5f9;
            border: 1px solid #e5eaf2;
            border-bottom-left-radius: 4px;
        }

        .admin-message .bubble {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            border-bottom-right-radius: 4px;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        /* Bulle groupée : coins ajustés */
        .message.grouped.parent-message .bubble {
            border-top-left-radius: 4px;
        }

        .message.grouped.admin-message .bubble {
            border-top-right-radius: 4px;
        }

        /* Sender : masqué si groupé */
        .sender {
            display: block;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 4px;
            letter-spacing: 0.2px;
        }

        .parent-message .sender { color: #334155; }
        .admin-message .sender { color: #dbeafe; }

        .message.grouped .sender { display: none; }

        /* Body */
        .bubble p {
            margin: 0;
            white-space: pre-wrap;
            font-size: 13.5px;
            line-height: 1.5;
            font-weight: 500;
        }

        /* Date */
        .date {
            display: block;
            font-size: 10px;
            margin-top: 5px;
            font-weight: 500;
            opacity: 0.85;
        }

        .parent-message .date { color: #94a3b8; }
        .admin-message .date { color: #bfdbfe; }

        /* ── État vide ── */
        .empty {
            text-align: center;
            padding: 40px 20px;
            color: #64748b;
            font-size: 13.5px;
            line-height: 1.6;
            font-weight: 500;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px dashed #e2e8f0;
            margin: auto;
        }

        /* ═════════════════════════════════════════════
           BARRE DE SAISIE (style Messenger)
           ═════════════════════════════════════════════ */
        .reply-section {
            padding: 14px 22px 18px;
            border-top: 1px solid #eef2f8;
            background: white;
            flex-shrink: 0;
        }

        .reply-section form {
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }

        .reply-section textarea {
            flex: 1;
            min-height: 44px;
            max-height: 120px;
            padding: 11px 16px;
            border: 1px solid #dce4f0;
            border-radius: 22px;
            font: inherit;
            font-size: 14px;
            resize: none;
            color: #0f1f3d;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            background: #f8fafc;
            overflow-y: auto;
            line-height: 1.4;
        }

        .reply-section textarea::placeholder {
            color: #94a3b8;
        }

        .reply-section textarea:focus {
            border-color: #2563eb;
            background: white;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .error {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #991b1b;
            font-size: 13px;
            font-weight: 500;
            margin-top: 8px;
        }

        .error svg {
            width: 16px;
            height: 16px;
            stroke: #dc2626;
            flex-shrink: 0;
        }

        /* Bouton Envoyer rond (style Messenger) */
        .send-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            border: none;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            cursor: pointer;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.3);
            transition: all 0.18s ease;
            flex-shrink: 0;
        }

        .send-btn svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            transform: translateX(1px);
        }

        .send-btn:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.4);
        }

        .send-btn:active {
            transform: translateY(0) scale(0.98);
        }

        /* ═════════════════════════════════════════════
           RESPONSIVE
           ═════════════════════════════════════════════ */
        @media (max-width: 600px) {
            header { padding: 16px 20px; }
            header h2 { font-size: 16px; }
            header p { font-size: 11.5px; }

            .header-logo { width: 40px; height: 40px; }
            .header-logo svg { width: 20px; height: 20px; }

            .container { padding: 0 12px; margin: 20px auto; }

            .panel { max-height: calc(100vh - 160px); }

            .parent-info {
                padding: 14px 16px;
                gap: 12px;
            }

            .parent-avatar {
                width: 44px;
                height: 44px;
                font-size: 15px;
            }

            .parent-info-text h1 { font-size: 15px; }

            .messages { padding: 16px 14px 10px; }

            .message { max-width: 95%; }

            .bubble { padding: 9px 12px; }
            .bubble p { font-size: 13px; }

            .reply-section { padding: 12px 14px 14px; }

            .reply-section textarea {
                font-size: 13.5px;
            }

            .send-btn {
                width: 42px;
                height: 42px;
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
                <p>Discussion avec un parent</p>
            </div>
        </div>
    </header>

    <main class="container">

        {{-- ── Bouton retour ── --}}
        <a class="back" href="{{ route('admin.messages.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/>
                <polyline points="12 19 5 12 12 5"/>
            </svg>
            Retour aux conversations
        </a>

        <section class="panel">

            {{-- ═══════════════════════════════════════
                 EN-TÊTE PARENT
                 ═══════════════════════════════════════ --}}
            <div class="parent-info">
                <div class="parent-avatar">
                    @php
                        $nomParent = $conversation->parent?->name ?? 'Parent inconnu';
                        $initParent = collect(explode(' ', $nomParent))
                            ->map(fn($mot) => mb_substr($mot, 0, 1))
                            ->take(2)
                            ->join('');
                    @endphp
                    {{ mb_strtoupper($initParent) }}
                </div>

                <div class="parent-info-text">
                    <h1>Discussion avec {{ $conversation->parent?->name ?? 'Parent inconnu' }}</h1>

                    <div class="parent-meta">
                        <span class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="4" width="20" height="16" rx="2"/>
                                <path d="m22 7-10 6L2 7"/>
                            </svg>
                            {{ $conversation->parent?->email ?? 'Aucun e-mail' }}
                        </span>

                        <span class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            {{ $conversation->parent?->phone ?? 'Non renseigné' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════
                 BANDEAU SUCCÈS
                 ═══════════════════════════════════════ --}}
            @if (session('success'))
                <div class="success">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- ═══════════════════════════════════════
                 MESSAGES (BULLES)
                 ═══════════════════════════════════════ --}}
            <div
                class="messages"
                id="messagesContainer"
                data-fetch-url="{{ route('admin.messages.fetch', $conversation) }}"
            >
                @php
                    $previousRole = null;
                @endphp

                @forelse ($conversation->messages as $message)
                    @php
                        $isAdmin = $message->sender?->role === 'admin';
                        $currentRole = $isAdmin ? 'admin' : 'parent';
                        $isGrouped = ($currentRole === $previousRole);
                        $previousRole = $currentRole;

                        $senderName = $message->sender?->name ?? 'Utilisateur';
                        $senderInit = collect(explode(' ', $senderName))
                            ->map(fn($mot) => mb_substr($mot, 0, 1))
                            ->take(2)
                            ->join('');
                    @endphp

                    <div
                        class="message {{ $isAdmin ? 'admin-message' : 'parent-message' }} {{ $isGrouped ? 'grouped' : '' }}"
                        data-message-id="{{ $message->id }}"
                    >
                        <div class="bubble-avatar">
                            {{ mb_strtoupper($senderInit) }}
                        </div>

                        <div class="bubble">
                            <span class="sender">
                                {{ $senderName }}
                                ({{ $isAdmin ? 'Administration' : 'Parent' }})
                            </span>

                            <p>{{ $message->body }}</p>

                            <span class="date">
                                {{ $message->created_at?->format('d/m/Y à H:i') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="empty">
                        Aucun message dans cette conversation.<br>
                        Vous pouvez envoyer le premier message ci-dessous.
                    </div>
                @endforelse
            </div>

            {{-- ═══════════════════════════════════════
                 BARRE DE RÉPONSE (style Messenger)
                 ═══════════════════════════════════════ --}}
            <div class="reply-section">
                <form method="POST"
                      action="{{ route('admin.messages.reply', $conversation) }}">
                    @csrf

                    <textarea
                        name="body"
                        placeholder="Écrivez votre réponse ici..."
                        required
                        maxlength="5000"
                    >{{ old('body') }}</textarea>

                    <button type="submit" class="send-btn" title="Envoyer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                    </button>
                </form>

                @error('body')
                    <div class="error">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

        </section>
    </main>

    {{-- ═════════════════════════════════════════════
         SCRIPT : auto-refresh + auto-scroll
         ═════════════════════════════════════════════ --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('messagesContainer');

        if (!container) return;

        const fetchUrl = container.dataset.fetchUrl;
        let isFetching = false;
        let isInitialScrollDone = false;

        // ✅ Scroll en bas immédiat
        function scrollToBottom(smooth = true) {
            if (smooth) {
                container.scrollTo({
                    top: container.scrollHeight,
                    behavior: 'smooth'
                });
            } else {
                container.scrollTop = container.scrollHeight;
            }
        }

        // ✅ Scroll initial (une seule fois)
        if (!isInitialScrollDone) {
            scrollToBottom(false);
            isInitialScrollDone = true;
        }

        // ✅ Créer une bulle (miroir exact du Blade)
        function buildMessageRow(message, grouped, isAdmin) {
            const row = document.createElement('div');

            row.className = 'message ' +
                (isAdmin ? 'admin-message' : 'parent-message') +
                (grouped ? ' grouped' : '');

            row.dataset.messageId = String(message.id);

            const senderName = message.sender?.name || 'Utilisateur';

            const initials = senderName
                .trim()
                .split(/\s+/)
                .slice(0, 2)
                .map(part => part.charAt(0))
                .join('')
                .toUpperCase();

            const avatar = document.createElement('div');
            avatar.className = 'bubble-avatar';
            avatar.textContent = initials;

            const bubble = document.createElement('div');
            bubble.className = 'bubble';

            const sender = document.createElement('span');
            sender.className = 'sender';
            sender.textContent = senderName + ' (' +
                (isAdmin ? 'Administration' : 'Parent') + ')';

            const body = document.createElement('p');
            body.textContent = message.body || '';

            const date = document.createElement('span');
            date.className = 'date';
            date.textContent = message.created_at || '';

            bubble.append(sender, body, date);
            row.append(avatar, bubble);

            return row;
        }

        // ✅ Rafraîchir les messages depuis l'API
        async function refreshMessages() {
            if (isFetching) return;

            isFetching = true;

            try {
                const response = await fetch(fetchUrl, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin',
                    cache: 'no-store'
                });

                if (!response.ok) {
                    throw new Error('Erreur HTTP : ' + response.status);
                }

                const data = await response.json();
                const messages = data.messages || [];

                const currentRows =
                    container.querySelectorAll('.message');

                const currentIds = Array.from(currentRows).map(
                    message => message.dataset.messageId
                );

                const newIds = messages.map(
                    message => String(message.id)
                );

                // ✅ Rien n'a changé → on sort
                if (
                    currentIds.length === newIds.length &&
                    currentIds.every((id, index) => id === newIds[index])
                ) {
                    return;
                }

                // ✅ On détecte si l'utilisateur est déjà en bas
                const nearBottom =
                    container.scrollHeight -
                    container.scrollTop -
                    container.clientHeight < 120;

                container.replaceChildren();

                if (messages.length === 0) {
                    const empty = document.createElement('div');
                    empty.className = 'empty';
                    empty.innerHTML =
                        'Aucun message dans cette conversation.<br>Vous pouvez envoyer le premier message ci-dessous.';
                    container.appendChild(empty);
                    return;
                }

                // ✅ Reconstruction avec groupement
                let previousRole = null;

                messages.forEach(function (message) {
                    const isAdmin =
                        message.sender && message.sender.role === 'admin';
                    const currentRole = isAdmin ? 'admin' : 'parent';
                    const grouped = (currentRole === previousRole);
                    previousRole = currentRole;

                    const row = buildMessageRow(message, grouped, isAdmin);
                    container.appendChild(row);
                });

                // ✅ Scroll intelligent
                if (nearBottom || currentIds.length === 0) {
                    scrollToBottom(true);
                }

            } catch (error) {
                console.error(
                    'Actualisation de la messagerie :',
                    error
                );
            } finally {
                isFetching = false;
            }
        }

        // ✅ Premier rafraîchissement puis polling toutes les 3s
        refreshMessages();
        setInterval(refreshMessages, 3000);

        // ✅ Auto-resize du textarea
        const textarea = document.querySelector('.reply-section textarea');
        if (textarea) {
            textarea.addEventListener('input', function () {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 120) + 'px';
            });
        }
    });
    </script>

</body>
</html>