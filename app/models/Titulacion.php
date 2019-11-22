<?php

class Titulacion extends Eloquent {

 	protected $table = 'titulaciones';

 	protected $fillable = array('codigo', 'titulacion');


	
    /**
    *
    * Query Scope, return all titulaciones
    */

  //  public function scopeTitulaciones($query)
   // {
   //     return $query->order
   // }

    /**
     * Relación: 1 título tiene muchas asignaturas
     * 
    */
    
    public function asignaturas(){
        return $this->hasMany('Asignatura');
    }

}