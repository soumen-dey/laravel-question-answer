<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
        	'User',
        	'Admin',
        ];

        foreach ($roles as $role) {
        	Role::firstOrCreate(['name' => $role]);
        }
    }
}
