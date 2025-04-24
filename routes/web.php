<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return view('dashboard.welcome');
});

Auth::routes();

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/category', [CategoryController::class, 'index'])->name('category');
Route::get('/category/add', [CategoryController::class, 'add']);
Route::post('/category/create', [CategoryController::class, 'create']);
Route::get('/category/{id}/detail', [CategoryController::class, 'show'])->name('category-detail');
Route::get('/category/{id}/edit', [CategoryController::class, 'edit']);
Route::patch('/category/{id}/update', [CategoryController::class, 'update']);
Route::get('/category/{id}/delete', [CategoryController::class, 'delete']);
Route::delete('/category/{id}/destroy', [CategoryController::class, 'destroy']);

Route::get('/item', [ItemController::class, 'index'])->name('item');
Route::get('/item/add', [ItemController::class, 'add']);
Route::post('/item/create', [ItemController::class, 'create']);
Route::get('/item/{id}/detail', [ItemController::class, 'show'])->name('item-detail');
Route::get('/item/{id}/edit', [ItemController::class, 'edit']);
Route::patch('/item/{id}/update', [ItemController::class, 'update']);
Route::get('/item/{id}/delete', [ItemController::class, 'delete']);
Route::delete('/item/{id}/destroy', [ItemController::class, 'destroy']);

Route::get('/transaction', [TransactionController::class, 'indexCart'])->name('cart');
Route::patch('/transaction/{cart_item}', [TransactionController::class, 'updateQuantity']);
Route::delete('/transaction/{cart_item}', [TransactionController::class, 'destroy']);
Route::post('/transaction/add', [TransactionController::class, 'add']);
Route::get('/transaction/checkout', [TransactionController::class, 'index']);
Route::post('/transaction/checkout', [TransactionController::class, 'store'])->name('checkout.store');

Route::get('/history', [HistoryController::class, 'history'])->name('transaction.history');
Route::get('/history/{id}', [HistoryController::class, 'show'])->name('transaction.show');