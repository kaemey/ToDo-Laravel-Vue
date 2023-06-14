<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Todo\IndexController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(["prefix" => "todo"], function () {
    Route::post('/store', [IndexController::class, 'store']);
    Route::post('/{todo}', [IndexController::class, 'update']);
    Route::get('/', [IndexController::class, 'index'])->middleware("auth")->name("todo.index");
    Route::get('/edit', [IndexController::class, 'edit'])->middleware("auth");
    Route::get('/search/{todo}', [IndexController::class, 'edit'])->middleware("auth");
    Route::get('/send', [IndexController::class, 'send'])->middleware("auth")->name("todo.send");
});