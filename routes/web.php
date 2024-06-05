<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


Route::get('/', [AuthController::class, 'index'])->middleware(RedirectIfAuthenticated::class)->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
});
