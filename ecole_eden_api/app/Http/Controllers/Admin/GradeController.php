<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::with('student')
            ->latest()
            ->paginate(15);

        $students = Student::orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('admin.notes.index', compact('grades', 'students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'subject' => ['required', 'string', 'max:100'],
            'grade' => ['required', 'numeric', 'min:0', 'max:20'],
            'coefficient' => ['required', 'numeric', 'gt:0', 'max:20'],
            'term' => ['required', 'string', 'max:50'],
            'school_year' => ['required', 'string', 'max:20'],
            'scan' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ]);

        $scanPath = $request->file('scan')?->store('scans-notes', 'local');

        Grade::create([
            'student_id' => $validated['student_id'],
            'subject' => $validated['subject'],
            'grade' => $validated['grade'],
            'coefficient' => $validated['coefficient'],
            'term' => $validated['term'],
            'school_year' => $validated['school_year'],
            'scan_path' => $scanPath,
            'entered_by' => $request->user()?->id,
            'status' => 'draft',
        ]);

        return redirect()
            ->route('admin.notes.index')
            ->with('success', 'Note enregistrée en brouillon.');
    }
}
