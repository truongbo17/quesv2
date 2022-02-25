<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin/tag')->group(function () {
    Route::get('/list', [\App\Http\Controllers\Admin\TagController::class, 'index'])->middleware(['auth', 'can:list_tag'])->name('admin.tag.list');
    Route::get('/add', [\App\Http\Controllers\Admin\TagController::class, 'create'])->middleware(['auth', 'can:add_tag'])->name('admin.tag.add');
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\TagController::class, 'edit'])->middleware(['auth', 'can:edit_tag'])->name('admin.tag.edit');
    Route::get('/delete', [\App\Http\Controllers\Admin\TagController::class, 'destroy'])->middleware(['auth', 'can:delete_tag'])->name('admin.tag.delete');
    Route::post('store', [\App\Http\Controllers\Admin\TagController::class, 'store'])->middleware(['auth', 'can:add_tag'])->name('admin.tag.store');
    Route::patch('/update/{id}', [\App\Http\Controllers\Admin\TagController::class, 'update'])->middleware(['auth', 'can:edit_tag'])->name('admin.tag.update');
});
