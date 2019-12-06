<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Watchlist;

class ShowWatchlist extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $watchlist = Watchlist::where('user_id', 1)->get();
        $players = array();
        foreach ($watchlist as $watch) {
            $players[] = $watch->player;
        }
        return view('player.players', ['players' => $players]);
    }
}
