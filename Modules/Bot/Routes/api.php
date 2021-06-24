<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('handle', 'BotController@handle')->name('handle');
