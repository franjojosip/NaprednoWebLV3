<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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


Route::prefix('projects')->group(function () {
    Route::get('/', [App\Http\Controllers\ProjectController::class, 'index'])->name('projects');

    Route::get('/add',  [App\Http\Controllers\ProjectController::class, 'add']);
    Route::post('/insert', [App\Http\Controllers\ProjectController::class, 'create']);
    Route::get('/delete/{id}', [App\Http\Controllers\ProjectController::class, 'delete']);

    Route::get('/update/{id}', [App\Http\Controllers\ProjectController::class, 'update']);
    Route::put('/edit/{id}', [App\Http\Controllers\ProjectController::class, 'edit']);
});
