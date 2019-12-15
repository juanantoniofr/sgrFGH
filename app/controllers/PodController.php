<?php

class PodController extends BaseController {

	private $warningSolapesCSV	= array();
	private $warningSolapesDB	= array();
	private $success		 	= array();
	private $warningNoLugar		= array();

	
	/**
        * Index: formulario input file csv
        *
		* @param void
		*
        * @return View :View::make()
        *
        *
    */
	public function index(){

		$dropdown = Auth::user()->dropdownMenu();

		return View::make('pod.index')->nest('dropdown',$dropdown);	
	}

	/**
        * 
        * Analiza ficehro csv y devuelve la vista con los errores que no se vuelcan a la BD y filas del csv salvadas a BD 
        * 
        * @param Input::file('csvfile') :File
        *
        * @return View :View::make()
        *
        *
    */
	public function compruebaCsv(){

		//return
		$aSinAula = array();
		$aSolapesCsv = array();
		$aSolapesBD = array();
		$aEventosValidos = array();
		$dropdown = Auth::user()->dropdownMenu();

		//@inputcontrol de errores formulario
		$file = Input::file('csvfile');

		if (empty($file)){
			Session::flash('msg-error','No se ha seleccionado ningún archivo csv'); 
			return View::make('pod.index')->nest('dropdown',$dropdown);	
		}

		$csv = new sgrCsv(Config::get('csvpod.columnas'),Config::get('csvpod.evento'),$file);

		$isValid = $csv->isValidCsv();
		if ($isValid['error'] == true){
			Session::flash('msg-error','No se ha seleccionado ningún archivo csv'); 
			return View::make('pod.index')->nest('dropdown',$dropdown);	
		}

		$f = $csv->open();
		$csv->leeFila();

		if ($csv->compruebaCabeceras() == false){
			Session::flash('msg-error','Error al leer cabeceras archivos csv xxx');
			$f = $csv->close();
			return View::make('pod.index')->nest('dropdown',$dropdown); 
		}
		
		$i = 0;
		$numfila = 2;
		while ( $csv->leeFila() != false ){
			$eventos[$i]['numfila'] = $numfila;

			$eventos[$i]['codigoTitulacion'] = $csv->getValue(Config::get('csvpod.evento')['codigoTitulacion']);

			$eventos[$i]['asignatura'] = $csv->getValue(Config::get('csvpod.evento')['asignatura']);
			$eventos[$i]['codigo'] = $csv->getValue(Config::get('csvpod.evento')['codigo']);
			$eventos[$i]['cuatrimestre'] = $csv->getValue(Config::get('csvpod.evento')['cuatrimestre']);

			$eventos[$i]['grupo'] = $csv->getValue(Config::get('csvpod.evento')['grupo']);
			$eventos[$i]['capacidad'] = $csv->getValue(Config::get('csvpod.evento')['capacidad']);

			$eventos[$i]['profesor'] = $csv->getValue(Config::get('csvpod.evento')['profesor']);
			$eventos[$i]['dni'] = $csv->getValue(Config::get('csvpod.evento')['dni']);


			$eventos[$i]['aula'] = $csv->getValue(Config::get('csvpod.evento')['aula']);
			$eventos[$i]['f_desde'] = $csv->getValue(Config::get('csvpod.evento')['f_desde']);
			$eventos[$i]['f_hasta'] = $csv->getValue(Config::get('csvpod.evento')['f_hasta']);
			$eventos[$i]['diaSemana'] = $csv->getValue(Config::get('csvpod.evento')['codigoDia']);
			$eventos[$i]['h_inicio'] = $csv->getValue(Config::get('csvpod.evento')['h_inicio']);
			$eventos[$i]['h_fin'] = $csv->getValue(Config::get('csvpod.evento')['h_fin']);
			$eventos[$i]['codigoDia'] = $csv->getValue(Config::get('csvpod.evento')['codigoDia']);
			$i++;
			$numfila++;
		}
		$csv->close();
		

		
		foreach ($eventos  as $evento) {
			$exclude = false;
			if (!$this->existeAula($evento)) {$aSinAula[] = $evento; $exclude = true;}
		 	if ($this->solapaCsv($eventos,$evento)) {$aSolapesCsv[] = $evento; $exclude = true;}
		 	if ($this->solapaBD($evento)) {$aSolapesBD[] = $evento; $exclude = true;}   
			if(!$exclude) $aEventosValidos[] = $evento;
		}
		
		return View::make('pod.index')->nest('resultadoComprobacionCsv','pod.resultadoComprobacionCsv',compact('aSinAula','aSolapesCsv','aSolapesBD','aEventosValidos'))->nest('dropdown',$dropdown);
	}


	/**
        * 
        * Salva eventos válidos definidos en csv a BD 
        * 
        * @param $eventos :Json // Eventos válidos cvs
        *
        * @return $resultado :View::make()
        *
        *
    */
    /*
    json eventos:

	{"0":{"numfila":26,"asignatura":"\"La Rep\u00fablica de Indios\": Status Jur\u00eddico, Social y Laboral","profesor":"DELIBES MATEOS ,ROCIO","aula":"AULA XV","f_desde":"24\/02\/2020","f_hasta":"26\/03\/2020","diaSemana":"1","h_inicio":"15:00","h_fin":"17:00","codigoDia":"1"},"1":{"numfila":27,"asignatura":"\"La Rep\u00fablica de Indios\": Status Jur\u00eddico, Social y Laboral","profesor":"DELIBES MATEOS ,ROCIO","aula":"AULA XV","f_desde":"24\/02\/2020","f_hasta":"26\/03\/2020","diaSemana":"3","h_inicio":"15:00","h_fin":"17:00","codigoDia":"3"},"2":{"numfila":28,"asignatura":"\"La Rep\u00fablica de Indios\": Status Jur\u00eddico, Social y Laboral","profesor":"DELIBES MATEOS ,ROCIO","aula":"AULA XV","f_desde":"24\/02\/2020","f_hasta":"26\/03\/2020","diaSemana":"5","h_inicio":"15:00","h_fin":"17:00","codigoDia":"5"},"3":{"numfila":29,"asignatura":"\"La Rep\u00fablica de Indios\": Status Jur\u00eddico, Social y Laboral","profesor":"DELIBES MATEOS ,ROCIO","aula":"AULA XV","f_desde":"27\/03\/2020","f_hasta":"27\/03\/2020","diaSemana":"5","h_inicio":"15:00","h_fin":"19:00","codigoDia":"5"}}
    
    */
	public function salvaEventosCsv(  ){
		
		$eventos = Input::get('eventos', '');
		
		if (empty($eventos)) return 'No hay eventos que salvar';
		
		$aEventos = json_decode($eventos);

		$resultado = array(	'resultAsignatura' 	=> array(),
							'resultEvento'		=> array( 	'error' => array(), 
															'exito' => array()
														),
						);	

		foreach ($aEventos as $evento) {

			$e['aula'] = $evento->aula;
			$e['f_desde'] = $evento->f_desde; // 	formato --> d/m/Y
			$e['f_hasta'] = $evento->f_hasta; //	formato --> d/m/Y
			$e['h_inicio'] = $evento->h_inicio;
			$e['h_fin'] = $evento->h_fin;
			$e['codigoDia'] = $evento->codigoDia;
			$e['numfila'] = $evento->numfila;

			$codigoTitulacion = $evento->codigoTitulacion;

			$aAsignatura = array(
                            'asignatura'	=> $evento->asignatura,
                            'codigo' 		=> $evento->codigo,
                            'cuatrimestre' 	=> $evento->cuatrimestre,
                            );
			
			$aProfesor = array(
                            'dni' 		=> $evento->dni,
                            'profesor' 	=> $evento->profesor,
                            );

			$aGrupo = array (
                        'grupo' 	=> $evento->grupo,
                        'capacidad' => $evento->capacidad,
                        );
			
			$recurso = Recurso::where('nombre','=',$e['aula'])->first();
			if ( $recurso  == NULL ) {
				$resultado['resultEvento']['error'][]  = 'Error al salvar evento con número de fila: ' . $evento->numfila . 'No se encontró Aula'; //No hay solape por que no hay recurso en BD.
				return $resultado;
			}
			
			$e['recurso_id'] = $recurso->id;

			//Solape DB??
			if ( $this->solapaBD($e) ) {
				$resultado['resultEvento']['error'][]  = 'Error al salvar evento con número de fila: ' . $evento->numfila . ' --> Solapa en DB!!';
				return $resultado;
			}
			

			//Update Titulación -> asignatura -> grupo -> profesor, salaFila definida en BaseController
			$resultado['resultAsignatura'] = $this->salvaFila($codigoTitulacion,$aAsignatura,$aGrupo,$aProfesor);

			//identificador único para todos los eventos.
			do {
				$evento_id = md5(microtime());
			} while (Evento::where('evento_id','=',$evento_id)->count() > 0);
			
			$e['evento_id'] = $evento_id;

			$e['titulo'] = $evento->asignatura . ' - ' . $evento->profesor;
			$e['asignatura'] = $evento->asignatura;
			$e['codigoAsignatura'] = $evento->codigo;
			$e['grupo'] = $evento->grupo;
			$e['profesor'] = $evento->profesor; 
			$e['codigoTitulacion'] = $evento->codigoTitulacion;
			
			//método definido en BaseController.php
			if ( $this->salvaEvento($e) != true) {
				$resultado['resultEvento']['error'][]  = 'Error al salvar evento con número de fila: ' . $evento->numfila;
				return $resultado;
			}
			
			$resultado['resultEvento']['exito'][] = 'Evento con número de fila = ' . $evento->numfila . ', salvado con éxito';			 
		}

		return $resultado;
	}

	/**
        * 
        * True si exite Aula en el evento leido del csv, false en caso contrario
        * 
        * @param $evento :array
        *
        * @return $resultado :booleano   
        *
        *
    */
	private function existeAula($evento){
		
		$resultado = false;

			$recurso = Recurso::where('nombre','=',$evento['aula'])->get();

			if($recurso->count() > 0) $resultado = true;

		return $resultado;
	}

	/**
        * 
        * True si hay solapamiento con otro evento en BD, false en caso contrario
        * 
        * @param $evento :array
        *
        * @return $resultado :booleano   
        *
        *
    */
	private function solapaBD($evento){
		
		$aula = $evento['aula'];
		$f_desde = $evento['f_desde'];// 	formato --> d/m/Y
		$f_hasta = $evento['f_hasta'];//	formato --> d/m/Y
		$h_inicio = $evento['h_inicio'];
		$h_fin = $evento['h_fin'];
		$diaSemana = $evento['codigoDia'];
		$numfila = $evento['numfila'];
		
		$recurso = Recurso::where('nombre','=',$aula)->first();
		if ( $recurso  == NULL ) return false; //No hay solape por que no hay recurso en BD.

		$nRepeticiones = Date::numRepeticiones($f_desde,$f_hasta,$diaSemana,'/');

		for($j=0;$j < $nRepeticiones; $j++ ){ //foreach 
			
			//fecha Evento
			$start = Date::timeStamp_fristDayNextToDate($f_desde,$diaSemana,'/');
			$currentfecha = Date::currentFecha($start,$j);
			
			if ( 0 < Calendar::getNumSolapamientos($recurso->id,$currentfecha,$h_inicio,$h_fin) ){
					//hay solape: fin -> return true
					return true;
					}	
		}//fin foreach repeticion periodica
		

		return false;
	}

	/**
        * 
        * True si exite Aula en el evento leido del csv, false en caso contrario
        * 
        * @param $eventos: Array (todos los eventos leidos en el csv)
        * @param $evento :Array (evento a verificar solapamiento)
        *
        * @return  :Booleano true si solapa, false en caso contrario
        *
        *
    */
	private function solapaCsv($eventos,$evento){

		$aula = $evento['aula'];
		$f_desde = $evento['f_desde'];//d-m-Y
		$f_hasta = $evento['f_hasta'];//d-m-Y
		$h_inicio = $evento['h_inicio'];
		$h_fin = $evento['h_fin'];
		$diaSemana = $evento['codigoDia'];
		$numfila = $evento['numfila'];
		
		foreach ($eventos as $eventoCsv) {
							
			if ($eventoCsv['aula'] == $aula && $eventoCsv['codigoDia'] == $diaSemana && $eventoCsv['numfila'] != $numfila){
				//posible solapamiento
				if ( 
					(
						( Date::getTimeStamp($eventoCsv['f_desde'],'/') <= Date::getTimeStamp($f_hasta,'/') && Date::getTimeStamp($f_hasta,'/') <= Date::getTimeStamp($eventoCsv['f_hasta'],'/') ) 
					
						|| 
					 
						( Date::getTimeStamp($eventoCsv['f_desde'],'/') <= Date::getTimeStamp($f_desde,'/') && Date::getTimeStamp($f_desde,'/') <= Date::getTimeStamp($eventoCsv['f_hasta'],'/') ) 
					)

					&&

					(
						( strtotime($eventoCsv['h_inicio']) <= strtotime($h_inicio) && strtotime($eventoCsv['h_fin']) > strtotime($h_inicio) )
					
						||

						( strtotime($eventoCsv['h_inicio']) < strtotime($h_fin) && strtotime($eventoCsv['h_fin']) >= strtotime($h_fin) )	

					)	
					 ){
					 //hay solapamiento
						return true;//$solapamientos['eventoFila'] = $numfila;
						//$solapamientos['filasSolapes'][] = $eventoCsv['numfila'];
				}//segundo if
			} //primer if
				
		}//fin del foreach
		
		return false;
	}


	private function delPOD(){
		
		$userPOD = User::where('username','=','pod')->first();
		$filasAfectadas = Evento::where('user_id','=',$userPOD->id)->delete();
	}
}