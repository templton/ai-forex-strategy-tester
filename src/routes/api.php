<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CommonApiController;
use App\Http\Controllers\Api\V1\StrategyController;
use App\Http\Controllers\Api\V1\TestApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    Route::get('/test-api', [TestApiController::class, 'test']);
    Route::get('/time/current', [CommonApiController::class, 'getWeekDayInfo']);
    Route::get('/strategies', [StrategyController::class, 'index']);
    Route::post('/strategies', [StrategyController::class, 'store']);
    Route::get('/strategies/{id}', [StrategyController::class, 'show']);
    Route::put('/strategies/{id}', [StrategyController::class, 'update']);
    Route::delete('/strategies/{id}', [StrategyController::class, 'destroy']);
});

