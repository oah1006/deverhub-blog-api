<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CatalogController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('admin')->name('admin.')->group(function() {
    Route::prefix('auth')->name('auth.')->group(function() {
        Route::post('/register', [RegisterController::class, 'register'])->name('register');
        Route::post('/login', [LoginController::class, 'login'])->name('login');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    });

    Route::prefix('catalog')->name('catalog.')->group(function() {
        Route::get('/search', [CatalogController::class, 'index'])->name('search');
        Route::post('/store', [CatalogController::class, 'store'])->name('store');
        Route::get('/show/{id}', [CatalogController::class, 'show'])->name('show');
        Route::post('/update/{id}', [CatalogController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [CatalogController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('post')->name('post.')->group(function() {
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/show/{id}', [PostController::class, 'show'])->name('show');
        Route::post('/update/{id}', [PostController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [PostController::class, 'destroy'])->name('destroy');
        Route::get('/search', [PostController::class, 'index'])->name('search');
    }); 

    Route::prefix('user')->name('user.')->group(function() {
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/show/{id}', [UserController::class, 'show'])->name('show');
    });
});