<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController as UserCatalogController;
use App\Http\Controllers\PostController as UserPostController;
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
    });

    Route::middleware('auth:sanctum')->group(function() {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        Route::apiResource('catalogs', CatalogController::class);

        Route::apiResource('posts', PostController::class);
    
        Route::apiResource('users', UserController::class);
    });

});

Route::prefix('home')->name('home.')->group(function() {
    Route::prefix('catalog')->name('catalog.')->group(function() {
        Route::get('/index', [UserCatalogController::class, 'index'])->name('index');
    });

    Route::prefix('post')->name('post.')->group(function() {
        Route::get('/index', [UserPostController::class, 'index'])->name('index');
        Route::get('/getPostByCatalog/{id}', [UserPostController::class, 'getPostByCatalog'])->name('getPostByCatalog');
        Route::get('/show/{id}', [UserPostController::class, 'show'])->name('show');
    });
});