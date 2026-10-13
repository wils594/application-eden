<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Associer un élève à un parent - École Eden</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            background: #f4f7fb;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 850px;
            margin: auto;
        }

        /* ── Header ── */
        .header {
            background: white;
            padding: 22px 24px;
            border-radius: 14px;
            margin-bottom: 20px;
            border: 1px solid #e5eaf2;
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .header-logo {
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

        .header-logo svg { width: 24px; height: 24px; stroke: white; }

        .header-text h1 {
            margin: 0 0 4px;
            font-size: 20px;
            letter-spacing: -0.4px;
            color: #0f1f3d;
        }

        .header-text p {
            margin: 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
        }

        /* ── Panel ── */
        .panel {
            background: white;
            padding: 24px;
            border-radius: 14px;
            border: 1px solid #e5eaf2;
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
        }

        /* ── Champs ── */
        label.field-label {
            display: block;
            font-weight: 600;
            font-size: 13.5px;
            color: #334155;
            margin: 18px 0 8px;
        }

        label.field-label:first-of-type { margin-top: 0; }

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

        select,
        input[type="search"] {
            width: 100%;
            padding: 12px 14px 12px 40px;
            border: 1px solid #dce4f0;
            border-radius: 9px;
            font-size: 14px;
            font-family: inherit;
            background: white;
            color: #1e293b;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        select:focus,
        input[type="search"]:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        input[type="search"]::placeholder { color: #94a3b8; }

        /* ── Liste des élèves ── */
        .student-list {
            border: 1px solid #e5eaf2;
            border-radius: 10px;
            margin-top: 10px;
            max-height: 320px;
            overflow-y: auto;
            background: #fafbfd;
        }

        .student {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 14px;
            margin: 0;
            border-bottom: 1px solid #eef2f8;
            font-weight: normal;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .student:last-child { border-bottom: none; }
        .student:hover { background: #f1f5f9; }

        .student input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #2563eb;
            cursor: pointer;
            flex-shrink: 0;
        }

        .student-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .student-info strong {
            font-size: 14px;
            color: #0f1f3d;
            font-weight: 600;
        }

        .student-info small {
            color: #64748b;
            font-size: 12px;
            font-weight: 500;
        }

        /* ── Actions ── */
        .actions {
            display: flex;
            gap: 10px;
            margin-top: 24px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 18px;
            border-radius: 10px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
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
            box-shadow: 0 8px 18px rgba(15, 31, 61, 0.08);
        }

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

        .errors {
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

        .errors svg {
            width: 20px;
            height: 20px;
            stroke: #dc2626;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .errors strong {
            display: block;
            margin-bottom: 6px;
            color: #7f1d1d;
        }

        .errors ul {
            margin: 0;
            padding-left: 18px;
        }

        .errors li { margin-bottom: 3px; }

        .muted {
            color: #64748b;
            font-size: 13px;
            margin: 4px 0 0;
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            body { padding: 15px; }
            .header,
            .panel { padding: 18px; }
            .actions { flex-direction: column; }
            .actions .btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
<div class="container">
    {{-- ── Header ── --}}
    <div class="header">
        <div class="header-logo">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                <path d="M6 12v5c3 3 9 3 12 0v-5"/>
            </svg>
        </div>
        <div class="header-text">
            <h1>Associer un élève à un parent</h1>
            <p>Sélectionnez le parent, puis cochez les élèves dont il est responsable.</p>
        </div>
    </div>

    {{-- ── Succès ── --}}
    @if (session('success'))
        <div class="success">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Erreurs ── --}}
    @if ($errors->any())
        <div class="errors">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div>
                <strong>Vérifiez les informations :</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.parents.associer.store') }}">
        @csrf

        <div class="panel">
            {{-- ── Choisir un parent ── --}}
            <label class="field-label" for="parent_id">Choisir un parent</label>
            <div class="input-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <select id="parent_id" name="parent_id" required>
                    <option value="">-- Sélectionner un parent --</option>
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->id }}"
                            @selected(old('parent_id') == $parent->id)>
                            {{ $parent->name }} — {{ $parent->email }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- ── Rechercher un élève ── --}}
            <label class="field-label" for="student_search">Rechercher un élève</label>
            <div class="input-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input id="student_search" type="search"
                       placeholder="Nom, prénom ou matricule...">
            </div>

            {{-- ── Liste des élèves ── --}}
            <label class="field-label">Élèves à associer</label>
            <p class="muted">Vous pouvez sélectionner plusieurs élèves.</p>

            <div class="student-list" id="student_list">
                @forelse ($eleves as $eleve)
                    <label class="student"
                           data-search="{{ strtolower($eleve->first_name.' '.$eleve->last_name.' '.$eleve->matricule) }}">
                        <input type="checkbox" name="student_ids[]"
                               value="{{ $eleve->id }}"
                               @checked(in_array($eleve->id, old('student_ids', [])))>
                        <span class="student-info">
                            <strong>{{ $eleve->last_name }} {{ $eleve->first_name }}</strong>
                            <small>
                                Matricule : {{ $eleve->matricule }}
                                — Classe : {{ $eleve->class_name }}
                            </small>
                        </span>
                    </label>
                @empty
                    <p style="padding: 15px; color: #64748b;">Aucun élève enregistré.</p>
                @endforelse
            </div>

            {{-- ── Actions ── --}}
            <div class="actions">
                <button type="submit" class="btn primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Enregistrer les associations
                </button>
                <a href="{{ url('/admin') }}" class="btn secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"/>
                        <polyline points="12 19 5 12 12 5"/>
                    </svg>
                    Retour au tableau de bord
                </a>
            </div>
        </div>
    </form>
</div>

<script>
    const search = document.getElementById('student_search');
    const students = document.querySelectorAll('#student_list .student');

    search.addEventListener('input', function () {
        const query = this.value.toLowerCase().trim();

        students.forEach(function (student) {
            student.style.display =
                student.dataset.search.includes(query) ? 'flex' : 'none';
        });
    });
</script>
</body>
</html>