<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un élève - École Eden</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            background: #f3f6fb;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Header ── */
        header {
            background: linear-gradient(120deg, #2563eb, #1d4ed8);
            color: white;
            padding: 22px 30px;
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

        .header-logo svg { width: 24px; height: 24px; stroke: white; }

        header h1 { margin: 0 0 4px; font-size: 22px; letter-spacing: -0.4px; }
        header p { margin: 0; color: #dbeafe; font-size: 13px; font-weight: 500; }

        /* ── Main ── */
        main {
            max-width: 900px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .heading { margin-bottom: 22px; }
        .heading h2 { margin: 0 0 8px; font-size: 22px; letter-spacing: -0.3px; color: #0f1f3d; }
        .heading p { margin: 0; color: #64748b; font-size: 14px; }

        /* ── Carte ── */
        .card {
            background: white;
            padding: 28px;
            border-radius: 14px;
            border: 1px solid #e5eaf2;
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
        }

        /* ── Grille formulaire ── */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .field.full { grid-column: 1 / -1; }

        label {
            font-size: 13.5px;
            font-weight: 600;
            color: #334155;
        }

        /* ── Champs avec icône ── */
        .input-wrap {
            position: relative;
        }

        .input-wrap > svg {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            width: 17px;
            height: 17px;
            stroke: #94a3b8;
            pointer-events: none;
            transition: stroke 0.15s ease;
        }

        .input-wrap:focus-within > svg { stroke: #2563eb; }

        input, select {
            width: 100%;
            padding: 12px 14px 12px 40px;
            border: 1px solid #dce4f0;
            border-radius: 9px;
            font: inherit;
            font-size: 14px;
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

        /* Select : chevron SVG à droite */
        .input-wrap.select select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 40px;
            cursor: pointer;
        }

        .input-wrap.select .chevron {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            width: 15px;
            height: 15px;
            stroke: #94a3b8;
            pointer-events: none;
        }

        /* ── Erreurs ── */
        .error {
            color: #dc2626;
            font-size: 12.5px;
            font-weight: 500;
            margin-top: 2px;
        }

        /* ── Bandeau d'erreurs globales ── */
        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 22px;
            font-size: 13.5px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
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

        /* ── Actions ── */
        .actions {
            display: flex;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 28px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border: none;
            border-radius: 9px;
            font: inherit;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.15s ease, border-color 0.15s ease;
        }

        .btn svg { width: 16px; height: 16px; stroke: currentColor; }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover { background: #1d4ed8; }

        .btn-secondary {
            background: white;
            color: #334155;
            border: 1px solid #dce4f0;
        }

        .btn-secondary:hover { background: #f1f5f9; }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .form-grid { grid-template-columns: 1fr; }
            .field.full { grid-column: auto; }
            .card { padding: 20px; }
            header { padding: 18px; }
            header h1 { font-size: 18px; }
            .actions { flex-direction: column-reverse; }
            .actions .btn { width: 100%; justify-content: center; }
        }
    </style>
</head>

<body>
    <header>
        <div class="header-inner">
            <div class="header-logo">
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
    </header>

    <main>
        <div class="heading">
            <h2>Ajouter un élève</h2>
            <p>Renseignez les informations de l'élève pour l'enregistrer.</p>
        </div>

        <div class="card">
            @if ($errors->any())
                <div class="alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <div>
                        <strong>Vérifiez les informations saisies.</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.eleves.store') }}" method="POST">
                @csrf

                <div class="form-grid">
                    {{-- Matricule --}}
                    <div class="field full">
                        <label for="matricule">Matricule *</label>
                        <div class="input-wrap">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                                required
                            >
                        </div>
                        @error('matricule')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Nom --}}
                    <div class="field">
                        <label for="last_name">Nom *</label>
                        <div class="input-wrap">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <input
                                type="text"
                                id="last_name"
                                name="last_name"
                                value="{{ old('last_name') }}"
                                placeholder="Nom de famille"
                                required
                            >
                        </div>
                        @error('last_name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Prénom --}}
                    <div class="field">
                        <label for="first_name">Prénom *</label>
                        <div class="input-wrap">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <input
                                type="text"
                                id="first_name"
                                name="first_name"
                                value="{{ old('first_name') }}"
                                placeholder="Prénom de l'élève"
                                required
                            >
                        </div>
                        @error('first_name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Date de naissance --}}
                    <div class="field">
                        <label for="date_of_birth">Date de naissance</label>
                        <div class="input-wrap">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                            >
                        </div>
                        @error('date_of_birth')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Classe --}}
                    <div class="field">
                        <label for="class_name">Classe *</label>
                        <div class="input-wrap select">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                            </svg>
                            <select id="class_name" name="class_name" required>
                                <option value="">Choisir une classe</option>
                                @foreach (['6e', '5e', '4e', '3e'] as $classe)
                                    <option
                                        value="{{ $classe }}"
                                        @selected(old('class_name') === $classe)
                                    >
                                        {{ $classe }}
                                    </option>
                                @endforeach
                            </select>
                            <svg class="chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </div>
                        @error('class_name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="actions">
                    <a href="{{ url('/admin/eleves') }}" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"/>
                            <polyline points="12 19 5 12 12 5"/>
                        </svg>
                        Annuler
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Enregistrer l'élève
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>