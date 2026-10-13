
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Models\Student;
use App\Http\Controllers\ParentController;
use App\Models\User;
use App\Http\Controllers\ParentStudentController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/admin', function () {
    $totalEleves = Student::count();
    $totalParents = User::where('role', 'parent')->count();

    return view('admin.dashboard', compact(
        'totalEleves',
        'totalParents'
    ));
});



Route::get('/admin/eleves', function () {
    $eleves = Student::orderBy('last_name')->get();

    return view('eleves', compact('eleves'));
});

Route::post('/admin/eleves', [StudentController::class, 'store'])
    ->name('admin.eleves.store');

    Route::get('/admin/eleves/ajouter', function () {
    return view('admin.eleves.create');
})->name('admin.eleves.create');

Route::get('/admin/classes', function () {
    return 'Gestion des classes';
});

Route::get('/admin/eleves/ajouter', function () {
    return view('ajouter-eleve');
});

Route::get('/admin/bulletins', function () {
    return 'Gestion des bulletins';
});

Route::get('/admin/annonces', function () {
    return 'Gestion des annonces';
});

Route::get('/admin/messages', function () {
    return 'Gestion des messages';
});
Route::get('/admin/parents', [ParentController::class, 'index'])
    ->name('admin.parents.index');
    Route::get('/admin/parents/associer', [
    ParentStudentController::class,
    'index'
])->name('admin.parents.associer');

Route::post('/admin/parents/associer', [
    ParentStudentController::class,
    'store'
])->name('admin.parents.associer.store');