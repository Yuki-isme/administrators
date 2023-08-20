<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;

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

Route::get('/aa', function () {
    return view('frontend.checkout.cart');
});


Route::group(['prefix' => 'admin'], function () {

    Route::get('login', [AdminAuthController::class, 'viewlogin'])->name('admin.login');
    Route::post('auth', [AdminAuthController::class, 'login'])->name('admin.auth');
    Route::get('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

Route::get('/',[HomeController::class, 'index'])->name('frontend.index');
Route::get('/product/{id}',[HomeController::class, 'productDetail'])->name('frontend.productDetail');

Route::get('/addtocart/{id}',[CartController::class, 'add'])->name('addtocart');
Route::get('/cart',[CartController::class, 'index'])->name('cart.index');