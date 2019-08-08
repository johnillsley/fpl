<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnderstatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('understats', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->integer('player_id')->nullable();
            $table->string('player_name', 64);
            $table->smallInteger('games');
            $table->smallInteger('time');
            $table->smallInteger('goals');
            $table->decimal('xg', 5, 3);
            $table->smallInteger('assists');
            $table->decimal('xa', 5, 3);
            $table->smallInteger('shots');
            $table->smallInteger('key_passes');
            $table->smallInteger('yellow_cards');
            $table->smallInteger('red_cards');
            $table->string('position', 32);
            $table->string('team_title', 32);
            $table->smallInteger('npg');
            $table->decimal('npxg', 5, 3);
            $table->decimal('xg_chain', 5, 3);
            $table->decimal('xg_buildup', 5, 3);
            $table->timestamps();

            $table->foreign('player_id')->references('id')->on('players');
        });
    }
    
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('understats');
    }
}
