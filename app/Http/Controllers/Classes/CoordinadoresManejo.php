<?php

namespace App\Http\Controllers\Classes;

use App\Http\Controllers\Classes\Coordinadores;
use App\Models\Coordinador;

class CoordinadoresManejo {

    private $coordinadores;
	private $coordinadoresConectados;

    public function __construct()
    {
        $this->coordinadores = new Coordinadores();
		$this->coordinadoresConectados = array();
		
    }

    public function desconectarCoordinador($idCoordinador)
    {
        
    }

    public function conectarCoordinador($idTicket, $nuevosDatosTicket)
    {

    }

    public function registrarCoordinador($idTicket)
    {

    }

    public function asignarEncargado($idTicket, $idEncargado)
    {

    }

}
