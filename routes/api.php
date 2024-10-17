<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KTPController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




Route::get('ktps', [KTPController::class, 'index']);
Route::post('ktps', [KTPController::class, 'store']);
Route::get('ktps/{id}', [KTPController::class, 'show']);
Route::put('ktps/{id}', [KTPController::class, 'update']);
Route::patch('ktps/{id}', [KTPController::class, 'update']);
Route::delete('ktps/{id}', [KTPController::class, 'destroy']);

Route::get('ktps/export/csv', [KtpController::class, 'exportCsv']);
Route::get('ktps/export/pdf', [KtpController::class, 'exportPdf']);
Route::post('ktps/import', [KtpController::class, 'importCsv']);

