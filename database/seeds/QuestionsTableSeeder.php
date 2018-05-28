<?php

use App\Question;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i=0; $i < 100; $i++) {
        	$title = $faker->sentence(mt_rand(10, 15));
        	Question::create([
        		'title' => $title.'?',
	            'body' => $faker->paragraph(),
	            'reference' => ($i%2 == 0) ? $faker->sentence() : null,
	            'user_id' => mt_rand(2, 50),
	            'slug' => _slug($title),
                'topic_id' => ($i%2 == 0) ? rand(1, 50) : null,
        	]);
        }
    }
}
