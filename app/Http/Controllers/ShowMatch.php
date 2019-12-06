<?php

namespace App\Http\Controllers;
use App\Fixture;
use App\Performance;

use Illuminate\Http\Request;

class ShowMatch extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($fixture_id)
    {
        $fixture = Fixture::find($fixture_id);
        
        // Get perfomances for both teams
        
        return view('fixture', ['fixture' => $fixture]);
    }
}
