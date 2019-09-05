<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return 'Hello';
});
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/


Route::resource('player', 'PlayerController', ['only' => [
        'index', 'show'
]]);

Route::get('getdata/{type?}', 'GetExternalData');

Route::get('fixtures/{week?}', 'ShowFixtures');

Route::get('matches/{team}', 'ShowMatches');

Route::get('table', 'ShowTable');

Route::get('team/{team}', 'ShowTeam');

Route::get('chart/{type}', 'ShowChart');

Route::get('watchlist', 'ShowWatchlist');

Route::post('watchlist/{player}', 'AjaxController@watchlist');