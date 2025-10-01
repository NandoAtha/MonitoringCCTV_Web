<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('landing'); 
});

Route::middleware('guest')->group(function () {
    // Rute Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [App\Http\Controllers\dashboardController::class, 'index'])->name('cctv.index')->middleware('auth');
    Route::get('/playback', [dashboardController::class, 'playback'])->name('playback');
    Route::get('/settings', [dashboardController::class, 'settings'])->name('settings');
    Route::get('/logs', [dashboardController::class, 'logs'])->name('logs');

    Route::get('/users', [dashboardController::class, 'users'])->name('users');
    Route::post('/roles', [dashboardController::class, 'store'])->name('roles.store');
    Route::post('/roles/{id}', [dashboardController::class, 'update'])->name('roles.update');

    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::post('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');

    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
    // Alias for compatibility with 'cctv.accounts' route name
    Route::get('/accounts', [AccountController::class, 'index'])->name('cctv.accounts');
    Route::post('/accounts/store', [AccountController::class, 'store'])->name('accounts.store');
    Route::post('/accounts/update', [AccountController::class, 'update'])->name('accounts.update');
    Route::delete('/accounts/{id}', [AccountController::class, 'destroy'])->name('accounts.destroy');



});