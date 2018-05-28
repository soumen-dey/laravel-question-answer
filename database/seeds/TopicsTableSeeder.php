<?php

use App\Topic;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TopicsTableSeeder extends Seeder
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
        	$name = $faker->words(mt_rand(1, 5), true);
            $topic = Topic::create([
        		'name' => ucfirst($name),
                'slug' => _slug($name),
        	]);
        }
    }
}
