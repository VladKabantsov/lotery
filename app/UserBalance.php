<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBalance extends Model
{
    protected $fillable = [
        'amount'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
