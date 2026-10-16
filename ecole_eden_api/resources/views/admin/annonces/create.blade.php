<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle annonce - École Eden</title>

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

        /* ── Carte formulaire ── */
        .eden-card {
            background: white;
            padding: 26px;
            border-radius: 14px;
            border: 1px solid var(--eden-border);
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
        }

        /* ── Bandeau d'erreurs ── */
        .eden-error {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 13.5px;
        }

        .eden-error svg { width: 20px; height: 20px; stroke: #dc2626; flex-shrink: 0; margin-top: 1px; }
        .eden-error strong { display: block; margin-bottom: 6px; color: #7f1d1d; }
        .eden-error ul { margin: 0; padding-left: 18px; }
        .eden-error li { margin-bottom: 3px; }

        /* ── Labels ── */
        .eden-card .form-label {
            font-size: 13.5px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 7px;
        }

        /* ── Inputs avec icône ── */
        .eden-input-wrap { position: relative; }

        .eden-input-wrap > svg.icon-left {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 17px;
            height: 17px;
            stroke: #94a3b8;
            pointer-events: none;
            transition: stroke 0.15s ease;
            z-index: 2;
        }

        .eden-input-wrap.textarea > svg.icon-left {
            top: 16px;
            transform: none;
        }

        .eden-input-wrap:focus-within > svg.icon-left { stroke: var(--eden-primary); }

        .eden-input-wrap .form-control,
        .eden-input-wrap .form-select {
            padding-left: 38px;
            border: 1px solid #dce4f0;
            border-radius: 9px;
            font-size: 14px;
            padding-top: 11px;
            padding-bottom: 11px;
            box-shadow: none;
        }

        .eden-input-wrap .form-control:focus,
        .eden-input-wrap .form-select:focus {
            border-color: var(--eden-primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .eden-input-wrap .form-control::placeholder { color: #94a3b8; }

        .eden-input-wrap textarea.form-control {
            min-height: 180px;
            resize: vertical;
            line-height: 1.6;
        }

        .eden-input-wrap .form-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 38px;
            cursor: pointer;
            background-image: none;
        }

        .eden-input-wrap svg.chevron {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 15px;
            height: 15px;
            stroke: #94a3b8;
            pointer-events: none;
            z-index: 2;
        }

        /* ── Fichier ── */
        .eden-input-wrap input[type="file"] {
            padding: 9px 12px 9px 38px;
            font-size: 13px;
            color: #64748b;
            cursor: pointer;
        }

        .eden-input-wrap input[type="file"]::file-selector-button {
            background: #eff6ff;
            color: var(--eden-primary);
            border: none;
            padding: 7px 14px;
            border-radius: 7px;
            font-weight: 600;
            font-size: 12.5px;
            margin-right: 12px;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.15s ease;
        }

        .eden-input-wrap input[type="file"]::file-selector-button:hover {
            background: #dbeafe;
        }

        /* ── Bloc checkbox ── */
        .eden-check {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-top: 20px;
            padding: 13px 16px;
            background: #f8fafc;
            border: 1px solid #eef2f8;
            border-radius: 10px;
            cursor: pointer;
        }

        .eden-check input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--eden-primary);
            cursor: pointer;
            flex-shrink: 0;
            margin: 0;
        }

        .eden-check label {
            margin: 0;
            font-weight: 600;
            font-size: 13.5px;
            color: #334155;
            cursor: pointer;
        }

        /* ── Aide ── */
        .eden-help {
            color: #64748b;
            font-size: 12.5px;
            line-height: 1.5;
            margin: 8px 0 0;
            padding-left: 4px;
            font-style: italic;
        }

        .eden-help.first { margin-top: 12px; }

        /* ═══════════════════════════════════════════
           📑 BARRE D'ACTIONS (nouveau)
           ═══════════════════════════════════════════ */
        .eden-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px solid #eef2f8;
            flex-wrap: wrap;
        }

        /* ── Boutons ── */
        .btn-eden {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
            color: white;
            border-radius: 10px;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
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

        .btn-eden-outline {
            background: white;
            color: #334155;
            border: 1px solid #dce4f0;
            border-radius: 10px;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 3px 10px rgba(15, 31, 61, 0.04);
            transition: all 0.15s ease;
        }

        .btn-eden-outline:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #1e293b;
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(15, 31, 61, 0.08);
        }

        .btn-eden-outline svg { width: 16px; height: 16px; stroke: currentColor; }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .eden-header { padding: 18px; }
            .eden-header h1 { font-size: 18px; }
            .eden-card { padding: 20px; }
            .eden-actions { flex-direction: column-reverse; }
            .eden-actions .btn-eden,
            .eden-actions .btn-eden-outline { width: 100%; justify-content: center; }
        }
    </style>
</head>

<body>

    <!-- ═══════════════════════════════════════════
         HEADER
         ═══════════════════════════════════════════ -->
    <header class="eden-header">
        <div class="container-fluid" style="max-width: 800px;">
            <div class="d-flex align-items-center gap-3">

                <!-- 🔙 BOUTON RETOUR -->
                <a href="{{ route('admin.annonces.index') }}" class="eden-back-btn" title="Retour aux annonces">
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
                    <h1>Créer une annonce</h1>
                    <p>École Eden — Administration</p>
                </div>
            </div>
        </div>
    </header>

    <div class="container" style="max-width: 800px;">

        {{-- ── Erreurs ── --}}
        @if($errors->any())
            <div class="eden-error mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <div>
                    <strong>Vérifie les informations :</strong>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- ── Formulaire ── --}}
        <div class="eden-card">
            <form method="POST" action="{{ route('admin.annonces.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Titre --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Titre de l'annonce</label>
                    <div class="eden-input-wrap">
                        <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 7V4h16v3"/>
                            <path d="M9 20h6"/>
                            <path d="M12 4v16"/>
                        </svg>
                        <input id="title" name="title" type="text"
                               value="{{ old('title') }}"
                               placeholder="Ex. Réunion parents-professeurs"
                               class="form-control @error('title') is-invalid @enderror"
                               required maxlength="255">
                    </div>
                    @error('title')
                        <div class="text-danger mt-1" style="font-size:12.5px;font-weight:500;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Catégorie --}}
                <div class="mb-3">
                    <label for="category" class="form-label">Catégorie</label>
                    <div class="eden-input-wrap">
                        <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                            <line x1="7" y1="7" x2="7.01" y2="7"/>
                        </svg>
                        <select id="category" name="category" class="form-select @error('category') is-invalid @enderror" required>
                            <option value="information" @selected(old('category', 'information') === 'information')>Information</option>
                            <option value="activite"    @selected(old('category') === 'activite')>Activité</option>
                            <option value="evenement"   @selected(old('category') === 'evenement')>Événement</option>
                            <option value="urgent"      @selected(old('category') === 'urgent')>Urgent</option>
                        </select>
                        <svg class="chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </div>
                    @error('category')
                        <div class="text-danger mt-1" style="font-size:12.5px;font-weight:500;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Contenu --}}
                <div class="mb-3">
                    <label for="content" class="form-label">Contenu</label>
                    <div class="eden-input-wrap textarea">
                        <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="17" y1="10" x2="3" y2="10"/>
                            <line x1="21" y1="6" x2="3" y2="6"/>
                            <line x1="21" y1="14" x2="3" y2="14"/>
                            <line x1="17" y1="18" x2="3" y2="18"/>
                        </svg>
                        <textarea id="content" name="content"
                                  placeholder="Rédigez le contenu de l'annonce..."
                                  class="form-control @error('content') is-invalid @enderror"
                                  required>{{ old('content') }}</textarea>
                    </div>
                    @error('content')
                        <div class="text-danger mt-1" style="font-size:12.5px;font-weight:500;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pièce jointe --}}
                <div class="mb-3">
                    <label for="attachment" class="form-label">Pièce jointe (facultatif)</label>
                    <div class="eden-input-wrap">
                        <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/>
                        </svg>
                        <input id="attachment" type="file" name="attachment"
                               accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                               class="form-control @error('attachment') is-invalid @enderror">
                    </div>
                    @error('attachment')
                        <div class="text-danger mt-1" style="font-size:12.5px;font-weight:500;">{{ $message }}</div>
                    @enderror

                    <p class="eden-help first">
                        Formats acceptés : PDF, JPG, PNG, DOC, DOCX — 10 Mo maximum.
                    </p>
                </div>

                {{-- Checkbox --}}
                <div class="eden-check">
                    <input type="checkbox" id="target_all_parents" name="target_all_parents" value="1"
                           @checked(old('target_all_parents', '1'))>
                    <label for="target_all_parents">Envoyer à tous les parents</label>
                </div>

                <p class="eden-help">
                    Si cette option est décochée, le ciblage par classe sera configuré après vérification
                    des identifiants de tes classes.
                </p>

                {{-- ═══════════════════════════════════════
                     ACTIONS (ordre inversé)
                     ═══════════════════════════════════════ --}}
                <div class="eden-actions">

                    {{-- 1️⃣ Brouillon (gauche) --}}
                    <button class="btn-eden-outline" type="submit" name="action" value="draft">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Enregistrer comme brouillon
                    </button>

                    {{-- 2️⃣ Publier (droite, mis en valeur) --}}
                    <button class="btn-eden" type="submit" name="action" value="publish">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                        Publier l'annonce
                    </button>

                </div>

            </form>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         BOOTSTRAP JS (CDN)
         ═══════════════════════════════════════════ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>