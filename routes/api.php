<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\api\authController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





    Route::prefix('v1')->group(function () {




        Route::post('login', [authController::class, 'login']);
        Route::post('register', [authController::class, 'register']);

        Route::get('login', function () {
            return sent_error('Unauthorised', '', 401);
        })->name('login');

        Route::middleware('auth:api')->group(function () {

            Route::post('logout', [authController::class, 'logout']);


            Route::get('users', [authController::class, 'index']);
            Route::post('users/{id}/edit', [authController::class, 'Edit']);
            Route::delete('users/{id}/delete', [authController::class, 'delete']);
            Route::get('users/restore/{id}', [authController::class, 'restore']);
            Route::get('users/restore/', [authController::class, 'restoreAll']);
            Route::get('users/deleted/', [authController::class, 'deleted']);
            Route::get('users/{id}', [authController::class, 'show']);
        });
    });
