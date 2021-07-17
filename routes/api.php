<?php

use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/chat/rooms', [ChatController::class, 'rooms'])->name('room.index');
    Route::get('/chat/room/{roomId}/messages', [ChatController::class, 'messages'])->name('message.index');
    Route::post('/chat/room/{roomId}/message', [ChatController::class, 'newMessage'])->name('message.create');
});
