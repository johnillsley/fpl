<?php

namespace App\Classes;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Player;

class ExternalData
{
    static function getall()
    {
        $url = \Config::get('constants.options.fpl_web_service');
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
}