<?php

use Illuminate\http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route ::get('/', function () {
    return view('welcome');
});


Route::prefix('/blog')->name('blog.')->controller(\App\Http\Controllers\BlogController::class)->group(function () {
    Route::get('/',[\App\Http\Controllers\BlogController::class, 'index'])->name('index');
    Route::get('/new',[\App\Http\Controllers\BlogController::class,'create'])->name('create');
    Route::post('/new',[\App\Http\Controllers\BlogController::class,'store']);
    Route::get('/{post}/edit', [\App\Http\Controllers\BlogController::class,'edit'])->name('edit');
    Route::patch('/{post}/edit', [\App\Http\Controllers\BlogController::class,'update']);

    Route::get('/{slug}-{post}',[\App\Http\Controllers\BlogController::class, 'show'])->where([
        'post'=>'[0-9]+',
        'slug'=>'[a-z0-9\-]+'
    ])->name('show');


});











