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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/login', 'AuthenticationController@login');

Route::group(['middleware' => 'auth:api'], function () {

    Route::post('/logout', 'AuthenticationController@logout');

    Route::get('/technicians', 'TechnicianController@getActive');

    Route::get('/technician-sales', 'TechnicianSaleController@get');
    Route::post('/technician-sales', 'TechnicianSaleController@add');
    Route::put('/technician-sales', 'TechnicianSaleController@update');
    Route::delete('/technician-sales/{saleID}', 'TechnicianSaleController@delete');

    Route::get('/square-receipts', 'SquareReceiptController@getDailySquareReceipt');

    Route::put('/square-receipt-items', 'SquareReceiptController@redeemGiftCard');

    Route::get('/account-types', 'AccountTypeController@get');
    Route::get('/accounts', 'AccountController@get');

    Route::post('/accounts', 'AccountController@add');

    // Testing Square API
    Route::get('/test-square-receipts', 'SquareClientController@get');

});
