<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNullableToPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prices', function (Blueprint $table) {

                 $table->date('period1start')->nullable()->change();
            $table->date('period1end')->nullable()->change();
            $table->integer('price1')->nullable()->change();

            $table->date('period2start')->nullable()->change();
            $table->date('period2end')->nullable()->change();
            $table->integer('price2')->nullable()->change();

            $table->date('period3start')->nullable()->change();
            $table->date('period3end')->nullable()->change();
            $table->integer('price3')->nullable()->change();

            $table->date('period4start')->nullable()->change();
            $table->date('period4end')->nullable()->change();
            $table->integer('price4')->nullable()->change();

            $table->date('period5start')->nullable()->change();
            $table->date('period5end')->nullable()->change();
            $table->integer('price5')->nullable()->change();

            $table->integer('room_id')->unsigned()->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prices', function (Blueprint $table) {

        });
    }
}
