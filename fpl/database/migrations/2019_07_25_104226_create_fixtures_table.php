<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFixturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->mediumInteger('id')->unique();
            $table->integer('code');
            $table->integer('event');
            $table->integer('finished')->default(0);
            $table->dateTimeTz('kickoff_time');
            $table->integer('team_a');
            $table->integer('team_a_score')->nullable();
            $table->integer('team_h');
            $table->integer('team_h_score')->nullable();
            $table->integer('team_h_difficulty');
            $table->integer('team_a_difficulty');
            $table->timestamps();

            $table->index('event');
            $table->index('team_a');
            $table->index('team_h');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fixtures');
    }
}
