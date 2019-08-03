<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/lookup', 'Api\LookupController@request');
Route::post('/verification/start', 'Api\VerifyController@request');
Route::post('/verification/verify', 'Api\VerifyController@validateCode');
Route::post('/user/register', 'Api\RegisterController@request');
