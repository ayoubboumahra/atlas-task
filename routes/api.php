<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
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

Route::post('/auth/login', [AuthController::class, 'login'])->middleware(['guest']);

Route::middleware(['auth:api'])->group(function(){
    
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
    
    Route::post('/user/delete', [UserController::class, 'delete']);

    Route::resource('/projects', ProjectController::class);
    Route::post('/projects/{project}', [ProjectController::class, 'save']);
    Route::post('/projects/{project}/render', [ProjectController::class, 'render']);

});
