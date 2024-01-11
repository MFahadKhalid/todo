<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\FrontendController;


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



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/' , [FrontendController::class , 'index'])->name('index');


Route::prefix('todo')->name('todo.')->controller(TodoController::class)->group(function(){
//Todo

Route::get('/fetch' ,  'fetch')->name('fetch');
Route::post('/store' ,  'store')->name('store');
Route::get('/edit/{id}' ,  'edit')->name('edit');
Route::get('/view/{id}' ,  'view')->name('view');
Route::post('/update/{id}' ,  'update')->name('update');
Route::delete('/delete/{id}' ,  'delete')->name('delete');
Route::post('/task/completed/{id}' ,  'TaskCompleted')->name('TaskCompleted');


});

