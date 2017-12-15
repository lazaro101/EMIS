<?php

use Illuminate\Database\Seeder;

class UsersTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('users')->insert(
	        [
	        'username' => 'admin',
	        'password' => bcrypt('admin'),
	        'role' => 'admin',
	        'display_name' => 'admin',
	        'email' => '',
	        'created_at' => date_create('now'),
	        'updated_at' => date_create('now'),
	        ]);
    }
}
