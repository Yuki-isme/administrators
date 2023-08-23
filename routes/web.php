<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

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

Route::get('login', [UserAuthController::class, 'viewlogin'])->name('login');
Route::post('auth', [UserAuthController::class, 'login'])->name('auth');
Route::get('logout', [UserAuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth:web'], function () {
    Route::get('myAccount', [UserAuthController::class, 'myAccount'])->name('myAccount');
});

Route::get('/',[HomeController::class, 'index'])->name('index');
Route::get('/product/{id}',[HomeController::class, 'productDetail'])->name('productDetail');
Route::get('/list',[HomeController::class, 'productList'])->name('productList');
Route::get('/grid',[HomeController::class, 'productGrid'])->name('productGrid');
Route::get('/library', [HomeController::class, 'library'])->name('library');

Route::get('/addToCart/{id}',[CartController::class, 'add'])->name('addToCart');
Route::get('/deleteItem/{id}',[CartController::class, 'deleteItem'])->name('deleteItem');
Route::get('/cart',[CartController::class, 'index'])->name('cart');
Route::get('/order', [CheckoutController::class, 'order'])->name('order');
Route::get('/payment', [CheckoutController::class, 'payment'])->name('payment');

