<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Player;
use App\Performance;

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
        $chart = new \stdClass();
        switch ($type) {
            case 'ownership':
                $chart->type = "BubbleChart";

                $options = array();
                $options['title'] = 'Player points per game against price';
                $options['hAxis']['title'] = 'Price';
                $options['vAxis']['title'] = 'Points per game';
                $options['bubble']['textStyle']['fontSize'] = "11";
                
                $players = Player::where('minutes', '>', 200)->get();
                $data = array(['ID', 'Price', 'Points per game', 'Team', 'Ownership']);
                foreach ($players as $player) {
                    $item = array();
                    $item[] = $player->second_name;
                    $item[] = (float)$player->transfer->now_cost;
                    $item[] = (float)$player->points_per_game;
                    $item[] = $player->team_short_name;
                    $item[] = (float)$player->transfer->selected_by_percent;
                    $data[] = $item;
                }
                break;

            case 'form':
                $chart->type = "BubbleChart";

                $options = array();
                $options['title'] = 'Player points next game based on ICT index';
                $options['hAxis']['title'] = 'ICT index';
                $options['vAxis']['title'] = 'Points in next game';
                $options['bubble']['textStyle']['fontSize'] = "11";

                $performances = Performance::where([['ict_index', '>', 0], ['week', '=', 4]])->get();
                $data = array(['ID', 'ICT index', 'Points in next game', 'Team', 'Ownership']);

                foreach ($performances as $performance) {
                    $next_week = Performance::where([['player_id', '=', $performance->player_id], ['week', '=', $performance->week + 1]])->first();
                    $item = array();

                    $item[] = $performance->player->second_name;
                    $item[] = (float)$performance->player->form;
                    $item[] = (float)$performance->total_points;
                    $item[] = $performance->player->team_short_name;
                    $item[] = (float)$performance->player->transfer->selected_by_percent;
                    $data[] = $item;
                }

                break;
        }
        $chart->options = json_encode((object)$options);
        $chart->data = json_encode($data);

        return view('chart', ['chart' => $chart]);
    }
}
