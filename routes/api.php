<?php

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
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

Route::post('register', [AuthorController::class, 'register']);
Route::post('login', [AuthorController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('profile', [AuthorController::class, 'profile']);
    Route::get('logout', [AuthorController::class, 'logout']);

    Route::post('create-book', [BookController::class, 'create']);
    Route::get('list-book', [BookController::class, 'index']);
    Route::get('list-author-book', [BookController::class, 'authorBook']);
    Route::get('list-book/{id}', [BookController::class, 'single']);
    Route::post('update-book/{id}', [BookController::class, 'update']);
    Route::delete('delete-book', [BookController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
