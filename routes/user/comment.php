<?php

use Illuminate\Support\Facades\Route;

Route::prefix('user/comment')->middleware('auth')->group(function () {
    Route::post('/history', [\App\Http\Controllers\User\CommentQuestionController::class, 'historyComment'])->name('user.comment.history');
    Route::post('/send', [\App\Http\Controllers\User\CommentQuestionController::class, 'sendComment'])->name('user.comment.send');
});
