<?php

use App\City;
use Faker\Factory as Faker;
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
        $faker = Faker::create();

        for ($i=0; $i < 50; $i++) { 
        	City::create([
        		'name' => $faker->city,
        	]);
        }
    }
}
