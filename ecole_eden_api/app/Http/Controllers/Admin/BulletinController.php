<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bulletin;
use App\Models\Grade;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BulletinController extends Controller
{
    public function index()
    {
        $bulletins = Bulletin::with('student')
            ->latest()
            ->paginate(15);

        $students = Student::orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('admin.bulletins.index', compact(
            'bulletins',
            'students'
        ));
    }

    /**
     * Récupère les données et calcule la moyenne du bulletin.
     */
    private function getBulletinData(array $data): array
    {
        $student = Student::findOrFail($data['student_id']);

        $grades = Grade::where('student_id', $student->id)
            ->where('term', $data['term'])
            ->where('school_year', $data['school_year'])
            ->orderBy('subject')
            ->get();

        if ($grades->isEmpty()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'student_id' => 'Aucune note trouvée pour cet élève, ce trimestre et cette année scolaire.',
            ]);
        }

        $totalCoefficients = $grades->sum(
            fn ($grade) => (float) $grade->coefficient
        );

        $average = $totalCoefficients > 0
            ? $grades->sum(fn ($grade) =>
                (float) $grade->grade * (float) $grade->coefficient
            ) / $totalCoefficients
            : 0;

        $bulletin = new Bulletin([
            'student_id' => $student->id,
            'term' => $data['term'],
            'school_year' => $data['school_year'],
        ]);

        $bulletin->setRelation('student', $student);

        return compact('bulletin', 'student', 'grades', 'average');
    }

    /**
     * Génère et enregistre le bulletin en brouillon.
     */
    public function generate(Request $request)
    {
        $data = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'term' => ['required', 'string', 'max:50'],
            'school_year' => ['required', 'string', 'max:20'],
        ]);

        $bulletinData = $this->getBulletinData($data);

        $pdf = Pdf::loadView(
            'admin.bulletins.pdf',
            $bulletinData
        );

        $path = 'bulletins/' . $bulletinData['student']->id . '/'
            . $data['school_year'] . '_'
            . md5($data['term']) . '.pdf';

        Storage::disk('local')->put($path, $pdf->output());

        Bulletin::updateOrCreate(
            [
                'student_id' => $data['student_id'],
                'term' => $data['term'],
                'school_year' => $data['school_year'],
            ],
            [
                'pdf_path' => $path,
                'status' => 'draft',
                'validated_by' => null,
                'validated_at' => null,
            ]
        );

        return redirect()
            ->route('admin.bulletins.index')
            ->with('success', 'Bulletin PDF généré et enregistré en brouillon.');
    }

    /**
     * Prévisualise le bulletin sans l'enregistrer.
     */
    public function preview(Request $request)
    {
        $data = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'term' => ['required', 'string', 'max:50'],
            'school_year' => ['required', 'string', 'max:20'],
        ]);

        $bulletinData = $this->getBulletinData($data);

        $pdf = Pdf::loadView(
            'admin.bulletins.pdf',
            $bulletinData
        );

        return $pdf->stream('apercu-bulletin.pdf');
    }

    /**
     * Importe un bulletin PDF existant en brouillon.
     */
    public function upload(Request $request)
    {
        $data = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'term' => ['required', 'string', 'max:50'],
            'school_year' => ['required', 'string', 'max:20'],
            'pdf' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $student = Student::findOrFail($data['student_id']);

        $path = $request->file('pdf')->store(
            'bulletins/importes/' . $student->id,
            'local'
        );

        Bulletin::updateOrCreate(
            [
                'student_id' => $student->id,
                'term' => $data['term'],
                'school_year' => $data['school_year'],
            ],
            [
                'pdf_path' => $path,
                'status' => 'draft',
                'validated_by' => null,
                'validated_at' => null,
            ]
        );

        return redirect()
            ->route('admin.bulletins.index')
            ->with('success', 'Bulletin PDF importé en brouillon.');
    }

    /**
     * Publie un bulletin après vérification du fichier.
     */
    public function validateBulletin(Request $request, Bulletin $bulletin)
    {
        if (
            !$bulletin->pdf_path ||
            !Storage::disk('local')->exists($bulletin->pdf_path)
        ) {
            return back()->withErrors([
                'bulletin' => 'Le fichier PDF du bulletin est introuvable.',
            ]);
        }

        // À protéger par une autorisation réservée à la direction
        // avant toute mise en production.
        $bulletin->update([
            'status' => 'published',
            'validated_by' => $request->user()?->id,
            'validated_at' => now(),
        ]);

        return back()->with('success', 'Bulletin publié.');
    }

    /**
     * Télécharge un bulletin publié.
     */
    public function download(Bulletin $bulletin)
    {
        if ($bulletin->status !== 'published') {
            abort(403, 'Ce bulletin n’est pas encore publié.');
        }

        abort_unless(
            $bulletin->pdf_path &&
            Storage::disk('local')->exists($bulletin->pdf_path),
            404
        );

        return Storage::disk('local')->download(
            $bulletin->pdf_path,
            'bulletin-' . $bulletin->student_id . '.pdf'
        );
    }
}
