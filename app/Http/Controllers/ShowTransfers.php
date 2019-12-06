<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transfer;

class ShowTransfers extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($player)
    {
        $chart = new \stdClass();
        $chart->type = "LineChart";

        $options = array();
        $options['title'] = 'Player transfers';
        $options['hAxis']['title'] = 'Time';
        $options['vAxis']['title'] = 'Transfers';
        $options['curveType'] = "function";

        $data = array(['Date', 'Transfers in', 'Transfers out', 'Net transfers in']);
        $transfers = Transfer::where([['player_id', '=', $player], ['created_at', '>', '2019-09-02']])->orderBy('created_at', 'ASC')->get();

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
        $chart->options = json_encode((object)$options);
        $chart->data = json_encode($data);

        return view('chart', ['chart' => $chart]);
    }
}
