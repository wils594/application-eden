<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class ParentStudentController extends Controller
{
    public function index()
    {
        $parents = User::where('role', 'parent')
            ->orderBy('name')
            ->get();

        $eleves = Student::orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('admin.parents.associer', compact(
            'parents',
            'eleves'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'student_ids' => ['required', 'array', 'min:1'],
            'student_ids.*' => [
                'integer',
                'distinct',
                'exists:students,id',
            ],
        ]);

        $parent = User::where('role', 'parent')
            ->findOrFail($validated['parent_id']);

        $parent->students()->syncWithoutDetaching(
            $validated['student_ids']
        );

        return redirect()
            ->route('admin.parents.associer')
            ->with('success', 'Association enregistrée avec succès.');
    }
}
