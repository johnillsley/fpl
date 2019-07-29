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
}
