<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin/role')->group(function () {
    Route::get('/list', [\App\Http\Controllers\Admin\RoleController::class, 'index'])->middleware(['auth', 'can:list_role'])->name('admin.role.list');
    Route::get('/add', [\App\Http\Controllers\Admin\RoleController::class, 'create'])->middleware(['auth', 'can:add_role'])->name('admin.role.add');
    Route::post('store', [\App\Http\Controllers\Admin\RoleController::class, 'store'])->middleware(['auth', 'can:add_role'])->name('admin.role.store');
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\RoleController::class, 'edit'])->middleware(['auth', 'can:edit_role'])->name('admin.role.edit');
    Route::patch('/update/{id}', [\App\Http\Controllers\Admin\RoleController::class, 'update'])->middleware(['auth', 'can:edit_role'])->name('admin.role.update');
    Route::get('/delete', [\App\Http\Controllers\Admin\RoleController::class, 'destroy'])->middleware(['auth', 'can:delete_role'])->name('admin.role.delete');
});
