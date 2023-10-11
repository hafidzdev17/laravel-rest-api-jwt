<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PostController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login',[\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/refresh',[\App\Http\Controllers\AuthController::class, 'refresh'])
    ->middleware('jwt.verify');
Route::get('/me',[\App\Http\Controllers\AuthController::class, 'me'])
    ->middleware('jwt.auth');

// post
Route::resource('post', PostController::class)
    ->middleware('jwt.auth');
