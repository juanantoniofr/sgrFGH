<?php
return array (

	// PL -> Plan
	// ES -> Estudios
	// ....
	// DUR -> Cuatrimestre (C2|C1)
	'columnas' => [ 'PL','ES','C.ASIG.','ASIGNATURA','DUR.','GRP.','CAP.','DNI','PROFESOR',
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
	);
?>