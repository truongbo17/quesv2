<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin/')->group(function () {
    Route::get('home', function(){
        return view('admin.home.index');
    })->middleware(['auth', 'can:dashbroad_index'])->name('admin.home.index');
});
