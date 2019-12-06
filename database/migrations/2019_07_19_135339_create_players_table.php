<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            
            $table->integer('id')->unique();
            $table->mediumInteger('code');
            $table->tinyInteger('element_type');
            $table->decimal('ep_next', 4, 1)->nullable();
            $table->decimal('ep_this', 4, 1)->nullable();
            $table->smallInteger('event_points');
            $table->string('first_name', 32);
            $table->decimal('form', 4, 1);
            $table->decimal('points_per_game', 4, 1);
            $table->string('second_name', 32);
            $table->integer('team');
            $table->smallInteger('team_code');
            $table->smallInteger('total_points');
            $table->decimal('value_form', 5, 1);
            $table->decimal('value_season', 5, 1);
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
            $table->decimal('influence', 5, 1);
            $table->decimal('creativity', 5, 1);
            $table->decimal('threat', 5, 1);
            $table->decimal('ict_index', 5, 1);
            $table->timestamps();
            
            $table->foreign('team')->references('id')->on('teams');
            $table->index('team');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
}
