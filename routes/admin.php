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
    // Thêm các route khác liên quan tới quản lý danh mục ở đây
});

