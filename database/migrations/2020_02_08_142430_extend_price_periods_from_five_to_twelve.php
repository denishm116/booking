<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendPricePeriodsFromFiveToTwelve extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->date('period6start')->nullable();
            $table->date('period6end')->nullable();
            $table->integer('price6')->nullable();

            $table->date('period7start')->nullable();
            $table->date('period7end')->nullable();
            $table->integer('price7')->nullable();

            $table->date('period8start')->nullable();
            $table->date('period8end')->nullable();
            $table->integer('price8')->nullable();

            $table->date('period9start')->nullable();
            $table->date('period9end')->nullable();
            $table->integer('price9')->nullable();

            $table->date('period10start')->nullable();
            $table->date('period10end')->nullable();
            $table->integer('price10')->nullable();

            $table->date('period11start')->nullable();
            $table->date('period11end')->nullable();
            $table->integer('price11')->nullable();

            $table->date('period12start')->nullable();
            $table->date('period12end')->nullable();
            $table->integer('price12')->nullable();
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
            $table->dropColumn('period6start');
            $table->dropColumn('period6end');
            $table->dropColumn('price6');

            $table->dropColumn('period7start');
            $table->dropColumn('period7end');
            $table->dropColumn('price7');

            $table->dropColumn('period8start');
            $table->dropColumn('period8end');
            $table->dropColumn('price8');

            $table->dropColumn('period9start');
            $table->dropColumn('period9end');
            $table->dropColumn('price9');

            $table->dropColumn('period10start');
            $table->dropColumn('period10end');
            $table->dropColumn('price10');

            $table->dropColumn('period11start');
            $table->dropColumn('period11end');
            $table->dropColumn('price11');

            $table->dropColumn('period12start');
            $table->dropColumn('period12end');
            $table->dropColumn('price12');
        });
    }
}
