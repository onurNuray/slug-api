<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SlugController;
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

Route::post('/register', [UserController::class, 'create']);
Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [LoginController::class, 'logout']);

    Route::prefix('user')->group(function () {
        Route::get('/profile', [UserController::class, 'show']);
        Route::put('/profile', [UserController::class, 'update']);
        Route::put('/password-update', [UserController::class, 'password_update']);
        Route::delete('/', [UserController::class, 'destroy']);
    });

    Route::prefix('slug')->group(function () {

        Route::post('/', [SlugController::class, 'create']);
        Route::get('/', [SlugController::class, 'index']);

        Route::middleware(['slug'])->group(function () {
                Route::get('/{slug_id}', [SlugController::class,'show']);
                Route::put('/', [SlugController::class, 'update']);
                Route::delete('/{slug_id}', [SlugController::class, 'destroy']);
        });
    });
});
