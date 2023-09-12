<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;

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
    return view('admin.order.index');
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
    Route::get('myAccount', [HomeController::class, 'myAccount'])->name('myAccount');
    Route::get('wishlist', [HomeController::class, 'wishlist'])->name('wishlist');
});

Route::get('/',[HomeController::class, 'index'])->name('index');
Route::get('/product/{id}',[HomeController::class, 'productDetail'])->name('productDetail');
Route::get('/list',[HomeController::class, 'list'])->name('list');
Route::get('/listbycategory/{id}',[HomeController::class, 'listByCategory'])->name('listByCategory');
Route::get('/listbybrand/{id}',[HomeController::class, 'listByBrand'])->name('listByBrand');
Route::post('/listbycategorybrand',[HomeController::class, 'listByCategoryBrand'])->name('listByCategoryBrand');
Route::get('/library', [HomeController::class, 'library'])->name('library');

Route::post('/addToCart/{id}',[CartController::class, 'add'])->name('addToCart');
Route::put('/updateAmount/{id}',[CartController::class, 'updateAmount'])->name('updateAmount');
Route::delete('/deleteItem/{id}',[CartController::class, 'deleteItem'])->name('deleteItem');
Route::get('/cart',[CartController::class, 'index'])->name('cart');

Route::get('/order', [CheckoutController::class, 'order'])->name('order');
Route::get('/districts', [CheckoutController::class, 'getDistricts'])->name('getDistricts');
Route::get('/wards', [CheckoutController::class, 'getWards'])->name('getWards');
Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/payment', [CheckoutController::class, 'payment'])->name('payment');
Route::get('/success', [CheckoutController::class, 'success'])->name('success');
Route::get('/failed', [CheckoutController::class, 'failed'])->name('failed');

Route::get('/vnpay',[PaymentController::class, 'vnPay'])->name('vnPay');
Route::get('/vnpay_return',[PaymentController::class, 'vnPayReturn'])->name('vnPayReturn');
