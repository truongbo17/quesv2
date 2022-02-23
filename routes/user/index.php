<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('index.html', [\App\Http\Controllers\User\IndexController::class, 'index'])->middleware('auth')->name('user.index');
Route::post('addquestion', [\App\Http\Controllers\User\IndexController::class, 'store'])->middleware('auth')->name('user.store');
