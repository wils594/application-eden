<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin scolaire - École Eden</title>

    <style>
        @page {
            margin: 25px 30px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #1e293b;
            margin: 0;
            line-height: 1.5;
        }

        /* ── En-tête ── */
        .header {
            text-align: center;
            border-bottom: 3px double #2563eb;
            padding-bottom: 14px;
            margin-bottom: 8px;
        }

        .school-name {
            font-size: 26px;
            font-weight: bold;
            color: #1e40af;
            letter-spacing: 1.5px;
            margin-bottom: 6px;
        }

        .subtitle {
            color: #64748b;
            font-size: 10px;
            font-style: italic;
            letter-spacing: 0.3px;
        }

        /* ── Titre principal ── */
        .title {
            text-align: center;
            margin: 20px 0 18px;
        }

        .title-main {
            font-size: 18px;
            font-weight: bold;
            color: #1e40af;
            letter-spacing: 3px;
            margin-bottom: 6px;
        }

        .title-term {
            display: inline-block;
            background: #eff6ff;
            color: #1e40af;
            padding: 5px 16px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            border: 1px solid #93c5fd;
        }

        /* ── Bloc infos ── */
        .info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #cbd5e1;
        }

        .info td {
            padding: 8px 10px;
            border: 1px solid #cbd5e1;
            font-size: 10.5px;
            vertical-align: middle;
        }

        .label {
            font-weight: bold;
            background: #eff6ff;
            color: #1e40af;
            width: 20%;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .value {
            color: #0f1f3d;
            font-weight: bold;
            width: 30%;
        }

        /* ── Tableau des notes ── */
        table.notes {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .notes th {
            background: #1e40af;
            color: white;
            padding: 10px 6px;
            border: 1px solid #1e40af;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            text-align: left;
        }

        .notes th.center {
            text-align: center;
        }

        .notes td {
            padding: 9px 6px;
            border: 1px solid #cbd5e1;
            font-size: 10.5px;
            vertical-align: middle;
        }

        .notes td.center {
            text-align: center;
        }

        .notes tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .notes .subject {
            font-weight: bold;
            color: #0f1f3d;
        }

        .notes .grade {
            font-weight: bold;
            color: #0f1f3d;
        }

        /* ── Badges d'appréciation ── */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge.excellent {
            background: #dcfce7;
            color: #166534;
        }

        .badge.bien {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge.assez-bien {
            background: #fef3c7;
            color: #92400e;
        }

        .badge.passable {
            background: #fed7aa;
            color: #9a3412;
        }

        .badge.insuffisant {
            background: #fee2e2;
            color: #991b1b;
        }

        /* ── Bloc moyenne ── */
        .average {
            margin-top: 4px;
            padding: 14px 18px;
            background: #eff6ff;
            border: 2px solid #1e40af;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .average-label {
            color: #1e40af;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .average-value {
            color: #1e40af;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        /* ── Appréciation générale ── */
        .remarks {
            margin-top: 18px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 0;
            overflow: hidden;
        }

        .remarks-header {
            background: #f1f5f9;
            padding: 8px 12px;
            font-size: 10.5px;
            font-weight: bold;
            color: #1e40af;
            border-bottom: 1px solid #cbd5e1;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .remarks-body {
            padding: 14px 12px;
            min-height: 60px;
            color: #94a3b8;
            font-size: 10px;
        }

        .remarks-line {
            border-bottom: 1px dotted #cbd5e1;
            margin-bottom: 12px;
            padding-bottom: 4px;
            height: 10px;
        }

        .remarks-line:last-child {
            margin-bottom: 0;
        }

        /* ── Signatures ── */
        .signatures {
            width: 100%;
            margin-top: 28px;
            border-collapse: separate;
            border-spacing: 16px 0;
            table-layout: fixed;
        }

        .signatures td {
            width: 50%;
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            text-align: center;
            vertical-align: top;
            background: #fafbfd;
        }

        .signatures .role {
            font-weight: bold;
            color: #1e40af;
            font-size: 10.5px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 8px;
        }

        .signatures .signature-area {
            height: 50px;
            border-bottom: 1px dashed #cbd5e1;
            margin: 12px 20px 6px;
        }

        .signatures .signature-label {
            color: #94a3b8;
            font-size: 9px;
            font-style: italic;
        }

        /* ── Pied de page ── */
        .footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 12px;
            border-top: 1px solid #e2e8f0;
            color: #94a3b8;
            font-size: 8.5px;
            font-style: italic;
            letter-spacing: 0.3px;
        }

        /* ── Impression ── */
        @media print {
            .average { break-inside: avoid; }
            .remarks { break-inside: avoid; }
            .signatures { break-inside: avoid; }
            tr { break-inside: avoid; }
        }
    </style>
</head>

<body>

    {{-- ── En-tête ── --}}
    <div class="header">
        <div class="school-name">ÉCOLE EDEN</div>
        <div class="subtitle">
            Établissement scolaire — Excellence et réussite
        </div>
    </div>

    {{-- ── Titre ── --}}
    <div class="title">
        <div class="title-main">BULLETIN SCOLAIRE</div>
        <span class="title-term">{{ $bulletin->term }}</span>
    </div>

    {{-- ── Infos élève ── --}}
    <table class="info">
        <tr>
            <td class="label">Nom et prénom</td>
            <td class="value" colspan="3">
                {{ $bulletin->student->last_name }}
                {{ $bulletin->student->first_name }}
            </td>
        </tr>
        <tr>
            <td class="label">Matricule</td>
            <td class="value">{{ $bulletin->student->matricule }}</td>
            <td class="label">Classe</td>
            <td class="value">{{ $bulletin->student->class_name }}</td>
        </tr>
        <tr>
            <td class="label">Année scolaire</td>
            <td class="value" colspan="3">{{ $bulletin->school_year }}</td>
        </tr>
    </table>

    {{-- ── Tableau des notes ── --}}
    <table class="notes">
        <thead>
            <tr>
                <th style="width: 30%;">Matière</th>
                <th class="center" style="width: 12%;">Note / 20</th>
                <th class="center" style="width: 14%;">Coefficient</th>
                <th class="center" style="width: 14%;">Points</th>
                <th class="center" style="width: 30%;">Appréciation</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($grades as $grade)
                <tr>
                    <td class="subject">{{ $grade->subject }}</td>
                    <td class="center grade">
                        {{ number_format($grade->grade, 2) }}
                    </td>
                    <td class="center">{{ $grade->coefficient }}</td>
                    <td class="center">
                        {{ number_format(
                            $grade->grade * $grade->coefficient,
                            2
                        ) }}
                    </td>
                    <td class="center">
                        @if ($grade->grade >= 16)
                            <span class="badge excellent">Très bien</span>
                        @elseif ($grade->grade >= 14)
                            <span class="badge bien">Bien</span>
                        @elseif ($grade->grade >= 12)
                            <span class="badge assez-bien">Assez bien</span>
                        @elseif ($grade->grade >= 10)
                            <span class="badge passable">Passable</span>
                        @else
                            <span class="badge insuffisant">Insuffisant</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ── Moyenne générale ── --}}
    <div class="average">
        <span class="average-label">Moyenne générale</span>
        <span class="average-value">
            {{ number_format($average, 2) }} / 20
        </span>
    </div>

    {{-- ── Appréciation générale ── --}}
    <div class="remarks">
        <div class="remarks-header">Appréciation générale</div>
        <div class="remarks-body">
            <div class="remarks-line"></div>
            <div class="remarks-line"></div>
            <div class="remarks-line"></div>
        </div>
    </div>

    {{-- ── Signatures ── --}}
    <table class="signatures">
        <tr>
            <td>
                <div class="role">Professeur principal</div>
                <div class="signature-area"></div>
                <div class="signature-label">Signature</div>
            </td>
            <td>
                <div class="role">La Direction</div>
                <div class="signature-area"></div>
                <div class="signature-label">Signature et cachet</div>
            </td>
        </tr>
    </table>

    {{-- ── Pied de page ── --}}
    <div class="footer">
        École Eden — Bulletin scolaire généré par le système de gestion scolaire.
    </div>

</body>
</html>