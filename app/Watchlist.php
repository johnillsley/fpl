<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    protected $table = "watchlists";

    protected $fillable = [
            'id',
            'player_id',
            'user_id',
    ];

    public function player()
    {
        return $this->hasOne('App\Player', 'id', 'player_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
