
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Models\Student;
use App\Http\Controllers\ParentController;
use App\Models\User;
use App\Http\Controllers\ParentStudentController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\BulletinController;
use App\Http\Controllers\Admin\AnnouncementController;


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


Route::prefix('admin/annonces')->name('admin.annonces.')->group(function () {
    Route::get('/', [AnnouncementController::class, 'index'])->name('index');
    Route::get('/create', [AnnouncementController::class, 'create'])->name('create');
    Route::post('/', [AnnouncementController::class, 'store'])->name('store');
    Route::delete('/{announcement}', [AnnouncementController::class, 'destroy'])->name('destroy');
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

Route::get('/admin/notes', [GradeController::class, 'index'])
    ->name('admin.notes.index');

Route::post('/admin/notes', [GradeController::class, 'store'])
    ->name('admin.notes.store');

    
Route::get('/admin/bulletins', [BulletinController::class, 'index'])
    ->name('admin.bulletins.index');

Route::post('/admin/bulletins/generer', [BulletinController::class, 'generate'])
    ->name('admin.bulletins.generate');

Route::post('/admin/bulletins/importer', [BulletinController::class, 'upload'])
    ->name('admin.bulletins.upload');

Route::post('/admin/bulletins/{bulletin}/valider', [BulletinController::class, 'validateBulletin'])
    ->name('admin.bulletins.validate');

Route::get('/admin/bulletins/{bulletin}/telecharger', [BulletinController::class, 'download'])
    ->name('admin.bulletins.download');

Route::post(
    '/admin/bulletins/preview',
    [BulletinController::class, 'preview']
)->name('admin.bulletins.preview');
