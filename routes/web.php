<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('home');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/transaction', [TransactionController::class, 'index'])
    ->name('transaction.index');


// daftar order
Route::get('/order', [OrderController::class, 'index'])->name('order.index');

// simpan order baru
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

// print HTML (untuk preview di browser)
Route::get('/order/print/{order}', [OrderController::class, 'print'])
    ->name('order.print');

// generate PDF (DomPDF)
Route::get('/order/{order}/pdf', [OrderController::class, 'pdf'])
    ->name('order.pdf');

Route::get('/invoice/{id}', [OrderController::class, 'invoice'])->name('order.invoice');

Route::resource('category', CategoryController::class);

Route::resource('products', ProductController::class);

// Category CRUD
Route::resource('/category', CategoryController::class);

// Order page
Route::get('/order', [OrderController::class, 'index'])->name('order.index');


