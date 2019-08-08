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
                    $item[] = (float)$player->now_cost;
                    $item[] = (float)$player->points_per_game;
                    $item[] = $player->team_short_name;
                    $item[] = (float)$player->selected_by_percent;
                    $data[] = $item;
                }
                break;
        }
        /*
        $data = [
                ['ID', 'Price', 'Points per game', 'Team', 'Ownership'],
                ['CAN',    80.66,              1.67,      'North America',  33739900],
                ['DEU',    79.84,              1.36,      'Europe',         81902307],
                ['DNK',    78.6,               1.84,      'Europe',         5523095],
                ['EGY',    72.73,              2.78,      'Middle East',    79716203],
                ['GBR',    80.05,              2,         'Europe',         61801570],
                ['IRN',    72.49,              1.7,       'Middle East',    73137148],
                ['IRQ',    68.09,              4.77,      'Middle East',    31090763],
                ['ISR',    81.55,              2.96,      'Middle East',    7485600],
                ['RUS',    68.6,               1.54,      'Europe',         141850000],
                ['USA',    78.09,              2.05,      'North America',  307007000]  
        ];
        */
        $chart->options = json_encode((object)$options);
        $chart->data = json_encode($data);

        return view('chart', ['chart' => $chart]);
    }
}
