<?php
/*
|--------------------------------------------------------------------------
| database/seeds/ObjectsTableSeeder.php *** Copyright netprogs.pl | avaiable only at Udemy.com | further distribution is prohibited  ***
|--------------------------------------------------------------------------
*/

use Illuminate\Database\Seeder;

class ObjectsTableSeeder extends Seeder
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
        for ($i = 1; $i <= 10; $i++)
        {

            DB::table('objects')->insert([

                'name' => $faker->unique()->word,
                'description' => $faker->text(1000),
                'city_id' => $faker->numberBetween(1,10),
                'user_id' => $faker->numberBetween(1,10),

            ]);
        }
    }
}

