<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\CategoryController;

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

// 1. ルートパス（/）にアクセスしたら Todo一覧を表示（未ログインならログイン画面へ）
Route::middleware(['auth'])->group(function () {

    Route::get('/', [TodoController::class, 'index'])->name('todos.index');

    // 2. Todo関連（/todos という共通パスでまとめる）
    Route::prefix('todos')->name('todos.')->group(function () {
        Route::post('/', [TodoController::class, 'store'])->name('store');
        Route::patch('/update', [TodoController::class, 'update'])->name('update');
        Route::delete('/delete', [TodoController::class, 'destroy'])->name('destroy');
        Route::get('/search', [TodoController::class, 'search'])->name('search');
    });

    // 3. カテゴリ関連（/categories という共通パスでまとめる）
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::patch('/update', [CategoryController::class, 'update'])->name('update');
        Route::delete('/delete', [CategoryController::class, 'destroy'])->name('destroy');
    });
});
