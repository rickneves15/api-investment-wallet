<?php

use App\Http\Controllers\AssetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Hello World';
});

Route::get('/assets', [AssetController::class, 'index']);
Route::post('/assets', [AssetController::class, 'store']);
Route::get('/assets/{id}', [AssetController::class, 'show']);
Route::delete('/assets/{id}', [AssetController::class, 'destroy']);
