<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {

            $table->increments('id');

            $table->date('period1start');
            $table->date('period1end');
            $table->integer('price1');

            $table->date('period2start');
            $table->date('period2end');
            $table->integer('price2');

            $table->date('period3start');
            $table->date('period3end');
            $table->integer('price3');

            $table->date('period4start');
            $table->date('period4end');
            $table->integer('price4');

            $table->date('period5start');
            $table->date('period5end');
            $table->integer('price5');

            $table->integer('room_id')->unsigned();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
