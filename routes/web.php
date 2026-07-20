<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Note: after installing Breeze + Inertia, auth routes will be available.
