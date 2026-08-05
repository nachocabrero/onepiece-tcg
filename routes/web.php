<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\SetController;
use App\Http\Controllers\RarityController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Auth\LoginController;

// Public routes
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{card}', [CatalogController::class, 'show'])->name('catalog.show');

// Auth routes
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/cards', [CardController::class, 'index'])->name('cards.index');
    Route::get('/cards/create', [CardController::class, 'create'])->name('cards.create');
    Route::post('/cards', [CardController::class, 'store'])->name('cards.store');
    Route::get('/cards/{card}/edit', [CardController::class, 'edit'])->name('cards.edit');
    Route::put('/cards/{card}', [CardController::class, 'update'])->name('cards.update');
    Route::delete('/cards/{card}', [CardController::class, 'destroy'])->name('cards.destroy');

    // PDF downloads
    Route::get('/cards/missing-pdf', [CardController::class, 'downloadMissingPdf'])->name('cards.missing-pdf');
    Route::get('/cards/set/{setId}/missing-pdf', [CardController::class, 'downloadSetPdf'])->name('cards.set-pdf');

    // Catalog toggle
    Route::post('/catalog/{card}/toggle', [CatalogController::class, 'toggleCollected'])->name('catalog.toggle');

    // Search by numbers
    Route::get('/cards/search-by-numbers', [CardController::class, 'searchByNumbers'])->name('cards.search-by-numbers');

    // Search by set code + numbers (bulk text)
    Route::get('/cards/search-by-set-numbers', [CardController::class, 'searchBySetNumbers'])->name('cards.search-by-set-numbers');

    // CRUD routes
    Route::resource('sets', SetController::class);
    Route::resource('rarities', RarityController::class);
});