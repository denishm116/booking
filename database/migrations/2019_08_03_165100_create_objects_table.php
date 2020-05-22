<?php
/*
|--------------------------------------------------------------------------
| database/migrations/2018_01_28_141736_create_objects_table.php *** Copyright netprogs.pl | avaiable only at Udemy.com | further distribution is prohibited  ***
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objects', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name'); /* Lecture 8 */
            $table->bigInteger('user_id')->unsigned(); /* Lecture 8 */
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); /* Lecture 8 */
            $table->bigInteger('city_id')->unsigned(); /* Lecture 8 */
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade'); /* Lecture 8 */
            $table->text('description'); /* Lecture 8 */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('objects');
    }
}

