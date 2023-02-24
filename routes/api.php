<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Auth\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::controller(EmployeeController::class)->prefix('employee')->group(function () {
            Route::post('add', 'add');
            Route::put('edit/{id}', 'edit');
            Route::delete('delete/{id}', 'delete');
            Route::patch('restore/{id}', 'restore');
            Route::get('view/{id}', 'view');
            Route::get('/', 'list');
        });
    });
    Route::controller(AuthController::class)->prefix('auth')->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::post('view', 'view')->middleware('auth:api');
        Route::get('logout', 'logout')->middleware('auth:api');
    });
});

