<?php

namespace App\Http\Controllers;

use DB;
use App\Player;
use App\Performance;
use App\Transfer;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $players = Player::all();
        return view('player.players',['players' => $players]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Player::Create($request->all())){
            return true;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        // Prepare data for performance chart.
        $data = array([
                'Week',
                'Minutes played',
                'Goals scored',
                'Assists',
                'Clean_sheets',
                'Saves points',
                'Penalties saved',
                'Bonus',
                'Goals conceded',
                'Own goals',
                'Penalties missed',
                'Yellow Cards',
                'Red Cards']);

        switch ($player->element_type) {
            case 1: 
                $goal_points = 6;
                $clean_sheet_points = 4;
                $goals_conceded = 1;
                break;
            case 2: 
                $goal_points = 6;
                $clean_sheet_points = 4;
                $goals_conceded = 1;
                break;
            case 3: 
                $goal_points = 5;
                $clean_sheet_points = 1;
                $goals_conceded = 0;
                break;
            case 4: 
                $goal_points = 4;
                $clean_sheet_points = 0;
                $goals_conceded = 0;
                break;
        }

        foreach ($player->performances as $performance) {
            $item = array();
            switch ($performance->minutes) {
                case $performance->minutes>= 60: $played_points = 2; break;
                case $performance->minutes> 0: $played_points = 1; break;
                default: $played_points = 0;
            }
            $item[] = $performance->week;
            $item[] = $played_points;
            $item[] = $performance->goals_scored * $goal_points;
            $item[] = $performance->assists * 3;
            $item[] = $performance->clean_sheets * $clean_sheet_points;
            $item[] = floor($performance->saves * 3);
            $item[] = $performance->penalties_saved * 5;
            $item[] = $performance->bonus;
            $item[] = floor($performance->goals_conceded * $goals_conceded / (-2));
            $item[] = (-3) * $performance->own_goals;
            $item[] = (-2) * $performance->panalties_missed;
            $item[] = (-1) * $performance->yellow_cards;
            $item[] = (-3) * $performance->red_cards;
            $data[] = $item;
        }
        for ($week = $performance->week; $week <= 38; $week++) {
            $data[] = array($week, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        }
        $performances = new \stdClass();
        $performances->data = json_encode($data);

        // Prepare data for transfers chart.
        $data = array(['Date', 'Transfers in', 'Transfers out', 'Net transfers in']);
        $transfers = Transfer::where([['player_id', '=', $player->id], ['created_at', '>', '2019-09-02']])->orderBy('created_at', 'ASC')->get();
        $prev_transfers_in = $transfers[0]->transfers_in;
        $prev_transfers_out = $transfers[0]->transfers_out;

        foreach ($transfers as $transfer) {
            $change_transfers_in = $transfer->transfers_in - $prev_transfers_in;
            $change_transfers_out = $transfer->transfers_out - $prev_transfers_out;

            $item = array();
            $item[] = date("M j, Y", strtotime($transfer->created_at));
            $item[] = $change_transfers_in;
            $item[] = $change_transfers_out;
            $item[] = $change_transfers_in - $change_transfers_out;
            $data[] = $item;

            $prev_transfers_in = $transfer->transfers_in;
            $prev_transfers_out = $transfer->transfers_out;
        }
        $tr = new \stdClass();
        $tr->data = json_encode($data);

        // Prepare data for ownership chart.
        $data = array(['Date', 'Ownership (%)']);
        
        foreach ($transfers as $transfer) {
            $item = array();
            $item[] = date("M j, Y", strtotime($transfer->created_at));
            $item[] = (float)$transfer->selected_by_percent;
            $data[] = $item;
        }
        $ownership = new \stdClass();
        $ownership->data = json_encode($data);
      
        return view('player.player',['player' => $player, 'performance' => $performances, 'transfers' => $tr, 'ownership' => $ownership]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Player $player)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Player $player)
    {
        if($player->fill($request->all())->save()){
            return true;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player $player)
    {
        if( $player->delete()){
            return true;
        }
    }
}
