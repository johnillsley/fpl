<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Team;

class Player extends Model
{
    protected $table = "players";
    protected $primaryKey = "id";
    public $incrementing = false;

    protected $fillable = [
            'id',
            'code',
            'element_type',
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

    public function getTeamShortNameAttribute()
    {
        return Team::find($this->team)->short_name;
    }
    
    public function getPositionAttribute()
    {
        switch ($this->element_type) {
            case 1: $position = 'Goalkeeper'; break;
            case 2: $position = 'Defender'; break;
            case 3: $position = 'Midfielder'; break;
            case 4: $position = 'Forward'; break;
        }
        return $position;
    }

    public function getPointsPer90MinutesAttribute()
    {
        if ($this->minutes > 0) {
            $points = ($this->total_points / $this->minutes) * 90;
        } else {
            $points = 0;
        }
        return number_format($points, 1);
    }
    
    public function getNowCostAttribute($value)
    {
        $value = number_format($value / 10, 1);
        return $value;
    }
}

