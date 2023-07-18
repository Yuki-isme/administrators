<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\CategoryController;

Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
    // Điều hướng tới phương thức 'index' trong 'CategoryController'
    Route::get('/', [CategoryController::class, 'index'])->name('index');

    // Điều hướng tới phương thức 'create' trong 'CategoryController'
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::post('/store', [CategoryController::class, 'store'])->name('store');

    Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [CategoryController::class, 'update'])->name('update');

    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
});


