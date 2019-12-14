<?php

class GrupoAsignatura extends Eloquent {

 	protected $table = 'gruposAsignatura';

 	protected $fillable = array('grupo', 'asignatura_id','capacidad');


	
    /**
        * Relación: 1 grupo puede tener varios profesores y 1 profesor puede impartir clase en varios grupos
    */

    public function profesores(){
    	return $this->belongsToMany('Profesor');
    } 

    /**
        * Relación: 1 grupoAsignatura tiene muchos eventos
    */

    public function eventos(){
        return $this->belongsToMany('Evento');
    }

    public function asignatura()
    {
        return $this->belongsTo('Asignatura');
    }

}