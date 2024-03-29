<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\CodeCheckController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\VisitSchedulingController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) 
{
    return $request->user();
});

Route::prefix('v1')->group(function() 
{

    Route::post('/properties/filters', [PropertyController::class, 'filters']);
    
    // Rotas para imoveis
    Route::name('properties.')->group(function() 
    {

        Route::resource('properties', PropertyController::class);
        Route::get('/properties/admin', [PropertyController::class, 'propertiesAdminList']);
        Route::put('/properties/approve/{propertyId}', [PropertyController::class, 'approveProperty']);
        Route::post('/properties/remove/{propertyId}', [PropertyController::class, 'removeSolicitation']);
        Route::post('/properties/unable/{propertyId}', [PropertyController::class, 'switchUnableProperty']);

    });


    // Rotas para usuarios
    Route::name('users.')->group(function()
    {
        Route::resource('users', UserController::class)->except(['update']);
        Route::put('/me/update', [UserController::class, 'update']);
        Route::post('users/favorite/{propertyId}', [UserController::class, 'favorite']);
        Route::post('users/unfavorite/{propertyId}', [UserController::class, 'unfavorite']);
        Route::get('users/favorite/show', [UserController::class, 'showFavorite']);
        Route::post('users/proposal/{propertyId}', [UserController::class, 'proposal']);
        Route::post('users/remove-proposal/{propertyId}', [UserController::class, 'removeProposal']);
        Route::get('users/proposal/show', [UserController::class, 'showProposal']);
        Route::delete('users/removeUserPhoto/{userId}', [UserController::class, 'removeUserPhoto']);

    });


    // Rotas para fotos
    Route::name('photos.')->prefix('photos')->group(function() 
    { 

        Route::delete('/{id}', [PhotoController::class, 'remove']);
        Route::put('/set-thumb/{photoId}/{propertyId}', [PhotoController::class, 'setThumb']);

    });


    // Rotas para documentos
    Route::name('documents.')->group(function() 
    {

        Route::resource('documents', DocumentController::class);
        Route::get('/me/documents', [DocumentController::class, 'userDocuments']);

    });

    Route::prefix('statistics')->group(function() 
    {
        Route::get('/users', [StatisticsController::class, 'usersCount']);
        Route::get('/properties', [StatisticsController::class, 'propertiesCount']);

    });


    // Rotas para visitas
    Route::name('visits.')->prefix('visits')->group(function() 
    {

        Route::get('/', [VisitSchedulingController::class, 'index']);
        Route::post('/', [VisitSchedulingController::class, 'store']);
        Route::match(['put', 'patch'], '/accept/{visit}', [VisitSchedulingController::class, 'accept']);
        Route::match(['put', 'patch'], '/done/{visit}', [VisitSchedulingController::class, 'done']);
        Route::match(['put', 'patch'], '/cancel/{visit}', [VisitSchedulingController::class, 'cancel']);
        Route::delete('/{visit}', [VisitSchedulingController::class, 'destroy']);

    });


    // Rotas para autenticação de usuário
    Route::group([

        'prefix' => 'auth'
    
    ], function ($router) {
    
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    
    });


    // Rotas de verificação de senha
    Route::post('password/email',  [ForgotPasswordController::class, 'email']);
    Route::post('password/code/check', [CodeCheckController::class, 'code']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);
    

    // Rotas de verificação de email
    Route::get('email/verify/{id}', [VerificationController::class,'verify'])->name('verification.verify'); // Make sure to keep this as your route name
    Route::get('email/resend', [VerificationController::class,'resend'])->name('verification.resend');
});

