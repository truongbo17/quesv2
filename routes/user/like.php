<?php

use Illuminate\Support\Facades\Route;

Route::prefix('user/like')->group(function () {
    Route::get('/history', [\App\Http\Controllers\User\LikeQuestionController::class, 'historyLike'])->name('user.like.history');
    Route::post('/send', [\App\Http\Controllers\User\LikeQuestionController::class, 'like'])->name('user.like.send');
});
