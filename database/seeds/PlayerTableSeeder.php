<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class PlayerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i = 1; $i <= 3; $i++) {
            DB::table('users')->insert([
                    'name' => $faker->name,
                    'email' => $faker->email,
                    'password' => bcrypt('admin'),
                    'created_at'  => new \DateTime(),
                    'updated_at'  => new \DateTime(),
                ]
            );
            $user = App\Models\User::latest('id')->first();
            DB::table('players')->insert([
                    'user_id' => $user->id,
                    'picture' =>  'user' . $user->id . '.jpg',
                    'created_at'  => new \DateTime(),
                    'updated_at'  => new \DateTime(),
                ]
            );
        }

    }
}
