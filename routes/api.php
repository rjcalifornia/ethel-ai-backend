<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\MainController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('/v1/ethel-ia')->group(function () {
    Route::post('/procesar-consulta', [MainController::class, 'promptQuery']);
    Route::post('/gemma2/procesar-consulta', [MainController::class, 'gemmaLargeModel']);
    Route::post('/tinyllama/procesar-consulta', [MainController::class, 'promptQuery']);
});