<?php

class sgrCsv {

	public $columnas = array(); //nombre de las columnas a leer del csv
	public $columnasCsv = array(); //Nombre de todas las columnas del CSV
	private $file = ''; //nombre del archivo csv
	public $fila = array(); //fila leida csv
	public $datos = array(); //asociativo key=nombreColumnaCSV, Value=valorDeColumnaEnUnaFila
	private $f = ''; //puntero de lectura

	public function __construct($columnasCsv = [],$columnasValidas = [],$file = '' ){

		$this->columnasCsv = $columnasCsv;
		$this->columnas = $columnasValidas;
		$this->file = $file;
	}

	public function open(){
		return ($this->f = fopen($this->file,"r"));
	}

	public function close(){
		return fclose($this->f);
	}

	public function compruebaCabeceras(){
	
		foreach ($this->fila as $cabecera) {
			if (in_array($cabecera, $this->columnasCsv) == false) return false;
		}

		return true;
	}

	public function leeFila() {
		if ( ( $this->fila = fgetcsv($this->f,0,',','"') ) == NULL) return false;
		$indice = 0;
		foreach ($this->columnasCsv as $columna) {
			$this->datos[$columna] = $this->fila[$indice];
			$indice++;
		}
		return true;
	}


	/**
        * 
        * Comprueba que el fichero CSV no es vacío, y al mneos, contiene las columnas a leer
        * 
        * @param $file :file
        *
        * @return $resultado :array ('error' => true|false, 'columnasNoValida' => 'vacio|columnas no validas')  
        *
        *
    */

	public function isValidCsv(){
        
        $resultado = array( 'error' => false,
                            'columnasNoValidas' => array(),
                            'msg-error' => 'Fichero no válido: <br />',
                        );
        
        if (empty($this->file)){
            $resultado['error'] = true;
            $resultado['msg-error'] = 'No se ha seleccionado ningún archivo *.csv';
            return $resultado;
        }

        $columnasValidas = $this->columnas;
        $f = fopen($this->file,"r");
        //Lee nombres de las columnas
        $columnasCSV = fgetcsv($f,0,',','"');
        foreach($columnasValidas as $columna){
            if (in_array($columna, $columnasCSV) === false) {
                $resultado['error'] = true;
                $resultado['msg-error'] = $resultado['msg-error'] . 'columna ' . $columna . 'no encontrada <br />';
                $resultado['columnasNoValidas'][] = $columna;    
            } 
        }
        fclose($f);
        return $resultado;
    }

    

    /**
        * 
        * Devuelve el valor de la Key=$columna del array $fila
        * 
        * @param $fila :array
        * @param $columna :string
        * 
        * @return $fila :array   
        *
        *
    */

    public function getValue($columna){

        return $this->datos[$columna];
    }


}

?>