<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('player_id');
            $table->mediumInteger('player_code');
            $table->smallInteger('now_cost');
            $table->decimal('selected_by_percent', 4, 1);
            $table->char('status');
            $table->smallInteger('transfers_in');
            $table->smallInteger('transfers_in_event');
            $table->smallInteger('transfers_out');
            $table->smallInteger('transfers_out_event');
            $table->timestamps();

            $table->index('player_id');
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
        Schema::dropIfExists('transfers');
    }
}
