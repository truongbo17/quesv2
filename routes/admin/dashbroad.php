<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin/')->group(function () {
    Route::get('home', function(){
        return view('admin.home.index');
    })->name('admin.home.index');
});
