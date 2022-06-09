<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AuthController;
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

    // Rotas para fotos
    Route::name('photos.')->prefix('photos')->group(function() {

        Route::delete('/{id}', [PhotoController::class, 'remove']);
        Route::put('/set-thumb/{photoId}/{propertyId}', [PhotoController::class, 'setThumb']);

    });

   // Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');

    Route::group([

        //'middleware' => 'api',
        'prefix' => 'auth'
    
    ], function ($router) {
    
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    
    });

});