<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\TodoController;

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


//Todo
Route::get('todo' , [TodoController::class , 'index'])->name('todo');
Route::post('todo/store' , [TodoController::class , 'store'])->name('todo.store');
Route::get('todo/edit/{id}' , [TodoController::class , 'edit'])->name('todo.edit');
Route::post('todo/update/{id}' , [TodoController::class , 'update'])->name('todo.update');
Route::delete('todo/delete/{id}' , [TodoController::class , 'delete'])->name('todo.delete');
Route::post('task/completed/{id}' , [TodoController::class , 'TaskCompleted'])->name('TaskCompleted');
