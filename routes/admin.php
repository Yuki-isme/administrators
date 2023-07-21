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

    Route::get('/', [CategoryController::class, 'index'])->name('index');


    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::post('/', [CategoryController::class, 'store'])->name('store');

    Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CategoryController::class, 'update'])->name('update');

    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');

    Route::get('/child', [CategoryController::class, 'getChildCategories'])->name('child_index');

    Route::get('/child/create', [CategoryController::class, 'childCreate'])->name('child_create');
    Route::post('/child/store', [CategoryController::class, 'childStore'])->name('child_store');
});


