<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Roles\RolesController;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/',[AuthController::class, 'index'])->name('auth.index');
Route::post('signin',[AuthController::class, 'signIn'])->name('signIn');
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::prefix('users')->group(function () {
    Route::get('index', [UsersController::class, 'index'])->name('users.index');
    Route::get('list', [UsersController::class, 'list'])->name('users.list');
    Route::get('create', [UsersController::class, 'create'])->name('users.create');
    Route::post('store', [UsersController::class, 'store'])->name('users.store');
    Route::get('edit/{user}', [UsersController::class, 'edit'])->name('users.edit');
    Route::post('users/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::get('destroy/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
});

Route::prefix('roles')->group(function () {
    Route::get('/', [RolesController::class, 'index'])->name('roles.index');
    Route::get('list', [RolesController::class, 'list'])->name('roles.list');
    Route::get('edit/{id}', [RolesController::class, 'edit'])->name('roles.edit');
    Route::put('update/{id}', [RolesController::class, 'update'])->name('roles.update');
});
