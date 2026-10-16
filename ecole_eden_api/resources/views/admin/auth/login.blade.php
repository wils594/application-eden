<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administration - École Eden</title>

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
            --eden-border:       #e5eaf2;
        }

        * { box-sizing: border-box; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            background: linear-gradient(135deg, #eff6ff 0%, #f1f5f9 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Carte ── */
        .eden-login-card {
            width: 100%;
            max-width: 420px;
            background: white;
            padding: 36px 32px;
            border-radius: 18px;
            border: 1px solid var(--eden-border);
            box-shadow:
                0 20px 45px rgba(15, 23, 42, 0.08),
                0 4px 12px rgba(15, 23, 42, 0.04);
            animation: edenFadeUp 0.5s ease;
        }

        @keyframes edenFadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Logo ── */
        .eden-logo {
            width: 64px;
            height: 64px;
            margin: 0 auto 20px;
            border-radius: 16px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
        }

        .eden-logo svg { width: 32px; height: 32px; stroke: white; }

        /* ── Titres ── */
        .eden-title {
            color: #0f1f3d;
            text-align: center;
            font-size: 23px;
            font-weight: 700;
            letter-spacing: -0.4px;
            margin: 0 0 6px;
        }

        .eden-subtitle {
            text-align: center;
            color: #64748b;
            margin: 0 0 28px;
            font-size: 13.5px;
            font-weight: 500;
        }

        /* ── Labels ── */
        .eden-login-card .form-label {
            display: block;
            margin-bottom: 8px;
            color: #334155;
            font-size: 13.5px;
            font-weight: 600;
        }

        /* ── Champs avec icône ── */
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

        .eden-input-wrap .form-control {
            padding: 13px 14px 13px 40px;
            border: 1px solid #dce4f0;
            border-radius: 10px;
            font-size: 14.5px;
            background: white;
            color: #0f1f3d;
            outline: none;
            box-shadow: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .eden-input-wrap .form-control::placeholder { color: #94a3b8; }

        .eden-input-wrap .form-control:focus {
            border-color: var(--eden-primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        /* ── Champ mot de passe (avec bouton œil) ── */
        .eden-input-wrap.password .form-control {
            padding-right: 46px;
        }

        .eden-eye-btn {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: transparent;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #94a3b8;
            z-index: 2;
            transition: background 0.15s ease, color 0.15s ease;
        }

        .eden-eye-btn:hover { background: #f1f5f9; color: #475569; }
        .eden-eye-btn svg { width: 17px; height: 17px; stroke: currentColor; }

        /* ── Bouton principal ── */
        .btn-eden {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            letter-spacing: 0.2px;
            cursor: pointer;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.3);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-eden:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.4);
        }

        .btn-eden:active { transform: translateY(0); }
        .btn-eden svg { width: 16px; height: 16px; stroke: currentColor; }

        /* ── Bandeau d'erreur ── */
        .eden-error {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 500;
        }

        .eden-error svg {
            width: 18px;
            height: 18px;
            stroke: #dc2626;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* ── Pied de page ── */
        .eden-footer {
            text-align: center;
            margin-top: 26px;
            padding-top: 20px;
            border-top: 1px solid #eef2f8;
            color: #94a3b8;
            font-size: 12px;
            font-weight: 500;
        }

        /* ── Responsive ── */
        @media (max-width: 480px) {
            .eden-login-card { padding: 28px 22px; }
            .eden-title { font-size: 20px; }
        }
    </style>
</head>

<body>

    <div class="eden-login-card">

        {{-- ── Logo ── --}}
        <div class="eden-logo">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                <path d="M6 12v5c3 3 9 3 12 0v-5"/>
            </svg>
        </div>

        <h1 class="eden-title">École Eden</h1>
        <p class="eden-subtitle">Espace d'administration</p>

        {{-- ── Erreurs ── --}}
        @if ($errors->any())
            <div class="eden-error mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        {{-- ── Formulaire ── --}}
        <form method="POST" action="{{ url('/admin/login') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Adresse email</label>
                <div class="eden-input-wrap">
                    <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="4" width="20" height="16" rx="2"/>
                        <path d="m22 7-10 6L2 7"/>
                    </svg>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="admin@ecoleeden.com"
                        class="form-control @error('email') is-invalid @enderror"
                        required
                        autofocus
                    >
                </div>
                @error('email')
                    <div class="text-danger mt-1" style="font-size:12.5px;font-weight:500;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Mot de passe (avec bouton œil) --}}
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <div class="eden-input-wrap password">
                    <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Saisissez votre mot de passe"
                        class="form-control @error('password') is-invalid @enderror"
                        required
                    >
                    <button type="button" class="eden-eye-btn" id="togglePassword" title="Afficher / masquer">
                        {{-- Œil ouvert --}}
                        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        {{-- Œil barré (caché au départ) --}}
                        <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <div class="text-danger mt-1" style="font-size:12.5px;font-weight:500;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Bouton --}}
            <button type="submit" class="btn-eden">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Se connecter
            </button>
        </form>

        {{-- ── Pied de page ── --}}
        <div class="eden-footer">
            © {{ date('Y') }} École Eden — Administration
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         BOOTSTRAP JS (CDN)
         ═══════════════════════════════════════════ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        /* ── Bouton afficher / masquer le mot de passe ── */
        const toggleBtn = document.getElementById('togglePassword');
        const pwdInput  = document.getElementById('password');
        const eyeOpen   = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        toggleBtn.addEventListener('click', function () {
            const isHidden = pwdInput.type === 'password';

            pwdInput.type = isHidden ? 'text' : 'password';
            eyeOpen.style.display   = isHidden ? 'none' : 'block';
            eyeClosed.style.display = isHidden ? 'block' : 'none';
        });
    </script>
</body>
</html>