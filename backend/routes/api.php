<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PricePredictionController;

Route::get('/rooms', [PricePredictionController::class, 'getRoomsWithPrices']);
Route::post('/rooms/{id}/price', [PricePredictionController::class, 'predictPrice']);
