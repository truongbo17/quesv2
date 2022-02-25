<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin/permission')->group(function () {
    Route::get('/list', [\App\Http\Controllers\Admin\PermissionController::class, 'index'])->middleware(['auth', 'can:list_permission'])->name('admin.permission.list');
    Route::get('/add', [\App\Http\Controllers\Admin\PermissionController::class, 'create'])->middleware(['auth', 'can:add_permission'])->name('admin.permission.add');
    Route::post('store', [\App\Http\Controllers\Admin\PermissionController::class, 'store'])->middleware(['auth', 'can:add_permission'])->name('admin.permission.store');
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\PermissionController::class, 'edit'])->middleware(['auth', 'can:edit_permission'])->name('admin.permission.edit');
    Route::patch('/update/{id}', [\App\Http\Controllers\Admin\PermissionController::class, 'update'])->middleware(['auth', 'can:edit_permission'])->name('admin.permission.update');
    Route::get('/delete', [\App\Http\Controllers\Admin\PermissionController::class, 'destroy'])->middleware(['auth', 'can:delete_permission'])->name('admin.permission.delete');
});
