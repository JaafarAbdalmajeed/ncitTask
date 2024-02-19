<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\chat\ChatController;

// Route::get('/chat', [ChatController::class, 'chat'])->middleware(['auth']);


// Route::post('pusher/send-message', 'pusherController@sendMessage')->name('pusher.sendmessage');
// Route::get('/chat/students/{subjectId}', [ChatController::class, 'chatStudents'])->middleware(['auth']);

// Route::get('/chat/messages/{user_id}', [ChatController::class, 'getChatData'])->middleware(['auth']);
// Route::post('/chat/{user_id}', [ChatController::class, 'sendMessage'])->middleware(['auth']);


Route::get('/chat', [ChatController::class, 'index']);
Route::get('/retrieve-messages/{recipient}', [MessageController::class, 'retrieveMessages']);

Route::post('/chat/{user_id}', [ChatController::class, 'sendMessage'])->middleware(['auth']);


