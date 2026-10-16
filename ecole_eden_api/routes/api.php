<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\BulletinController;
use App\Http\Controllers\Api\AnnouncementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatController;

// Inscription et connexion
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Enfants
Route::middleware('auth:sanctum')->get(
    '/enfants',
    [StudentController::class, 'index']
);

// Informations du parent connecté
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Routes protégées pour le parent connecté
Route::middleware('auth:sanctum')->group(function () {

    // Bulletins scolaires
    Route::get('/bulletins', [BulletinController::class, 'index']);

    Route::get(
        '/bulletins/{bulletin}/telecharger',
        [BulletinController::class, 'download']
    );

    // Annonces publiées
    Route::get(
        '/annonces',
        [AnnouncementController::class, 'index']
    );
        // Messagerie privée du parent connecté
    Route::get('/chat', [ChatController::class, 'index']);
    Route::post('/chat', [ChatController::class, 'store']);
});