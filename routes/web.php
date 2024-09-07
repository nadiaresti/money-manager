<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\AccountGroupController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
// 	return view('welcome');
// });

Route::group(['middleware' => ['guest']], function() {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
	Route::post('/register', [AuthController::class, 'store'])->name('post-register');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/', [SiteController::class, 'index']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/change-password', [SiteController::class, 'changePassword'])->name('password.change');
    Route::post('/change-password', [SiteController::class, 'updatePassword'])->name('password.update');

    // Route::resource('period', PeriodController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('account-group', AccountGroupController::class);
    Route::resource('account', AccountController::class);
});

