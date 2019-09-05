<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;

class ShowTable extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $teams = Team::orderBy('name', 'ASC')->get();
        $table = array();
        foreach ($teams as $team) {

            $team->aw = 0;
            $team->ad = 0;
            $team->al = 0;
            $team->agf = 0;
            $team->aga = 0;
            foreach ($team->away_results as $away_result) {
                if ($away_result->team_a_score > $away_result->team_h_score) $team->aw++;
                if ($away_result->team_a_score == $away_result->team_h_score) $team->ad++;
                if ($away_result->team_a_score < $away_result->team_h_score) $team->al++;
                $team->agf += $away_result->team_a_score;
                $team->aga += $away_result->team_h_score;
            }
            $team->hw = 0;
            $team->hd = 0;
            $team->hl = 0;
            $team->hgf = 0;
            $team->hga = 0;
            foreach ($team->home_results as $home_result) {
                if ($home_result->team_h_score > $home_result->team_a_score) $team->hw++;
                if ($home_result->team_h_score == $home_result->team_a_score) $team->hd++;
                if ($home_result->team_h_score < $home_result->team_a_score) $team->hl++;
                $team->hgf += $home_result->team_h_score;
                $team->hga += $home_result->team_a_score;
            }
            $team->points = ($team->aw + $team->hw) * 3 + $team->ad + $team->hd;
            $team->mp = $team->aw + $team->ad + $team->al + $team->hw + $team->hd + $team->hl;
            $team->gd = $team->agf + $team->hgf - $team->aga - $team->hga;
            $table[] = $team;
        }
        // Order table.
        usort($table, array($this, 'cmp'));
        return view('table', ['teams' => $table]);
    }
    
    private static function cmp($a, $b) {
        if ($a->points == $b->points) {
            if ($a->gd == $b->gd) {
                if ($a->hgf + $a->agf == $b->hgf + $b->agf) {
                    return 0;
                }
                return ($a->hgf + $a->agf > $b->hgf + $b->agf) ? -1 : 1;
            }
            return ($a->gd > $b->gd) ? -1 : 1;
        }
        return ($a->points > $b->points) ? -1 : 1;
    }
}
