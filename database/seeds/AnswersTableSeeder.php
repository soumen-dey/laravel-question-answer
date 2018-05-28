<?php

use App\Answer;
use App\Question;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class AnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $questions = Question::all();

        foreach ($questions as $question) {
        	for ($i=0; $i < mt_rand(1, 50); $i++) { 
	        	Answer::create([
	        		'body' => $faker->paragraph(),
	        		'reference' => $faker->sentence(),
	        		'user_id' => mt_rand(2, 50),
	        		'question_id' => $question->id,
	        	]);
        	}
        }
    }
}
