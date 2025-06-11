<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KandydatController;
use App\Http\Controllers\KandydaturaController;
use App\Http\Controllers\KierunekController;
use App\Http\Controllers\DokumentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Strona główna - Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Zarządzanie kandydatami
Route::resource('kandydats', KandydatController::class);

// Zarządzanie kandydaturami
Route::resource('kandydaturas', KandydaturaController::class);
Route::patch('kandydaturas/{kandydatura}/status', [KandydaturaController::class, 'updateStatus'])
     ->name('kandydaturas.update-status');

// Zarządzanie kierunkami
Route::resource('kieruneks', KierunekController::class);


// Zarządzanie dokumentami
Route::get('kandydaturas/{kandydatura}/dokuments', [DokumentController::class, 'index'])
     ->name('dokuments.index');
Route::get('kandydaturas/{kandydatura}/dokuments/create', [DokumentController::class, 'create'])
     ->name('dokuments.create');
Route::post('dokuments', [DokumentController::class, 'store'])
     ->name('dokuments.store');
Route::get('dokuments/{dokument}/download', [DokumentController::class, 'download'])
     ->name('dokuments.download');
Route::delete('dokuments/{dokument}', [DokumentController::class, 'destroy'])
     ->name('dokuments.destroy');
// API endpoints dla AJAX
Route::prefix('api')->group(function () {
    Route::get('kandydats/search', [KandydatController::class, 'search'])->name('api.kandydats.search');
    Route::get('kieruneks/active', [KierunekController::class, 'getActive'])->name('api.kieruneks.active');
    Route::get('stats', [DashboardController::class, 'getStats'])->name('api.stats');
});

// Obsługa błędów
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});