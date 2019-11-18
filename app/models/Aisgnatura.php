<?php

class Asignatura extends Eloquent {

 	protected $table = 'asignaturas';

 	protected $fillable = array('codigo', 'asignatura','curso','titulacion_id');


	
    /**
     * Relación: 1 asignatura pertenece a 1 títulación
     * 
     */
    
    public function titulacion(){
        return $this->hasOne('Titulacion');
    }

    /**
    * Relación: 1 asignatura se imparte por profesores a través de los grupos que tiene la asignatura
    */

    public function profesores(){
    	return $this->hasManyThrough('Profesor','GrupoAsignatura');
    }
    
}