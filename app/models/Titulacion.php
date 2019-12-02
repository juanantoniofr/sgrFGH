<?php

class Titulacion extends Eloquent {

 	protected $table = 'titulaciones';


 	protected $fillable = array('id','codigo', 'nombre');

  /**
    * Relación: 1 título tiene muchas asignaturas
    * 
  */
    
  public function asignaturas(){
  
    return $this->hasMany('Asignatura','titulacion_id','id');
  }



}