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

Route::middleware(['authy_api'])->group(function () {
    Route::post('/lookup', 'Api\LookupController@request');

    Route::post('/verification/start', 'Api\VerifyController@request');
    Route::post('/verification/verify', 'Api\VerifyController@validateCode');
    Route::post('/user/register', 'Api\RegisterController@request');

    Route::post('/authy/sms', 'Api\AuthyController@sms');
    Route::post('/authy/voice', 'Api\AuthyController@voice');
    Route::post('/authy/onetouch', 'Api\AuthyController@createOneTouch');
    Route::post('/authy/onetouchstatus', 'Api\AuthyController@verifyOneTouch');
    Route::post('/authy/verify', 'Api\AuthyController@verifyToken');

    Route::post('/login', 'Api\LoginController@request');
    Route::get('/logout', 'Api\LogoutController@request');
});
