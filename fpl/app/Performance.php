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
        return $this->belongsTo('App\Player');
    }

    public function week()
    {
        return $this->belongsTo('App\Week', 'id', 'week');
    }
}
