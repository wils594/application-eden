<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'matricule' => ['required', 'string', 'max:255', 'unique:students,matricule'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'class_name' => ['required', 'string', 'max:255'],
        ]);

        $validated['school_year'] = date('Y') . '-' . (date('Y') + 1);

        Student::create($validated);

        return redirect('/admin/eleves')
            ->with('success', 'Élève enregistré avec succès.');
    }
}
