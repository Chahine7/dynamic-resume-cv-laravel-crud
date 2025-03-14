<?php

use App\Http\Controllers\Userprofile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialLoginController;

// Social Authentication Routes
Route::get('/auth/{provider}', [SocialLoginController::class, 'redirect'])->name('social.login');
Route::get('/auth/{provider}/callback', [SocialLoginController::class, 'callback']);



Route::middleware(['auth'])->group(function () {
    Route::get('/', [Userprofile::class, 'index'])->name('index');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::get('/user/{id}', [Userprofile::class, 'view'])->name('user.profile.view')
    ->middleware('authorize.access');
    Route::middleware(['no_resume'])->get('/create', [Userprofile::class, 'create'])->name('user.profile.create');
    Route::post('/store', [Userprofile::class, 'store'])->name('store');
    Route::get('/edit/{id}', [Userprofile::class, 'edit'])
    ->name('edit')
    ->middleware('authorize.access');    
    Route::post('/update', [Userprofile::class, 'update'])->name('update');
    Route::post('/destroy/{id}', [Userprofile::class, 'destroy'])->name('destroy')
    ->middleware('authorize.access');
});

require __DIR__.'/auth.php';
