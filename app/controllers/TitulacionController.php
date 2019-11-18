<?php

class TitulacionController extends BaseController {


	public function listar(){
      
   		//$sortby = Input::get('sortby','nombre');
    	//$order = Input::get('order','asc');
    	//$offset = Input::get('offset','10');
    	//$search = Input::get('search','');

    	$titulaciones=Titulacion::orderBy('titulacion','ASC')->get();
    	/*echo "<pre>";
    		var_dump($titulaciones);
    	echo "</pre>";*/
        
        return View::make('titulaciones.index')->nest('header','titulaciones.headerMainContainer');  
	    //return View::make('admin.recurselist')->with(compact('recursos','sortby','order','grupos','idgruposelected','recursosListados'))->nest('dropdown',Auth::user()->dropdownMenu())->nest('menuRecursos','admin.menuRecursos')->nest('modalAdd','admin.recurseModalAdd',array('grupos'=>$grupos))->nest('modalEdit','admin.recurseModalEdit',array('recursos'=>$grupos))->nest('modalEditGrupo','admin.modaleditgrupo');
    }
    


} //fin del controlador