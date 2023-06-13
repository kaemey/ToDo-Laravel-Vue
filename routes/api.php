<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Todo\IndexController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(["prefix" => "todo"], function () {
    Route::get('/get', [IndexController::class, 'get']);
    Route::delete('/{todo}', [IndexController::class, 'delete']);
    Route::delete('/image/{todo}', [IndexController::class, 'deleteImage']);
    Route::post('/send', [IndexController::class, 'sendTodo']);
});