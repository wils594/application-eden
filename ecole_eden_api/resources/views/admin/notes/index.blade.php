<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des notes - École Eden</title>

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

        .container {
            max-width: 1100px;
            margin: auto;
        }

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

        /* ── Cartes ── */
        .card {
            background: white;
            padding: 24px;
            border-radius: 14px;
            border: 1px solid #e5eaf2;
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
            margin-bottom: 24px;
        }

        .card h2 {
            margin: 0 0 20px;
            font-size: 18px;
            letter-spacing: -0.3px;
            color: #0f1f3d;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card h2::before {
            content: "";
            width: 4px;
            height: 18px;
            background: #2563eb;
            border-radius: 4px;
        }

        /* ── Formulaire ── */
        form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        }

        label {
            display: block;
            font-weight: 600;
            font-size: 13.5px;
            color: #334155;
            margin-bottom: 7px;
        }

        .field {
            position: relative;
        }

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

        input,
        select {
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

        input:focus,
        select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        input::placeholder { color: #94a3b8; }

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

        /* ── Bouton submit ── */
        .submit-wrap {
            align-self: end;
            grid-column: 1 / -1;
            display: flex;
            justify-content: flex-end;
        }

        button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 12px 22px;
            border: 0;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.3);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.4);
        }

        button svg { width: 16px; height: 16px; stroke: currentColor; }

        /* ── Bandeaux ── */
        .success {
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

        .success svg {
            width: 22px;
            height: 22px;
            stroke: #16a34a;
            flex-shrink: 0;
        }

        .error-card {
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

        .error-card svg {
            width: 20px;
            height: 20px;
            stroke: #dc2626;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .error-card strong {
            display: block;
            margin-bottom: 6px;
            color: #7f1d1d;
        }

        .error-card ul {
            margin: 0;
            padding-left: 18px;
        }

        .error-card li { margin-bottom: 3px; }

        /* ── Tableau ── */
        .table-wrap {
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

        .badge {
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

        .badge::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #2563eb;
        }

        .empty-row td {
            text-align: center;
            color: #64748b;
            padding: 40px 20px !important;
            font-style: italic;
        }

        /* ── Pagination ── */
        .pagination-wrap {
            margin-top: 18px;
            display: flex;
            justify-content: center;
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            body { padding: 16px; }
            .card { padding: 18px; }
            .submit-wrap { justify-content: stretch; }
            button { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
<div class="container">

    {{-- ── Header ── --}}
    <div class="page-header">
        <div class="page-logo">
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

    {{-- ── Succès ── --}}
    @if(session('success'))
        <div class="success">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Erreurs ── --}}
    @if($errors->any())
        <div class="error-card">
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

    {{-- ── Formulaire ── --}}
    <div class="card">
        <h2>Enregistrer une note</h2>

        <form method="POST" action="{{ route('admin.notes.store') }}" enctype="multipart/form-data">
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
                            <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                                {{ $student->last_name }} {{ $student->first_name }}
                            </option>
                        @endforeach
                    </select>
                    <svg class="chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </div>
            </div>

            {{-- Matière --}}
            <div>
                <label for="subject">Matière</label>
                <div class="field">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    </svg>
                    <input id="subject" name="subject" value="{{ old('subject') }}" placeholder="Ex. Mathématiques" required>
                </div>
            </div>

            {{-- Note --}}
            <div>
                <label for="grade">Note sur 20</label>
                <div class="field">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <input id="grade" type="number" name="grade" min="0" max="20" step="0.25" value="{{ old('grade') }}" placeholder="0 à 20" required>
                </div>
            </div>

            {{-- Coefficient --}}
            <div>
                <label for="coefficient">Coefficient</label>
                <div class="field">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="4" y1="9" x2="20" y2="9"/>
                        <line x1="4" y1="15" x2="20" y2="15"/>
                        <line x1="10" y1="3" x2="8" y2="21"/>
                        <line x1="16" y1="3" x2="14" y2="21"/>
                    </svg>
                    <input id="coefficient" type="number" name="coefficient" min="0.01" max="20" step="0.01" value="{{ old('coefficient', 1) }}" required>
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
                        <option value="">Choisir</option>
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
                    <input id="school_year" name="school_year" placeholder="2026-2027" value="{{ old('school_year', '2026-2027') }}" required>
                </div>
            </div>

            {{-- Scan justificatif --}}
            <div>
                <label for="scan">Scan justificatif (PDF ou image)</label>
                <div class="field file">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                    <input id="scan" type="file" name="scan" accept=".pdf,.jpg,.jpeg,.png">
                </div>
            </div>

            {{-- Submit --}}
            <div class="submit-wrap">
                <button type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Enregistrer la note
                </button>
            </div>
        </form>
    </div>

    {{-- ── Tableau ── --}}
    <div class="card">
        <h2>Notes enregistrées</h2>

        <div class="table-wrap">
            <table>
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
                            <td><span class="badge">{{ $item->status }}</span></td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="7">Aucune note enregistrée pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            {{ $grades->links() }}
        </div>
    </div>
</div>
</body>
</html>