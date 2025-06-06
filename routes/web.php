<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResepController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Untuk yang login saja
Route::middleware(['auth'])->group(function () {
    Route::get('/reseps/create', [ResepController::class, 'create'])->name('reseps.create');
    Route::post('/reseps', [ResepController::class, 'store'])->name('reseps.store');
    Route::get('/reseps/{resep}/edit', [ResepController::class, 'edit'])->name('reseps.edit');
    Route::put('/reseps/{resep}', [ResepController::class, 'update'])->name('reseps.update');
    Route::delete('/reseps/{resep}', [ResepController::class, 'destroy'])->name('reseps.destroy');
});

Route::get('/reseps', [ResepController::class, 'index'])->name('reseps.index');
Route::get('/reseps/{resep}', [ResepController::class, 'show'])->name('reseps.show');


require __DIR__.'/auth.php';
