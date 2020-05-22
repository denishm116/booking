<?php
/*
|--------------------------------------------------------------------------
| database/seeds/LikeablesTableSeeder.php *** Copyright netprogs.pl | avaiable only at Udemy.com | further distribution is prohibited  ***
|--------------------------------------------------------------------------
*/

use Illuminate\Database\Seeder;

class LikeablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Lecture 11 */
        $faker = Faker\Factory::create();

        /* Lecture 11 */
        for ($i = 1; $i <= 40; $i++) {

            DB::table('likeables')->insert([
                'likeable_type' => $faker->randomElement($array = array('App\TouristObject', 'App\Article')),
                'likeable_id' => $faker->numberBetween(1, 10),
                'user_id' => $faker->numberBetween(1, 10),
            ]);
        }
    }
}

