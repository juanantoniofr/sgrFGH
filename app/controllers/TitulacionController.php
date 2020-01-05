<?php

class TitulacionController extends BaseController {



    /**
         * Listado de titulaciones o estudios
         * 
         * @return View::make('titulaciones.index') listado de titulaciones // cursos // asignaturas // grupos de alumnos // profesor
         * 
         * 
    */
    public function listar(){
      
   	
    	$titulaciones=Titulacion::orderBy('titulacion','ASC')->get();

    	
        $dropdown = Auth::user()->dropdownMenu();

        return View::make('titulaciones.index')->with(compact('titulaciones'))->nest('dropdown',$dropdown)->nest('header','titulaciones.headerMainContainer')->nest('modalNuevaTitulacion','titulaciones.modalNuevaTitulacion')->nest('modalEditaTitulacion','titulaciones.modalEditaTitulacion')->nest('modalEliminaTitulacion','titulaciones.modalEliminaTitulacion')->nest('modalUploadCsv','titulaciones.modalUploadCsv');  
	    //return View::make('admin.recurselist')->with(compact('recursos','sortby','order','grupos','idgruposelected','recursosListados'))->nest('dropdown',Auth::user()->dropdownMenu())->nest('menuRecursos','admin.menuRecursos')->nest('modalAdd','admin.recurseModalAdd',array('grupos'=>$grupos))->nest('modalEdit','admin.recurseModalEdit',array('recursos'=>$grupos))->nest('modalEditGrupo','admin.modaleditgrupo');
    }


    /**
        * Guarda en BD nueva títulacion o estudios
        * 
        * @param Input::get('codigo') :varchar(32) 
        * @param Input::get('titulacion') :varchar(256)
        *
        * @return $respuesta :array, errores de validación de formulario o mensaje de éxito
    */
    public function nuevaTitulacion(){

        //@params
        $codigo = Input::get('codigo','');
        $nombre = Input::get('titulacion','');
        
        //@return
        $respuesta = array( 'error' => false, 
                            'msg'   => '',
                            'errors' => array()
                    );

        //Validación datos formulario.
        $rules = array(
            'codigo'      => 'required|unique:titulaciones',
            'titulacion'  => 'required|unique:titulaciones',
        );

        $messages = array( 'required'   => 'El campo <strong>:attribute</strong> es obligatorio',
                           'unique'    => 'Existe una titulacion con el mismo valor <strong>:attribute</strong>',
                          );
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()){
            $respuesta['error']     =   true;
            $respuesta['msg']       =   'Errores de validación de formulario añadir nueva titulación';
            $respuesta['errors']    =   $validator->errors()->toArray();

            return $respuesta;
        }
        // --end validación formulario

        $nuevaTitulacion = new Titulacion;
        $nuevaTitulacion->codigo = $codigo;
        $nuevaTitulacion->titulacion = $nombre;


        if ($nuevaTitulacion->save())
            Session::flash('message', 'Nueva titulación <strong>'. $nuevaTitulacion->nombre .' </strong> añadida con éxito');
        else 
            Session::flash('message', 'Error al salvar nueva titulación: <strong>'. $titulacion->nombre .' </strong> no se ha añadido a la DB');
        
        return $respuesta;
    }
    

    /**
        * 
        * Obtiene una Titulación desde su id
        * 
        * @param Input::get('id') :int
        * 
        * @return $respuesta :array   
        *
        *
    */
    public function getTitulacion(){


        //@params
        $id = Input::get('id','');
        
        
        //@return
        $respuesta = array( 'error' => false, 
                            'msg'   => '',
                            'errors' => array(),
                            'titulacion' => array(),
                    );

        //Validación datos formulario.
        $rules = array(
            'id'   => 'exists:titulaciones|required',
        );


        $messages = array( 'required'   => 'El campo <strong>:attribute</strong> es obligatorio....',
                           'exits'      => 'No existe titulación con id igual a <strong>:attribute</strong>....',
                          );
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()){
            $respuesta['error']     =   true;
            $respuesta['msg']       =   'Errores de validación de formulario Edita nueva titulación';
            $respuesta['errors']    = $validator->errors()->toArray();

            return $respuesta;
        }

        $respuesta['titulacion'] = Titulacion::find($id)->toArray();

        return $respuesta;
    }

    /**
        * 
        * Procesa archivo csv
        * 
        * @param Input::file('csvfile') :file
        * 
        * @return $resultado :array   
        *
        *
    */
    public function saveCSV(){

        
        $resultado = array('error' => true,
                            'msgError' => '',
                            'msgExito' => array(),
                        );

        $file = Input::file('csvfile'); 
        
        $hasError = false;

        $isValidCsv = $this->isValidCsv($file); 
        if ($isValidCsv['error'] == true){
            Session::flash('msg-error',$isValidCsv['msg-error']);
            $hasError = true;            
        }
        
        if (!$hasError){
        
            $f = fopen($file,"r");
            //Lee nombres de las columnas
            $columnas = fgetcsv($f,0,',','"'); 

            //Hasta final del fichero csv
            $fila = fgetcsv($f,0,',','"'); 
            $resultado = array();
            while ($fila !== false){
                           
                $datos = $this->matchColumnas($columnas,$fila); // $datos = array('nombreColumna' => valor);
                $columAsignatura = Config::get('csvtitulaciones.asignatura');
                $aAsignatura = array(
                            'asignatura' => $this->getValue($datos,$columAsignatura['asignatura']),
                            'codigo' => $this->getValue($datos,$columAsignatura['codigo']),
                            'cuatrimestre' => $this->getValue($datos,$columAsignatura['cuatrimestre']),
                            );
                //return var_dump(($aAsignatura));
                
                $columGrupo = Config::get('csvtitulaciones.grupo');
                $aGrupo = array (
                            'grupo' => $this->getValue($datos,$columGrupo['grupo']),
                            'capacidad' => $this->getValue($datos,$columGrupo['capacidad']),
                        );

                $columProfesor = Config::get('csvtitulaciones.profesor');
                $aProfesor = array(
                                'dni' => $this->getValue($datos,$columProfesor['dni']),
                                'profesor' => $this->getValue($datos,$columProfesor['profesor']),
                            );
                
                $columCodigoTitulacion = Config::get('csvtitulaciones.titulacion');
                $codigoTitulacion = $this->getValue($datos,$columCodigoTitulacion['codigo']);
                $resultado[] = $this->salvaFila($codigoTitulacion,$aAsignatura,$aGrupo,$aProfesor);
                //exit;  
                $fila = fgetcsv($f,0,',','"');
                    
            }
        }

        $titulaciones=Titulacion::orderBy('titulacion','ASC')->get();
        $dropdown = Auth::user()->dropdownMenu();
        return View::make('titulaciones.index')->with(compact('titulaciones'))->nest('dropdown',$dropdown)->nest('header','titulaciones.headerMainContainer')->nest('modalNuevaTitulacion','titulaciones.modalNuevaTitulacion')->nest('modalEditaTitulacion','titulaciones.modalEditaTitulacion')->nest('modalEliminaTitulacion','titulaciones.modalEliminaTitulacion')->nest('modalUploadCsv','titulaciones.modalUploadCsv');
    }


    /**
        * 
        * Comprueba que el fichero CSV contiene al menos las columnas esperadas
        * 
        * @param $file :file
        *
        * @return $resultado :array   
        *
        *
    */
    public function isValidCsv($file){
        
        $resultado = array( 'error' => false,
                            'columnasNoValidas' => array(),
                            'msg-error' => 'Fichero no válido: <br />',
                        );
        
        if (empty($file)){
            $resultado['error'] = true;
            $resultado['msg-error'] = 'No se ha seleccionado ningún archivo *.csv';
            return $resultado;
        }

        $columnasValidas = Config::get('csvtitulaciones.columnas');
        $f = fopen($file,"r");
        //Lee nombres de las columnas
        $columnasCSV = fgetcsv($f,0,',','"');
        foreach($columnasValidas as $columna){
            if (in_array($columna, $columnasCSV) === false) {
                $resultado['error'] = true;
                $resultado['msg-error'] = $resultado['msg-error'] . 'columna ' . $columna . 'no encontrada <br />';
                $resultado['columnasNoValidas'][] = $columna;    
            } 
        }
        fclose($f);
        return $resultado;
    }

    /**
        * 
        * Devuelve el valor de la Key=$columna del array $fila
        * 
        * @param $fila :array
        * @param $columna :string
        * 
        * @return $fila :array   
        *
        *
    */   
    public function getValue($fila,$columna){

        return $fila[$columna];
    }
    
    /**
        * 
        * Devuelve array asociativo con Key=$columna y value=$fila[posión $i]
        * 
        * @param $columnas :array
        * @param $fila :array
        * 
        * @return $datos :array   
        *
        *
    */ 
    public function matchColumnas($columnas,$fila){

        $datos = array();
        $indice = 0;
        foreach ($columnas as $columna) {
            $datos[$columna] = $fila[$indice];
            $indice = $indice + 1;
        }

        return $datos;
    }

    /**
        * 
        * Elimina titulación y sus asignaturas (con sus grupos)
        * 
        * @param Input::get('id') 
        * 
        * @return $datos :array   
        *
        *
    */ 
    public function elimina(){
 
        $id = Input::get('id','');

    
        if ( ($titulacion = Titulacion::find($id)) === NULL ){
            Session::flash('msg-error', 'No existe titulación con id = ' . $id);
            return Redirect::to($url);
        }


        $asignaturas = $titulacion->asignaturas;
        foreach ($asignaturas as $asignatura) {
            $gruposAsignatura = $asignatura->gruposAsignatura;
            foreach ($gruposAsignatura as $grupo) {
                $grupo->profesores()->detach();
                $grupo->delete();
            }
            $asignatura->delete();
        }
        $titulacion->delete();
        
        Session::flash('msg-exito', 'Titulación eliminada con éxito.');
        return Redirect::back();
    }

    /**
        * 
        * Devuelve todas las asignaturas de cada una de las títulaciones con código en $aCodigos
        * 
        * @param Input::get('aCodigos') :array 
        * 
        * @return $respuesta :array    
        *
        *
    */
    //llamada ajax desde filtraEventos.js
    public function getAsignaturas( Array $aCodigos = [] ){

        //@return
        $respuesta = array();
        
        //@param
        $aCodigos = Input::get('aCodigos',array());

        //Validación Input
        if (empty($aCodigos)) return $respuesta;
        
        foreach($aCodigos as $codigo) {
            $respuesta[] = [    'titulacion' => [ 'codigo' => $codigo ], 
                                'asignatura' => Titulacion::where('codigo','=',$codigo)->first()->asignaturas->toArray() 
                            ];
        }
        
        //formato Key = codigo Asignautra, Value Asignatura
        return $respuesta;
    }

    /**
        * 
        * Devuelve todos los profesores de cada una de las asignaturas con código en $aCodigos
        * 
        * @param Input::get('aCodigos') :array 
        * 
        * @return $respuesta :array    
        *
        *
    */
    //llamada ajax desde filtraEventos.js
    public function getProfesores( Array $aCodigos = [] ){

        //@return
        $respuesta = array();
        
        //@param
        $aCodigosTitulaciones = Input::get('aCodigosTitulaciones',array());
        $aCodigosAsignaturas = input::get('aCodigosAsignaturas',array());
        //return $aCodigos;

        //Validación Input
        if (empty($aCodigosAsignaturas) || empty($aCodigosTitulaciones)) return $respuesta;

        if (in_array('all', $aCodigosAsignaturas) != false){

            $aProfesores = array();
            foreach ($aCodigosTitulaciones as $codigoTitulacion) {
                # code...
                Titulacion::where('codigo','=',$codigoTitulacion)->first()->asignaturas->each(function($asignatura) use (&$respuesta){

                                $aProfesores = array();
                                $asignatura->gruposAsignatura->each(function($g) use (&$aProfesores) {
                                        $aProfesores[] = $g->profesores->toArray();
                                });
                                $respuesta[] = [    'asignatura' => [ 'codigo' => $asignatura->codigo ],
                                                    'profesores' => $aProfesores ];
                });
            } 
        }
        else {
        
            foreach($aCodigosAsignaturas as $codigo) {

                $aProfesores = array();
                Asignatura::where('codigo','=',$codigo)->first()->gruposAsignatura->each(function($grupoAsignatura) use (&$aProfesores){
                        $aProfesores[] = $grupoAsignatura->profesores->toArray();
                });
        
                $respuesta[] = [    'asignatura' => [ 'codigo' => $codigo ], 
                                    'profesores' => $aProfesores, ];

            }
        }
        
        //formato Key = codigo Asignautra, Value Asignatura
        return $respuesta;
    }    


} //fin del controlador