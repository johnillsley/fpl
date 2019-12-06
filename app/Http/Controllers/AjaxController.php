<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Watchlist;

class AjaxController extends Controller
{
    public function watchlist($player) {
        
        $watchlist = Watchlist::firstOrCreate(['user_id' => 1, 'player_id' => $player]);
        if ($watchlist->wasRecentlyCreated) {
            $inwatchlist = 1;
        } else {
            $watchlist->delete();
            $inwatchlist = 0;
        }
        return json_encode(["player" => $player, "inwatchlist" => $inwatchlist]);
    }
}
