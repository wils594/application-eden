<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get(
    '/enfants',
    [StudentController::class, 'index']
);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');