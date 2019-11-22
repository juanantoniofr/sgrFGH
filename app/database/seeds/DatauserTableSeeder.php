<?php

class DatauserTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('datausers')->delete();

		// root
		Datauser::create(array(
				'nombre' => 'Administrador',
				'apellidos' => 'fcom',
				'email' => 'fcom@us.es',
				'colectivo' => 'PAS',
				'tratamiento' => 'Sr',
				'telefono' => '59611',
				'user_id' => 1
			));

		// alumno
		Datauser::create(array(
				'nombre' => 'Alumno',
				'apellidos' => 'Probando',
				'email' => 'alum@us.es',
				'colectivo' => 'alumnos',
				'tratamiento' => 'Don',
				'telefono' => '009900',
				'user_id' => 2
			));

		// PAS
		Datauser::create(array(
				'nombre' => 'Técnico',
				'apellidos' => 'Fcom',
				'email' => 'tfcom@us.es',
				'colectivo' => 'PAS',
				'tratamiento' => 'Sr',
				'telefono' => '445566',
				'user_id' => 3
			));
	}
}