<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table = "players";
    protected $primaryKey = "id";
    public $incrementing = false;

    protected $fillable = [
            'id',
            'code',
            'ep_next',
            'ep_this',
            'event_points',
            'first_name',
            'form',
            'now_cost',
            'points_per_game',
            'second_name',
            'selected_by_percent',
            'status',
            'team',
            'team_code',
            'total_points',
            'transfers_in',
            'transfers_in_event',
            'transfers_out',
            'transfers_out_event',
            'value_form',
            'value_season',
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
            'ict_index'
    ];
    
}

