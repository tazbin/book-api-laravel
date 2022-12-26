<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/ping', function() {
    return 'server running...';
});

Route::post('/users/register', [UserController::class, 'register']);
Route::post('/users/login', [UserController::class, 'login']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/users/{id}/book', [BookController::class, 'index']);

Route::get('/contacts/{id}', [ContactController::class, 'show']);
Route::get('/contacts', [ContactController::class, 'index']);

Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/books', [BookController::class, 'index']);


Route::group(['middleware' => ['auth:sanctum']], function() {

    Route::post('/users/logout', [UserController::class, 'logout']);

    // prevent multiple post
    Route::post('/users/contacts', [ContactController::class, 'store']);

    // why i need id here ?
    Route::put('/users/{id}/contacts', [ContactController::class, 'update']);

    // why i need id here ?
    Route::delete('/users/{id}/contact', [ContactController::class, 'destroy']);

    Route::post('/users/book', [BookController::class, 'store']);

    Route::put('/users/book/{id}', [BookController::class, 'update']);

    Route::delete('/users/book/{id}', [BookController::class, 'destroy']);
    
});
