<?php

use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
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

Route::get('/', [HomeController::class, 'index'])->name('site.index');

Route::prefix('products')->name('products.')->group(function() {
    Route::get('{product:slug}', [ProductController::class, 'show'])->name('show');
});

//Admin
Route::prefix('admin/products')->name('admin.products.')->group(function() {
    Route::get('', [AdminProductController::class, 'index'])->name('index');
    Route::post('', [AdminProductController::class, 'store'])->name('store');
    Route::get('{product:slug}/edit', [AdminProductController::class, 'edit'])->name('edit');
    Route::get('/create', [AdminProductController::class, 'create'])->name('create');
    Route::patch('', [AdminProductController::class, 'update'])->name('update');
    Route::delete('', [AdminProductController::class, 'destroy'])->name('destroy');
});
