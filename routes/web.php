<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KandydatController;
use App\Http\Controllers\KandydaturaController;
use App\Http\Controllers\KierunekController;
use App\Http\Controllers\DokumentController;

// Route logowania (dostępne dla niezalogowanych)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Route wylogowania
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route wymagające logowania
Route::middleware('auth')->group(function () {
    
    // Dashboard - dla wszystkich zalogowanych
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Kierunki - dostępne dla wszystkich (admin i kandydat)
    Route::get('/kieruneks', [KierunekController::class, 'index'])->name('kieruneks.index');
    Route::get('/kieruneks/{kierunek}', [KierunekController::class, 'show'])->name('kieruneks.show');
    
    // Route tylko dla ADMINA
    Route::middleware('role:admin')->group(function () {
        // Zarządzanie kandydatami
        Route::resource('kandydats', KandydatController::class);
        
        // Wszystkie kandydatury (dla admina) - PEŁNY RESOURCE
        Route::resource('kandydaturas', KandydaturaController::class)->except(['create', 'store']);
        Route::patch('/kandydaturas/{kandydatura}/status', [KandydaturaController::class, 'updateStatus'])->name('kandydaturas.update-status');
        
        // Zarządzanie kierunkami (CRUD)
        Route::resource('kieruneks', KierunekController::class)->except(['index', 'show']);
        
        // API dla admina
        Route::prefix('api')->group(function () {
            Route::get('kandydats/search', [KandydatController::class, 'search'])->name('api.kandydats.search');
            Route::get('kieruneks/active', [KierunekController::class, 'getActive'])->name('api.kieruneks.active');
            Route::get('stats', [DashboardController::class, 'getStats'])->name('api.stats');
        });
    });
    
    // Route dla KANDYDATA
    Route::middleware('role:kandydat')->group(function () {
        // Moje kandydatury
        Route::get('/moje-kandydatury', [KandydaturaController::class, 'myApplications'])->name('kandydaturas.my');
        Route::get('/kandydatury/create', [KandydaturaController::class, 'create'])->name('kandydaturas.create');
        Route::post('/kandydatury', [KandydaturaController::class, 'store'])->name('kandydaturas.store');
        Route::get('/kandydatury/{kandydatura}', [KandydaturaController::class, 'show'])->name('kandydaturas.show');
    });
    
    // Dokumenty - dostępne dla właściciela kandydatury lub admina
    Route::get('kandydaturas/{kandydatura}/dokuments', [DokumentController::class, 'index'])->name('dokuments.index');
    Route::get('kandydaturas/{kandydatura}/dokuments/create', [DokumentController::class, 'create'])->name('dokuments.create');
    Route::post('dokuments', [DokumentController::class, 'store'])->name('dokuments.store');
    Route::get('dokuments/{dokument}/download', [DokumentController::class, 'download'])->name('dokuments.download');
    Route::delete('dokuments/{dokument}', [DokumentController::class, 'destroy'])->name('dokuments.destroy');
});

// Obsługa błędów
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});