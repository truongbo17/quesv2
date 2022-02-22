<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin/question')->group(function () {
    Route::get('/list', [\App\Http\Controllers\Admin\QuestionController::class, 'index'])->name('admin.question.list');
    Route::get('/show/{id}', [\App\Http\Controllers\Admin\QuestionController::class, 'show'])->name('admin.question.show');
    Route::get('/add', [\App\Http\Controllers\Admin\QuestionController::class, 'create'])->name('admin.question.add');
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\QuestionController::class, 'edit'])->name('admin.question.edit');
    Route::get('/delete', [\App\Http\Controllers\Admin\QuestionController::class, 'destroy'])->name('admin.question.delete');
    Route::post('store', [\App\Http\Controllers\Admin\QuestionController::class, 'store'])->name('admin.question.store');
    Route::patch('/update/{id}', [\App\Http\Controllers\Admin\QuestionController::class, 'update'])->name('admin.question.update');
});
