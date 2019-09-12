<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Player;

class ShowPosition extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($position)
    {
        $players = Player::where('element_type', $position)
                ->orderBy('total_points', 'DESC')
                ->orderBy('second_name', 'ASC')
                ->orderBy('first_name', 'ASC')
                ->get();

        return view('player.players', ['players' => $players]);
    }
}
