<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::apiResources([
    'posts' => PostController::class,
]);

Route::get('/file/posts/{filename}', [FileController::class, 'posts']);
Route::get('/file/users/{filename}', [FileController::class, 'users']);
Route::post('/file/posts/', [FileController::class, 'uploadPhoto']);

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'regist']);
