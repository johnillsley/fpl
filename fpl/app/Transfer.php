<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $table = "transfers";

    protected $fillable = [
            'id',
            'player_id',
            'player_code',
            'now_cost',
            'selected_by_percent',
            'status',
            'transfers_in',
            'transfers_in_event',
            'transfers_out',
            'transfers_out_event'
    ];

    public function player()
    {
        return $this->belongsTo('App\Player');
    }
    
    public function getNowCostAttribute($value)
    {
        $value = number_format($value / 10, 1);
        return $value;
    }
}
