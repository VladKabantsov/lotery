<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'purse', 'amount', 'desc', 'disable_exchange', 'currency', 'user_id', 'status'
    ];

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
