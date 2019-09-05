<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    protected $table = "performances";

    protected $fillable = [
            'player_id',
            'week',
            'minutes',
            'goals_scored',
            'assists',
            'clean_sheets',
            'goals_conceded',
            'own_goals',
            'penalties_saved',
            'penalties_missed',
            'yellow_cards',
            'red_cards',
            'saves',
            'bonus',
            'bps',
            'influence',
            'creativity',
            'threat',
            'ict_index',
            'total_points',
            'in_dreamteam'
    ];

    public function player()
    {
        return $this->hasOne('App\Player', 'id', 'player_id');
    }

    public function week()
    {
        return $this->hasOne('App\Week', 'id', 'week');
    }
}
