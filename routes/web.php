<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WEB\KTPWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard.dashboard');
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('ktp', KTPWebController::class);
Route::get('/ktp', function () {
    return view('ktp.index');
})->name('ktp.index');
Route::get('/ktp/{id}', [KTPWebController::class, 'show'])->name('ktp.show');
Route::get('/export', function () {
    return view('ktp.export');
})->name('export');
Route::get('/import', function () {
    return view('ktp.import');
})->name('import');

require __DIR__.'/auth.php';
