<?php

use Illuminate\Support\Facades\Route;

Route::get('/backend', function () {
    return redirect('/backend/authentication');
});

Route::get('/id', function () {
    return redirect()->route('home');
});