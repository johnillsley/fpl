<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Performance;
use App\Player;
use App\Team;
use App\Transfer;
use App\Week;

class ShowChart extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $type)
    {
        // get all players
        $chart = new \stdClass();
        $filters = array();
        $current_week = Week::current();
        switch ($type) {
            case 'ownership':
                
                // Filter 1 - minutes played.
                if (!is_null($current_week)) {
                    $filter = new \stdClass();
                    $filter->type = "select";
                    $filter->name = "minutes";
                    $filter->label = "Minimum number of minutes: ";
                    $filter->options = array();
                    for ($i = 1; $i <=  $current_week->id; $i++) {
                        $value = $i * 90;
                        $filter->options[$value] = $value;
                    }
                    $filter->selected = ($request->input('minutes')) ? $request->input('minutes') : 90;
                    $filters[] = $filter;
                    $players = Player::where('minutes', '>=', $filter->selected)->with('club')->orderBy('team');
                    // where('minutes', '>=', $filter->selected)
                    
                }
                
                // Filter 2 - team.
                $filter = new \stdClass();
                $teams = Team::orderBy('name')->get();
                $filter->type = "multiple";
                $filter->name = "teams";
                $filter->label = "Only players in these teams: ";
                $filter->options = array();
                foreach ($teams as $team) {
                    $filter->options[$team->id] = $team->name;
                }
                if (is_array($request->input('teams'))) {
                    $filter->selected = $request->input('teams');
                    $players = $players->whereIn('team', $filter->selected);
                } else {
                    $filter->selected = null;
                }
                $filters[] = $filter;
                // End of filters.
            
                $chart->type = "BubbleChart";
                $options = array();
                $players = $players->get();
                $options['title'] = 'Player points per game against price';
                $options['chartArea'] = 'left:10,top:20,width:"100%",height:"100%"';
                $options['hAxis']['title'] = 'Price';
                $options['vAxis']['title'] = 'Points per game';
                // $options['colors'] = $this->get_team_colours();
                $options['bubble']['textStyle']['fontSize'] = "11";
                $data = array(['ID', 'Price', 'Points per game', 'Team', 'Ownership']);
                $teams_included = array();
                foreach ($players as $player) {
                    $item = array();
                    $item[] = $player->second_name;
                    $item[] = (float)$player->transfer->now_cost;
                    $item[] = (float)$player->points_per_game;
                    $item[] = $player->club->name;
                    $item[] = (float)$player->transfer->selected_by_percent;
                    $data[] = $item;
                    if (!in_array($player->team, $teams_included)) {
                        $teams_included[] = $player->team;
                    }
                }
                $options['colors'] = $this->get_team_colours($teams_included);
                break;

            case 'form':
                $chart->type = "BubbleChart";

                $options = array();
                $options['title'] = 'Player points next game based on ICT index';
                $options['hAxis']['title'] = 'ICT index';
                $options['vAxis']['title'] = 'Points in next game';
                $options['bubble']['textStyle']['fontSize'] = "11";
                $performances = Performance::where([['ict_index', '>', 0], ['week', '=', $current_week->id]])
                        ->with('player')
                        ->with('player.club')
                        ->get();
                $data = array(['ID', 'ICT index', 'Points in next game', 'Team', 'Ownership']);
                $teams_included = array();
                $performances = $performances->sortBy('player.team');
                foreach ($performances as $performance) {
                    $next_week = Performance::where([['player_id', '=', $performance->player_id], ['week', '=', $performance->week + 1]])->first();
                    $item = array();
                    $item[] = $performance->player->second_name;
                    $item[] = (float)$performance->player->form;
                    $item[] = (float)$performance->total_points;
                    $item[] = $performance->player->club->name;
                    $item[] = (float)$performance->player->transfer->selected_by_percent;
                    $data[] = $item;
                    if (!in_array($performance->player->team, $teams_included)) {
                        $teams_included[] = $performance->player->team;
                    }
                }
                $options['colors'] = $this->get_team_colours($teams_included);
                break;

            case 'transferactivity':
                $chart->type = "BubbleChart";

                $options = array();
                $options['title'] = 'Most transferred players in the last hour';
                $options['hAxis']['title'] = 'Form';
                $options['vAxis']['title'] = 'Net transfers in during last hour';
                $options['bubble']['textStyle']['fontSize'] = "11";

                $recent1 = Transfer::where('updated_at', '>', date('Y-m-d H:i:s', strtotime('-1 hour')))
                        ->with('player')
                        ->get();
                $recent2 = Transfer::where('updated_at', '>', date('Y-m-d H:i:s', strtotime('-2 hour')))
                        ->where('updated_at', '<', date('Y-m-d H:i:s', strtotime('-1 hour')))->get();
                
                $data = array(['ID', 'Form', 'Net transfers in last hour', 'Team', 'Cost']);
                $teams_included = array();
                $recent1 = $recent1->sortBy('player.team');
                foreach ($recent1 as $transfer) {

                    if (!$previous = $recent2->where('player_id', $transfer->player_id)->first()) {
                        continue;
                    } 
                    
                    $transfers_hour = ($transfer->transfers_in - $transfer->transfers_out)
                            - ($previous->transfers_in - $previous->transfers_out);
                    if (abs($transfers_hour) < 200) {
                        continue;
                    }
                    $item = array();
                    $item[] = $transfer->player->second_name;
                    $item[] = (float)$transfer->player->form;
                    $item[] = $transfers_hour;
                    $item[] = $transfer->player->club->name;
                    $item[] = (float)$transfer->player->transfer->now_cost;
                    $data[] = $item;
                    if (!in_array($transfer->player->team, $teams_included)) {
                        $teams_included[] = $transfer->player->team;
                    }
                }
                $options['colors'] = $this->get_team_colours($teams_included);
                break;

            case 'value':
                $chart->type = "BubbleChart";

                $options = array();
                $options['title'] = 'Best value for money players';
                $options['hAxis']['title'] = 'Cost';
                $options['vAxis']['title'] = 'Form';
                $options['bubble']['textStyle']['fontSize'] = "11";

                $players = Player::where('form', '>', 0)
                        ->with('club')
                        ->orderBy('team')
                        ->get();

                $data = array(['ID', 'Cost', 'Form', 'Team', 'Ownership']);
                $teams_included = array();
                foreach ($players as $player) {
                    $item = array();
                    $item[] = $player->second_name;
                    $item[] = (float)$player->transfer->now_cost;
                    $item[] = (float)$player->form;
                    $item[] = $player->club->name;
                    $item[] = (float)$player->transfer->selected_by_percent;
                    $data[] = $item;
                    if (!in_array($player->team, $teams_included)) {
                        $teams_included[] = $player->team;
                    }
                }
                $options['colors'] = $this->get_team_colours($teams_included);
                break;
        }
        $chart->options = json_encode((object)$options);
        $chart->data = json_encode($data);
        
        return view('chart', ['chart' => $chart, 'filters' => $filters]);
    }
    
    private function get_team_colours($teams_included) {
        
        $colours = array();
        $teams = Team::whereIn('id', $teams_included)->orderBy('name')->get();
        foreach ($teams as $team) {
            $colours[] = $team->colours->colour1;
        }
        return $colours;
    }
}
