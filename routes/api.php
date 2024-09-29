<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/students', function () {
    return 'Students List';
});

Route::get('/students/{id}', function () {
    return 'Geting Student';
});

Route::post('/students', function () {
    return 'Creating Student';
});

Route::put('/students/{id}', function () {
    return 'Updating Student';
});

Route::delete('/students/{id}', function () {
    return 'Deleting Student';
});