<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MeasurementUnitController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeReviewController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRecipeController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->name('desktop-login');

Route::middleware(['auth:sanctum', 'abilities:desktop'])->group(function () {

    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('media/{media}', [MediaController::class, 'show']);
    Route::delete('media/{media}', [MediaController::class, 'destroy']);

    Route::apiResource('users', UserController::class);

    Route::apiResource('users/{user}/recipes', UserRecipeController::class);

    Route::apiResource('measurement_units', MeasurementUnitController::class);

    Route::post('ingredients/{ingredient}/add_images', [IngredientController::class, 'addImages']);
    Route::apiResource('ingredients', IngredientController::class);

    Route::post('recipes/{recipe}/add_images', [RecipeController::class, 'addImages']);
    Route::apiResource('recipes', RecipeController::class)->except(['store']);

    Route::apiResource('reviews', ReviewController::class)->only(['show', 'update', 'destroy']);

    Route::apiResource('recipes/{recipe}/reviews', RecipeReviewController::class)->only(['index', 'store']);
});
