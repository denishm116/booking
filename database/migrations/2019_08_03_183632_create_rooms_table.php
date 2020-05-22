<?php
/*
|--------------------------------------------------------------------------
| database/migrations/2018_01_28_194251_create_rooms_table.php *** Copyright netprogs.pl | avaiable only at Udemy.com | further distribution is prohibited  ***
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('room_number'); /* Lecture 9 */
            $table->integer('room_size'); /* Lecture 9 */
            $table->integer('price'); /* Lecture 9 */
            $table->text('description'); /* Lecture 9 */
            $table->integer('object_id')->unsigned(); /* Lecture 9 */
            $table->foreign('object_id')->references('id')->on('objects')->onDelete('cascade'); /* Lecture 9 */


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}

