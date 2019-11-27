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
        

        return View::make('titulaciones.index')->with(compact('titulaciones'))->nest('header','titulaciones.headerMainContainer')->nest('modalNuevaTitulacion','titulaciones.modalNuevaTitulacion')->nest('modalEditaTitulacion','titulaciones.modalEditaTitulacion');  
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


} //fin del controlador