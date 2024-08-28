<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ModelController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('auth.login');
});

// Dashboard Route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authentication Routes
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Product Routes
    Route::resource('products', ProductController::class);
    Route::get('/get-models/{carId}', [ProductController::class, 'getModels']);
    Route::get('/view', [ProductController::class, 'view'])->name('all.view');

    // Car Routes
    Route::prefix('cars')->name('car.')->group(function () {
        Route::get('/', [CarController::class, 'index'])->name('index');
        Route::post('/', [CarController::class, 'store'])->name('store');
        Route::get('/delete/{id}', [CarController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [CarController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [CarController::class, 'update'])->name('update');
    });

    // Model Routes
    Route::prefix('models')->name('model.')->group(function () {
        Route::get('/', [ModelController::class, 'index'])->name('index');
        Route::post('/', [ModelController::class, 'store'])->name('store');
        Route::get('/delete/{id}', [ModelController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [ModelController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ModelController::class, 'update'])->name('update');
    });

    // Additional Model Route
    Route::get('/get/models', [ModelController::class, 'getModelsByCar']);
});

require __DIR__.'/auth.php';

// Route::view('/view', 'product.products');