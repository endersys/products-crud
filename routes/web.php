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

Route::get('/', [HomeController::class, 'index']);
Route::get('/{id}', [ProductController::class, 'show']);

//Admin
Route::prefix('admin/products')->name('admin.products.')->group(function() {
    Route::get('', [AdminProductController::class, 'index'])->name('index');
    Route::get('edit', [AdminProductController::class, 'edit'])->name('edit');
});
