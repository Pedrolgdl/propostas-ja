<?php

use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function() {

    // Rotas para imoveis
    Route::name('properties.')->group(function() {

        Route::resource('properties', PropertyController::class);

    });

    // Rotas para usuarios
    Route::name('users.')->group(function() {

        Route::resource('users', UserController::class);

    });

});