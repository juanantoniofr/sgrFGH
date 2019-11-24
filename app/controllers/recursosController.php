<?php

class recursosController extends BaseController {


  public function eliminar(){
 
    $id = Input::get('id','');

    
    if (empty($id)){
      Session::flash('message', 'Identificador vacio: No se ha realizado ninguna acción....');
      return Redirect::to($url);
    }

    $recurso = Recurso::findOrFail($id);
    $recurso->administradores()->detach();
    $recurso->delete();
    
    Session::flash('message', 'Recurso eliminado con éxito....');
    return Redirect::back();
    
  }

  public function deshabilitar(){
 
    $id = Input::get('id','');

    
    if (empty($id)){
      Session::flash('message', 'Identificador vacio: No se ha realizado ninguna acción....');
      return Redirect::to($url);
    }

    $recurso = Recurso::where('id','=',$id)->update(array('disabled' => true));
    
    //Enviar mail a usuarios con reserva futuras
    $sgrMail = new sgrMail();
    $sgrMail->notificaDeshabilitaRecurso($id);         

    Session::flash('message', 'Recurso <b>deshabilitado</b> con éxito....');
    return Redirect::back();
    
  }
  
  public function habilitar(){
 
    $id = Input::get('id','');

    
    if (empty($id)){
      Session::flash('message', 'Identificador vacio: No se ha realizado ninguna acción....');
      return Redirect::to($url);
    }

    $recurso = Recurso::where('id','=',$id)->update(array('disabled' => false));
    
    //Enviar mail a usuarios con reserva futuras
    $sgrMail = new sgrMail();
    $sgrMail->notificaHabilitaRecurso($id); 

    Session::flash('message', 'Recurso <b>habilitado</b> con éxito....');
    return Redirect::back();
    
  }

  public function admins(){

    $sortby = Input::get('sortby','username');
    $order = Input::get('order','asc');
    $offset = Input::get('offset','10');
    $search = Input::get('search','');
    $idRecurso = Input::get('idRecurso','');

    $recurso = Recurso::find($idRecurso);
    $administradores = $recurso->administradores()->orderby($sortby,$order)->paginate($offset);
    return View::make('admin.recurseAdmins')->with(compact('recurso','administradores','sortby','order','offset','search'))->nest('dropdown',Auth::user()->dropdownMenu())->nest('menuAdministradores','admin.menuAdministradores',['idRecurso' => $recurso->id, 'recurso' => $recurso->nombre]);
  }

  public function addAdmin(){
    
    $idRecurso = Input::get('idRecurso','');
    $username = Input::get('username','');
    
    $recurso = Recurso::find($idRecurso);
    $users = array();
    if(!empty($username)){
      $users = User::where('username','like',"%$username%")->where('capacidad', '>', '2')->get();
      $aIdRecurso = array($idRecurso);
      $users = $users->filter(function($user) use ($idRecurso) {
          return !ACL::isAdminForRecurso($user->id,$idRecurso);
        });
      }  

    return View::make('admin.recurseAddAdmin')->with(compact('username','users','recurso'))->nest('dropdown',Auth::user()->dropdownMenu())->nest('menuAdministradores','admin.menuAdministradores',['idRecurso' => $recurso->id, 'recurso' => $recurso->nombre]);
  }

  public function addRecursoAdmin(){

    $idRecurso = Input::get('idRecurso','');
    $username = Input::get('username','');
    $admins = Input::get('admins',array());

    if(!empty($admins)){
      $recurso = Recurso::find($idRecurso);
      $recurso->administradores()->attach($admins);
      Session::flash('msg', 'administrador/es añadido/s con éxito......');
    }
    else Session::flash('msg' , 'No se ha marcado ningún usuario......');
    

    $url = URL::route('addRecursoAdmin',['username' => $username, 'idRecurso' => $idRecurso]); 
    return Redirect::to($url);
    
  }

  /**
    * Devuelve vista para añadir recurso ??? 
    * 
    * @return View::make('admin.recurseAdd') :string
  */

	public function formAdd(){

    $recursos = Recurso::groupby('grupo_id')->orderby('grupo','asc')->get();
    $mediosdisponibles = Config::get('mediosdisponibles.medios');
    return View::make('admin.recurseAdd')->with(compact('recursos','mediosdisponibles'))->nest('dropdown',Auth::user()->dropdownMenu())->nest('menuRecursos','admin.menuRecursos');
  }

  /**
    * Guarda en BD un nuevo recurso (Espacio//puesto//medio
    * 
    * @param Input::get('odGRupo') :int 
    * @param Input::get('nuevogrupo') :varchar(256)
    *
    * @return $respuesta :array, errores de validación de formulario o mensaje de éxito
  */

  public function addRecurso(){
    
    //@params
    $idgrupo = Input::get('idgrupo','');
    $nuevogrupo = Input::get('nuevogrupo','');
    
    //@return
    $respuesta = array( 'error' => false,
                        'msg'   => 'Mensaje para el usuario....idgrupo = ' . $idgrupo .' y, nuevogrupo = ' . $nuevogrupo,
                        'errors' => array());
    
    //Validación formulario 
    $rules = array(
      'nombre'      => 'required|unique:recursos',
      'nuevogrupo'  => 'required_if:idgrupo,0',
      'aforomaximo' => 'integer',
      'aforoexamen' => 'integer',        
    );

     $messages = array(
      'required'  => 'El campo <strong>:attribute</strong> es obligatorio.',
      'unique'  => 'Existe un recurso con el mismo nombre.',
      'nuevogrupo.required_if'  => 'Campo requerido.',
      'integer' => 'El campo <strong>:attribute</strong> debe ser un número entero.'
      );
    
    $validator = Validator::make(Input::all(), $rules, $messages);

    
    if ($validator->fails()){
        $respuesta['error'] = true;
        $respuesta['errors'] = $validator->errors()->toArray();
      }
    else{  
      $recurso = new Recurso;
      $recurso->nombre = Input::get('nombre');
      $recurso->grupo = $this->getNombre();
      $recurso->grupo_id = $this->getIdGrupo();
      $recurso->tipo = Input::get('tipo');
      $recurso->descripcion = Input::get('descripcion');
      $recurso->acl = $this->getACL();
      $recurso->id_lugar = Input::get('id_lugar');
      $recurso->aforomaximo = Input::get('aforomax');
      $recurso->aforoexamen = Input::get('aforoexam');
      $aMediosDisponibles = Input::get('mediosdisponibles',array());
      $medios = implode(',', $aMediosDisponibles);
      $recurso->mediosdisponibles = json_encode(
          array(
                'medios' => $medios )
        );

      if ($recurso->save()) Session::flash('message', 'Recurso <strong>'. $recurso->nombre .' </strong>añadido con éxito');
    
      //Añadir administradores
      $ids = array();
      if (Auth::user()->capacidad != 4) $ids[] = Auth::user()->id; //El propio usuario que lo añade si no es administrador
     
      if (!empty($ids)) $recurso->administradores()->attach($ids);

      
    }//fin else

    return $respuesta;
  }


  /**
    * Devuelve vista principal gestión de recursos 
    * 
    * @return View::make('admin.recurseAdd') :string
  */

  public function listar(){
      
    $sortby = Input::get('sortby','nombre');
    $order = Input::get('order','asc');
    $offset = Input::get('offset','10');
    $search = Input::get('search','');

    $idgruposelected = Input::get('grupoid','');
    
    $mediosdisponibles = Config::get('mediosdisponibles.medios');
    $recursosListados = 'Todos los recursos';
    if (!empty($idgruposelected)) $recursosListados = Recurso::where('grupo_id','=',$idgruposelected)->first()->grupo;

    if (Auth::user()->capacidad == '4'){
      //administrador puede ver todo
      $recursos = Recurso::where('nombre','like',"%$search%")->paginate($offset);
      //ONLY_FULL_GROUP_BY delete for sql_mode servidor mysql
      $grupos = Recurso::groupby('grupo_id')->orderby('grupo','asc')->get();
      
      if (!empty($idgruposelected)) 
        $recursos = Recurso::where('nombre','like',"%$search%")->where('grupo_id','=',$idgruposelected)->paginate($offset);
      else
        return View::make('admin.recurselist')->with(compact('recursos','sortby','order','grupos','idgruposelected','recursosListados'))->nest('dropdown',Auth::user()->dropdownMenu())->nest('menuRecursos','admin.menuRecursos')->nest('modalAdd','admin.recurseModalAdd',compact('grupos','mediosdisponibles'))->nest('modalEdit','admin.recurseModalEdit',array('recursos'=>$grupos))->nest('modalEditGrupo','admin.modaleditgrupo');
    }
    
    $recursos = User::find(Auth::user()->id)->supervisa()->where('nombre','like',"%$search%")->orderby($sortby,$order)->paginate($offset);
    $grupos = User::find(Auth::user()->id)->supervisa()->groupby('grupo_id')->orderby('grupo','asc')->get();
    if (!empty($idgruposelected))
      $recursos = Recurso::where('nombre','like',"%$search%")->where('grupo_id','=',$idgruposelected)->orderby($sortby,$order)->paginate($offset);
      
    return View::make('admin.recurselist')->with(compact('recursos','sortby','order','grupos','idgruposelected','recursosListados'))->nest('dropdown',Auth::user()->dropdownMenu())->nest('menuRecursos','admin.menuRecursos')->nest('modalAdd','admin.recurseModalAdd',compact('grupos','mediosdisponibles'))->nest('modalEdit','admin.recurseModalEdit',array('recursos'=>$grupos))->nest('modalEditGrupo','admin.modaleditgrupo');
  } 

  
  //edición
  /**
    * 
    * ??????
    * Devuelve formulario de edición de recurso 
    * 
    * @param Input:get('id') :integer
    * 
    * @return View::make('admin.recurseAdd') :string
  */  

  public function formEdit(){

    //@param
    $id = Input::get('id');
    
    $recurso = Recurso::find($id);

    $recursos = Recurso::groupby('grupo_id')->orderby('grupo','asc')->get();
        
    $modo = 0;//Con validación
    if (ACL::automaticAuthorization($id)) $modo = 1;//sin validación
    
    $permisos = json_decode($recurso->acl,true);
    $capacidades = $permisos['r']; //array con los valores de la capacidades con acceso
    $aMediosdisponibles = json_decode($recurso->mediosdisponibles,true);
    $aMedios = $aMediosdisponibles['medios'];

    return View::make('admin.recurseEdit')->with(compact('recursos','recurso','modo','capacidades','aMedios'))->nest('dropdown',Auth::user()->dropdownMenu())->nest('menuRecursos','admin.menuRecursos');
  }

  /**
    * Devuelve las propiedades de un recurso 
    * 
    * @param Input:get('id') :integer
    * 
    * @return $result :array
  */ 
  
  public function getrecurso(){
    
    //@param
    $id = Input::get('id','');

    //@return
    $result = array('atributos' => '',
                    'visibilidad' => array(),
                    'medios'  => array());
    
    $recurso = Recurso::find($id)->toArray();
    $result['atributos'] = $recurso;
    $acl = json_decode($recurso['acl']);
    $result['visibilidad'] = explode(',',$acl->r);
    $result['medios'] = explode(',', json_decode($recurso['mediosdisponibles'])->medios);
   
    return $result;
  }

  /**
    * Actualiza recurso en BD con id = Input::get('id')
    * @param Input::get('id') :integer
    * @param Input::all() :object Recurso
    *
    * @return $respuesta :array, errores de validación de formulario | mesnaje de éxito
  */

  public function editRecurso(){
   
    //@param
    $id = Input::get('id');
    $idgrupo = Input::get('idgrupo','');
    $nuevogrupo = Input::get('nuevogrupo','');
    
    //@return
    $respuesta = array(
      'errores'   => array(),
      'hasError'  => false
    );
    
    //Validación de formulario
    $rules = array(
      'nombre'  => 'required|unique:recursos,nombre,'.$id,
      'nuevogrupo'  => 'required_if:idgrupo,0',
      'aforomaximo' => 'integer',
      'aforoexamen' => 'integer',
    );

    $messages = array(
      'required'  => 'El campo <strong>:attribute</strong> es obligatorio....',
      'unique'  => 'Existe un recurso con el mismo nombre....',
      'nuevogrupo.required_if'  => 'El valor no puede quedar vacio....',
      'integer' => 'El campo <strong>:attribute</strong> debe ser un número entero.',
    );
    
    $validator = Validator::make(Input::all(), $rules, $messages);

    if ($validator->fails()){
    
      $respuesta['errores'] = $validator->errors()->toArray();
      $respuesta['hasError'] = true;
      return $respuesta;
    }
    else{  
      
      $recurso = Recurso::find($id);
      $recurso->nombre = Input::get('nombre');
      $recurso->aforomaximo = Input::get('aforomaximo');
      $recurso->aforoexamen = Input::get('aforoexamen');
      $recurso->grupo = $this->getNombre();
      $recurso->grupo_id = $this->getIdGrupo();
      $recurso->tipo = Input::get('tipo','espacio');
      $recurso->descripcion = Input::get('descripcion');
      $recurso->acl = $this->getACL();
      $recurso->id_lugar = Input::get('id_lugar');
      $aMediosDisponibles = Input::get('medios',array());
      $medios = implode(',', $aMediosDisponibles);
      $recurso->mediosdisponibles = json_encode(
          array(
                'medios' => $medios )
        );


      if ($recurso->save()) Session::flash('message', 'Cambios en <strong>'. $recurso->nombre .' </strong> salvados...');
    }

    return $respuesta;
  }

  public function updateDescripcionGrupo(){

    
    //Input
    $idRecurso = Input::get('idRecurso','');
    $grupo = Input::get('grupo','');
    $descripcionGrupo = Input::get('descripcion','');
 
    //Output
    $respuesta = array( 'errores'   => array(),
                        'hasError'  => false);
    //check input
    if ( empty($idRecurso) ) {
      $respuesta['hasError']=true;
      Session::flash('message','Error en el envío del formulario...');
      return $respuesta;
    }

    $rules = array(
        'grupo'      => 'required',
        );

     $messages = array(
          'required'      => 'El campo <strong>:attribute</strong> es obligatorio....',
          );
    
    $validator = Validator::make(Input::all(), $rules, $messages);
    if ($validator->fails()){
        $respuesta['errores'] = $validator->errors()->toArray();
        $respuesta['hasError'] = true;
        return $respuesta;
      }
    else{  
        $groupToUpdate = Recurso::find($idRecurso)->grupo;
        $recursosDelMismoGrupo = Recurso::where('grupo','=',$groupToUpdate)->update(array('descripcionGrupo' => $descripcionGrupo, 'grupo' => $grupo));
        Session::flash('message', 'Cambios en <strong>'. $grupo . $idRecurso . ' </strong> salvados con éxito...');
      }
    

    //$respuesta = Input::all();
    return $respuesta;
  }

  //private
  private function getNombre(){

    $idgrupo = Input::get('idgrupo');
    $nuevogrupo = Input::get('nuevogrupo','');

    if (empty($nuevogrupo)) $nombregrupo = Recurso::where('grupo_id','=',$idgrupo)->first()->grupo;
    else $nombregrupo = $nuevogrupo;
   
    return $nombregrupo;
  }

  private function getIdGrupo(){

    $idgrupo = Input::get('idgrupo');
    $nuevogrupo = Input::get('nuevogrupo','');

    if (!empty($nuevogrupo)){
      //
      $identificadores = Recurso::select('grupo_id')->groupby('grupo_id')->get()->toArray();
      $idgrupo = 1;
      $salir = false;
      while(array_search(['grupo_id' => $idgrupo], $identificadores) !== false){
        $idgrupo++;
      }
    }

    return $idgrupo;
  }

  private function getACL(){

    $aACL = array('r' => '',
                  'm' => '0',//por defecto gestión Atendida de las solicitudes de uso.
                  );
    $aACL['m'] = Input::get('modo','0');
    $acceso = Input::get('acceso',array());
    $acceso[] = 4; //Añadir rol administrador
    $listIdRolesConAcceso = implode(',',$acceso);
    $aACL['r'] = $listIdRolesConAcceso;

    return json_encode($aACL);

  }


}//Fin de la Clase