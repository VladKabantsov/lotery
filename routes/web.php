<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login/vk', 'AuthController@vkAuth');
Route::get('login/ok', 'AuthController@okAuth');
Route::get('login/vk/user', 'AuthController@vkUser');
Route::get('login/ok/user', 'AuthController@okUser');

Route::get('payments/external/server', 'PaymentOrderController@paymentAlert');
Route::get('payments/external/success', 'PaymentOrderController@paymentSuccess');
Route::get('payments/external/fail', 'PaymentOrderController@paymentFail');

//Route::get('payments-form', 'PaymentOrderController@form');
//Route::get('payments-results', 'PaymentOrderController@paymentResult');
//Route::get('payments-status/{orderId}', 'PaymentOrderController@orderStatus');
//Route::get('payments-balance', 'PaymentOrderController@balance');
//Route::get('payments-payment', 'PaymentOrderController@payment');
//Route::get('payments-my-payment-form', 'PaymentOrderController@getForm');
//Route::get('test-log', 'PaymentOrderController@testLog');

//Route::get('applications', 'ApplicantController@index');
//Route::get('applications/{applicantId}', 'ApplicantController@accept');

//Route::get('get-payments', 'PaymentOrderController@getPaymentUrl');
//Route::get('get-payments-kiwi', 'PaymentOrderController@getPaymentKiwiWallet');

Route::get('/{any}', 'SpaController@index')->where('any', '.*')->name('base');
