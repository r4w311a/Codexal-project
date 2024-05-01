<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'admin.dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::get('/categories', function () {
        return view('admin.categories.index');
    })->middleware(['auth'])->name('manage-categories');
    Route::get('/products', function () {
        return view('admin.products.index');
    })->middleware(['auth'])->name('manage-products');

    
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
