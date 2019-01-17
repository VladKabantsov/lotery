<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const casinoPercent = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'screen_name',
        'photo',
        'vk_id',
        'ok_id',
        'referral_reference',
        'room_id',
        'big_photo'
    ];

    public function token()
    {

        return $this->hasOne('App\Token');
    }

    public function referralUsers()
    {

        return $this->hasMany('App\User');
    }

    public function completedRounds()
    {

        return $this->hasMany('App\CompletedRound');
    }

    public function balance()
    {

        return $this->hasOne('App\UserBalance');
    }

    public function bet()
    {
        return $this->hasOne('App\CurrentGame');
    }

    public function room()
    {

        return $this->hasOne('App\Room');
    }

    public function orders()
    {
        return $this->belongsTo('App\PaymentOrder');
    }

    public function applications()
    {
        return $this->belongsTo('App\Application');
    }
}
