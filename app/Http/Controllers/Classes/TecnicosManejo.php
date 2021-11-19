<?php

namespace App\Http\Controllers\Classes;

use App\Http\Controllers\Classes\Tecnicos;
use App\Http\Controllers\Classes\TecnicosConectados;
use App\Http\Controllers\Classes\TecnicosNoConectados;

class TecnicosManejo {

    private $tecnicos;
	private $tecnicosNoConectados;
	private $tecnicosConectados;
	
    public function __construct()
    {
        $this->tecnicos = new Tecnicos();
		$this->tecnicosNoConectados = array();
		$this->tecnicosConectados = array();
    }

    public function registrarNuevoTecnico($datosTecnico)
    {

    }

    public function eliminarTecnico($idTecnico)
    {

    }

    public function modificarDatosTecnico($idTicket)
    {

    }

    public function modificarPermisoTecnico($idTecnico, $)
    {

    }

	public function getTecnicosConectados()
	{
		return $tecnicosConectados;
	}
	
	public function getTecnicosNoConectados()
	{
		return $tecnicosNoConectados;
	}
	
	public function getTecnicosTotal()
	{
		return $tecnicos;
	}
	
	public function conectarTecnico($idTecnico)
	{
		
	}
}
