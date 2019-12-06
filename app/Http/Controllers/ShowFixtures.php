<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Fixture;
use App\Week;

class ShowFixtures extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($week_id = null)
    {
        if (isset($week_id)) {
            $week = Week::find($week_id);
            $fixtures = Fixture::where('event', $week_id)
                    ->orderBy('kickoff_time', 'ASC')
                    ->orderBy('team_h', 'ASC')
                    ->get();
            return view('fixtures', ['fixtures' => $fixtures, 'week' => $week ]);
        } else {
            $weeks = Week::orderBy('id')->get();
            return view('weeks', ['weeks' => $weeks]);
        }
    }
}
