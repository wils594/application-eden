<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des notes - École Eden</title>

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

        /* ── Carte ── */
        .eden-card {
            background: white;
            padding: 24px;
            border-radius: 14px;
            border: 1px solid var(--eden-border);
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
            margin-bottom: 24px;
        }

        .eden-card h2 {
            margin: 0 0 20px;
            font-size: 18px;
            letter-spacing: -0.3px;
            color: #0f1f3d;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .eden-card h2::before {
            content: "";
            width: 4px;
            height: 18px;
            background: var(--eden-primary);
            border-radius: 4px;
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
        .eden-card .form-label {
            font-size: 13.5px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 7px;
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

        .eden-success svg {
            width: 22px;
            height: 22px;
            stroke: #16a34a;
            flex-shrink: 0;
        }

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

        .eden-error svg {
            width: 20px;
            height: 20px;
            stroke: #dc2626;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .eden-error strong {
            display: block;
            margin-bottom: 6px;
            color: #7f1d1d;
        }

        .eden-error ul {
            margin: 0;
            padding-left: 18px;
        }

        .eden-error li { margin-bottom: 3px; }

        /* ── Bouton principal ── */
        .btn-eden {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
            color: white;
            border-radius: 10px;
            padding: 12px 22px;
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

        /* ── Badge statut ── */
        .badge-eden {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eff6ff;
            color: #1d4ed8;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .badge-eden::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--eden-primary);
        }

        /* ── Pagination ── */
        .eden-pagination {
            display: flex;
            justify-content: center;
            margin-top: 18px;
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .eden-card { padding: 18px; }
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
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                </div>
                <div>
                    <h1>Gestion des notes</h1>
                    <p>École Eden — Administration</p>
                </div>
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

        {{-- ── Formulaire ── --}}
        <div class="eden-card">
            <h2>Enregistrer une note</h2>

            <form method="POST" action="{{ route('admin.notes.store') }}" enctype="multipart/form-data">
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
                            <select id="student_id" name="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                                <option value="">Choisir un élève</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                                        {{ $student->last_name }} {{ $student->first_name }}
                                    </option>
                                @endforeach
                            </select>
                            <svg class="chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </div>
                        @error('student_id')
                            <div class="text-danger mt-1" style="font-size:12.5px;font-weight:500;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Matière --}}
                    <div class="col-md-4">
                        <label for="subject" class="form-label">Matière</label>
                        <div class="eden-input-wrap">
                            <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                            </svg>
                            <input id="subject" name="subject" type="text"
                                   value="{{ old('subject') }}"
                                   placeholder="Ex. Mathématiques"
                                   class="form-control @error('subject') is-invalid @enderror"
                                   required>
                        </div>
                        @error('subject')
                            <div class="text-danger mt-1" style="font-size:12.5px;font-weight:500;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Note --}}
                    <div class="col-md-4">
                        <label for="grade" class="form-label">Note sur 20</label>
                        <div class="eden-input-wrap">
                            <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <input id="grade" type="number" name="grade"
                                   min="0" max="20" step="0.25"
                                   value="{{ old('grade') }}"
                                   placeholder="0 à 20"
                                   class="form-control @error('grade') is-invalid @enderror"
                                   required>
                        </div>
                        @error('grade')
                            <div class="text-danger mt-1" style="font-size:12.5px;font-weight:500;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Coefficient --}}
                    <div class="col-md-4">
                        <label for="coefficient" class="form-label">Coefficient</label>
                        <div class="eden-input-wrap">
                            <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="4" y1="9" x2="20" y2="9"/>
                                <line x1="4" y1="15" x2="20" y2="15"/>
                                <line x1="10" y1="3" x2="8" y2="21"/>
                                <line x1="16" y1="3" x2="14" y2="21"/>
                            </svg>
                            <input id="coefficient" type="number" name="coefficient"
                                   min="0.01" max="20" step="0.01"
                                   value="{{ old('coefficient', 1) }}"
                                   class="form-control @error('coefficient') is-invalid @enderror"
                                   required>
                        </div>
                        @error('coefficient')
                            <div class="text-danger mt-1" style="font-size:12.5px;font-weight:500;">{{ $message }}</div>
                        @enderror
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
                            <select id="term" name="term" class="form-select @error('term') is-invalid @enderror" required>
                                <option value="">Choisir</option>
                                <option value="1er trimestre" @selected(old('term') === '1er trimestre')>1er trimestre</option>
                                <option value="2e trimestre" @selected(old('term') === '2e trimestre')>2e trimestre</option>
                                <option value="3e trimestre" @selected(old('term') === '3e trimestre')>3e trimestre</option>
                            </select>
                            <svg class="chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </div>
                        @error('term')
                            <div class="text-danger mt-1" style="font-size:12.5px;font-weight:500;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Année scolaire --}}
                    <div class="col-md-4">
                        <label for="school_year" class="form-label">Année scolaire</label>
                        <div class="eden-input-wrap">
                            <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            <input id="school_year" name="school_year" type="text"
                                   placeholder="2026-2027"
                                   value="{{ old('school_year', '2026-2027') }}"
                                   class="form-control @error('school_year') is-invalid @enderror"
                                   required>
                        </div>
                        @error('school_year')
                            <div class="text-danger mt-1" style="font-size:12.5px;font-weight:500;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Scan --}}
                    <div class="col-md-8">
                        <label for="scan" class="form-label">Scan justificatif (PDF ou image)</label>
                        <div class="eden-input-wrap">
                            <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="17 8 12 3 7 8"/>
                                <line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                            <input id="scan" type="file" name="scan"
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="form-control @error('scan') is-invalid @enderror">
                        </div>
                        @error('scan')
                            <div class="text-danger mt-1" style="font-size:12.5px;font-weight:500;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn-eden">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Enregistrer la note
                        </button>
                    </div>

                </div>
            </form>
        </div>

        {{-- ── Tableau ── --}}
        <div class="eden-card">
            <h2>Notes enregistrées</h2>

            <div class="eden-table-wrap table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Élève</th>
                            <th>Matière</th>
                            <th>Note / 20</th>
                            <th>Coefficient</th>
                            <th>Trimestre</th>
                            <th>Année scolaire</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grades as $item)
                            <tr>
                                <td>{{ $item->student->last_name }} {{ $item->student->first_name }}</td>
                                <td>{{ $item->subject }}</td>
                                <td><strong>{{ $item->grade }}</strong></td>
                                <td>{{ $item->coefficient }}</td>
                                <td>{{ $item->term }}</td>
                                <td>{{ $item->school_year }}</td>
                                <td><span class="badge-eden">{{ $item->status }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted fst-italic">
                                    Aucune note enregistrée pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="eden-pagination">
                {{ $grades->links() }}
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         BOOTSTRAP JS (CDN)
         ═══════════════════════════════════════════ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>