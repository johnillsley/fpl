<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('player_id');
            $table->integer('week');
            $table->smallInteger('minutes');
            $table->smallInteger('goals_scored');
            $table->smallInteger('assists');
            $table->smallInteger('clean_sheets');
            $table->smallInteger('goals_conceded');
            $table->smallInteger('own_goals');
            $table->smallInteger('penalties_saved');
            $table->smallInteger('penalties_missed');
            $table->smallInteger('yellow_cards');
            $table->smallInteger('red_cards');
            $table->smallInteger('saves');
            $table->smallInteger('bonus');
            $table->smallInteger('bps');
            $table->decimal('influence', 4, 1);
            $table->decimal('creativity', 4, 1);
            $table->decimal('threat', 4, 1);
            $table->decimal('ict_index', 4, 1);
            $table->smallInteger('total_points');
            $table->boolean('in_dreamteam');
            $table->timestamps();

            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('week')->references('id')->on('weeks');

            $table->index('player_id');
            $table->index('week');
            $table->index('in_dreamteam');
            /*
            89 => 
    array (
            'id' => 84, player_id
            'stats' =>
                    array (
                            'minutes' => 90,
                            'goals_scored' => 0,
                            'assists' => 0,
                            'clean_sheets' => 0,
                            'goals_conceded' => 3,
                            'own_goals' => 0,
                            'penalties_saved' => 0,
                            'penalties_missed' => 0,
                            'yellow_cards' => 0,
                            'red_cards' => 0,
                            'saves' => 0,
                            'bonus' => 0,
                            'bps' => 9,
                            'influence' => '19.6',
                            'creativity' => '0.6',
                            'threat' => '8.0',
                            'ict_index' => '2.8',
                            'total_points' => 1,
                            'in_dreamteam' => false,
                    ),
            'explain' =>
                    array (
                            0 =>
                                    array (
                                            'fixture' => 32,
                                            'stats' =>
                                                    array (
                                                            0 =>
                                                                    array (
                                                                            'identifier' => 'minutes',
                                                                            'points' => 2,
                                                                            'value' => 90,
                                                                    ),
                                                            1 =>
                                                                    array (
                                                                            'identifier' => 'goals_conceded',
                                                                            'points' => -1,
                                                                            'value' => 3,
                                                                    ),
                                                    ),
                                    ),
                    ),
    ),
            */
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('performances');
    }
}
