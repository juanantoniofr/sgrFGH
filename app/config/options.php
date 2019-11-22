<?php

return array (

	//Último día de la semana en curso para poder reservar para la semana siguiente (en este caso es el jueves día 4 de la semana)
	'ant_ultimodia' => '4', 

	//Dias de antelación minima (7 - ant_minDias)
	'ant_minDias' => '3',

	//Número de semanas de antelación minima (en este caso Una semana)
	'ant_minSemanas' => '1',

	//Máximo de horas a la semana para usuarios del perfil alumno
	'max_horas'	=> '12',
 
	//eventos que generan mail
	'required_mail' => array('add' => 0,
							 'edit' => 1,
							 'del'	=> 2,
							 'allow' => 3,
							 'deny' => 4,
							 'request' => 5,
							 ),
	'fecha_caducidadAlumnos'	=> '2020-09-30',
	'fin_cursoAcademico' 		=> '2020-07-31',
	'inicio_cursoAcademico' 	=> '2019-09-23',
	'inicio_titulospropios'		=> '2019-09-23',
	'userexcluded'				=> array('morenobujez','paz'),
	
	'inicio_gestiondesatendida' => '2019-10-01',
	
	//definición de perfiles (roles//capacidades)
	'perfiles' => array(	'1' =>	'Usuarios (Alumnos)',
							'2'	=>	'Usuarios Avanzados (PDI & PAS de Administración)',
							'3'	=>	'Tecnicos (PAS Técnico MAV)',
							'4'	=>	'Administradores de SGR',
							'5'	=>	'Validadores (Dirección-Decanato)',
							'6'	=>	'Supervisores (Responsable Unidad)',
	),

	'homeByrol'	=> array(	'1' =>	'calendarios.html',
							'2'	=>	'calendarios.html',
							'3'	=>	'calendarios.html',
							'4'	=>	'admin/home.html',
							'5'	=>	'validador/home.html',
							'6'	=>	'admin/listarecursos.html',
	),
	'dropdownMenu' => array('1' =>	'emptydropdown',
							'2'	=>	'emptydropdown',
							'3'	=>	'emptydropdown',
							'4'	=>	'admin.dropdown',
							'5'	=>	'validador.dropdown',
							'6'	=>	'tecnico.dropdown',
	
	),


	'gestionAtendida' 	=> 'Atendida (requiere validación)',
	'gestionDesatendida' => 'Desatendida (sin validación)', 
	'colectivos' => array('PAS','PDI','Alumno'),
	'userdelegacionalumnos' => array('sarpende','pabgonrob'),
	'ssologin' => false,
	'nombreSitio' => 'Facultad de Geografía e Historia',
	'nombreUnidad' => 'Unidad Tic. FGH',
	'tipoActividad' => array(	
								array(	'codigo'	=> 'ACT-INV',
										'actividad' => 'Actividades de Investigación',
										'roles' => '1,2,3,4,5,6'),
								array(	'codigo'	=> 'AUT-APR',
										'actividad' => ' Autoaprendizaje',
										'roles' => '1,2,3,4,5,6'),
								array(	'codigo'	=> 'CAM-INC',
										'actividad' => 'Cambio por Incidencia',
										'roles' => '1,2,3,4,5,6'),
								array(	'codigo'	=> 'CES-INS',
										'actividad' => 'Cesión de Espacios a Otras Instituciones',
										'roles' => '1,2,3,4,5,6'),
								array(	'codigo'	=> 'CES-REM',
										'actividad' => 'Cesión Remunerada de Espacios',
										'roles' => '1,2,3,4,5,6'),
								array(	'codigo'	=> 'CON-DEP',
										'actividad' => 'Consejo de Departamento',
										'roles' => '1,2,3,4,5,6'),	
								array(	'codigo'	=> 'CUR-EXT',
										'actividad' => 'Cursos Extranjeros',
										'roles' => '1,2,3,4,5,6'),
								array(	'codigo'	=> 'DEF-TES',
										'actividad' => 'Defensa Tesis Doctorales',
										'roles' => '1,2,3,4,5,6'),
								array(	'codigo'	=> 'DEF-TFG',
										'actividad' => 'Defensa TFG',
										'roles' => '1,2,3,4,5,6'),
								array(	'codigo'	=> 'DEF-TFM',
										'actividad' => 'Defensa FTM',
										'roles' => '1,2,3,4,5,6'),
								array(	'codigo'	=> 'DOC-GRA',
										'actividad' => 'Docencia Reglada POD Grados',
										'roles' => '1,2,3,4,5,6'),
								array(	'codigo'	=> 'DOC-MAS',
										'actividad' => 'Docencia Reglada POD Máster',
										'roles' => '1,2,3,4,5,6'),
								array(	'codigo'	=> 'EVE',
										'actividad' => 'Eventos',
										'roles' => '1,2,3,4,5,6'),
								array(	'codigo'	=> 'EXE',
										'actividad' => 'Exámenes',
										'roles' => '1,2,3,4,5,6'),	
								array(	'codigo'	=> 'EXP',
										'actividad' => 'Exposiciones',
										'roles' => '1,2,3,4,5,6'),
								array(	'codigo'	=> 'MAN',
										'actividad' => 'Mantenimiento',
										'roles' => '1,2,3,4,5,6'),
								array(	'codigo'	=> 'OTR-DOC',
										'actividad' => 'Otras actividades de Docencia',
										'roles' => '1,2,3,4,5,6'),
								array(	'codigo'	=> 'REU-GRM',
										'actividad' => 'Reunión Grupo de Mejora',
										'roles' => '1,2,3,4,5,6'),
								array(	'codigo'	=> 'REU-COM',
										'actividad' => 'Reuniones Comisiones',
										'roles' => '1,2,3,4,5,6'),
								array(	'codigo'	=> 'REU-PAS',
										'actividad' => 'Reuniones PAS',
										'roles' => '1,2,3,4,5,6'),
								),


	);


?>