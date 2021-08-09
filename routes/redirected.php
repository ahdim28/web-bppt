<?php

use Illuminate\Support\Facades\Route;

Route::get('/backend', function () {
    return redirect('/backend/authentication');
});

Route::get('/'.config('custom.language.default'), function () {
    return redirect()->route('home');
});