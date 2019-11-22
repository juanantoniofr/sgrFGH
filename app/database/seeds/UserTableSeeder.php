<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('users')->delete();

		// userAdmin
		User::create(array(
				'username' => 'admin',
				'password' => Hash::make('111'),
				'caducidad' => 123456789,
				'capacidad' => '3'
			));

		// userAlumno
		User::create(array(
				'username' => 'alumno',
				'password' => Hash::make('111'),
				'caducidad' => 123456789,
				'capacidad' => '2'
			));

		// userPAS
		User::create(array(
				'username' => 'pas',
				'password' => Hash::make('111'),
				'caducidad' => 123123123,
				'capacidad' => '1'
			));
	}
}