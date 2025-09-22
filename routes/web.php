<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UploadController;

Route::get('/', function () {
    return redirect()->route('categories.index');
});

// Routes pour la gestion des catégories
Route::resource('categories', CategoryController::class);

// Routes pour l'upload d'images
Route::post('upload/category-image', [UploadController::class, 'uploadCategoryImage'])->name('upload.category-image');
Route::post('upload/recipe-image', [UploadController::class, 'uploadRecipeImage'])->name('upload.recipe-image');
Route::post('upload/avatar-image', [UploadController::class, 'uploadAvatarImage'])->name('upload.avatar-image');
Route::delete('upload/delete-image', [UploadController::class, 'deleteImage'])->name('upload.delete-image');
