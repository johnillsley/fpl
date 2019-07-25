<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weeks', function (Blueprint $table) {
            $table->mediumInteger('id')->unique();
            $table->string('name', 100);
            $table->decimal('average_entry_score', 5, 1);
            $table->tinyInteger('finished')->default(0);
            $table->tinyInteger('data_checked')->default(0);
            $table->integer('highest_scoring_entry')->nullable();
            $table->integer('deadline_time_epoch');
            $table->integer('deadline_time_game_offset');
            $table->integer('highest_score')->nullable();
            $table->tinyInteger('is_previous')->default(0);
            $table->tinyInteger('is_current')->default(0);
            $table->tinyInteger('is_next')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weeks');
    }
}
