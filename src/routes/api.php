<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TestApiController;
use App\Http\Controllers\Api\V1\CommonApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    Route::get('/test-api', [TestApiController::class, 'test']);
    Route::get('/time/current', [CommonApiController::class, 'getWeekDayInfo']);
});

