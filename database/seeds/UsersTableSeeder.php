<?php

use App\User;
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
			User::create([
				'first_name' => 'Programador',
				'last_name' => 'Web',
				'email' => 'programador@dimacros.net',
				'password' => bcrypt('123456'),
				'role' => 'admin'
			]);

			User::create([
				'first_name' => 'Trabajador',
				'last_name' => 'Web',
				'email' => 'trabajador@dimacros.net',
				'password' => bcrypt('123456'),
				'role' => 'employee'
			]);

			User::create([
				'first_name' => 'Cliente',
				'last_name' => 'Hosting',
				'email' => 'cliente@dimacros.net',
				'password' => bcrypt('123456'),
				'role' => 'customer'
			]);		
    }
}
