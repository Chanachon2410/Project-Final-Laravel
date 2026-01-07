<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIs\UserController;

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
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // User CRUD Endpoints
    Route::prefix('users')->group(function () {
        // List Users (Admin, Registrar)
        Route::get('/', [UserController::class, 'index'])->middleware('role:Admin|Registrar');
        // Create User (Admin)
        Route::post('/', [UserController::class, 'store'])->middleware('role:Admin');
        // Show User (Admin, Registrar)
        Route::get('/{id}', [UserController::class, 'show'])->middleware('role:Admin|Registrar');
        // Update User (Admin)
        Route::put('/{id}', [UserController::class, 'update'])->middleware('role:Admin');
        // Delete User (Admin)
        Route::delete('/{id}', [UserController::class, 'destroy'])->middleware('role:Admin');
    });
});
