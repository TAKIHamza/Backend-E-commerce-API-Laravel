<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\CategoryController;

// User routes
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/users', [AuthController::class, 'users']);
Route::middleware('auth:sanctum')->delete('/deleteUser', [AuthController::class, 'deleteUser']);
Route::middleware('auth:sanctum')->put('/changeUserRole', [AuthController::class, 'changeUserRole']);
// Product routes
Route::middleware('auth:sanctum')->resource('/products', ProductController::class);
Route::middleware('auth:sanctum')->post('/products/{id}', [ProductController::class, 'update']);
Route::middleware('auth:sanctum')->get('/products/by-category/{category}', [ProductController::class, 'getProductsByCategory']);
// Command routes
Route::middleware('auth:sanctum')->resource('/commands', CommandController::class);
Route::middleware('auth:sanctum')->get('/getCombinedData', [CommandController::class, 'getCombinedData']);
Route::middleware('auth:sanctum')->get('/getClientCommands', [CommandController::class, 'getClientCommands']);
Route::middleware('auth:sanctum')->put('/updateCommandValidation', [CommandController::class, 'updateCommandValidation']);
Route::middleware('auth:sanctum')->put('/updateCommandReceived', [CommandController::class, 'updateCommandReceived']);
// Catigory routes
Route::middleware('auth:sanctum')->resource('/categorys', CategoryController::class);
// --------------
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});