<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin/user')->group(function () {
    Route::get('/list', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.user.list');
    Route::get('/add', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.user.add');
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.user.edit');
    Route::get('/delete', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.user.delete');
    Route::post('store', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.user.store');
    Route::patch('/update/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.user.update');
});
