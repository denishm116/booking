<?php
/*
|--------------------------------------------------------------------------
| database/seeds/CommentsTableSeeder.php *** Copyright netprogs.pl | avaiable only at Udemy.com | further distribution is prohibited  ***
|--------------------------------------------------------------------------
*/

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
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
        for ($i = 1; $i <= 50; $i++) {

            DB::table('comments')->insert([
                'content' => $faker->text(500),
                'rating' => $faker->numberBetween(1, 5),
                'user_id' => $faker->numberBetween(1, 10),
                'commentable_type' => $faker->randomElement($array = array('App\TouristObject', 'App\Article')),
                'commentable_id' => $faker->numberBetween(1, 10),

            ]);
        }
    }
}

