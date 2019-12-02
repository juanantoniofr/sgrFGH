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
      
   		//$sortby = Input::get('sortby','nombre');
    	//$order = Input::get('order','asc');
    	//$offset = Input::get('offset','10');
    	//$search = Input::get('search','');


    	$titulaciones=Titulacion::orderBy('titulacion','ASC')->get();

    	/*echo "<pre>";
    		var_dump($titulaciones);
    	echo "</pre>";*/
        $dropdown = Auth::user()->dropdownMenu();

        return View::make('titulaciones.index')->with(compact('titulaciones'))->nest('dropdown',$dropdown)->nest('header','titulaciones.headerMainContainer')->nest('modalNuevaTitulacion','titulaciones.modalNuevaTitulacion')->nest('modalEditaTitulacion','titulaciones.modalEditaTitulacion');  
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

    public function csv(){

        $pod = array();
        return View::make('titulaciones.csv')->with(compact('pod'));
    }

    /**
        * 
        * Procesa archivo csv
        * 
        * @param Input::file('csvfile') :file
        * 
        * @return $respuesta :array   
        *
        *
    */
    public function saveCSV(){

        $numFila = 1;

        //$csv = new csv();
        
        $file = Input::file('csvfile'); //controlar que no sea vacio !!!!!
        if (empty($file)){
            Session::put('msg', 'No se ha seleccionado ningún archivo *.csv');
            return View::make('titulaciones.csv');  
        }


        $f = fopen($file,"r");
        $columnas = fgetcsv($f,0,',','"'); //en la primera fila del csv, están los nombres de las columnas
               
        //Hasta final del fichero csv
        $fila = fgetcsv($f,0,',','"'); 
        $i=0;
        while ($fila !== false){
                       
            $datos = $this->matchColumnas($columnas,$fila); // $datos = array('nombreColumna' => valor);
            $codigoAsignatura = $this->getValue($datos,'ASS_CODNUM1');
            
            $pod[$i] = array(   'asignatura' => $this->getValue($datos,'ASIGNATURA'),
                                'codigo-asignatura' => $this->getValue($datos,'ASS_CODNUM1'),
                        );
            $pod[$i]['grupos'][] =  array(  'grupo' => $this->getValue($datos,'DES_GRP'),
                                            'profesor'   => $this->getValue($datos,'NOMCOM'), 
                                    );
            
            do{

                $fila = fgetcsv($f,0,',','"');
                if ($fila !== false) {
                    $datos = $this->matchColumnas($columnas,$fila); // $datos = array('nombreColumna' => valor);
                    if ($codigoAsignatura == $this->getValue($datos,'ASS_CODNUM1')){
                        $pod[$i]['grupos'][] = array(   'grupo' => $this->getValue($datos,'DES_GRP'),
                                                        'profesor'   => $this->getValue($datos,'NOMCOM'),
                                                );
                    }
                } 

            }while ($codigoAsignatura == $this->getValue($datos,'ASS_CODNUM1') && $fila !== false );
            $i = $i + 1; 
        }

        $result = $this->salvaPod($pod);
        

        return View::make('titulaciones.csv')->with(compact('pod'));
    }

    public function salvaPod($pod){

        foreach ($pod as $asignatura) {
            $codigoTitulacion = substr($pod[0]['codigo-asignatura'],0,4);
            $titulacion = Titulacion::where('codigo','=',$codigoTitulacion)->get();
            if (!empty($titulacion)) {
                $titulacion->asignaturas()->asignatura = $asignatura['asignatura'];
                $titulacion->asignaturas()->codigo = $aisgnatura['codigo-asignatura'];
            }
        }
        return true;
    }

    public function getValue($fila,$columna){

        return $fila[$columna];
    }

    public function matchColumnas($columnas,$fila){

        $datos = array();
        $indice = 0;
        foreach ($columnas as $columna) {
            $datos[$columna] = $fila[$indice];
            $indice = $indice + 1;
        }

        return $datos;
    }

} //fin del controlador