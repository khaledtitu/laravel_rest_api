<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarController;


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




Route::apiResource('users', UserController::class);

Route::apiResource('cars', CarController::class);

// Route::get('cars', [CarController::class, 'index']);
// Route::post('cars', [CarController::class, 'store']);
// Route::put('cars/{id}', [CarController::class, 'update']);
// Route::delete('cars/{id}', [CarController::class, 'destroy']);

