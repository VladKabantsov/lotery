<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name', 'max_bet', 'min_bet'
    ];

    public function user()
    {

        return $this->belongsTo('App\User', 'id');
    }

    public function currentGameBets()
    {

        return $this->hasMany('App\CurrentGame');
    }
}
