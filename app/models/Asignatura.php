<?php

class Asignatura extends Eloquent {

 	protected $table = 'asignaturas';

 	protected $fillable = array('codigo', 'asignatura','cuatrimestre','curso');


	
    /**
     * Relación: 1 asignatura pertenece a 1 títulación
     * 
     */
    
    public function titulacion(){
        
        return $this->belongsTo('Titulacion');
        //return $this->hasOne('Titulacion');
    }

    /**
        * Relación: 1 asignatura tiene uno o varios grupos de alumnos
    */

    public function gruposAsignatura(){
        return $this->hasMany('GrupoAsignatura','asignatura_id','id');
    }

    /**
    * Relación: 1 asignatura se imparte por profesores a través de los grupos que tiene la asignatura
    */

    public function profesores(){
    	return $this->hasManyThrough('Profesor','GrupoAsignatura');
    }
    
}