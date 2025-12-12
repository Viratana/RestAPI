<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use function Laravel\Prompts\search;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [UserController::class, 'Login']);
Route::post('/register', [UserController::class, 'Register']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::apiResource('author', AuthorController::class);
    Route::get('author/search/{term}', [AuthorController::class, 'search']);

    Route::apiResource('book', BookController::class);
});

