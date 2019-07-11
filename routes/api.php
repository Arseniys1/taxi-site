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

Route::post('/broadcasting/auth', function (Request $request) {
    return \Illuminate\Support\Facades\Broadcast::auth($request);
})
    ->middleware('api.auth');

Route::post('/registerByPhoneNumber', 'Api\RegisterByPhoneNumber@get')
    ->middleware('throttle:5,1');

Route::post('/checkSMSCode', 'Api\CheckSMSCode@get')
    ->middleware('throttle:5,1', 'api.auth');

Route::post('/resendActivationCode', 'Api\ResendActivationCode@get')
    ->middleware('throttle:5,1');

Route::post('/taxiOrder', 'Api\TaxiOrder@get')
    ->middleware('api.auth');

Route::post('/getTaxiOrder', 'Api\GetTaxiOrder@get')
    ->middleware('api.auth');

Route::post('/getUser', 'Api\GetUser@get')
    ->middleware('api.auth');

Route::post('/getDriverCreatedOrders', 'Api\GetDriverCreatedOrders@get')
    ->middleware('api.auth', 'permissions:driver,driver.getDriverCreatedOrders');

Route::post('/driverTakeOrder', 'Api\DriverTakeOrder@get')
    ->middleware('api.auth', 'permissions:driver,driver.driverTakeOrder');

Route::post('/driverOnline', 'Api\DriverOnline@get')
    ->middleware('api.auth', 'permissions:driver');

Route::post('/driverOffline', 'Api\DriverOffline@get')
    ->middleware('api.auth', 'permissions:driver');

Route::post('/driverSos', 'Api\DriverSos@get')
    ->middleware('api.auth', 'permissions:driver');

Route::post('/driverChatMessage', 'Api\DriverChatMessage@get')
    ->middleware('api.auth', 'permissions:driver,driver.driverChatMessage');

