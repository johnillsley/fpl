<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Fixture;

class ShowFixtures extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($week)
    {
        $fixtures = Fixture::where('event', $week)
                    ->orderBy('kickoff_time', 'ASC')
                    ->orderBy('team_h', 'ASC')
                    ->get();
        return view('fixtures', ['fixtures' => $fixtures]);
    }
}
