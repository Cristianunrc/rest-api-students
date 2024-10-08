<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\StudentController;

Route::get('/students', [StudentController::class, 'getStudents']);

Route::get('/students/{id}', [StudentController::class, 'getStudent']);

Route::post('/students', [StudentController::class, 'createStudent']);

Route::put('/students/{id}', [StudentController::class, 'updateStudent']);

Route::patch('/students/{id}', [StudentController::class, 'updatePartial']);

Route::delete('/students/{id}', [StudentController::class, 'deleteStudent']);