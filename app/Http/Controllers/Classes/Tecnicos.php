<?php

namespace App\Http\Controllers\Classes;
use App\Models\Tecnico;

class Tecnicos {

    private $tecnicos;

    public function __construct()
    {
        $this->tecnicos = array();	
		$this->cargarTecnicos();
    }
	
	private function cargarTecnicos()
	{
		$coleccionTecnicos = Tecnico:: ;
		return;
	}
	
	public function registrarTecnico($datosTecnico)
	{
		$nuevoTecnico = new Tecnico($datosTecnico);
		$nuevoTecnico->save();
		$tecnicos[$nuevoTecnico->id] = $nuevoTecnico;
	}

    public function getTecnico($idTecnico)
    {
        return $tecnicos[$idTecnico];
    }
	
	public function getTecnicos()
	{
	    return $tecnicos;
	}

    public function eliminarTecnico($idTecnico)
    {
		//eliminar de la base de datos.
        unset($tecnicos[idTecnico]);
    }

    public function modificarDatosTecnico($idTecnico, $nuevosDatos)
    {
        $nuevoTecnico = new Tecnico($datosTecnico);
		$nuevoTecnico->save();
		$tecnicos[$nuevoTecnico->id] = $nuevoTecnico;
    }
	
	public function quitarTecnico($idTecnico)
	{
		unset($tecnicos[idTecnico]);
	}
	
	public function conectarTecnico($idTecnico){
		
	}
    
}
