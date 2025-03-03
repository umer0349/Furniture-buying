<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//  defult routes with auth package
Route::get('/dashboard', function () {
    return view('Admin_dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';

//  ...............admincontroller  routes
Route::middleware(['role:admin'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin', 'admin')->name('adminside');
        Route::get('/product/create', 'create')->name('product.create');
        Route::post('/product/create', 'store')->name('product.store');
        Route::get('/product/edit/{id}', 'editproduct')->name('product.edit');
        Route::post('/product/update/{id}', 'updateproduct')->name('product.update');
        Route::get('/product/delete/{id}', 'deleteproduct')->name('product.delete');
        Route::get('/order/show', 'showorders')->name('orders.show');
        Route::get('/order/detail/{id}', 'orderdetail')->name('orderdtail.show');
        Route::get('/order/delete/soft/{id}', 'deleteorder')->name('order.delete');
        Route::get('/order/restore/{id}', 'restoreorders')->name('order.restore');
        Route::get('/order/delete/{id}', 'headdelete')->name('order.heard_deleted');
        Route::get('/user/show', 'showusers')->name('user.show');
        Route::get('/user/delete/{id}', 'deleteusers')->name('user.delete');
    });
});
//  ...............usercontroller  routes

Route::controller(UserController::class)->group(function () {
    Route::get('/', 'user')->name('userside')->middleware('restrict_admin');
    Route::middleware(['role:user'])->group(function () {
        Route::post('/addtocart', 'addToCart')->name('add.cart');
        Route::get('/show-cart', 'ShowCart')->name('show.cart');
        Route::get('/delete-cart/{id}', 'deleteCart')->name('delete.cart');
    });
    //  ...............paymentcontroller  routes
    Route::controller(PaymentController::class)->group(function () {
        Route::post('/checkout', 'checkout')->name('checkout');
        Route::get('/payment/success', 'success')->name('payment.success');
        Route::get('/payment/cancel', 'cancel')->name('payment.cancel');
    });
});
Route::get('/notification/markasread', function () {
    auth()->user()->unreadNotifications->markAsRead();

    return back();
})->name('read.notify');
