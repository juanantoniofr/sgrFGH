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
        $result = array();
        return View::make('titulaciones.csv')->with(compact('pod','result'));
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
       
        $file = Input::file('csvfile'); 
        //controlar que no sea vacio !!!!!
        if (empty($file)){
           Session::put('msg', 'No se ha seleccionado ningún archivo *.csv');
           return View::make('titulaciones.csv');  
        }

        $f = fopen($file,"r");
        //Lee nombres de las columnas
        $columnas = fgetcsv($f,0,',','"'); 

        //Hasta final del fichero csv
        $fila = fgetcsv($f,0,',','"'); 
        $result = array();
        while ($fila !== false){
                       
            $datos = $this->matchColumnas($columnas,$fila); // $datos = array('nombreColumna' => valor);
            $aAsignatura = array(
                        'asignatura' => $this->getValue($datos,'ASIGNATURA'),
                        'codigo' => $this->getValue($datos,'ASS_CODNUM1'),
                        );
            $aGrupoAsignatura = array(
                        'grupo' => $this->getValue($datos,'DES_GRP'));
            $aProfesor = array(
                        'profesor' => $this->getValue($datos,'NOMCOM'));
            
            $result[] = $this->salvaFila($aAsignatura,$aGrupoAsignatura,$aProfesor);   
            $fila = fgetcsv($f,0,',','"');
                
        }

        return View::make('titulaciones.csv')->with(compact('result'));
    }

    /**
        * 
        * Salva a DB los valores de Asignaturas, gruposAsisgnatura y profesor
        * 
        * @param $aAsignatura :array
        * @param $aGrupoAsignatura :array
        * @param $aProfesor :array
        * 
        * @return $result :array   
        *
        *
    */

    public function salvaFila($aAsignatura,$aGrupoAsignatura,$aProfesor){

        $result = array();

        $codigoTitulacion = substr($aAsignatura['codigo'],0,4);
        $titulacion = Titulacion::where('codigo','=',$codigoTitulacion)->first();
        if (!empty($titulacion)){
            $asignatura = $titulacion->asignaturas()->where('codigo','=',$aAsignatura['codigo'])->first();
            if (empty($asignatura)){
                $nuevaAsignatura = new Asignatura($aAsignatura);
                $result['Asignatura'][]= $titulacion->asignaturas()->save($nuevaAsignatura);
                $result['GrupoAsignatura'] = $nuevaAsignatura->gruposAsignatura()->save(new GrupoAsignatura($aGrupoAsignatura));
               //falta añadir el grupo
            }
            else {
               //Añade nuevo grupo.
            }
        }
      
        return $result;
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

} //fin del controlador