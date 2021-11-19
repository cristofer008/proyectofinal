<?php

namespace App\Http\Controllers\Classes;

use Illuminate\Support\Collection;
use App\Models\Ticket;

class Tickets {

    protected $tickets;

    public function __construct()
    {
        $this->tickets = array();
		$this->cargarTickets();
    }
	
	public function insertarTickets($ticketsNuevos, $ticketsAbiertos, $ticketsEspera, $ticketsResueltos)
	{
		$tickets = array_merge($ticketsNuevos, $ticketsAbiertos, $ticketsEspera, $ticketsResueltos);
	}

    public function crearNuevoTicket($idTicket, $datosTicket)
    {
		
    }

    public function modificarTicket($idTicket, $nuevosDatosTicket)
    {

    }

    public function eliminarTicket($idTicket)
    {

    }

    public function asignarEncargado($idTicket, $idEncargado)
    {

    }

    public function create()
    {
        // create notification
        // send email
        // return output
    }
}
