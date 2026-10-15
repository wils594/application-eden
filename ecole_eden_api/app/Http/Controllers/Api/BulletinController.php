<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bulletin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BulletinController extends Controller
{
    /**
     * Affiche uniquement les bulletins publiés
     * des enfants du parent connecté.
     */
    public function index(Request $request)
    {
        $parent = $request->user();

        $bulletins = Bulletin::with('student')
            ->where('status', 'published')
            ->whereHas('student.parents', function ($query) use ($parent) {
                $query->where('users.id', $parent->id);
            })
            ->latest()
            ->get()
            ->map(function ($bulletin) {
                return [
                    'id' => $bulletin->id,
                    'student_id' => $bulletin->student_id,
                    'student_name' => $bulletin->student->first_name
                        . ' ' . $bulletin->student->last_name,
                    'term' => $bulletin->term,
                    'school_year' => $bulletin->school_year,
                    'status' => $bulletin->status,
                    'download_url' => url(
                        '/api/bulletins/' . $bulletin->id . '/telecharger'
                    ),
                ];
            });

        return response()->json([
            'success' => true,
            'bulletins' => $bulletins,
        ]);
    }

    /**
     * Télécharge un bulletin publié appartenant
     * à l'un des enfants du parent connecté.
     */
    public function download(Request $request, Bulletin $bulletin)
    {
        $parent = $request->user();

        abort_unless($bulletin->status === 'published', 404);

        $belongsToParent = $parent->students()
            ->where('students.id', $bulletin->student_id)
            ->exists();

        abort_unless($belongsToParent, 403);

        abort_unless(
            $bulletin->pdf_path
                && Storage::disk('local')->exists($bulletin->pdf_path),
            404
        );

        return Storage::disk('local')->download(
            $bulletin->pdf_path,
            'bulletin-' . $bulletin->id . '.pdf'
        );
    }
}
