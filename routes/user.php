<?php


use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;



Route::group( [ 'prefix' => 'user', 'middleware' => 'userMiddleware' ] , function(){
    Route::get('home',function(){
        return view('user.home');
    })->name('user#homepage');

    Route::get('home', [UserController::class, 'home'])->name('user#homepage');

    Route::get('profile/edit', [ProfileController::class, 'editProfile'])->name('user#editProfile');
    Route::post('/profile/update',[ProfileController::class, 'updateProfile'])->name('user#updateProfile');

    Route::get('/change/password',[ProfileController::class, 'changePasswordPage'])->name('user#changePasswordPage');
    Route::post('change/password',[ProfileController::class, 'changePassword'])->name('user#changePassword');

});
