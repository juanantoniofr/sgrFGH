<?php

class TitulacionController extends BaseController {



    /**
         * Listado de titulaciones o estudios
         * 
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

        $messages = array( 'required'   => 'El campo <strong>:attribute</strong> es obligatorio....',
                           'unique'    => 'Existe una titulacion con el mismo nombre....',
                          );
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()){
            $respuesta['error']     =   true;
            $respuesta['msg']       =   'Errores de validación de formulario añadir nueva titulación';
            $respuesta['errors']    = $validator->errors()->toArray();

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
        * Muestra vista para upload csv file
        * 
        * @return View::make('titulaciones.csv') :string   
        *
        *
    */

   /* public function csv(){

        $pod = array();
        $resultado = array();

        $dropdown = Auth::user()->dropdownMenu();
        return View::make('titulaciones.csv')->with(compact('pod','resultado'))->nest('dropdown',$dropdown)->nest('header','titulaciones.headerMainContainer');
    }*/

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
        
        //Falta por implementar la función isValidCsv
        if (!$this->isValidCsv($file)){
            Session::flash('msg-error','Fichero csv no válido');
            $hasError = true;            
        }
        //controlar que no sea vacio !!!!! poner dento de la funcion isvalidcsv
        if (empty($file)){
           Session::flash('msg-error','No se ha seleccionado ningún archivo *.csv');
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
                $aAsignatura = array(
                            'asignatura' => $this->getValue($datos,'ASIGNATURA'),
                            'codigo' => $this->getValue($datos,'ASS_CODNUM1'),
                            );
                $grupoAsignatura = $this->getValue($datos,'DES_GRP');
                $profesor = $this->getValue($datos,'NOMCOM');
                
                $resultado[] = $this->salvaFila($aAsignatura,$grupoAsignatura,$profesor);   
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
        return false;
        $columnasValidas = Config::get('csvtitulaciones.columnas');
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


    public function salvaFila($aAsignatura,$grupoAsignatura,$profesor){

        $resultado = array('error' => false,
                            'exito' => array(),
                    );

        $codigoTitulacion = substr($aAsignatura['codigo'],0,4);
        $titulacion = Titulacion::where('codigo','=',$codigoTitulacion)->first();
          if (!empty($titulacion)){
            // Obtiene $asignatura o la instancia si no existe en DB
            $asignatura = Asignatura::firstorNew($aAsignatura);
            $titulacion = $titulacion->asignaturas()->save($asignatura); 
            $grupoAsignatura = GrupoAsignatura::firstOrNew(['grupo' => $grupoAsignatura, 'asignatura_id' => $asignatura->id]);
            $grupoAsignatura = $asignatura->gruposAsignatura()->save($grupoAsignatura);
            
            $profesor = Profesor::firstOrNew(['profesor' => $profesor]);// 'grupoAsignatura_id' => $grupoAsignatura->id]);
            $profesor->save();
            $grupoAsignatura = $grupoAsignatura->profesores()->attach($profesor->id);
            $resultado['exito'][] = 'Asignatura ' . $asignatura->asignatura . 'salvada con exito.';
        }
        else {
            $resultado['error'] = 'No existe la titulación con ID = ' . $codigoTitulacion;
        }
      
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

} //fin del controlador