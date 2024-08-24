<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ModelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::resource('products', ProductController::class);
Route::get('/get-models/{carId}', [ProductController::class, 'getModels']);

//Car Routes
Route::get('/cars', [CarController::class, 'index'])->name('car.create');
Route::post('/cars', [CarController::class, 'store'])->name('car.store');
Route::get('/cars/delete/{id}', [CarController::class, 'delete'])->name('car.delete');
Route::get('/cars/edit/{id}', [CarController::class, 'edit'])->name('car.edit');
Route::post('/cars/update/{id}', [CarController::class, 'update'])->name('car.update');

//Model Routes
Route::get('/models', [ModelController::class, 'index'])->name('model.index');
Route::post('/models', [ModelController::class, 'store'])->name('model.store');
Route::get('/model/delete/{id}', [ModelController::class, 'delete'])->name('model.delete');
Route::get('/model/edit/{id}', [ModelController::class, 'edit'])->name('model.edit');
Route::post('/model/update/{id}', [ModelController::class, 'update'])->name('model.update');
Route::get('/get/models', [ModelController::class, 'getModelsByCar']);
