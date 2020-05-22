<?php
/*
|--------------------------------------------------------------------------
| database/migrations/2018_01_28_194555_create_addresses_table.php *** Copyright netprogs.pl | avaiable only at Udemy.com | further distribution is prohibited  ***
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('number'); /* Lecture 9 */
            $table->string('street'); /* Lecture 9 */
            $table->integer('object_id')->unsigned(); /* Lecture 9 */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}

