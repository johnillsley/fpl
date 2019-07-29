<?php

namespace App\Classes;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Player;
use App\Team;
use App\Week;
use App\Fixture;

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

    static function import_stats()
    {

    }

    static function import_transfers()
    {

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
}