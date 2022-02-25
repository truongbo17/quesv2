<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin/user')->group(function () {
    Route::get('/list', [\App\Http\Controllers\Admin\UserController::class, 'index'])->middleware(['auth', 'can:list_user'])->name('admin.user.list');
    Route::get('/add', [\App\Http\Controllers\Admin\UserController::class, 'create'])->middleware(['auth', 'can:add_user'])->name('admin.user.add');
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->middleware(['auth', 'can:add_user'])->name('admin.user.edit');
    Route::get('/delete', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->middleware(['auth', 'can:edit_user'])->name('admin.user.delete');
    Route::post('store', [\App\Http\Controllers\Admin\UserController::class, 'store'])->middleware(['auth', 'can:edit_user'])->name('admin.user.store');
    Route::patch('/update/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->middleware(['auth', 'can:delete_user'])->name('admin.user.update');
});
