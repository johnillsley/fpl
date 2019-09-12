<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->integer('code');
            $table->integer('draw');
            $table->integer('loss');
            $table->string('name', 100);
            $table->integer('played');
            $table->integer('points');
            $table->integer('position');
            $table->string('short_name', 3);
            $table->integer('strength');
            $table->integer('win');
            $table->integer('strength_overall_home');
            $table->integer('strength_overall_away');
            $table->integer('strength_attack_home');
            $table->integer('strength_attack_away');
            $table->integer('strength_defence_home');
            $table->integer('strength_defence_away');
            $table->timestamps();

            $table->foreign('id')->references('team_a')->on('fixtures');
            $table->foreign('id')->references('team_h')->on('fixtures');
            $table->foreign('id')->references('team')->on('players');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
