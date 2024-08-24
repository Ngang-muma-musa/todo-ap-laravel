<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\TodoController;
use App\Http\Controllers\API\V1\ItemController;
use App\Http\Controllers\API\V1\AuthController;

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

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::group(['middleware' => ['auth:sanctum']], function ()  {
    Route::controller(AuthController::class)->prefix('auth')->group(function () {
        Route::post('/logout', 'logout');
    });

    Route::group(['prefix' => 'v1'],function(){
        // Group Routes
        Route::apiResource('users.todos', TodoController::class);
    
        // Todo Routes (Nested under groups)
        Route::apiResource('todos.items', ItemController::class)->except(['show']);
    });
});
