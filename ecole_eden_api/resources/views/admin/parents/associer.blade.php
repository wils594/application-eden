<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Associer un élève à un parent - École Eden</title>

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
            --eden-bg:           #f4f7fb;
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

        /* ── Carte panneau ── */
        .eden-panel {
            background: white;
            padding: 24px;
            border-radius: 14px;
            border: 1px solid var(--eden-border);
            box-shadow: 0 6px 18px rgba(15, 31, 61, 0.05);
        }

        /* ── Labels ── */
        .eden-panel .form-label {
            font-size: 13.5px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        /* ── Inputs avec icône ── */
        .eden-input-wrap { position: relative; }

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

        .eden-input-wrap:focus-within > svg.icon-left { stroke: var(--eden-primary); }

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

        .eden-input-wrap .form-control::placeholder { color: #94a3b8; }

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

        /* ── Liste des élèves ── */
        .eden-student-list {
            border: 1px solid var(--eden-border);
            border-radius: 10px;
            margin-top: 10px;
            max-height: 320px;
            overflow-y: auto;
            background: #fafbfd;
        }

        .eden-student {
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

        .eden-student:last-child { border-bottom: none; }
        .eden-student:hover { background: #f1f5f9; }

        .eden-student input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--eden-primary);
            cursor: pointer;
            flex-shrink: 0;
            margin: 0;
        }

        .eden-student-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .eden-student-info strong {
            font-size: 14px;
            color: #0f1f3d;
            font-weight: 600;
        }

        .eden-student-info small {
            color: #64748b;
            font-size: 12px;
            font-weight: 500;
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
            .eden-panel { padding: 18px; }
        }
    </style>
</head>

<body>

    <!-- ═══════════════════════════════════════════
         HEADER
         ═══════════════════════════════════════════ -->
    <header class="eden-header">
        <div class="container-fluid" style="max-width: 850px;">
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
                    <h1>Associer un élève à un parent</h1>
                    <p>Sélectionnez le parent, puis cochez les élèves dont il est responsable.</p>
                </div>
            </div>
        </div>
    </header>

    <div class="container" style="max-width: 850px;">

        {{-- ── Succès ── --}}
        @if (session('success'))
            <div class="eden-success mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- ── Erreurs ── --}}
        @if ($errors->any())
            <div class="eden-error mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <div>
                    <strong>Vérifiez les informations :</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- ── Formulaire ── --}}
        <form method="POST" action="{{ route('admin.parents.associer.store') }}">
            @csrf

            <div class="eden-panel">

                {{-- ── Choisir un parent ── --}}
                <div class="mb-3">
                    <label class="form-label" for="parent_id">Choisir un parent</label>
                    <div class="eden-input-wrap">
                        <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <select id="parent_id" name="parent_id" class="form-select @error('parent_id') is-invalid @enderror" required>
                            <option value="">-- Sélectionner un parent --</option>
                            @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}"
                                    @selected(old('parent_id') == $parent->id)>
                                    {{ $parent->name }} — {{ $parent->email }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </div>
                    @error('parent_id')
                        <div class="text-danger mt-1" style="font-size:12.5px;font-weight:500;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ── Rechercher un élève ── --}}
                <div class="mb-3">
                    <label class="form-label" for="student_search">Rechercher un élève</label>
                    <div class="eden-input-wrap">
                        <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input id="student_search" type="search"
                               placeholder="Nom, prénom ou matricule..."
                               class="form-control">
                    </div>
                </div>

                {{-- ── Liste des élèves ── --}}
                <div class="mb-3">
                    <label class="form-label">Élèves à associer</label>
                    <p class="text-muted mb-2" style="font-size:13px;">Vous pouvez sélectionner plusieurs élèves.</p>

                    <div class="eden-student-list" id="student_list">
                        @forelse ($eleves as $eleve)
                            <label class="eden-student"
                                   data-search="{{ strtolower($eleve->first_name.' '.$eleve->last_name.' '.$eleve->matricule) }}">
                                <input type="checkbox" name="student_ids[]"
                                       value="{{ $eleve->id }}"
                                       @checked(in_array($eleve->id, old('student_ids', [])))>
                                <span class="eden-student-info">
                                    <strong>{{ $eleve->last_name }} {{ $eleve->first_name }}</strong>
                                    <small>
                                        Matricule : {{ $eleve->matricule }}
                                        — Classe : {{ $eleve->class_name }}
                                    </small>
                                </span>
                            </label>
                        @empty
                            <p class="p-3 text-muted mb-0">Aucun élève enregistré.</p>
                        @endforelse
                    </div>
                </div>

                {{-- ── Actions ── --}}
                <div class="d-flex gap-2 mt-4 flex-wrap">
                    <button type="submit" class="btn-eden">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Enregistrer les associations
                    </button>

                    <a href="{{ url('/admin') }}" class="btn-eden-outline text-decoration-none">
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

    <!-- ═══════════════════════════════════════════
         BOOTSTRAP JS (CDN)
         ═══════════════════════════════════════════ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const search = document.getElementById('student_search');
        const students = document.querySelectorAll('#student_list .eden-student');

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