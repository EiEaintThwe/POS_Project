<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::group( [ 'prefix' => 'user', 'middleware' => 'userMiddleware' ] , function(){
    Route::get('home',function(){
        return view('user.home');
    })->name('user#homepage');

});
