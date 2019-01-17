<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrentGame extends Model
{
    protected $fillable = [
        'bet', 'room_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function room()
    {

        return $this->belongsTo('App\Room');
    }

}
