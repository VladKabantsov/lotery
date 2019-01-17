<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = [
        'access_token', 'expires_in'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
