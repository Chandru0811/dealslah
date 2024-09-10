<?php

use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CategoryGroupsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Shops
Route::post('/create/shop', [ShopController::class, 'store']);
Route::get('/shops', [ShopController::class, 'index']);
Route::get('/shop/{id}', [ShopController::class, 'show']);
Route::put('/update/shop/{id}', [ShopController::class, 'update']);
Route::delete('/delete/shop/{id}', [ShopController::class, 'destroy']);
Route::get('/restore/shop/{id}', [ShopController::class, 'restore']);
Route::delete('/forceDelete/shop/{id}', [ShopController::class, 'forceDelete']);

// Products
Route::get('product', [ProductController::class, 'index']);
Route::post('product', [ProductController::class, 'store']);
Route::post('product/restore/{id}', [ProductController::class, 'restore']);
Route::get('product/{id}', [ProductController::class, 'show']);
Route::post('product/{id}', [ProductController::class, 'update']);
Route::delete('product/{id}', [ProductController::class, 'destroy']);

//Announcements
Route::get('announcements', [AnnouncementController::class, 'index']);
Route::post('announcements', [AnnouncementController::class, 'store']);
Route::get('announcements/{id}', [AnnouncementController::class, 'show']);
Route::put('announcements/{id}', [AnnouncementController::class, 'update']);
Route::delete('announcements/{id}', [AnnouncementController::class, 'destroy']);


//Banner
Route::get('banners', [BannerController::class, 'index']);
Route::post('banners', [BannerController::class, 'store']);
Route::get('banners/{id}', [BannerController::class, 'show']);
Route::put('banners/{id}', [BannerController::class, 'update']);
Route::delete('banners/{id}', [BannerController::class, 'destroy']);
