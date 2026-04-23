<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'admin' , 'middleware' => 'adminMiddleware'],function(){
    Route::get('dashboard',[AdminController::class, 'dashboard'])->name('admin#dashboard');

    Route::group(['prefix' => 'category'], function(){
        Route::get('/list', [CategoryController::class, 'list'])->name('category#list');
        Route::post('/create',[CategoryController::class, 'create'])->name('category#create');
        Route::get('/delete/{id}',[CategoryController::class, 'delete'])->name('category#delete');
        Route::get('/edit/{id}',[CategoryController::class, 'edit'])->name('category#edit');
        Route::post('/update/{id}',[CategoryController::class, 'update'])->name('category#update');
    });

    Route::group(['prefix' => 'product','middleware' => 'adminMiddleware'], function(){
        Route::get('createPage',[ProductController::class, 'createPage'])->name('product#createPage');
        Route::get('list/{action?}', [ProductController::class, 'list'])->name('product#list');
        Route::post('create',[ProductController::class, 'create'])->name('product#create');
        Route::get('/delete/{id}',[ProductController::class, 'delete'])->name('product#delete');
        Route::get('/edit/{id}',[ProductController::class, 'edit'])->name('product#edit');
        Route::post('update',[ProductController::class, 'update'])->name('product#update');
        Route::get('/details/{id}', [ProductController::class, 'details'])->name('product#details');
    });

    Route::group(['prefix' => 'profile'], function(){
        Route::get('change/password',[ProfileController::class, 'changePasswordPage'])->name('profile#changePasswordPage');
        Route::post('change/password', [ProfileController::class, 'changePassword'])->name('profile#changePassword');

        Route::get('/edit',[ProfileController::class, 'editProfile'])->name('profile#editProfile');
        Route::post('update',[ProfileController::class, 'updateProfile'])->name('profile#update');

    });

    Route::group(['middleware' => 'superAdminMiddleware'], function(){
        Route::prefix('payment')->group(function(){
            Route::get('/list',[PaymentController::class, 'list'])->name('payment#list');
            Route::post('/create', [PaymentController::class, 'create'])->name('payment#create');
            Route::get('/delete/{id}', [PaymentController::class, 'delete'])->name('payment#delete');
            Route::get('/edit/{id}', [PaymentController::class, 'edit'])->name('payment#edit');
            Route::post('update/{id}', [PaymentController::class, 'update'])->name('payment#update');

        });

        Route::group(['prefix' => 'account'], function(){
            Route::get('create/newAdmin', [AdminController::class, 'createAdminPage'])->name('account#createAdminPage');
            Route::get('admin/list', [AdminController::class, 'adminList'])->name('account#adminList');
            Route::get('user/list', [AdminController::class, 'userList'])->name('account#userList');
        });
    });



});
