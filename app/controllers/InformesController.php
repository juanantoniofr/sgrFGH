<?php

class InformesController extends BaseController {
	

	//Vista de incio
	public function index(){
		
		//Menú de opción 
		$dropdown = Auth::user()->dropdownMenu();
		
		//variables para formulario modal para filtar eventos.
		$titulaciones = Titulacion::all();
		
		//se devuelve la vista calendario.
		$aMediosDisponibles = Config::get('mediosdisponibles.medios');
		
		return View::make('informes.index')->nest('dropdown',$dropdown)->nest('sidebar','informes.sidebar',compact('aMediosDisponibles','titulaciones'))->nest('msgInicio','informes.msgInicio');
	
		//Quitamos sidebar: ->nest('sidebar','sidebar',array('msg' => $msg,'grupos' => $groupWithAccess))
	}

	 /**
        * llamada ajax, devuelve el calendario de eventos con los filtros de entrada
        * 
        * @param 
        *
        * @return $respuesta :View::make 
    */
	public function getEventosByFiltros(){

		//Inputs
		$f_inicio_filtro = Input::get('f_inicio',Config::get('calendarioLectivo.f_inicio_curso'));
		$f_fin_filtro = Input::get('f_fin',Config::get('calendarioLectivo.f_fin_curso'));
		$aDias = Input::get('aDias',[1,2,3,4,5]); //filtra por fías de la semana // por defecto selecciona evento de todos los dias
		$h_inicio = Input::get('h_inicio','8:30');
		$h_fin = Input::get('h_fin','21:30');
		$aforomax = Input::get('aforomax','');
		$aforoexam = Input::get('aforoexam','');
		//$medios = Input::get('medios',Config::get('mediosdisponibles.codigos'));
		$medios = Input::get('medios',array());
		$aCodigosTitulaciones = Input::get('aCodigosTitulaciones',array());
		$aCodigosAsignaturas = Input::get('aCodigosAsignaturas',array());
		$aIdProfesores = Input::get('aIdProfesores',array());

		//Outputs
		$id_grupos = array(''); //identificadores de grupos de alumnos de cada asignatura
		
		//Code obtener identificadores de grupos de alumnos según criterios de filtrado

		//Filtro por titulaciones
		$aTitulaciones = array();
		if ( !empty($aCodigosTitulaciones) ){
			
			$aTitulaciones = Titulacion::whereIN('codigo',$aCodigosTitulaciones)->get();

			Titulacion::whereIN('codigo',$aCodigosTitulaciones)->get()->each(function($titulacion) use (&$id_grupos) {

										$titulacion->asignaturas->each(function($asignatura) use (&$id_grupos) {

											$asignatura->gruposAsignatura->each(function($g) use (&$id_grupos){
												$id_grupos[] = $g->id;	
											});
										});
			});
		}

		//Filtro por asignaturas (value = all => todas las asignaturas)
		if (!empty($aCodigosAsignaturas) && in_array('all', $aCodigosAsignaturas) == false){
			//tenemos que eliminar del array $id_grupos, aquellos identificadores que no coinciden con los grupos de las asignaturas seleccionadas
			$id_grupos = array('');
			Asignatura::whereIN('codigo',$aCodigosAsignaturas)->get()->each(function($asignatura) use (&$id_grupos) {

						//$titulacion->asignaturas->whereIN('codigo',$aCodigosAsignaturas)->get()->each(function($asignatura) use (&$id_grupos) {

											$asignatura->gruposAsignatura->each(function($g) use (&$id_grupos){
												$id_grupos[] = $g->id;	
											});
										//});
			});
		}

		//Filtro por profesores (value = all => todos/as los/as profesores/as)
		if (!empty($aIdProfesores) && in_array('all', $aIdProfesores) == false){
			//tenemos que eliminar del array $id_grupos, aquellos identificadores que no coinciden con los grupos de las asignaturas seleccionadas
			$id_grupos = array('0');
			Profesor::whereIN('id',$aIdProfesores)->get()->each(function($profesor) use (&$id_grupos) {

						//$titulacion->asignaturas->whereIN('codigo',$aCodigosAsignaturas)->get()->each(function($asignatura) use (&$id_grupos) {

											$profesor->gruposAsignatura->each(function($g) use (&$id_grupos){
												$id_grupos[] = $g->id;	
											});
										//});
			});
		}

		$recursos = Recurso::whereHas('events', function($e) use ($f_inicio_filtro,$f_fin_filtro,$aDias,$id_grupos) {
    					
    					$e->where('fechaEvento','>=',Date::toDB($f_inicio_filtro))->where('fechaEvento','<=',Date::toDB($f_fin_filtro))->whereIn('dia',$aDias)->whereIN('grupos_asignatura_id',$id_grupos);
    				})->get();
		
		//filtar por hora de inicio y hora fin de eventos
		$recursos = $recursos->filter(function($r) use ($h_inicio,$h_fin){

				$resultado = true;
				$r->events->each(function($e) use ($h_inicio,$h_fin,&$resultado){
					if ( strtotime($e->horaInicio) >= strtotime($h_fin) ) $resultado = false; 
					if (  strtotime($e->horaFin) <= strtotime($h_inicio) ) $resultado = false;
				});
			    return $resultado;
		});

		//filtar por aforo máximo
		if (!empty($aforomax)){
			
			$recursos = $recursos->filter(function($r) use($aforomax){
				
				return ($r->aforomaximo >= $aforomax);
			});
		}

		//filtar por aforo examen
		if (!empty($aforoexam)){
			
			$recursos = $recursos->filter(function($r) use($aforoexam){
				
				return ($r->aforoexamen >= $aforoexam);
			});
		}


		//filtar por medios
		foreach ($medios as $medio) {
			
			$recursos = $recursos->filter(function($r) use($medio){
				
				$mediosdisponibles = explode(',',json_decode($r->mediosdisponibles,true)['medios']);
				return ( in_array($medio, $mediosdisponibles) );
			});
		}

		$numeroRecursos = $recursos->count();

		//$resultado = View::make('informes.resultado',compact('recursos','id_grupos','aCodigosAsignaturas','aDias','numeroRecursos'))->nest('thead','informes.thead');
		if (Input::get('generaPdf') == true){

			$html = '<html><body>VARIABLE = TRUE ' . View::make('informes.resultado',compact('recursos','aDias')) . '</body></html>';
			return PDF::load($html, 'A4', 'portrait')->show();
		}
		else {

			$resultado = View::make('informes.resultado',compact('recursos','aDias'))->nest('thead','informes.thead');
			return $resultado;	
		}
		
	}


	/**
		* Genera informe de coupación // horario de clase (borrar solo para test- borrar)
		*
		*
	*/
	public function getPdfInforme(){


		//$html = View::make('informes.resultado',array($recursos = array(),$aDias = array()));
		//$nombreFichero = '_test';//.$recurso->nombre;
		//$result = myPDF::getPDF($html,$nombreFichero);
		//return $html;
   		//return Response::make($result)->header('Content-Type', 'application/pdf');
		$html = '<html><body>'
			. '<p>Put your html here, or generate it with your favourite '
			. 'templating system.</p>'
			. '</body></html>';
		return PDF::load($html, 'A4', 'portrait')->show();

	}

	
}//fin del controlador