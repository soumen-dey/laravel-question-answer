<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CitiesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(TopicsTableSeeder::class);
        $this->call(AnswersTableSeeder::class);
        $this->call(FollowsTableSeeder::class);
        $this->call(QuestionsTableSeeder::class);
    }
}
