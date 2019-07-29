<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    protected $table = "weeks";
    protected $primaryKey = "id";
    public $incrementing = false;

    protected $fillable = [
            'id',
            'name',
            'average_entry_score',
            'finished',
            'data_checked',
            'highest_scoring_entry',
            'deadline_time_epoch',
            'deadline_time_game_offset',
            'highest_score',
            'is_previous',
            'is_current',
            'is_next'
    ];
}
