<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhoneToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->after('email')->unique()->nullable();
            $table->string('code')->after('phone')->nullable();
            $table->integer('attempt')->after('code')->nullable()->default(1);
            $table->dateTime('time')->after('attempt')->nullable();

            $table->boolean('active')->after('time')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('code');
            $table->dropColumn('attempt');
            $table->dropColumn('time');
            $table->dropColumn('active');
        });
    }
}
