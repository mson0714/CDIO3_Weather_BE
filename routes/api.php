<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::middleware(['api'])->group(function () {
    Route::options('/predict', function() {
        return response()->json([], 200);
    });
    Route::post('/predict', [WeatherController::class, 'predict']);
});
 