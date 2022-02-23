<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin/tag')->group(function () {
    Route::get('/list', [\App\Http\Controllers\Admin\TagController::class, 'index'])->name('admin.tag.list');
    Route::get('/add', [\App\Http\Controllers\Admin\TagController::class, 'create'])->name('admin.tag.add');
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\TagController::class, 'edit'])->name('admin.tag.edit');
    Route::get('/delete', [\App\Http\Controllers\Admin\TagController::class, 'destroy'])->name('admin.tag.delete');
    Route::post('store', [\App\Http\Controllers\Admin\TagController::class, 'store'])->name('admin.tag.store');
    Route::patch('/update/{id}', [\App\Http\Controllers\Admin\TagController::class, 'update'])->name('admin.tag.update');
});
