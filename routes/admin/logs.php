
<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin/logs')->group(function () {
    Route::get('index', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->middleware(['auth', 'can:log_index'])->name('admin.log.index');
});
