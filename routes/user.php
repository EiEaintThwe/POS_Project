<?php


use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;



Route::group( [ 'prefix' => 'user', 'middleware' => 'userMiddleware' ] , function(){

    Route::get('home', [UserController::class, 'home'])->name('user#homepage');
    Route::get('product/details/{id}',[UserController::class, 'productDetails'])->name('user#productDetails');

    Route::post('comment',[UserController::class, 'comment'])->name('user#comment');
    Route::get('comment/delete/{id}',[UserController::class, 'commentDelete'])->name('user#commentDelete');

    Route::post('rating',[UserController::class, 'rating'])->name('user#rating');

    Route::get('/cart',[UserController::class, 'cart'])->name('user#cart');
    Route::post('/addToCart',[UserController::class, 'addToCart'])->name('user#addToCart');
    Route::get('cartDelete',[UserController::class, 'cartDelete'])->name('user#cartDelete');

    Route::get('tempStorage',[UserController::class, 'tempStorage'])->name('user#tempStorage');

    Route::get('paymentPage',[UserController::class, 'paymentPage'])->name('user#paymentPage');

    Route::post('/order',[UserController::class, 'order'])->name('user#order');
    Route::get('/orderList',[UserController::class, 'orderList'])->name('user#orderList');

    Route::get('contact',[UserController::class, 'contactPage'])->name('user#contactPage');
    Route::post('/contact/create',[UserController::class, 'contactCreate'])->name('user#contactCreate');

    Route::get('profile/edit', [ProfileController::class, 'editProfile'])->name('user#editProfile');
    Route::post('/profile/update',[ProfileController::class, 'updateProfile'])->name('user#updateProfile');

    Route::get('/change/password',[ProfileController::class, 'changePasswordPage'])->name('user#changePasswordPage');
    Route::post('change/password',[ProfileController::class, 'changePassword'])->name('user#changePassword');



});
