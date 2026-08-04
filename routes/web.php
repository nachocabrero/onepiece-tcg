<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\SetController;
use App\Http\Controllers\RarityController;
use App\Http\Controllers\CatalogController;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Catalog (all available cards)
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{card}', [CatalogController::class, 'show'])->name('catalog.show');
Route::post('/catalog/{card}/toggle', [CatalogController::class, 'toggleCollected'])->name('catalog.toggle');

// Cards (my collection)
Route::resource('cards', CardController::class);

// Sets
Route::resource('sets', SetController::class);

// Rarities
Route::resource('rarities', RarityController::class);