<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\NotificationController;
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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/', [TodoController::class, 'index'])->name('todos.index');
    Route::resource('todos', TodoController::class);
    
    Route::post('/notification/subscribe', [NotificationController::class, 'subscribe'])
        ->name('notification.subscribe');
    Route::post('/notification/unsubscribe', [NotificationController::class, 'unsubscribe'])
        ->name('notification.unsubscribe');
});