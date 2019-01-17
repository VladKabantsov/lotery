<?php

    return [

        /*
         |--------------------------------------------------------------------------
         | Merchant params
         |--------------------------------------------------------------------------
         |
         |
         */

        'merchant_id' => env('FREEKASSA_MERCHANT_ID', '107399'),
        'secret' => env('FREEKASSA_SECRET_1', 'bstnos7k'),
        'secret2' => env('FREEKASSA_SECRET_2', '728lae2k'),

        /*
         |--------------------------------------------------------------------------
         | Wallet params
         |--------------------------------------------------------------------------
         |
         |
         */

        'wallet_id' => env('FREEKASSA_WALLET_ID', 'F105208494'),
        'api_key' => env('FREEKASSA_WALLET_API_KEY', '8F1A7C258815AD07AF52D69601B9D016'),

        'default_lang' => 'ru',
        'default_currency' => '133',
        'cashout_currencies' =>[
            'FK_WALLET_RUB' => '133',
            'QIWI' => '63',
            'QIWI_EURO' => '161',
            'QIWI_USD' => '123',
            'YANDEX_MONEY' => '45',
            'QIWI_KZT' => '162',
            'VISA_MASTERCARD_RUB' => '94',
            'OOOPAY_RUR' => '106',
            'OOOPAY_USD' => '87',
            'OOOPAY_EUR' => '109',
            'WEBMONEY_WMR' => '1',
            'WEBMONEY_WMZ' => '2',
            'PAYEER_RUB' => '114',
            'PERFECT_MONEY_USD' => '64',
            'PERFECT_MONEY_EUR' => '69',
            'MEGAFON_MOBILE' => '82',
            'MTS_MOBILE' => '84',
            'TELE2_MOBILE' => '132',
            'BEELINE_MOBILE' => '83',
            'VISA_MASTERCARD_INT' => '158',
            'VISA_UAH_CASHOUT' => '157',
            'PAYPAL' => '70',
            'ADVCASH_USD' => '136',
            'ADVCASH_RUB' =>  '150'
        ],
        'cashout_currencies_comission' =>[
            'FK_WALLET_RUB' => 0,
            'QIWI' => 4,
            'QIWI_EURO' => 6,
            'QIWI_USD' => 6,
            'YANDEX_MONEY' => 0,
            'QIWI_KZT' => 6,
            'VISA_MASTERCARD_RUB' => 4,
            'OOOPAY_RUR' => 1,
            'OOOPAY_USD' => 1,
            'OOOPAY_EUR' => 1,
            'WEBMONEY_WMR' => 6,
            'WEBMONEY_WMZ' => 8.5,
            'PAYEER_RUB' => 4.5,
            'PERFECT_MONEY_USD' => 7,
            'PERFECT_MONEY_EUR' => 6.5,
            'MEGAFON_MOBILE' => 1,
            'MTS_MOBILE' => 1,
            'TELE2_MOBILE' => 1,
            'BEELINE_MOBILE' => 1,
            'VISA_MASTERCARD_INT' => 3,
            'VISA_UAH_CASHOUT' => 5,
            'PAYPAL' => 3.5,
            'ADVCASH_USD' => 8,
            'ADVCASH_RUB' =>  3
        ],
        'include_comission' => true,
        'crypto_currencies' => [
            'btc',
            'ltc',
            'eth'
        ],

        /*
         |--------------------------------------------------------------------------
         |
         |--------------------------------------------------------------------------
         | Список IP адресов с которых приходит колбек
         |
         */

        'ip_list' => [
            '136.243.38.147',
            '136.243.38.149',
            '136.243.38.150',
            '136.243.38.151',
            '136.243.38.189',
            '88.198.88.98'
        ],

    ];
