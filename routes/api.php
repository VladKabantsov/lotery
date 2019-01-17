<?php

use App\Events\MakeBet;
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

Route::middleware(['social.auth'])->group(function () {

    /**
     * get info about current user
     */
    Route::get('user', 'UserController@index');

    /**
     * get referrals users
     */
    Route::get('referral-users', 'UserController@getReferrals');

    /**
     * get won rounds
     */
    Route::get('wins', 'UserController@getWins');

    /**
     * get sorted finished rounds for particular room, sort by id,win,chance,bet also you should set params page and perPage for paginate
     */
    Route::get('completed-rounds', 'CompletedRoundController@index');

    /**
     * make bet for current user
     */
    Route::post('set-bet', 'CurrentGameController@store');

    /**
     * get all bets with users for room where id = $roomId
     */
    Route::get('current-game/{roomId}', 'CurrentGameController@index');

    Route::post('top-up-the-balance-kiwi', 'PaymentOrderController@getPaymentKiwiWallet');
    Route::post('top-up-the-balance-bank', 'PaymentOrderController@getPaymentKiwiBank');

    Route::post('top-up-the-balance', 'PaymentOrderController@generatePaymentUrl');

    Route::post('get-payment', 'PaymentOrderController@getPaymentUrl');
});

Route::get('payment/balance', 'PaymentOrderController@balance');
Route::get('payment/order-status/{orderId}', 'PaymentOrderController@orderStatus');
Route::get('payment/pay', 'PaymentOrderController@payment');
