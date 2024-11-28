<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\AuthorController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('author/index', [AuthorController::class, 'index']);
    Route::post('author/store', [AuthorController::class, 'store']);
    Route::get('author/show/{id}', [AuthorController::class, 'show']);
    Route::patch('author/update/{id}', [AuthorController::class, 'update']);
    Route::delete('author/destroy/{id}', [AuthorController::class, 'destroy']);
});
Route::middleware(['auth:sanctum','verified'])->group(function () {
    Route::get('category/index', [CategoryController::class, 'index']);
    Route::post('category/store', [CategoryController::class, 'store']);
    Route::get('category/show/{id}', [CategoryController::class, 'show']);
    Route::patch('/category/update/{id}', [CategoryController::class, 'update']);
    Route::delete('category/destroy/{id}', [CategoryController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('book/index', [BookController::class, 'index']);
    Route::post('book/store', [BookController::class, 'store']);
    Route::get('book/show/{id}', [BookController::class, 'show']);
    Route::patch('/book/update/{id}', [BookController::class, 'update']);
    Route::delete('book/destroy/{id}', [BookController::class, 'destroy']);
});

