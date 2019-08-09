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
}
