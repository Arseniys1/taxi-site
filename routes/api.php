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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/registerByPhoneNumber', 'Api\RegisterByPhoneNumber@get')
    ->middleware('throttle:5,1');

Route::get('/checkSMSCode', 'Api\CheckSMSCode@get')
    ->middleware('throttle:5,1', 'api.auth');

Route::get('/resendActivationCode', 'Api\ResendActivationCode@get')
    ->middleware('throttle:5,1');

Route::post('/taxiOrder', 'Api\TaxiOrder@get')
    ->middleware('api.auth');

Route::post('/getTaxiOrder', 'Api\GetTaxiOrder@get')
    ->middleware('api.auth');

Route::get('/', function () {
    return '';
})
    ->middleware('api.auth', 'permissions:driver');

