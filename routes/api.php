<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Traits\ApiResponses;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test-api', function () {
    return response("Function is Working");
});
