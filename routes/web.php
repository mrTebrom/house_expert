<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// Категорий
use App\Http\Controllers\CategoryController;
//

Route::get('/', function () {
    return view('welcome');
});
/*
|--------------------------------------------------------------------------
| Админ панель
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.categories.index'));
    Route::resource('categories', CategoryController::class);
});

/*
|--------------------------------------------------------------------------
| Апишка
|--------------------------------------------------------------------------
*/
Route::prefix('api')->as('webapi.')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
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
