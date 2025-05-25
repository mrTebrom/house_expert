<?php

use Illuminate\Support\Facades\Route;

// Админ-панель
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\ProjectImageController as AdminProjectImageController;
use App\Http\Controllers\Api\DetailFieldController;
use App\Http\Controllers\Admin\DetailFieldPageController;

// Профиль
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Главная страница
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Панель управления (админка)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->as('admin.')->group(function () {

    Route::get('/', fn () => redirect()->route('admin.categories.index'));

    // Категории
    Route::resource('categories', CategoryController::class);

    // Слайдер
    Route::resource('sliders', SliderController::class);

    // Проекты
    Route::resource('projects', ProjectController::class);

    // Галерея изображений проектов
    Route::prefix('projects/{project}/images')->name('projects.images.')->group(function () {
        Route::get('/', [AdminProjectImageController::class, 'index'])->name('index');           // Страница управления
        Route::post('/', [AdminProjectImageController::class, 'store'])->name('store');           // Загрузка
        Route::post('/reorder', [AdminProjectImageController::class, 'reorder'])->name('reorder'); // Сортировка
        Route::post('{image}/main', [AdminProjectImageController::class, 'setMain'])->name('setMain'); // Установка главного
        Route::delete('{image}', [AdminProjectImageController::class, 'destroy'])->name('destroy');    // Удаление
    });
    Route::get('detail-fields', [DetailFieldPageController::class, 'index'])->name('detail_fields.index');
});

/*
|--------------------------------------------------------------------------
| Внутреннее API (AJAX-запросы в админке)
|--------------------------------------------------------------------------
*/
Route::prefix('api')->as('webapi.')->middleware(['auth'])->group(function () {
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');


    Route::prefix('detail-fields')->group(function () {
        Route::get('/', [DetailFieldController::class, 'index']);
        Route::post('/', [DetailFieldController::class, 'store']);
        Route::put('/{detailField}', [DetailFieldController::class, 'update']);
        Route::delete('/{detailField}', [DetailFieldController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Пользовательский профиль
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Аутентификация
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

// Маршруты для авторизации
Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');
Route::post('/register', [App\Http\Controllers\Auth\AuthController::class, 'register'])->name('register');
Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');
