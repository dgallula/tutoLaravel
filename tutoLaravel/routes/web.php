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


Route::prefix('/blog')->name('blog.')->group(function () {
    Route::get('/',[\App\Http\Controllers\BlogController::class, 'index'])->name('index');


    Route::get('/{slug}-{id}',[\App\Http\Controllers\BlogController::class, 'show'])->where([
        'id'=>'[0-9]+',
        'slug'=>'[a-z0-9\-]+'
    ])->name('show');


});










