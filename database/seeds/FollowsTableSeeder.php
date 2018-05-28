<?php

use App\User;
use App\Follow;
use Illuminate\Database\Seeder;

class FollowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $follows = [
            'App\User',
            'App\Topic',
            'App\Question',
        ];

        $users = User::all()->pluck('id')->toArray();

        for ($i=0; $i < 50; $i++) { 
        	Follow::create([
        		'followable_id' => $i,
        		'followable_type' => $follows[rand(0, count($follows) - 1)],
        		'user_id' => $users[rand(2, count($users) - 1)],
        	]);
        }
    }
}
