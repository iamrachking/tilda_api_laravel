<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\UploadController;

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

// Routes utilisateur
Route::prefix('users')->group(function () {
    Route::post('create', [UserController::class, 'createOrUpdate']);
    Route::get('profile', [UserController::class, 'profile']);
    Route::put('profile', [UserController::class, 'updateProfile']);
    Route::get('my-recipes', [UserController::class, 'recipes']);
});

// Routes catégories
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{categoryId}', [CategoryController::class, 'show']);
Route::post('categories', [CategoryController::class, 'store']);
Route::put('categories/{categoryId}', [CategoryController::class, 'update']);
Route::delete('categories/{categoryId}', [CategoryController::class, 'destroy']);

Route::middleware('firebase.user')->group(function () {
// Routes recettes
Route::get('recipes', [RecipeController::class, 'index']);
Route::get('recipes/popular', [RecipeController::class, 'popular']);
Route::get('recipes/recent', [RecipeController::class, 'recent']);
Route::get('recipes/{recipeId}', [RecipeController::class, 'show']);
Route::post('recipes', [RecipeController::class, 'store']);
Route::put('recipes/{recipeId}', [RecipeController::class, 'update']);
Route::delete('recipes/{recipeId}', [RecipeController::class, 'destroy']);

// Routes favoris
Route::get('favorites', [FavoriteController::class, 'index']);
Route::post('favorites', [FavoriteController::class, 'store']);
Route::delete('favorites/{recipeId}', [FavoriteController::class, 'destroy']);
Route::get('favorites/check/{recipeId}', [FavoriteController::class, 'check']);

// Routes likes
Route::get('likes', [LikeController::class, 'index']);
Route::post('likes', [LikeController::class, 'store']);
Route::delete('likes/{recipeId}', [LikeController::class, 'destroy']);
Route::get('likes/check/{recipeId}', [LikeController::class, 'check']);

// Routes commentaires
Route::get('recipes/{recipeId}/comments', [CommentController::class, 'index']);
Route::post('comments', [CommentController::class, 'store']);
Route::put('comments/{commentId}', [CommentController::class, 'update']);
Route::delete('comments/{commentId}', [CommentController::class, 'destroy']);

// Routes upload d'images
Route::post('upload/image', [UploadController::class, 'uploadImage']);
Route::delete('upload/image', [UploadController::class, 'deleteImage']);
});