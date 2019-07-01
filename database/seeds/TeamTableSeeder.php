<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
class TeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\TeamProvider($faker));
        for($i = 1; $i <= 10; $i++) {
            DB::table('teams')->insert([
                    'name' => $faker->teamName(),
                    'created_at'  => new \DateTime(),
                    'updated_at'  => new \DateTime(),
                ]
            );
        }
    }
}
