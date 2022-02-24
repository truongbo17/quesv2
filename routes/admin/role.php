<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin/role')->group(function () {
    Route::get('/list', [\App\Http\Controllers\Admin\RoleController::class, 'index'])->name('admin.role.list');
    Route::get('/add', [\App\Http\Controllers\Admin\RoleController::class, 'create'])->name('admin.role.add');
    Route::post('store', [\App\Http\Controllers\Admin\RoleController::class, 'store'])->name('admin.role.store');
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('admin.role.edit');
    Route::patch('/update/{id}', [\App\Http\Controllers\Admin\RoleController::class, 'update'])->name('admin.role.update');
    Route::get('/delete', [\App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('admin.role.delete');
});
