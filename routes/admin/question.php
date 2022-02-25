<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin/question')->group(function () {
    Route::get('/list', [\App\Http\Controllers\Admin\QuestionController::class, 'index'])->middleware(['auth', 'can:list_question'])->name('admin.question.list');
    Route::get('/show/{id}', [\App\Http\Controllers\Admin\QuestionController::class, 'show'])->middleware(['auth', 'can:show_question'])->name('admin.question.show');
    Route::get('/add', [\App\Http\Controllers\Admin\QuestionController::class, 'create'])->middleware(['auth', 'can:add_question'])->name('admin.question.add');
    Route::get('/edit/{id}', [\App\Http\Controllers\Admin\QuestionController::class, 'edit'])->middleware(['auth', 'can:edit_question'])->name('admin.question.edit');
    Route::get('/delete', [\App\Http\Controllers\Admin\QuestionController::class, 'destroy'])->middleware(['auth', 'can:delete_question'])->name('admin.question.delete');
    Route::post('store', [\App\Http\Controllers\Admin\QuestionController::class, 'store'])->middleware(['auth', 'can:add_question'])->name('admin.question.store');
    Route::patch('/update/{id}', [\App\Http\Controllers\Admin\QuestionController::class, 'update'])->middleware(['auth', 'can:edit_question'])->name('admin.question.update');
});
