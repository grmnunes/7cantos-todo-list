<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tasks', TaskController::class)->except('show');
    Route::patch('tasks/{taskId}/toggle-status', [TaskController::class, 'toggleCompletedStatus']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('auth', [AuthController::class, 'login']);
