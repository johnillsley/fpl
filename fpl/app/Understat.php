<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Player;

class Understat extends Model
{
    protected $table = "understats";
    protected $primaryKey = "id";
    public $incrementing = false;

    protected $fillable = [
            'id',
            'player_id',
            'player_name',
            'games',
            'time',
            'goals',
            'xg',
            'assists',
            'xa',
            'shots',
            'key_passes',
            'yellow_cards',
            'red_cards',
            'position',
            'team_title',
            'npg',
            'npxg',
            'xg_chain',
            'xg_buildup',
    ];

    public function player()
    {
        return $this->hasOne('App\Player', 'id', 'player_id');
    }

    public function setXgAttribute($value)
    {
        $this->attributes['xg'] = round($value, 3);
    }

    public function setXaAttribute($value)
    {
        $this->attributes['xa'] = round($value, 3);
    }

    public function setNpxgAttribute($value)
    {
        $this->attributes['npxg'] = round($value, 3);
    }

    public function setXgChainAttribute($value)
    {
        $this->attributes['xg_chain'] = round($value, 3);
    }

    public function setXgBuildupAttribute($value)
    {
        $this->attributes['xg_buildup'] = round($value, 3);
    }
}
