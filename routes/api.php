<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CategoryGroupsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Traits\ApiResponses;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test-api', function () {
    return response("Function is Working");
});

// Category Groups 

Route::get('category-groups', [CategoryGroupsController::class, 'index']);
Route::post('product/restore/{id}', [CategoryGroupsController::class, 'restore']);
Route::post('category-groups', [CategoryGroupsController::class, 'store']);
Route::get('category-groups/{id}', [CategoryGroupsController::class, 'show']);
Route::post('category-groups/{id}', [CategoryGroupsController::class, 'update']);
Route::delete('category-groups/{id}', [CategoryGroupsController::class, 'delete']);


// Categories

Route::get('categories', [CategoriesController::class, 'index']);
Route::post('categories', [CategoriesController::class, 'store']);
Route::get('categories/{id}', [CategoriesController::class, 'show']);
Route::post('categories/{id}', [CategoriesController::class, 'update']);
Route::delete('categories/{id}', [CategoriesController::class, 'destroy']);
