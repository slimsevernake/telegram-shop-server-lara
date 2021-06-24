<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(
  [
      'as' => 'bot.',
      'prefix' => 'bot',
  ],
    function () {
      Route::put('greeting', 'BotController@updateGreeting')->name('greeting.update');
      Route::get('info', 'BotController@getInfo')->name('info');
    }
);

Route::group(
    [
        'prefix' => 'auth',
        'as' => 'auth.',
    ],
    function () {
        Route::group(
            ['middleware' =>'auth:api'],
            function () {
                Route::get('me', 'AuthController@me');
                Route::post('refresh', 'AuthController@refresh');
                Route::post('logout', 'AuthController@logout');
            }
        );

        Route::group(
            [
                'middleware' => 'guest',
            ],
            function () {
                Route::post('signup', 'AuthController@signup');
                Route::post('login', 'AuthController@login');
            }
        );
    }
);

