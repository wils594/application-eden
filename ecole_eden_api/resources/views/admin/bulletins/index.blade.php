<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bulletins - École Eden</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 24px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            background: #f3f6fb;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }

        main { max-width: 1100px; margin: auto; }

        /* ── Header ── */
        .page-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
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

        /* ── Sections ── */
        section {
            background: white;
            padding: 24px;
            border-radius: 14px;
            border: 1px solid #e5eaf2;
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
            margin-bottom: 24px;
        }

        /* ── Sous-cartes internes (formulaires) ── */
        .sub-card {
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #eef2f8;
            background: #fafbfd;
            margin-bottom: 24px;
        }

        .sub-card:last-child { margin-bottom: 0; }

        .sub-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
        }

        .sub-card-header .icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sub-card-header .icon svg {
            width: 18px;
            height: 18px;
            stroke: #2563eb;
        }

        .sub-card-header h2 {
            margin: 0;
            font-size: 16px;
            letter-spacing: -0.3px;
            color: #0f1f3d;
            font-weight: 700;
        }

        /* ── Formulaires ── */
        form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        label {
            display: block;
            font-weight: 600;
            font-size: 13px;
            color: #334155;
            margin-bottom: 6px;
        }

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

        input, select {
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

        input:focus, select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        input::placeholder { color: #94a3b8; }

        /* Select */
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

        /* Champ fichier */
        .field.file input[type="file"] {
            padding: 9px 12px 9px 38px;
            font-size: 13px;
            color: #64748b;
        }

        .field.file input[type="file"]::file-selector-button {
            background: #eff6ff;
            color: #2563eb;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12.5px;
            margin-right: 10px;
            cursor: pointer;
            font-family: inherit;
        }

        /* ── Zone des boutons submit ── */
        .submit-wrap {
            align-self: end;
            display: flex;
            flex-direction: column;
            gap: 10px;
            grid-column: span 2;
        }

        /* Bouton principal (submit) */
        button[type="submit"] {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 11px 20px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            border: 0;
            border-radius: 9px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.3);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.4);
        }

        button[type="submit"] svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
        }

        /* Bouton prévisualiser */
        .btn-preview {
            background: white !important;
            color: #2563eb !important;
            border: 1.5px solid #2563eb !important;
            box-shadow: 0 3px 10px rgba(37, 99, 235, 0.12) !important;
        }

        .btn-preview:hover {
            background: #eff6ff !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.2) !important;
        }

        /* ── Bandeaux ── */
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

        /* ── Section tableau ── */
        .table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .table-header .title-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-header h2 {
            margin: 0;
            font-size: 17px;
            letter-spacing: -0.3px;
            color: #0f1f3d;
            font-weight: 700;
        }

        .table-header .icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .table-header .icon svg {
            width: 18px;
            height: 18px;
            stroke: #2563eb;
        }

        .count-badge {
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

        .count-badge::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #2563eb;
        }

        /* ── Tableau ── */
        .scroll {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid #eef2f8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        th, td {
            padding: 13px 14px;
            border-bottom: 1px solid #eef2f8;
            text-align: left;
            font-size: 13.5px;
        }

        th {
            background: #f8fafc;
            color: #475569;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        tbody tr { transition: background 0.15s ease; }
        tbody tr:hover { background: #f8fafc; }
        tbody tr:last-child td { border-bottom: none; }

        /* ── Badge statut ── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 11px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .badge::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .badge.published {
            background: #dcfce7;
            color: #166534;
        }

        .badge.published::before { background: #16a34a; }

        .badge.pending {
            background: #fff7ed;
            color: #c2410c;
        }

        .badge.pending::before { background: #ea580c; }

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
            transition: background 0.15s ease, transform 0.15s ease;
            box-shadow: 0 3px 8px rgba(22, 163, 74, 0.25);
        }

        .btn-validate:hover {
            background: #15803d;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(22, 163, 74, 0.35);
        }

        .btn-validate svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
        }

        .text-published {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #16a34a;
            font-size: 12.5px;
            font-weight: 600;
        }

        .text-published svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
        }

        /* ── État vide ── */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            padding: 45px 20px;
            color: #64748b;
        }

        .empty-state .empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-state .empty-icon svg {
            width: 30px;
            height: 30px;
            stroke: #2563eb;
        }

        .empty-state p {
            margin: 0;
            font-size: 14px;
            font-weight: 500;
            color: #64748b;
        }

        /* ── Pagination ── */
        .pagination-wrap {
            margin-top: 18px;
            display: flex;
            justify-content: center;
        }

        /* ── Responsive ── */
        @media (max-width: 700px) {
            .submit-wrap { grid-column: 1 / -1; }
        }

        @media (max-width: 600px) {
            body { padding: 16px; }
            section { padding: 18px; }
            .sub-card { padding: 16px; }
            .table-header { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
<main>

    {{-- ── Header ── --}}
    <div class="page-header">
        <div class="page-logo">
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

    {{-- ── Erreurs ── --}}
    @if($errors->any())
        <div class="alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div>
                <strong>Vérifiez les informations :</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <section>

        {{-- ═══ Formulaire : générer un bulletin ═══ --}}
        <div class="sub-card">
            <div class="sub-card-header">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v20M2 12h20"/>
                    </svg>
                </div>
                <h2>Générer un bulletin PDF</h2>
            </div>

            <form method="POST" action="{{ route('admin.bulletins.generate') }}">
                @csrf

                {{-- Élève --}}
                <div>
                    <label for="student_id">Élève</label>
                    <div class="field select">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <select id="student_id" name="student_id" required>
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
                <div>
                    <label for="term">Trimestre</label>
                    <div class="field select">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <select id="term" name="term" required>
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
                <div>
                    <label for="school_year">Année scolaire</label>
                    <div class="field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <input id="school_year" name="school_year" value="2026-2027" required>
                    </div>
                </div>

                {{-- Submit : 2 boutons --}}
                <div class="submit-wrap">

                    <button
                        type="submit"
                        class="btn-preview"
                        formaction="{{ route('admin.bulletins.preview') }}"
                        formtarget="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        Prévisualiser le bulletin
                    </button>

                    <button type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Générer et enregistrer le brouillon
                    </button>

                </div>
            </form>
        </div>

        {{-- ═══ Formulaire : importer un bulletin ═══ --}}
        <div class="sub-card">
            <div class="sub-card-header">
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

                {{-- Élève --}}
                <div>
                    <label for="import_student_id">Élève</label>
                    <div class="field select">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <select id="import_student_id" name="student_id" required>
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
                <div>
                    <label for="import_term">Trimestre</label>
                    <div class="field select">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <select id="import_term" name="term" required>
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
                <div>
                    <label for="import_year">Année scolaire</label>
                    <div class="field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <input id="import_year" name="school_year" value="2026-2027" required>
                    </div>
                </div>

                {{-- Fichier PDF --}}
                <div>
                    <label for="pdf">Fichier PDF (10 Mo maximum)</label>
                    <div class="field file">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        <input id="pdf" type="file" name="pdf" accept=".pdf,application/pdf" required>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="submit-wrap">
                    <button type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="17 8 12 3 7 8"/>
                            <line x1="12" y1="3" x2="12" y2="15"/>
                        </svg>
                        Importer le PDF
                    </button>
                </div>
            </form>
        </div>

    </section>

    {{-- ═══ Section : bulletins enregistrés ═══ --}}
    <section>

        <div class="table-header">
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
            <span class="count-badge">{{ $bulletins->total() }} au total</span>
        </div>

        <div class="scroll">
            <table>
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
                                    <span class="badge published">{{ $bulletin->status }}</span>
                                @else
                                    <span class="badge pending">{{ $bulletin->status }}</span>
                                @endif
                            </td>
                            <td>
                                @if($bulletin->status !== 'published')
                                    <form method="POST" action="{{ route('admin.bulletins.validate', $bulletin) }}">
                                        @csrf
                                        <button type="submit" class="btn-validate">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                            Valider et publier
                                        </button>
                                    </form>
                                @else
                                    <span class="text-published">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
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
                                <div class="empty-state">
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

        <div class="pagination-wrap">
            {{ $bulletins->links() }}
        </div>
    </section>

</main>
</body>
</html>