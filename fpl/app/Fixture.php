<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Team;
use Carbon\Carbon;

class Fixture extends Model
{
    protected $table = "fixtures";
    protected $primaryKey = "id";
    public $incrementing = false;

    protected $fillable = [
            'id',
            'code',
            'event',
            'finished',
            'kickoff_time',
            'team_a',
            'team_a_score',
            'team_h',
            'team_h_score',
            'team_h_difficulty',
            'team_a_difficulty'
    ];

    public function away_team()
    {
        return $this->belongsTo('App\Team', 'team_a', 'id');
    }

    public function home_team()
    {
        return $this->belongsTo('App\Team', 'team_h', 'id');
    }

    public function week()
    {
        return $this->belongsTo('App\Week', 'event', 'id');
    }
    
    public function getFixtureTimeAttribute()
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->kickoff_time, 'UTC');
        $date->setTimezone('Europe/London');
        return $date->format('g:i a');
    }

    public function getFixtureDateAttribute()
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->kickoff_time, 'UTC');
        $date->setTimezone('Europe/London');
        return $date->format('l jS F Y');
    }
    
    public function setKickoffTimeAttribute($value)
    {
        $this->attributes['kickoff_time'] = date('Y-m-d H:i:s', strtotime($value));
    }
}
