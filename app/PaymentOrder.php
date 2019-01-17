<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentOrder extends Model
{
    protected $fillable = [
        'MERCHANT_ID', 'AMOUNT', 'intid', 'MERCHANT_ORDER_ID', 'P_EMAIL', 'CUR_ID', 'SIGN', 'success', 'user_id'
    ];

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
