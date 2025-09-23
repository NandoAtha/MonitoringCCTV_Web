<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [App\Http\Controllers\dashboardController::class, 'index'])->name('cctv.index')->middleware('auth');
Route::get('/playBack', [dashboardController::class, 'playback'])->name('playback');
Route::get('/settings', [dashboardController::class, 'settings'])->name('settings');
Route::get('/logs', [dashboardController::class, 'logs'])->name('logs');
Route::get('/users', [dashboardController::class, 'users'])->name('users');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::post('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
});