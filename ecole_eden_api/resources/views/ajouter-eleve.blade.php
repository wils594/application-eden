<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un élève - École Eden</title>

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
            --eden-text:         #1e293b;
            --eden-text-muted:   #64748b;
            --eden-border:       #e5eaf2;
        }

        body {
            background: var(--eden-bg);
            color: var(--eden-text);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Header ── */
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

        .eden-back-btn svg {
            width: 22px;
            height: 22px;
            stroke: currentColor;
        }

        .eden-back-btn:hover {
            background: rgba(255, 255, 255, 0.28);
            transform: translateX(-2px);
            color: white;
        }

        /* ── Carte formulaire ── */
        .eden-card {
            background: white;
            padding: 28px;
            border-radius: 14px;
            border: 1px solid var(--eden-border);
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
        }

        /* ── Champs avec icône ── */
        .eden-input-wrap {
            position: relative;
        }

        .eden-input-wrap > svg.icon-left {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            width: 17px;
            height: 17px;
            stroke: #94a3b8;
            pointer-events: none;
            transition: stroke 0.15s ease;
            z-index: 2;
        }

        .eden-input-wrap:focus-within > svg.icon-left {
            stroke: var(--eden-primary);
        }

        .eden-input-wrap .form-control,
        .eden-input-wrap .form-select {
            padding-left: 40px;
            border: 1px solid #dce4f0;
            border-radius: 9px;
            font-size: 14px;
            padding-top: 12px;
            padding-bottom: 12px;
            box-shadow: none;
        }

        .eden-input-wrap .form-control:focus,
        .eden-input-wrap .form-select:focus {
            border-color: var(--eden-primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .eden-input-wrap .form-control::placeholder {
            color: #94a3b8;
        }

        /* Select : chevron personnalisé */
        .eden-input-wrap .form-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 40px;
            cursor: pointer;
            background-image: none;
        }

        .eden-input-wrap svg.chevron {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            width: 15px;
            height: 15px;
            stroke: #94a3b8;
            pointer-events: none;
            z-index: 2;
        }

        /* ── Labels ── */
        .eden-card .form-label {
            font-size: 13.5px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 7px;
        }

        /* ── Bandeau d'erreurs ── */
        .eden-alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 14px 16px;
            border-radius: 10px;
            font-size: 13.5px;
        }

        .eden-alert-error svg {
            width: 20px;
            height: 20px;
            stroke: #dc2626;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .eden-alert-error strong {
            display: block;
            margin-bottom: 6px;
            color: #7f1d1d;
        }

        .eden-alert-error ul {
            margin: 0;
            padding-left: 18px;
        }

        .eden-alert-error li { margin-bottom: 3px; }

        /* ── Boutons ── */
        .btn-eden {
            background: var(--eden-primary);
            border: none;
            color: white;
            border-radius: 9px;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.15s ease, transform 0.15s ease;
        }

        .btn-eden:hover {
            background: var(--eden-primary-dark);
            color: white;
            transform: translateY(-1px);
        }

        .btn-eden svg { width: 16px; height: 16px; stroke: currentColor; }

        .btn-eden-outline {
            background: white;
            color: #334155;
            border: 1px solid #dce4f0;
            border-radius: 9px;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.15s ease;
        }

        .btn-eden-outline:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .btn-eden-outline svg { width: 16px; height: 16px; stroke: currentColor; }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .eden-card { padding: 20px; }
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
                <a href="{{ url('/admin/eleves') }}" class="eden-back-btn" title="Retour à la liste des élèves">
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
                    <p>Administration — Gestion des élèves</p>
                </div>
            </div>
        </div>
    </header>

    <!-- ═══════════════════════════════════════════
         MAIN
         ═══════════════════════════════════════════ -->
    <main class="container my-5" style="max-width: 900px;">

        <div class="mb-4">
            <h2 class="fw-bold mb-2" style="color:#0f1f3d;font-size:22px;letter-spacing:-0.3px;">Ajouter un élève</h2>
            <p class="text-muted mb-0" style="font-size:14px;">Renseignez les informations de l'élève pour l'enregistrer.</p>
        </div>

        <div class="eden-card">

            {{-- ═══════════════════════════════════════
                 BANDEAU D'ERREURS
                 ═══════════════════════════════════════ --}}
            @if ($errors->any())
                <div class="eden-alert-error d-flex gap-3 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <div>
                        <strong>Vérifiez les informations saisies.</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- ═══════════════════════════════════════
                 FORMULAIRE
                 ═══════════════════════════════════════ --}}
            <form action="{{ route('admin.eleves.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- Matricule (pleine largeur) --}}
                    <div class="col-12">
                        <label for="matricule" class="form-label">Matricule *</label>
                        <div class="eden-input-wrap">
                            <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="16" rx="2"/>
                                <path d="M7 9h10"/>
                                <path d="M7 13h6"/>
                            </svg>
                            <input
                                type="text"
                                id="matricule"
                                name="matricule"
                                value="{{ old('matricule') }}"
                                placeholder="Ex. EDEN-2026-001"
                                class="form-control @error('matricule') is-invalid @enderror"
                                required
                            >
                        </div>
                        @error('matricule')
                            <div class="text-danger mt-1" style="font-size:12.5px;font-weight:500;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nom --}}
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Nom *</label>
                        <div class="eden-input-wrap">
                            <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <input
                                type="text"
                                id="last_name"
                                name="last_name"
                                value="{{ old('last_name') }}"
                                placeholder="Nom de famille"
                                class="form-control @error('last_name') is-invalid @enderror"
                                required
                            >
                        </div>
                        @error('last_name')
                            <div class="text-danger mt-1" style="font-size:12.5px;font-weight:500;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Prénom --}}
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">Prénom *</label>
                        <div class="eden-input-wrap">
                            <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <input
                                type="text"
                                id="first_name"
                                name="first_name"
                                value="{{ old('first_name') }}"
                                placeholder="Prénom de l'élève"
                                class="form-control @error('first_name') is-invalid @enderror"
                                required
                            >
                        </div>
                        @error('first_name')
                            <div class="text-danger mt-1" style="font-size:12.5px;font-weight:500;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Date de naissance --}}
                    <div class="col-md-6">
                        <label for="date_of_birth" class="form-label">Date de naissance</label>
                        <div class="eden-input-wrap">
                            <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <input
                                type="date"
                                id="date_of_birth"
                                name="date_of_birth"
                                value="{{ old('date_of_birth') }}"
                                class="form-control @error('date_of_birth') is-invalid @enderror"
                            >
                        </div>
                        @error('date_of_birth')
                            <div class="text-danger mt-1" style="font-size:12.5px;font-weight:500;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Classe --}}
                    <div class="col-md-6">
                        <label for="class_name" class="form-label">Classe *</label>
                        <div class="eden-input-wrap">
                            <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                            </svg>
                            <select
                                id="class_name"
                                name="class_name"
                                class="form-select @error('class_name') is-invalid @enderror"
                                required
                            >
                                <option value="">Choisir une classe</option>
                                @foreach (['6e', '5e', '4e', '3e'] as $classe)
                                    <option value="{{ $classe }}" @selected(old('class_name') === $classe)>
                                        {{ $classe }}
                                    </option>
                                @endforeach
                            </select>
                            <svg class="chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </div>
                        @error('class_name')
                            <div class="text-danger mt-1" style="font-size:12.5px;font-weight:500;">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- ═══════════════════════════════════════
                     ACTIONS
                     ═══════════════════════════════════════ --}}
                <div class="d-flex justify-content-end flex-wrap gap-2 mt-4">
                    <a href="{{ url('/admin/eleves') }}" class="btn-eden-outline text-decoration-none">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"/>
                            <polyline points="12 19 5 12 12 5"/>
                        </svg>
                        Annuler
                    </a>

                    <button type="submit" class="btn-eden">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Enregistrer l'élève
                    </button>
                </div>

            </form>
        </div>
    </main>

    <!-- ═══════════════════════════════════════════
         BOOTSTRAP JS (CDN)
         ═══════════════════════════════════════════ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>