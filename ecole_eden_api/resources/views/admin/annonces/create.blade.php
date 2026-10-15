<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle annonce - École Eden</title>

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

        .container { max-width: 800px; margin: auto; }

        /* ── Header ── */
        .page-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
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

        .page-header p {
            margin: 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
        }

        /* ── Bouton retour ── */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #2563eb;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            margin-bottom: 20px;
            padding: 6px 0;
            transition: gap 0.15s ease;
        }

        .back-link svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
        }

        .back-link:hover { gap: 10px; }

        /* ── Bandeau d'erreurs ── */
        .alert-error {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 18px;
            font-size: 13.5px;
        }

        .alert-error svg {
            width: 20px;
            height: 20px;
            stroke: #dc2626;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .alert-error strong {
            display: block;
            margin-bottom: 6px;
            color: #7f1d1d;
        }

        .alert-error ul {
            margin: 0;
            padding-left: 18px;
        }

        .alert-error li { margin-bottom: 3px; }

        /* ── Carte formulaire ── */
        form {
            background: white;
            padding: 26px;
            border-radius: 14px;
            border: 1px solid #e5eaf2;
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
        }

        label {
            display: block;
            font-weight: 600;
            font-size: 13.5px;
            color: #334155;
            margin: 18px 0 7px;
        }

        label:first-of-type { margin-top: 0; }

        .field { position: relative; }

        .field > svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 17px;
            height: 17px;
            stroke: #94a3b8;
            pointer-events: none;
            transition: stroke 0.15s ease;
        }

        .field:focus-within > svg { stroke: #2563eb; }

        .field.textarea > svg {
            top: 16px;
            transform: none;
        }

        input, textarea, select {
            width: 100%;
            padding: 11px 14px 11px 38px;
            border: 1px solid #dce4f0;
            border-radius: 9px;
            font-size: 14px;
            font-family: inherit;
            background: white;
            color: #1e293b;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        input:focus, textarea:focus, select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        input::placeholder { color: #94a3b8; }

        textarea {
            min-height: 180px;
            resize: vertical;
            line-height: 1.6;
        }

        /* Select personnalisé */
        .field.select select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 38px;
            cursor: pointer;
        }

        .field.select .chevron {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 15px;
            height: 15px;
            stroke: #94a3b8;
            pointer-events: none;
        }

        /* ── Champ fichier ── */
        .field.file input[type="file"] {
            padding: 9px 12px 9px 38px;
            font-size: 13px;
            color: #64748b;
            cursor: pointer;
        }

        .field.file input[type="file"]::file-selector-button {
            background: #eff6ff;
            color: #2563eb;
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

        .field.file input[type="file"]::file-selector-button:hover {
            background: #dbeafe;
        }

        /* ── Checkbox ── */
        .check-row {
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

        .check-row input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #2563eb;
            cursor: pointer;
            flex-shrink: 0;
            padding: 0;
        }

        .check-row label {
            margin: 0;
            font-weight: 600;
            font-size: 13.5px;
            color: #334155;
            cursor: pointer;
        }

        /* ── Bloc d'aide ── */
        .help-text {
            color: #64748b;
            font-size: 12.5px;
            line-height: 1.5;
            margin: 8px 0 0;
            padding-left: 4px;
            font-style: italic;
        }

        .help-text.first {
            margin-top: 12px;
        }

        /* ── Actions ── */
        .actions {
            display: flex;
            gap: 10px;
            margin-top: 26px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            border: 0;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
        }

        .btn svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
        }

        .btn.primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.3);
        }

        .btn.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.4);
        }

        .btn.secondary {
            background: white;
            color: #334155;
            border: 1px solid #dce4f0;
            box-shadow: 0 3px 10px rgba(15, 31, 61, 0.04);
        }

        .btn.secondary:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(15, 31, 61, 0.08);
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            body { padding: 16px; }
            form { padding: 20px; }
            .actions { flex-direction: column; }
            .btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
<div class="container">

    {{-- ── Header ── --}}
    <div class="page-header">
        <div class="page-logo">
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

    {{-- ── Retour ── --}}
    <a href="{{ route('admin.annonces.index') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        Retour aux annonces
    </a>

    {{-- ── Erreurs ── --}}
    @if($errors->any())
        <div class="alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div>
                <strong>Vérifie les informations :</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- ── Formulaire ── --}}
    <form method="POST" action="{{ route('admin.annonces.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Titre --}}
        <label for="title">Titre de l'annonce</label>
        <div class="field">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 7V4h16v3"/>
                <path d="M9 20h6"/>
                <path d="M12 4v16"/>
            </svg>
            <input id="title" name="title" value="{{ old('title') }}"
                   placeholder="Ex. Réunion parents-professeurs"
                   required maxlength="255">
        </div>

        {{-- Catégorie --}}
        <label for="category">Catégorie</label>
        <div class="field select">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                <line x1="7" y1="7" x2="7.01" y2="7"/>
            </svg>
            <select id="category" name="category" required>
                <option value="information" @selected(old('category', 'information') === 'information')>Information</option>
                <option value="activite" @selected(old('category') === 'activite')>Activité</option>
                <option value="evenement" @selected(old('category') === 'evenement')>Événement</option>
                <option value="urgent" @selected(old('category') === 'urgent')>Urgent</option>
            </select>
            <svg class="chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"/>
            </svg>
        </div>

        {{-- Contenu --}}
        <label for="content">Contenu</label>
        <div class="field textarea">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="17" y1="10" x2="3" y2="10"/>
                <line x1="21" y1="6" x2="3" y2="6"/>
                <line x1="21" y1="14" x2="3" y2="14"/>
                <line x1="17" y1="18" x2="3" y2="18"/>
            </svg>
            <textarea id="content" name="content"
                      placeholder="Rédigez le contenu de l'annonce..."
                      required>{{ old('content') }}</textarea>
        </div>

        {{-- ✅ NOUVEAU : Pièce jointe --}}
        <label for="attachment">Pièce jointe (facultatif)</label>
        <div class="field file">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/>
            </svg>
            <input id="attachment" type="file" name="attachment"
                   accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
        </div>

        <p class="help-text first">
            Formats acceptés : PDF, JPG, PNG, DOC, DOCX — 10 Mo maximum.
        </p>

        {{-- Checkbox "Envoyer à tous les parents" --}}
        <div class="check-row">
            <input type="checkbox" id="target_all_parents" name="target_all_parents" value="1"
                   @checked(old('target_all_parents', '1'))>
            <label for="target_all_parents">Envoyer à tous les parents</label>
        </div>

        <p class="help-text">
            Si cette option est décochée, le ciblage par classe sera configuré après vérification
            des identifiants de tes classes.
        </p>

        {{-- Actions --}}
        <div class="actions">
            <button class="btn primary" type="submit" name="action" value="publish">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13"/>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                </svg>
                Publier l'annonce
            </button>

            <button class="btn secondary" type="submit" name="action" value="draft">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                Enregistrer comme brouillon
            </button>
        </div>

    </form>
</div>
</body>
</html>