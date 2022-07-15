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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'auth:web'], function () {

    Route::post('/storeTodo', [App\Http\Controllers\TodoController::class, 'store'])->name('storeTodo');
    Route::get('/remove/{todo?}',[App\Http\Controllers\TodoController::class, 'destroy'])->name('todo-remove');
    Route::get('/update/{todo?}',[App\Http\Controllers\TodoController::class, 'update'])->name('todo-update');

    Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');

});