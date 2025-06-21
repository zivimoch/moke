<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SSOController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/sso/callback', [SSOController::class, 'callback'])->name('sso.callback');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';
