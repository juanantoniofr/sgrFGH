<?php

class BusquedaController extends BaseController {

	public function index(){

		$aMediosDisponibles = Config::get('mediosdisponibles.medios');
		$dropdown = Auth::user()->dropdownMenu();
		$sidebar = View::make('busqueda.sidebar')->with(compact('aMediosDisponibles'));
		return View::make('busqueda.index')->with(compact('sidebar'))->nest('dropdown',$dropdown);
	} 

}//Fin del controlador