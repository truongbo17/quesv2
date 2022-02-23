
<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin/file-manager')->group(function () {
    Route::get('/', function () {
        return view('admin.files.index');
    })->name('admin.file.index');
});
