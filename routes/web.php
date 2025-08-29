<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/test', function () {
    return view('test');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Route::get('/', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [DashboardController::class, 'users'])->name('users.index');
});
