<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fixture;
use App\Player;

class ShowTeam extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($team_id)
    {
        $players = Player::where('team', $team_id)
                ->orderBy('total_points', 'DESC')
                ->orderBy('second_name', 'ASC')
                ->orderBy('first_name', 'ASC')
                ->get();
        $fixtures = Fixture::where('team_h', $team_id)
                ->orWhere('team_a', $team_id)
                ->orderBy('kickoff_time')
                ->get();
        return view('team', ['players' => $players, 'fixtures' => $fixtures]);
    }
}
