<?php
/*
|--------------------------------------------------------------------------
| database/seeds/PhotosTableSeeder.php *** Copyright netprogs.pl | avaiable only at Udemy.com | further distribution is prohibited  ***
|--------------------------------------------------------------------------
*/

use Illuminate\Database\Seeder;

class PhotosTableSeeder extends Seeder
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
        for ($i = 1; $i <= 100; $i++) {

            DB::table('photos')->insert([
                'photoable_type' => 'App\TouristObject',
                'photoable_id' => $faker->numberBetween(1, 10),
                'path' => $faker->imageUrl(800, 400, 'city')
            ]);
        }

        /* Lecture 11 */
        for ($i = 1; $i <= 200; $i++) {

            DB::table('photos')->insert([
                'photoable_type' => 'App\Room',
                'photoable_id' => $faker->numberBetween(1, 10),
                'path' => $faker->imageUrl(800, 400, 'nightlife')
            ]);
        }

        /* Lecture 11 */
        for ($i = 1; $i <= 10; $i++) {

            DB::table('photos')->insert([
                'photoable_type' => 'App\User',
                'photoable_id' => $faker->unique()->numberBetween(1, 10),
                'path' => $faker->imageUrl(275, 150, 'people')
            ]);
        }
    }
}

