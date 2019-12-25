<?php

class Recurso extends Eloquent {

 	protected $table = 'recursos';

 	protected $fillable = array('acl', 'admin_id','descripcion','nombre', 'tipo','grupo_id');


	//Devuelve los usarios administradores de un recurso
    public function administradores(){
        return $this->belongsToMany('User');
    }


    public function events(){
        return $this->hasMany('Evento','recurso_id','id');
    }

    public function filtraEventos($dia,$hora){
        
        $eventos = $this->events->filter(function($e) use ($dia,$hora){
                 
                    return ( $e->dia == $dia && $e->horaInicio <= $hora && $hora <= $e->horaFin );
                });

        $aEventos_id = array();
        
        $eventos = $eventos->sortBy('evento_id')->filter(function($evento) use (&$aEventos_id){
            
            if (in_array($evento->evento_id, $aEventos_id) == false) {
                $aEventos_id[] = $evento->evento_id;
                return true;
            }
            return false;

        });

        return $eventos;

    }
    
    public function scopetipoDesc($query)
    {
        return $query->orderBy('tipo','DESC');
    }

	public function scopegrupoDesc($query)
    {
        return $query->orderBy('grupo','DESC');
    }   
 
    
    public function perfiles(){
        $perfiles = array();
        $aPerfilesSGR = Config::get('options.perfiles');
        $aclrecurso = json_decode($this->acl,true);
        $capacidades = explode(',',$aclrecurso['r']);
        foreach ($capacidades as $capacidad) {
          $perfiles[] = $aPerfilesSGR[$capacidad]; 
        }
        return $perfiles;
        
    }

    /**
    * Nombres de los medios desde el código almacenado en DB 
    * 
    * @return $aNombresMedios :array
    */
    public function getNombreMedios(){
        
        $aNombresMedios = array();
        
        $objMediosDisponibles = json_decode($this->mediosdisponibles);
        if (empty($objMediosDisponibles))
            return $aNombresMedios;

        $aCodigosMediosRecurso = explode(',',$objMediosDisponibles->medios);
            
        foreach (Config::get('mediosdisponibles.medios') as $medio) {
            if (in_array($medio['codigo'],$aCodigosMediosRecurso) )
                    $aNombresMedios[] = $medio['nombre'];
                        
            }
        return $aNombresMedios;        
    }

    public function tipoGestionReservas(){

        $result = 'No está definida....';
        $modo = '1';
        $aclrecurso = json_decode($this->acl,true);
        if (isset($aclrecurso['m'])) $modo = $aclrecurso['m'];

        switch ($modo) {
            case 0: //Gestión atendida con validación
                $result = Config::get('options.gestionAtendida');
                break;
            case 1: //Gestión atendida con validación
                $result = Config::get('options.gestionDesatendida');
                break;
        }
        
        return $result;
    }

}