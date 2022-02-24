<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin/category')->group(function () {
    Route::get('/list', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->middleware(['auth', 'can:list_category'])->name('admin.category.list');
    Route::get('/show/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'show'])->middleware(['auth', 'can:show_category'])->name('admin.category.show');
    Route::get('/add', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->middleware(['auth', 'can:add_category'])->name('admin.category.add');
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->middleware(['auth', 'can:edit_category'])->name('admin.category.edit');
    Route::get('/delete', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->middleware(['auth', 'can:delete_category'])->name('admin.category.delete');
    Route::post('store', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->middleware(['auth', 'can:add_category'])->name('admin.category.store');
    Route::patch('/update/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->middleware(['auth', 'can:edit_category'])->name('admin.category.update');
});
