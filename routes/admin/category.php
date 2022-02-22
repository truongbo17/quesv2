<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin/category')->group(function () {
    Route::get('/list', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.category.list');
    Route::get('/show/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'show'])->name('admin.category.show');
    Route::get('/add', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('admin.category.add');
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::get('/delete', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('admin.category.delete');
    Route::post('store', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.category.store');
    Route::patch('/update/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin.category.update');
});
