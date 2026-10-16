<?php

use Illuminate\Support\Facades\Route;
use App\Models\Student;
use App\Models\User;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ParentStudentController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\BulletinController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ChatController;

// Connexion et déconnexion
Route::get('/admin/login', [AuthController::class, 'showLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AuthController::class, 'login'])
    ->name('admin.login.submit');

Route::post('/admin/logout', [AuthController::class, 'logout'])
    ->middleware(['auth', 'admin'])
    ->name('admin.logout');

// Page d'accueil publique
Route::get('/', function () {
    return view('welcome');
});

// Toutes les pages suivantes sont réservées à l'administration
Route::middleware(['auth', 'admin'])->group(function () {

    // Tableau de bord
    Route::get('/admin', function () {
        $totalEleves = Student::count();
        $totalParents = User::where('role', 'parent')->count();

        return view('admin.dashboard', compact(
            'totalEleves',
            'totalParents'
        ));
    });

    // Élèves
    Route::get('/admin/eleves', function () {
        $eleves = Student::orderBy('last_name')->get();

        return view('eleves', compact('eleves'));
    });

    Route::post('/admin/eleves', [StudentController::class, 'store'])
        ->name('admin.eleves.store');

   
Route::get('/admin/eleves/ajouter', function () {
    return view('ajouter-eleve');
})->name('admin.eleves.create');


    // Classes
    Route::get('/admin/classes', function () {
        return 'Gestion des classes';
    });

    // Parents et association avec les élèves
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

    // Notes
    Route::get('/admin/notes', [GradeController::class, 'index'])
        ->name('admin.notes.index');

    Route::post('/admin/notes', [GradeController::class, 'store'])
        ->name('admin.notes.store');

    // Bulletins
    Route::get('/admin/bulletins', [BulletinController::class, 'index'])
        ->name('admin.bulletins.index');

    Route::post('/admin/bulletins/generer', [
        BulletinController::class,
        'generate'
    ])->name('admin.bulletins.generate');

    Route::post('/admin/bulletins/importer', [
        BulletinController::class,
        'upload'
    ])->name('admin.bulletins.upload');

    Route::post('/admin/bulletins/{bulletin}/valider', [
        BulletinController::class,
        'validateBulletin'
    ])->name('admin.bulletins.validate');

    Route::get('/admin/bulletins/{bulletin}/telecharger', [
        BulletinController::class,
        'download'
    ])->name('admin.bulletins.download');

    Route::post('/admin/bulletins/preview', [
        BulletinController::class,
        'preview'
    ])->name('admin.bulletins.preview');

    // Annonces
    Route::prefix('admin/annonces')->name('admin.annonces.')->group(function () {
        Route::get('/', [AnnouncementController::class, 'index'])
            ->name('index');

        Route::get('/create', [AnnouncementController::class, 'create'])
            ->name('create');

        Route::post('/', [AnnouncementController::class, 'store'])
            ->name('store');

        Route::delete('/{announcement}', [
            AnnouncementController::class,
            'destroy'
        ])->name('destroy');
    });

 
    // Messagerie de l'administration
    Route::get('/admin/messages', [ChatController::class, 'index'])
        ->name('admin.messages.index');

    Route::get('/admin/messages/{conversation}', [ChatController::class, 'show'])
        ->name('admin.messages.show');

    Route::post('/admin/messages/{conversation}/reply', [ChatController::class, 'reply'])
        ->name('admin.messages.reply');

    // Récupération automatique des messages
    Route::get('/admin/messages/{conversation}/fetch', [
        ChatController::class,
        'fetchMessages'
    ])->name('admin.messages.fetch');
});