<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WEB\KTPWebController;
use App\Http\Controllers\AdminActivityController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'log.activity'])->group(
    function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::get('/ktp', function () {
            return view('ktp.index');
        })->name('ktp.index');

        Route::get('/export', function () {
            return view('ktp.export');
        })->name('export');

        Route::get('ktp/{ktp}', [KTPWebController::class, 'show'])->name('ktp.show');

        Route::get('export/pdf', [KTPWebController::class, 'exportPdf']);
        Route::get('export/csv', [KTPWebController::class, 'exportCsv']);
    }
);

// Rute untuk user admin
Route::middleware(['role:admin'])->group(function () {
    Route::get('ktps/create', [KTPWebController::class, 'create'])->name('ktp.create');
    Route::get('ktp/{ktp}/edit', [KTPWebController::class, 'edit'])->name('ktp.edit');
    Route::put('ktp/{ktp}', [KTPWebController::class, 'update'])->name('ktp.update');
    Route::delete('ktp/{ktp}', [KTPWebController::class, 'destroy'])->name('ktp.destroy');
    Route::get('/admin/activities', [AdminActivityController::class, 'index'])->name('admin.activities');
    Route::get('/admin/activities/export', [AdminActivityController::class, 'export'])->name('admin.activities.export');
    Route::get('/import', function () {
        return view('ktp.import');
    })->name('import');
});

// Route::resource('ktp', KTPWebController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/no-access/{role}', function ($role) {
    return view('no-access', ['role' => $role]);
})->name('no.access');


require __DIR__.'/auth.php';
