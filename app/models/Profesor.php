<?php

class Profesor extends Eloquent {

 	protected $table = 'profesores';

 	protected $fillable = array('profesor', 'dni');


	
    /**
     * Relación: 1 profesor puede impartir clase en más de un grupo y un grupo puede tener más de un profesor(*:*)
     * 
     */
    
    public function gruposAsignatura(){

        return $this->belongsToMany('GrupoAsignatura');
    }

     /**
        * Relación: 1 profesor tiene muchos eventos
    */

    public function eventos(){
        return $this->hasMany('Evento');
    }
}