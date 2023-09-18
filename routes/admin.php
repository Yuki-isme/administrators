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
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

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

    Route::get('/children', [CategoryController::class, 'getChildrenByParent_id'])->name('get-children');
    Route::get('/parent',  [CategoryController::class, 'getParentByChildren_id'])->name('get-parent');

});

Route::group(['prefix' => 'brands', 'as' => 'brands.'], function () {

    Route::get('/', [BrandController::class, 'index'])->name('index');

    Route::get('/create', [BrandController::class, 'create'])->name('create');
    Route::post('/', [BrandController::class, 'store'])->name('store');

    Route::get('/{id}/edit', [BrandController::class, 'edit'])->name('edit');
    Route::put('/{id}', [BrandController::class, 'update'])->name('update');

    Route::delete('/{id}', [BrandController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'products', 'as' => 'products.'], function () {

    Route::get('/', [ProductController::class, 'index'])->name('index');

    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->name('store');

    Route::get('/{id}', [ProductController::class, 'show'])->name('show');

    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProductController::class, 'update'])->name('update');

    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');

});

Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {

    Route::get('/getProducts', [OrderController::class, 'getProducts'])->name('getProducts');
    Route::get('/getProductInfo', [OrderController::class, 'getProductInfo'])->name('getProductInfo');

    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/completed', [OrderController::class, 'completed'])->name('completed');
    Route::get('/processing', [OrderController::class, 'processing'])->name('processing');
    Route::get('/requestCancel', [OrderController::class, 'requestCancel'])->name('requestCancel');
    Route::get('/canceled', [OrderController::class, 'canceled'])->name('canceled');

    Route::put('/status', [OrderController::class, 'status'])->name('status');

    Route::get('/create', [OrderController::class, 'create'])->name('create');
    Route::post('/', [OrderController::class, 'store'])->name('store');

    Route::get('/{id}', [OrderController::class, 'show'])->name('show');

    Route::get('/{id}/edit', [OrderController::class, 'edit'])->name('edit');
    Route::put('/{id}', [OrderController::class, 'update'])->name('update');

    Route::put('/{id}/cancel', [OrderController::class, 'cancel'])->name('cancel');
    Route::put('/{id}/notCancel', [OrderController::class, 'notCancel'])->name('notCancel');
    Route::get('/{id}/initialization', [OrderController::class, 'initialization'])->name('initialization');
});

Route::group(['prefix' => 'tags', 'as' => 'tags.'], function () {

    Route::get('/getTags', [TagController::class, 'getTags'])->name('getTags');

    Route::get('/', [TagController::class, 'index'])->name('index');

    Route::get('/create', [TagController::class, 'create'])->name('create');
    Route::post('/', [TagController::class, 'store'])->name('store');

    Route::get('/{id}/edit', [TagController::class, 'edit'])->name('edit');
    Route::put('/{id}', [TagController::class, 'update'])->name('update');

    Route::delete('/{id}', [TagController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'permissions', 'as' => 'permissions.'], function () {

    Route::get('/', [PermissionController::class, 'index'])->name('index');

    Route::get('/create', [PermissionController::class, 'create'])->name('create');
    Route::post('/', [PermissionController::class, 'store'])->name('store');

    // Route::get('/{id}', [PermissionController::class, 'show'])->name('show');

    // Route::get('/{id}/edit', [PermissionController::class, 'edit'])->name('edit');
    // Route::put('/{id}', [PermissionController::class, 'update'])->name('update');

    // Route::delete('/{id}', [PermissionController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {

    Route::get('/', [RoleController::class, 'index'])->name('index');

    Route::get('/create', [RoleController::class, 'create'])->name('create');
    Route::post('/', [RoleController::class, 'store'])->name('store');

    Route::get('/{id}', [RoleController::class, 'show'])->name('show');

    Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('edit');
    Route::put('/{id}', [RoleController::class, 'update'])->name('update');

    Route::delete('/{id}', [RoleController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'admins', 'as' => 'admins.'], function () {

    Route::get('/', [AdminController::class, 'index'])->name('index');

    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::post('/', [AdminController::class, 'store'])->name('store');

    Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AdminController::class, 'update'])->name('update');

    Route::delete('/{id}', [AdminController::class, 'destroy'])->name('destroy');

    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
});

Route::group(['prefix' => 'users', 'as' => 'users.'], function () {

    Route::get('/', [UserController::class, 'index'])->name('index');

    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');

    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('update');

    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
});

Route::get('/dashboard', function () {
    return view('admin.layout.dashboard');
})->name('admin.dashboard');


