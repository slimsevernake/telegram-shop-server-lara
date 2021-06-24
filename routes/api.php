<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'App\Modules\Public\Http\Controllers'
], base_path('Modules/Public/Routes/api.php'));

Route::group([
    'as' => 'admin.',
    'prefix' => 'admin',
    'namespace' => 'App\Modules\Admin\Http\Controllers'
], base_path('Modules/Admin/Routes/api.php'));

Route::group([
    'as' => 'bot.',
    'prefix' => 'bot',
    'namespace' => 'App\Modules\Bot\Http\Controllers'
], base_path('Modules/Bot/Routes/api.php'));
