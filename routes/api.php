<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\MainController;
use App\Http\Middleware\AppValidation;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('/v1/ethel-ia')->group(function () {
    Route::post('/procesar-consulta', [MainController::class, 'promptQuery']);
    Route::post('/full/procesar-consulta', [MainController::class, 'ethelLargeModel'])->middleware(AppValidation::class);
    Route::post('/basic/procesar-consulta', [MainController::class, 'ethelBasicModel']);
});