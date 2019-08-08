<?php

namespace App\Classes;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Player;
use App\Transfer;
use App\Team;
use App\Week;
use App\Fixture;
use App\Understat;

class ExternalData
{
    static function getall()
    {
        $url = \Config::get('constants.options.fpl_web_service');
        $data = file_get_contents($url);
        $array = json_decode($data);
        return $array;
    }

    static function getfixtures()
    {
        $url = \Config::get('constants.options.fpl_ws_fixtures');
        $data = file_get_contents($url);
        $array = json_decode($data);
        return $array;
    }
    
    static function get($type)
    {
        // $type options...
        // events
        // game_settings
        // phases
        // teams
        // total_players
        // elements
        // element_stats
        // element_types
        
        switch($type) {
            case 'players':
                $subset = 'elements';
                break;
            case 'teams':
                $subset = 'teams';
                break;
            case 'weeks':
                $subset = 'events';
                break;
            case 'stats':
                $subset = 'element_stats';
                break;
            case 'fixtures':
                return self::getfixtures();
                break;
            default:
                return false;
        }
        $data = self::getall();
        return $data->$subset;
    }
    
    static function import_players() 
    {
        $players = self::get('players');
        foreach ($players as $player) {
            Player::updateOrCreate(['id' => $player->id], (array)$player);
        }
    }

    static function import_stats($week)
    {
        $url = \Config::get('constants.options.fpl_ws_week') . '/' . $week . '/live';
        $data = file_get_contents($url);
        $array = json_decode($data);
        return $array;
    }

    static function import_transfers()
    {
        $players = self::get('players');
        foreach ($players as $player) {
            $player->player_id = $player->id;
            $player->player_code = $player->code;
            unset($player->id);
            unset($player->code);
            Transfer::create((array)$player);
        }
    }

    static function import_teams()
    {
        $teams = self::get('teams');
        foreach ($teams as $team) {
            Team::updateOrCreate(['id' => $team->id], (array)$team);
        }
    }

    static function import_weeks()
    {
        $weeks = self::get('weeks');
        foreach ($weeks as $week) {
            Week::updateOrCreate(['id' => $week->id], (array)$week);
        }
    }

    static function import_fixtures()
    {
        $fixtures = self::get('fixtures');
        foreach ($fixtures as $fixture) {
            Fixture::updateOrCreate(['id' => $fixture->id], (array)$fixture);
        }
    }

    static function import_understats()
    {
        $page = file_get_contents('https://understat.com/league/EPL/2019');
        $raw_data = self::get_string_between($page, "playersData	= JSON.parse('", "');");
        $data = str_replace(
                array('\x5B', '\x7B', '\x22', '\x3A', '\x7D', '\x5D', '\x20', '\x2D', '\x5C', '\x26', '\x23', '\x3B'),
                array('[', '{', '"', ':', '}', ']', ' ', '-', '\\', '&', '#', ';'),
                $raw_data);
        $data = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
        }, $data);
        $understats = json_decode($data);

        foreach ($understats as $understat) {
            $understat->xg          = $understat->xG;
            $understat->xa          = $understat->xA;
            $understat->npxg        = $understat->npxG;
            $understat->xg_chain    = $understat->xGChain;
            $understat->xg_buildup  = $understat->xGBuildup;
            
            $names = explode(" ", $understat->player_name);
            if (count($names) == 1) {
                $names[1] = '';
            }
            if ($player = Player::where([
                    ['first_name', '=', $names[0]],
                    ['second_name', '=', $names[1]]
            ])->first()) {
                //print_r($player);
                $understat->player_id = $player->id;
            }
            
            Understat::updateOrCreate(['id' => $understat->id], (array)$understat);
        }
    }

    static function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }


}