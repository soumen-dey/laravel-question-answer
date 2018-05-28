<?php

use App\City;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker::create();
        $cities = City::all()->pluck('id')->toArray();
    	
        for ($i=0; $i < 50; $i++) { 
        	$user = User::create([
        		'name' => $faker->name(),
        		'email' => $faker->email,
        		'password' => Hash::make('password'),
        	]);

            $user->detail()->create([
                'bio' => $faker->sentence(),
                'qualification' => $faker->word,
                'works_at' => $faker->company,
                'college' => $faker->company,
                'designation' => $faker->jobTitle,
                'dob' => $faker->date,
                'city_id' => $cities[rand(0, count($cities) - 1)],
            ]);

            if ($i == 0) {
                $user->roles()->attach(2);
            }

            $user->roles()->attach(1);
        }
    }
}
