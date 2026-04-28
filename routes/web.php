<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\StockController as AdminStockController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
Route::get('/productos/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/facturas/{order}/pdf', [InvoiceController::class, 'download'])->name('invoices.download');

Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
Route::get('/carrito/resumen', [CartController::class, 'summary'])->name('cart.summary');
Route::post('/carrito/agregar', [CartController::class, 'add'])->name('cart.add');
Route::patch('/carrito/actualizar', [CartController::class, 'update'])->name('cart.update');
Route::delete('/carrito/eliminar/{productId}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/exito/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
	Route::resource('productos', AdminProductController::class)
		->except(['show']);

	Route::get('stock', [AdminStockController::class, 'index'])->name('stock.index');
	Route::post('stock', [AdminStockController::class, 'store'])->name('stock.store');
	Route::post('stock/ajustar', [AdminStockController::class, 'adjust'])->name('stock.adjust');
	Route::get('stock/movimientos', [AdminStockController::class, 'movements'])->name('stock.movements');
});
