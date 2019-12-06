<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamColour extends Model
{
    protected $table = "team_colours";
    protected $primaryKey = "code";
    public $incrementing = false;

    protected $fillable = [
            'code',
            'colour1',
            'colour2',
    ];
}
