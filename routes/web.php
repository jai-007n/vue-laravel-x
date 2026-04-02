<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('vendor')->name('vendor.')
    ->controller(VendorController::class)
    ->group(function () {
        Route::get('/list', 'index')->name('list');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{vendor}', 'edit')->name('edit');
        Route::post('/', 'store')->name('store');
        Route::put('/{vendor}',  'update')->name('update');
        Route::delete('/{vendor}',  'destroy')->name('destroy');
    });

Route::middleware('auth')->prefix('product')->name('product.')
    ->controller(ProductController::class)
    ->group(function () {
        Route::get('/list', 'index')->name('list');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{product}', 'edit')->name('edit');
        Route::post('/', 'store')->name('store');
        Route::put('/{product}',  'update')->name('update');
        Route::delete('/{product}',  'destroy')->name('destroy');
    });

require __DIR__ . '/auth.php';
