<?php

use App\Http\Controllers\API\KTPApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\KtpController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');




Route::get('/ktp', [KTPApiController::class, 'index']);
Route::post('/ktp', [KTPApiController::class, 'store'])->name('ktp.store');
Route::get('ktps/{id}', [KTPApiController::class, 'show']);
Route::put('/ktp/{id}', [KTPApiController::class, 'update'])->name('api.ktp.update');
Route::patch('ktps/{id}', [KTPApiController::class, 'update']);
Route::delete('/ktp/{id}', [KTPApiController::class, 'destroy'])->name('ktp.destroy');
Route::post('/import/csv', [KTPApiController::class, 'importCsv'])->name('import.csv');
