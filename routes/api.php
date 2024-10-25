<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\MetricsController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Hello World';
});

Route::get('/assets', [AssetController::class, 'index']);
Route::post('/assets', [AssetController::class, 'store']);
Route::get('/assets/{id}', [AssetController::class, 'show']);
Route::delete('/assets/{id}', [AssetController::class, 'destroy']);

Route::post('/transactions/buy', [TransactionController::class, 'buy']);
Route::post('/transactions/sell', [TransactionController::class, 'sell']);

Route::group(['prefix' => 'metrics'], function () {
    Route::get('/total-gross', [MetricsController::class, 'getTotalGross']);
    Route::get('/total-assets', [MetricsController::class, 'getTotalAssets']);
    Route::get('/monthly-transactions', [MetricsController::class, 'getMonthlyTransactions']);
    Route::get('/assets-grouped-by-type', [MetricsController::class, 'getAssetsGroupedByType']);
});
