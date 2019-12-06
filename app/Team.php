<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = "teams";
    protected $primaryKey = "id";
    public $incrementing = false;

    protected $fillable = [
            'id',
            'code',
            'draw',
            'loss',
            'name',
            'played',
            'points',
            'position',
            'short_name',
            'strength',
            'win',
            'strength_overall_home',
            'strength_overall_away',
            'strength_attack_home',
            'strength_attack_away',
            'strength_defence_home',
            'strength_defence_away'
    ];

    public function away_fixtures()
    {
        return $this->hasMany('App\Fixture', 'team_a');
    }

    public function home_fixtures()
    {
        return $this->hasMany('App\Fixture', 'team_h');
    }

    public function away_results()
    {
        return $this->hasMany('App\Fixture', 'team_a')->where('fixtures.finished', '=', 1);
    }

    public function home_results()
    {
        return $this->hasMany('App\Fixture', 'team_h')->where('fixtures.finished', '=', 1);
    }
    
    public function players()
    {
        return $this->hasMany('App\Player', 'team');
    }

    public function colours()
    {
        return $this->belongsTo('App\TeamColour', 'code', 'code');
    }
}
