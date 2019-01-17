<?php

namespace App\Http\Controllers;

use App\Application;
use App\PaymentOrder;
use App\User;
use Carbon\Carbon;
use Gr8devofficial\LaravelFreecassa\Merchant;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use PHPUnit\Exception;
use SimpleXMLElement;

class PaymentOrderController extends Controller
{

    public function balance()
    {
        return (new Merchant)->getBalance();
    }

    public function orderStatus($orderId)
    {
        return (new Merchant)->checkOrderStatus($orderId);
    }

    public function payment(Request $request)
    {
        $data = $request->all();
        $data['currency'] = isset($data['currency']) ? $data['currency'] : 'fkw';
        $data['amount'] = isset($data['amount']) ? $data['amount'] : 0;
        $result = (new Merchant)->payment($data['currency'], $data['amount']);

        return $result;
    }



    public function paymentAlert(Request $request)
    {
        $data = $request->all();
        $arr = '';

        foreach ($data as $key => $value) {
            $arr .= $key . ' = ' . $value . "  \r\n\ ";
        }
        $this->writeLogs('ALERT ' . $arr);
        try {
            (new PaymentBase)->checkOrder($request);
            PaymentOrder::create([
                'MERCHANT_ID' => $data['MERCHANT_ID'] ? $data['MERCHANT_ID'] : null,
                'AMOUNT' => $data['AMOUNT'] ? $data['AMOUNT'] : null,
                'intid' => $data['intid'] ? $data['intid'] : null,
                'P_EMAIL' => $data['P_EMAIL'] ? $data['P_EMAIL'] : null,
                'CUR_ID' => $data['CUR_ID'] ? $data['CUR_ID'] : null,
                'SIGN' => $data['SIGN'] ? $data['SIGN'] : null,
                'user_id' => $data['us_user_id']
            ]);
        } catch (\Exception $exception) {
            return;
        }
    }

    public function paymentSuccess(Request $request)
    {
        $data = $request->all();
        $this->writeLogs('SUCCESS ' . implode($data));

        try {
            $order = PaymentOrder::where('intid', $data['intid'])->first();
            $order->success = true;
            $order->save();
            $user = User::where('id', $order['user_id'])->first();
            DB::transaction(function() use ($user, $order) {
                $user->balance()
                    ->first()
                    ->increment('amount', (int)$order['AMOUNT'] * 100);
            });
            return redirect('/cabinet');
        } catch (\Exception $exception) {
            return;
        }
    }

    public function paymentFail(Request $request)
    {
        $data = $request->all();
        dump('FAIL', $data);
        $this->writeLogs('FAIL ' . implode($data));
        try {
            (new PaymentBase)->checkOrder($request);
            $order = PaymentOrder::where('SIGN', $data['SIGN'])->first();
            $order->success = false;
            $order->save();
        } catch (\Exception $exception) {
            return;
        }
    }

    public function form()
    {
        return view('form');
    }

    public function paymentResult()
    {
        dump(PaymentOrder::all());
    }

    public function getForm()
    {
        return (new PaymentBase)->customizePaymentForm(1001);
    }

    public function testLog()
    {
        $this->writeLogs('TEST');
    }

    public function writeLogs($data)
    {
        $file = 'logs.txt';
        $current = file_get_contents($file);
        $current .= "\r\n" . 'TIME = ' . Carbon::now() . ' DATA = ' . $data . "\r\n";
        file_put_contents($file, $current);
    }

    public function generatePaymentUrl(Request $request)
    {
        $data = $request->only(['order_amount', 'currency']);
        $user = $request->get('user');

        return (new PaymentBase)->customizePaymentForm($data['order_amount'], $data['currency'], $user->id);
    }

    public function getPaymentKiwiBank(Request $request)
    {
        $data = $request->all();
        $user = $request->get('user');
        $balance = $user->balance()->first();

        if ($data['amount'] < ($balance->amount / 100)) {
            $resp = (new PaymentBase)->getPaymentKiwiBank($data[ 'bank_id' ], $data);

            if ($resp->getStatusCode() == 200) {
                return response($this->decrementUserBalance($user, $data[ 'amount' ]), 200);
            } else {
                return response($resp->getBody(), 400);
            }
        } else {
            return response('You don`t have enough money!!',400);
        }
    }

    public function getPaymentKiwiWallet(Request $request)
    {
        $data = $request->all();
        $user = $request->get('user');
        $balance = $user->balance()->first();

        if ($data['amount'] < ($balance->amount / 100)) {
            $resp = (new PaymentBase)->getPaymentKiwiWallet($data);

            if ($resp->getStatusCode() == 200) {
                return response($this->decrementUserBalance($user, $data['amount']), 200);
            } else {
                return response($resp->getBody(), 400);
            }
        } else {
            return response('You don`t have enough money!!',400);
        }
    }

    protected function decrementUserBalance(User $user, $amount = 0)
    {
        return DB::transaction( function() use ($user, $amount) {
            $user->balance()
                ->first()
                ->decrement('amount', $amount * 100);

            return 'success';
        });
    }
}
