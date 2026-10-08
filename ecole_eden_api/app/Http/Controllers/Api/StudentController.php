<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Récupérer les enfants du parent connecté.
     */
    public function index(Request $request): JsonResponse
    {
        $students = $request->user()
            ->students()
            ->get([
                'students.id',
                'students.matricule',
                'students.first_name',
                'students.last_name',
                'students.date_of_birth',
                'students.class_name',
                'students.school_year',
            ]);

        return response()->json([
            'message' => 'Liste des enfants récupérée avec succès.',
            'data' => $students,
        ]);
    }
}