<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bulletins - École Eden</title>

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
            margin-bottom: 24px;
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

        /* ── Section (carte principale) ── */
        .eden-section {
            background: white;
            padding: 24px;
            border-radius: 14px;
            border: 1px solid var(--eden-border);
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
            margin-bottom: 24px;
        }

        /* ── Sous-carte (formulaires) ── */
        .eden-subcard {
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #eef2f8;
            background: #fafbfd;
            margin-bottom: 24px;
        }

        .eden-subcard:last-child { margin-bottom: 0; }

        .eden-subcard-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
        }

        .eden-subcard-header .icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .eden-subcard-header .icon svg { width: 18px; height: 18px; stroke: var(--eden-primary); }

        .eden-subcard-header h2 {
            margin: 0;
            font-size: 16px;
            letter-spacing: -0.3px;
            color: #0f1f3d;
            font-weight: 700;
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

        /* Select : chevron personnalisé */
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
        }

        .eden-input-wrap input[type="file"]::file-selector-button {
            background: #eff6ff;
            color: var(--eden-primary);
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12.5px;
            margin-right: 10px;
            cursor: pointer;
            font-family: inherit;
        }

        /* ── Labels ── */
        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        /* ── Bandeaux ── */
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

        /* ── Boutons ── */
        .btn-eden {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
            color: white;
            border-radius: 9px;
            padding: 11px 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
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

        .btn-eden-preview {
            background: white;
            color: var(--eden-primary);
            border: 1.5px solid var(--eden-primary);
            border-radius: 9px;
            padding: 11px 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            box-shadow: 0 3px 10px rgba(37, 99, 235, 0.12);
            transition: all 0.15s ease;
        }

        .btn-eden-preview:hover {
            background: #eff6ff;
            color: var(--eden-primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.2);
        }

        .btn-eden-preview svg { width: 16px; height: 16px; stroke: currentColor; }

        /* ── Bouton valider ── */
        .btn-validate {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: #16a34a;
            color: white;
            border: 0;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12.5px;
            font-weight: 600;
            font-family: inherit;
            transition: all 0.15s ease;
            box-shadow: 0 3px 8px rgba(22, 163, 74, 0.25);
        }

        .btn-validate:hover {
            background: #15803d;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(22, 163, 74, 0.35);
        }

        .btn-validate svg { width: 14px; height: 14px; stroke: currentColor; }

        /* ── Table header ── */
        .eden-table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .eden-table-header .title-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .eden-table-header h2 {
            margin: 0;
            font-size: 17px;
            letter-spacing: -0.3px;
            color: #0f1f3d;
            font-weight: 700;
        }

        .eden-table-header .icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .eden-table-header .icon svg { width: 18px; height: 18px; stroke: var(--eden-primary); }

        .eden-count-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eff6ff;
            color: #1d4ed8;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 700;
        }

        .eden-count-badge::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--eden-primary);
        }

        /* ── Table ── */
        .eden-table-wrap {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid #eef2f8;
        }

        .eden-table-wrap table { margin-bottom: 0; }

        .eden-table-wrap thead th {
            background: #f8fafc;
            color: #475569;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            border-bottom: 1px solid #eef2f8;
            padding: 13px 14px;
            white-space: nowrap;
        }

        .eden-table-wrap tbody td {
            padding: 13px 14px;
            font-size: 13.5px;
            vertical-align: middle;
            border-bottom: 1px solid #eef2f8;
        }

        .eden-table-wrap tbody tr:hover { background: #f8fafc; }
        .eden-table-wrap tbody tr:last-child td { border-bottom: none; }

        /* ── Badges statut ── */
        .badge-eden {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 11px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .badge-eden::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .badge-eden.published { background: #dcfce7; color: #166534; }
        .badge-eden.published::before { background: #16a34a; }

        .badge-eden.pending { background: #fff7ed; color: #c2410c; }
        .badge-eden.pending::before { background: #ea580c; }

        /* ── État vide ── */
        .eden-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            padding: 45px 20px;
            color: #64748b;
        }

        .eden-empty .empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .eden-empty .empty-icon svg { width: 30px; height: 30px; stroke: var(--eden-primary); }
        .eden-empty p { margin: 0; font-size: 14px; font-weight: 500; color: #64748b; }

        /* ── Pagination ── */
        .eden-pagination {
            display: flex;
            justify-content: center;
            margin-top: 18px;
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
        @media (max-width: 700px) {
            .eden-section { padding: 18px; }
            .eden-subcard { padding: 16px; }
        }
    </style>
</head>

<body>

    <!-- ═══════════════════════════════════════════
         HEADER
         ═══════════════════════════════════════════ -->
    <header class="eden-header">
        <div class="container-fluid" style="max-width: 1100px;">
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
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                </div>
                <div>
                    <h1>Bulletins scolaires</h1>
                    <p>École Eden — Administration</p>
                </div>
            </div>
        </div>
    </header>

    <main class="container" style="max-width: 1100px;">

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

        {{-- ── Erreurs ── --}}
        @if($errors->any())
            <div class="eden-error mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <div>
                    <strong>Vérifiez les informations :</strong>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- ═══════════════════════════════════════════
             SECTION : Formulaires
             ═══════════════════════════════════════════ --}}
        <section class="eden-section">

            {{-- ── Générer un bulletin ── --}}
            <div class="eden-subcard">
                <div class="eden-subcard-header">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2v20M2 12h20"/>
                        </svg>
                    </div>
                    <h2>Générer un bulletin PDF</h2>
                </div>

                <form method="POST" action="{{ route('admin.bulletins.generate') }}">
                    @csrf

                    <div class="row g-3">

                        {{-- Élève --}}
                        <div class="col-md-4">
                            <label for="student_id" class="form-label">Élève</label>
                            <div class="eden-input-wrap">
                                <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                <select id="student_id" name="student_id" class="form-select" required>
                                    <option value="">Choisir un élève</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">
                                            {{ $student->last_name }} {{ $student->first_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <svg class="chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Trimestre --}}
                        <div class="col-md-4">
                            <label for="term" class="form-label">Trimestre</label>
                            <div class="eden-input-wrap">
                                <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                <select id="term" name="term" class="form-select" required>
                                    <option value="1er trimestre">1er trimestre</option>
                                    <option value="2e trimestre">2e trimestre</option>
                                    <option value="3e trimestre">3e trimestre</option>
                                </select>
                                <svg class="chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Année scolaire --}}
                        <div class="col-md-4">
                            <label for="school_year" class="form-label">Année scolaire</label>
                            <div class="eden-input-wrap">
                                <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                <input id="school_year" name="school_year" type="text" value="2026-2027" class="form-control" required>
                            </div>
                        </div>

                        {{-- Boutons --}}
                        <div class="col-12">
                            <div class="row g-2 justify-content-end">
                                <div class="col-md-5">
                                    <button type="submit" class="btn-eden-preview" formaction="{{ route('admin.bulletins.preview') }}" formtarget="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        Prévisualiser le bulletin
                                    </button>
                                </div>
                                <div class="col-md-5">
                                    <button type="submit" class="btn-eden">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                                            <polyline points="17 21 17 13 7 13 7 21"/>
                                            <polyline points="7 3 7 8 15 8"/>
                                        </svg>
                                        Générer et enregistrer
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            {{-- ── Importer un bulletin ── --}}
            <div class="eden-subcard">
                <div class="eden-subcard-header">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="17 8 12 3 7 8"/>
                            <line x1="12" y1="3" x2="12" y2="15"/>
                        </svg>
                    </div>
                    <h2>Importer un bulletin existant</h2>
                </div>

                <form method="POST" action="{{ route('admin.bulletins.upload') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">

                        {{-- Élève --}}
                        <div class="col-md-6">
                            <label for="import_student_id" class="form-label">Élève</label>
                            <div class="eden-input-wrap">
                                <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                <select id="import_student_id" name="student_id" class="form-select" required>
                                    <option value="">Choisir un élève</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">
                                            {{ $student->last_name }} {{ $student->first_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <svg class="chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Trimestre --}}
                        <div class="col-md-3">
                            <label for="import_term" class="form-label">Trimestre</label>
                            <div class="eden-input-wrap">
                                <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                <select id="import_term" name="term" class="form-select" required>
                                    <option value="1er trimestre">1er trimestre</option>
                                    <option value="2e trimestre">2e trimestre</option>
                                    <option value="3e trimestre">3e trimestre</option>
                                </select>
                                <svg class="chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Année scolaire --}}
                        <div class="col-md-3">
                            <label for="import_year" class="form-label">Année scolaire</label>
                            <div class="eden-input-wrap">
                                <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                <input id="import_year" name="school_year" type="text" value="2026-2027" class="form-control" required>
                            </div>
                        </div>

                        {{-- Fichier PDF --}}
                        <div class="col-12">
                            <label for="pdf" class="form-label">Fichier PDF (10 Mo maximum)</label>
                            <div class="eden-input-wrap">
                                <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                                <input id="pdf" type="file" name="pdf" accept=".pdf,application/pdf" class="form-control" required>
                            </div>
                        </div>

                        {{-- Bouton submit --}}
                        <div class="col-12 d-flex justify-content-end">
                            <div style="max-width: 320px; width: 100%;">
                                <button type="submit" class="btn-eden">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                        <polyline points="17 8 12 3 7 8"/>
                                        <line x1="12" y1="3" x2="12" y2="15"/>
                                    </svg>
                                    Importer le PDF
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </section>

        {{-- ═══════════════════════════════════════════
             SECTION : Bulletins enregistrés
             ═══════════════════════════════════════════ --}}
        <section class="eden-section">

            <div class="eden-table-header">
                <div class="title-wrap">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                    </div>
                    <h2>Bulletins enregistrés</h2>
                </div>
                <span class="eden-count-badge">{{ $bulletins->total() }} au total</span>
            </div>

            <div class="eden-table-wrap table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Élève</th>
                            <th>Trimestre</th>
                            <th>Année</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bulletins as $bulletin)
                            <tr>
                                <td>{{ $bulletin->student->last_name }} {{ $bulletin->student->first_name }}</td>
                                <td>{{ $bulletin->term }}</td>
                                <td>{{ $bulletin->school_year }}</td>
                                <td>
                                    @if($bulletin->status === 'published')
                                        <span class="badge-eden published">{{ $bulletin->status }}</span>
                                    @else
                                        <span class="badge-eden pending">{{ $bulletin->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($bulletin->status !== 'published')
                                        <form method="POST" action="{{ route('admin.bulletins.validate', $bulletin) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-validate">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="20 6 9 17 4 12"/>
                                                </svg>
                                                Valider et publier
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-success fw-semibold d-inline-flex align-items-center gap-2" style="font-size:12.5px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                            Publié
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="eden-empty">
                                        <div class="empty-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                                <polyline points="14 2 14 8 20 8"/>
                                            </svg>
                                        </div>
                                        <p>Aucun bulletin enregistré pour le moment.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ── Pagination ── --}}
            @if($bulletins->hasPages())
                <div class="eden-pagination">
                    {{ $bulletins->links() }}
                </div>
            @endif
        </section>

    </main>

    <!-- ═══════════════════════════════════════════
         BOOTSTRAP JS (CDN)
         ═══════════════════════════════════════════ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>