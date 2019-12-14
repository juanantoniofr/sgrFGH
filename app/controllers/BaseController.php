<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	    /**
        * 
        * Salva a DB los valores de Asignaturas, gruposAsisgnatura y profesor
        * 
        * @param $aAsignatura :array
        * @param $grupoAsignatura :string
        * @param $profesor :string
        * 
        * @return $resultado :array   
        *
        *
    */

	//Used by TitulacionController & CsvController    
    public function salvaFila($codigoTitulacion,$aAsignatura,$aGrupo,$aProfesor){

        $resultado = array('error' => false,
                            'exito' => array(),
                    );

        $titulacion = Titulacion::where('codigo','=',$codigoTitulacion)->first();
        if (!empty($titulacion)){
            // Obtiene $asignatura o la instancia si no existe en DB
            $asignatura = Asignatura::firstOrNew($aAsignatura);
            $asignatura = $titulacion->asignaturas()->save($asignatura); 
            
            $grupo = GrupoAsignatura::firstOrNew( [ 'asignatura_id' => $asignatura->id ]);//$aGrupo);
            $grupo->capacidad = $aGrupo['capacidad'];
            $grupo->grupo = $aGrupo['grupo'];
            $grupo = $asignatura->gruposAsignatura()->save($grupo);
            
            $profesor = Profesor::firstOrNew($aProfesor);
            $profesor->save();

            if ( empty(($grupo->profesores()->where('profesor_id','=',$profesor->id)->first())) )
                $grupo = $grupo->profesores()->attach($profesor->id);
            
            $resultado['exito'][] = 'Asignatura ' . $asignatura->asignatura . 'salvada con exito.';
        }
        else {
            $resultado['error'] = 'No existe la titulación con ID = ' . $codigoTitulacion;
        }
      
        return $resultado;
    }


    public function salvaEvento(Array $aDataEvento){

    	$f_desde = $aDataEvento['f_desde'];
    	$f_hasta = $aDataEvento['f_hasta'];
    	$cod_dia = $aDataEvento['codigoDia'];

		$nRepeticiones = Date::numRepeticiones($f_desde,$f_hasta,$cod_dia,'/');

		for($j=0;$j < $nRepeticiones; $j++ ){ //foreach 
				
				$evento = new Evento();
	
				//evento periodico o puntual??			
				if ($nRepeticiones == 1) $evento->repeticion = 0;
				else $evento->repeticion = 1;
				

				$evento->evento_id = $aDataEvento['evento_id'];
				//fechas de inicio y fin
				$evento->fechaFin = Date::toDB($f_hasta,'/');
				$evento->fechaInicio = Date::toDB($f_desde,'/');
				
				//fecha Evento
				//timeStamp_fristDayNextToDate --> Return date with format (dia-mes-año)	
				$startDate = Date::timeStamp_fristDayNextToDate($f_desde,$cod_dia,'/');
				$currentfecha = Date::currentFecha($startDate,$j);
				$evento->fechaEvento = Date::toDB($currentfecha,'-');

				//horario
				$evento->horaInicio = $aDataEvento['h_inicio'];
				$evento->horaFin = $aDataEvento['h_fin'];

				
				$evento->recurso_id = $aDataEvento['recurso_id'];//recurso->id;
				
				$evento->estado = 'aprobada';
				//código día de la semana
				$evento->diasRepeticion = json_encode($cod_dia);
				$evento->dia = $cod_dia;
			
				$evento->titulo = $aDataEvento['titulo'];
				$evento->asignatura = $aDataEvento['asignatura'];
				$evento->profesor = $aDataEvento['profesor'];
				$titulacion = Titulacion::where('codigo','=',$aDataEvento['codigoTitulacion'])->first();
				$aPod = Config::get('options.tipoTitulacion');
				if ($titulacion->tipo == "Grado") $evento->actividad = $aPod['Grado'];
				if ($titulacion->tipo == "Máster") $evento->actividad = $aPod['Master'];
				
				$evento->dia = $cod_dia;
				//Asignamos a usuario que carga el pod
				$userAdmin = User::where('username','=','admin')->first(); 
				//$evento->user_id = Auth::user()->id;
				$evento->user_id      = $userAdmin->id;
				$evento->reservadoPor = $userAdmin->id;
				if ( $evento->save() != true ) return false;
		}//fin foreach
		
		return true;
    }

}