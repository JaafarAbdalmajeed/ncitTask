<?php

use App\Http\Controllers\student\StudentController;

Route::get('/user/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
Route::get('/students/{id}',[StudentController::class,'students']);
