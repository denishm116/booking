<?php
/*
|--------------------------------------------------------------------------
| database/seeds/AddressesTableSeeder.php *** Copyright netprogs.pl | avaiable only at Udemy.com | further distribution is prohibited  ***
|--------------------------------------------------------------------------
*/

use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
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

            DB::table('addresses')->insert([
                'number' => $faker->numberBetween(1,10),
                'street' => $faker->streetName,
                'object_id' => $faker->unique()->numberBetween(1,10),
            ]);
        }
    }
}

