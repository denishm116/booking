<?php
/*
|--------------------------------------------------------------------------
| database/migrations/2018_01_28_142505_create_likeables_table.php *** Copyright netprogs.pl | avaiable only at Udemy.com | further distribution is prohibited  ***
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikeablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likeables', function (Blueprint $table) {

            $table->string('likeable_type'); /* Lecture 8 */
            $table->integer('likeable_id'); /* Lecture 8 */
            $table->bigInteger('user_id')->unsigned(); /* Lecture 8 */
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); /* Lecture 8 */


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likeables');
    }
}

