<?php

use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\LoginController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\PermissionController;
use \App\Http\Controllers\ImportController;


Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'login'])->name('login');
    Route::post('/', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

Route::middleware('auth')->group(function (){
    //Users endpoints
    Route::prefix('users')->group(function (){
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/create', [UserController::class, 'store'])->name('users.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}/edit', [UserController::class, 'update'])->name('users.update');
    });

    //Permissions endpoints
    Route::prefix('permissions')->group(function (){
        Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('/create', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::post('/{permission}/edit', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    });

    //Imports
    Route::prefix('imports')->group(function (){
        Route::get('/{type}/{file}', [ImportController::class, 'index'])->name('imports.index');
        Route::post('/{type}/{file}', [ImportController::class, 'export'])->name('imports.export');
        Route::delete('/{type}/{file}/{id}', [ImportController::class, 'destroy'])->name('imports.destroy');
        Route::get('/{type}/{file}/{id}/audits', [ImportController::class, 'audits'])->name('imports.audits');
        Route::get('/upload', [ImportController::class, 'create'])->name('imports.create');
        Route::post('/upload', [ImportController::class, 'upload'])->name('imports.upload');
    });

    //Logs
    Route::prefix('logs')->group(function (){
        Route::get('/', [LogController::class, 'index'])->name('logs.index');
        Route::get('/{upload}', [LogController::class, 'show'])->name('logs.show');
    });
    //Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    //Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

});

