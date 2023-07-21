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
    //category
    Route::get('/', [CategoryController::class, 'index'])->name('index');

    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::post('/', [CategoryController::class, 'store'])->name('store');

    Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CategoryController::class, 'update'])->name('update');

    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');

    //sub
    Route::get('/sub', [CategoryController::class, 'subIndex'])->name('sub_index');

    Route::get('/sub/create', [CategoryController::class, 'subCreate'])->name('sub_create');
    Route::post('/sub', [CategoryController::class, 'subStore'])->name('sub_store');

    Route::get('/sub/{id}/edit', [CategoryController::class, 'subEdit'])->name('sub_edit');
    Route::put('/sub/{id}', [CategoryController::class, 'subUpdate'])->name('sub_update');

    Route::delete('/sub/{id}', [CategoryController::class, 'subDestroy'])->name('sub_destroy');
    //
});


