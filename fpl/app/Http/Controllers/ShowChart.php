<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Player;

class ShowChart extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($type)
    {
        // get all players
        switch ($type) {
            case 'ownership':
                $chart_type = "bubble";
                
                $players = Player::where('minutes', '>', 200)->get();
                $data = array();
                foreach ($players as $player) {
                    $item = new \stdClass();
                    $item->y = $player->points_per_game;
                    $item->x = $player->now_cost;
                    $item->r = $player->selected_by_percent;
                    $item->label = $player->second_name;
                    $data[] = $item;
                }
                break;
        }
        $chart = new \stdClass();
        $chart->type = $chart_type;

        $datasets = array();
        $dataset = new \stdClass();
        $dataset->label = 'First dataset';
        $dataset->data = $data;
        $dataset->backgroundColor = 'rgb(255, 99, 132)';
        $datasets[] = $dataset;
        
        $chart->data = new \stdClass();
        $chart->data->datasets = $datasets;
        
        return view('chart', ['chart' => json_encode($chart)]);
    }
}
