<?php

namespace App\Http\Controllers;
use App\PaymentOrder;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class PaymentBase
{
    const BASE_URL = 'http://www.free-kassa.ru/api.php';
    const CASH_URL = 'http://www.free-kassa.ru/merchant/cash.php';

    protected $kiwiToken = 'b1d8e13eed017893eb8b64d84d918263';
    protected $client, $config;

    public function __construct()
    {
        $this->client = new Client();
        $this->config = Config::get('freekassa');
    }

    public function makeSign()
    {
        return md5($this->config['merchant_id'].$this->config['secret2']);
    }

    public function customizePaymentForm($order_amount, $currency, $user_id)
    {
        $order_id = $order_amount.$currency.$user_id;
        $sign = md5($this->config['merchant_id'] . ':' .$order_amount. ':' . $this->config[ 'secret' ] . ':'.$order_id);

        return 'm='.$this->config['merchant_id'].'&oa='.$order_amount.'&o='.$order_id.'&s='.$sign.'&i='.$currency.'&us_user_id='.$user_id;
    }

    public function checkOrder(Request $request)
    {
        $data = $request->all();

        $sign = md5($this->config['merchant_id'] . ':' . $data['AMOUNT'] . ':' . $this->config['secret'] . ':' . $data['MERCHANT_ORDER_ID']);

        if ($sign != $data['SIGN']) {
            return new \Exception('Wrong sign!');
        }
    }

    public function getPayment($data, $user)
    {
        $sign = md5($this->config['wallet_id'].$data['currency'].$data['amount'].$data['purse'].$this->config['api_key']);
        $params = 'wallet_id='.$this->config['wallet_id'].'&purse='.$data['purse'].'&amount='.$data['amount'].'&desc='.'&currency='.$data['currency'].'&sign='.$sign.'&action=cashout';
        DB::transaction( function () use ($data, $user, $params) {
            $user->balance()
                ->first()
                ->decrement('amount', (int)$data['amount'] * 100);
        });
//        $client = new Client();
//        $res = $client->request('POST', 'https://www.fkwallet.ru/api_v1.php', [
//            'wallet_id' => $this->config['wallet_id'],
//            'purse' => $data['purse'],
//            'amount' => $data['amount'],
//            'desc' => '',
//            'disable_exchange' => '0',
//            'currency' => $data['currency'],
//            'sign' => $sign,
//            'action' => 'cashout',
//        ]);

        return [
            'purse' => $data['purse'],
            'amount' => $data['amount'],
            'desc' => '',
            'disable_exchange' => '0',
            'currency' => $data['currency'],
            'user_id' => $user->id
        ];
    }

    public function getPaymentKiwiBank($bankId, $data)
    {
        $client = new Client();

        $requestData = '{
        "id":"' . 1000 * time() . '",
        "sum":{
          "amount":' . $data['amount'] . ',
          "currency":"643"
        },
        "paymentMethod":{
          "type":"Account",
          "accountId":"643"
        },
        "fields": {
          "account": "' . $data['account'] . '",
          "rec_address": "Rublik",
          "rec_city": "Москва",
          "rec_country": "Россия",
          "reg_name": "Rublik",
          "reg_name_f": "Money",
          "rem_name": "Rublik",
          "rem_name_f": "Money"
        }
      }';

        $response = $client->request('POST', $this->getKiwiUrl($bankId), [
            'headers' => [
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->kiwiToken,
            ],
            'body' => $requestData,
        ]);

        return $response;
    }

    protected function getKiwiUrl($bankId = 21013)
    {
        return 'https://edge.qiwi.com/sinap/api/v2/terms/'.$bankId.'/payments';
    }

    public function getPaymentKiwiWallet($data)
    {
        $client = new Client();

        $requestData = '{
        "id":"' . 1000 * time() . '",
        "sum": {
          "amount":' . $data['amount'] . ',
          "currency":"643"
        },
        "paymentMethod": {
          "type":"Account",
          "accountId":"643"
        },
        "comment":"Вывод средств с Rublik",
        "fields": {
          "account":"' . $data['account'] . '"
        }
      }';

        $response = $client->request('POST', 'https://edge.qiwi.com/sinap/api/v2/terms/99/payments', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->kiwiToken,
            ],
            'body' => $requestData,
        ]);

        return $response;
    }
}