<?php
/*
|--------------------------------------------------------------------------
| database/seeds/CitiesTableSeeder.php *** Copyright netprogs.pl | avaiable only at Udemy.com | further distribution is prohibited  ***
|--------------------------------------------------------------------------
*/

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
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

            DB::table('cities')->insert([
                'name' => $faker->unique()->city,
            ]);
        }
    }
}

