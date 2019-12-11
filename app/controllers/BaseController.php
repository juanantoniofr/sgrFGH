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

}