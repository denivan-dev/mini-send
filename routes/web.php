<?php

use Illuminate\Support\Facades\Route;

Route::view('/{param}', 'home')->where('param', '.*');
