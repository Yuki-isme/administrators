<?php

use App\Http\Controllers\AdminAuthController;
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

Route::get('/', function () {
    return view('admin.layout.layout');
});

Route::get('admin/login', [AdminAuthController::class, 'viewlogin'])->name('admin.login');

Route::post('admin/auth', [AdminAuthController::class, 'login'])->name('admin.auth');