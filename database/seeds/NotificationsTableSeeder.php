<?php
/*
|--------------------------------------------------------------------------
| database/seeds/NotificationsTableSeeder.php *** Copyright netprogs.pl | avaiable only at Udemy.com | further distribution is prohibited  ***
|--------------------------------------------------------------------------
*/

use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Lecture 10 */
        $faker = Faker\Factory::create();

        /* Lecture 10 */
        for ($i = 1; $i <= 60; $i++) {

            DB::table('notifications')->insert([
                'user_id' => $faker->numberBetween(1, 10),
                'content' => $faker->sentence,
                'status' => $faker->boolean(50),
                'shown' => $faker->boolean(0),
            ]);
        }
    }
}

