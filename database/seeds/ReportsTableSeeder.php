<?php

use App\Report;
use Illuminate\Database\Seeder;

class ReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $follows = [
            'App\Answer',
            'App\Question',
        ];

        for ($i=1; $i <= 10; $i++) { 
        	Report::create([
        		'reportable_id' => $i,
        		'reportable_type' => 'App\Answer',
        		'user_id' => $i+2,
        	]);
        }
    }
}
