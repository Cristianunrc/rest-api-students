<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\StudentController;

Route::get('/students', [StudentController::class, 'index']);

Route::get('/students/{id}', function () {
    return 'Geting Student';
});

Route::post('/students', [StudentController::class, 'createStudent']);

Route::put('/students/{id}', function () {
    return 'Updating Student';
});

Route::delete('/students/{id}', function () {
    return 'Deleting Student';
});