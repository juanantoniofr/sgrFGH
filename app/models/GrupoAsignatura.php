<?php

class GrupoAsignatura extends Eloquent {

 	protected $table = 'gruposAsignatura';

 	protected $fillable = array('grupo', 'asignatura_id');


	
    /**
     * Relación: 1 grupo pertenece a 1 asignatura
     * 
     */
    
    public function asignatura(){
        return $this->hasOne('Asignatura');
    }

    /**
    * Relación: 1 grupo puede tener varios profesores y 1 profesor puede impaertir clase en varios grupos
    */

    public function profesores(){
    	return $this->belongsToMany('Profesor');
    } 

}