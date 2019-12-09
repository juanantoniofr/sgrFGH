<?php
return array (

	// PL -> Plan
	// ES -> Estudios
	// ....
	// DUR -> Cuatrimestre (C2|C1)
	'columnas' => [ 'PL','ES','C.ASIG.','ASIGNATURA','R','DUR.','GRP.','CAP.','CRED.','DNI','PROFESOR',
					'F_DESDE','F_HASTA','C.DIA','DIA','H_INICIO','H_FIN','AULA'],
	'asignatura' => array(	'asignatura' => 'ASIGNATURA',
							'codigo' => 'C.ASIG.',
							'cuatrimestre' => 'DUR.',
						),

	'grupo' => array('grupo' => 'GRP.',
					'capacidad' => 'CAP.'
				),

	'profesor' => array('dni' => 'DNI',
						'profesor' => 'PROFESOR',
					),

	'titulacion' => array('codigo' => 'ES',
						),
	'evento' => array(	'f_desde' => 'F_DESDE',
						'f_hasta' => 'F_HASTA',
						'codigoDia' => 'C.DIA',
						'stringDia' => 'DIA',
						'h_inicio' => 'H_INICIO',
						'h_fin' => 'H_FIN',
						'aula' => 'AULA',
						'asignatura' => 'ASIGNATURA',
						'profesor' => 'PROFESOR',
					),
	);
?>