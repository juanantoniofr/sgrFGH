<?php

class DisponibilidadController extends BaseController {

	public function index(){

		$aMediosDisponibles = Config::get('mediosdisponibles.medios');
		$dropdown = Auth::user()->dropdownMenu();
		$sidebar = View::make('disponibilidad.sidebar')->with(compact('aMediosDisponibles'));
		$disponibilidad = View::make('disponibilidad.resultadoBusquedaDisponible');
		return View::make('disponibilidad.index')->with(compact('sidebar','disponibilidad'))->nest('dropdown',$dropdown);
	} 

}//Fin del controlador