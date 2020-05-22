<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {

            $table->increments('id');
            $table->string('content'); /* Lecture 8 */
            $table->boolean('status'); /* Lecture 8 */
            $table->bigInteger('user_id')->unsigned(); /* Lecture 8 */
            $table->foreign('user_id')->references('id')->on('users'); /* Lecture 8 */
            $table->boolean('shown')->default(false); /* Lecture 8 */

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}

