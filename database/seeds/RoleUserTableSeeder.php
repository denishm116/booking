<?php
/*
|--------------------------------------------------------------------------
| database/seeds/RoleUserTableSeeder.php *** Copyright netprogs.pl | avaiable only at Udemy.com | further distribution is prohibited  ***
|--------------------------------------------------------------------------
*/

use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
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
        for ($i = 1; $i <= 10; $i++) {

            DB::table('role_user')->insert([
                'user_id' => $faker->unique()->numberBetween(1, 10),
                'role_id' => $faker->randomElement($array = array (1,2,3))
            ]);
        }
    }
}

