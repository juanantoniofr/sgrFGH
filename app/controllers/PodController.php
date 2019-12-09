<?php

class PodController extends BaseController {

	private $warningSolapesCSV	= array();
	private $warningSolapesDB	= array();
	private $success		 	= array();
	private $warningNoLugar		= array();

	public function index(){

		$dropdown = Auth::user()->dropdownMenu();
		$test = array();
	
		return View::make('pod.index')->with(compact('test'))->nest('dropdown',$dropdown);	
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
	public function savePOD(){

		//control de errores formulario
		$file = Input::file('csvfile');
		$dropdown = Auth::user()->dropdownMenu();

		if (empty($file)){
			Session::flash('msg-error','No se ha seleccionado ningún archivo csv'); 
			return View::make('pod.index')->nest('dropdown',$dropdown);	
		}

		$csv = new sgrCsv(Config::get('csvpod.columnas'),Config::get('csvpod.evento'),$file);

		$isValid = $csv->isValidCsv();
		if ($isValid['error'] == true){
			Session::flash('msg-error','No se ha seleccionado ningún archivo csv'); 
			return View::make('pod.index')->with(compact('test','aSinAula'))->nest('dropdown',$dropdown);	
		}

		$f = $csv->open();
		$csv->leeFila();

		if ($csv->compruebaCabeceras() == false){
			Session::flash('msg-error','Error al leer cabeceras archivos csv xxx');
			$f = $csv->close();
			return View::make('pod.index')->with(compact('test','aSinAula'))->nest('dropdown',$dropdown); 
		}
		
		$i = 0;
		$numfila = 2;
		while ( $csv->leeFila() != false ){
			$eventos[$i]['numfila'] = $numfila;
			$eventos[$i]['asignatura'] = $csv->getValue(Config::get('csvpod.evento')['asignatura']);
			$eventos[$i]['profesor'] = $csv->getValue(Config::get('csvpod.evento')['profesor']);
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
		

		$aSinAula = array();
		$aSolapesCsv = array();
		$aSolapesBD = array();
		$aEventosValidos = array();
		foreach ($eventos  as $evento) {
			$exclude = false;
			if (!$this->existeAula($evento)) {$aSinAula[] = $evento; $exclude = true;}
		 	if ($this->solapaCsv($eventos,$evento)) {$aSolapesCsv[] = $evento; $exclude = true;}
		 	if ($this->solapaBD($evento)) {$aSolapesBD[] = $evento; $exclude = true;}   
			if(!$exclude) $aEventosValidos[] = $evento;
		}
		
		return View::make('pod.index')->with(compact('aSinAula','aSolapesCsv','aSolapesBD','aEventosValidos'))->nest('dropdown',$dropdown);
	}

	private function save($data,$numFila,$recurso,$evento_id){
		
		$result = true;
		$fechaDesde = Date::dateCSVtoSpanish($data['F_DESDE_HORARIO1']);
		$fechaHasta = Date::dateCSVtoSpanish($data['F_HASTA_HORARIO1']);
		
		$nRepeticiones = Date::numRepeticiones($fechaDesde,$fechaHasta,$data['COD_DIA_SEMANA']);

		
		
		

		for($j=0;$j < $nRepeticiones; $j++ ){ //foreach 
				$evento = new Evento();
	
				//evento periodico o puntual??			
				if ($nRepeticiones == 1) $evento->repeticion = 0;
				else $evento->repeticion = 1;

				
				$evento->evento_id = $evento_id;
				//fechas de inicio y fin
				$evento->fechaFin = Date::toDB(Date::dateCSVtoSpanish($data['F_HASTA_HORARIO1']),'-');//¿por que, no es $fechaDesde ya calculado??
				$evento->fechaInicio = Date::toDB(Date::dateCSVtoSpanish($data['F_DESDE_HORARIO1']),'-');
				
				//fecha Evento
				$startDate = Date::timeStamp_fristDayNextToDate(Date::dateCSVtoSpanish($data['F_DESDE_HORARIO1']),$data['COD_DIA_SEMANA']);
				$currentfecha = Date::currentFecha($startDate,$j);
				$evento->fechaEvento = Date::toDB($currentfecha,'-');

				//horario
				$evento->horaInicio = $data['INI'];
				$evento->horaFin = $data['FIN'];

				//obtner identificador de recurso (espacio o medio)
				//$evento->recurso_id = $this->getRecursoByIdLugar($data['ID_LUGAR']);
				$evento->recurso_id = $recurso->id;
				
				$evento->estado = 'aprobada';
				//código día de la semana
				$evento->diasRepeticion = json_encode($data['COD_DIA_SEMANA']);
				$evento->dia = $data['COD_DIA_SEMANA'];
			
				$evento->titulo = $data['ASIGNATURA'] . ' - ' . $data['NOMCOM'];
				$evento->asignatura = $data['ASIGNATURA'];
				$evento->profesor = $data['NOMCOM'];
				$evento->actividad = 'Docencia Reglada P.O.D';
				
				$evento->dia = $data['COD_DIA_SEMANA'];
				//Asignamos a usuario que carga el pod
				$userPOD = User::where('username','=','pod')->first(); 
				//$evento->user_id = Auth::user()->id;
				$evento->user_id      = $userPOD->id;
				$evento->reservadoPor = $userPOD->id;
				$evento->save();
			
		}//fin foreach
		

		return $result;
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

		$nRepeticiones = Date::numRepeticiones($f_desde,$f_hasta,$diaSemana);

		for($j=0;$j < $nRepeticiones; $j++ ){ //foreach 
			
			//fecha Evento
			$start = Date::timeStamp_fristDayNextToDate($f_desde,$diaSemana);
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
	public function solapaCsv($eventos,$evento){

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