<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fixture;

class ShowMatches extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($team)
    {
        $fixtures = Fixture::where('team_a', $team)
                ->orWhere('team_h', $team)
                ->orderBy('kickoff_time', 'ASC')
                ->get();

        return view('matches', ['fixtures' => $fixtures, 'team' => $team]);
    }
}
