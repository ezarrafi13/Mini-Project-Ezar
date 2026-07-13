<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StuntingPredictionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;

        Route::get('/', [AuthController::class, 'index'])->name('login');

        Route::post('/login', [AuthController::class, 'login'])->name('login.post');
        Route::post('/register', [AuthController::class, 'register'])->name('register.post');


        Route::middleware('auth')->group(function () {
    

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::prefix('stunting')->name('stunting.')->group(function () {
        Route::get('/',           [StuntingPredictionController::class, 'index'])->name('index');
        Route::get('/create',     [StuntingPredictionController::class, 'create'])->name('create');
        Route::post('/',          [StuntingPredictionController::class, 'store'])->name('store');
        Route::get('/{stunting}', [StuntingPredictionController::class, 'show'])->name('show');
    });
   
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
});