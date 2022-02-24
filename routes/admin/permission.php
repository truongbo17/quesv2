<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin/permission')->group(function () {
    Route::get('/list', [\App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('admin.permission.list');
    Route::get('/add', [\App\Http\Controllers\Admin\PermissionController::class, 'create'])->name('admin.permission.add');
    Route::post('store', [\App\Http\Controllers\Admin\PermissionController::class, 'store'])->name('admin.permission.store');
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\PermissionController::class, 'edit'])->name('admin.permission.edit');
    Route::patch('/update/{id}', [\App\Http\Controllers\Admin\PermissionController::class, 'update'])->name('admin.permission.update');
    Route::get('/delete', [\App\Http\Controllers\Admin\PermissionController::class, 'destroy'])->name('admin.permission.delete');
});
