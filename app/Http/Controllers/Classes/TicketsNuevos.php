<?php

namespace App\Http\Controllers\Classes;

use App\Http\Controllers\Classes\Tickets;
use App\Models\Ticket;
use Illuminate\Support\Collection;

class TicketsNuevos extends Tickets {
	
	private static $ticketsNuevos;

    public function __construct()
    {
		parent::__construct();
		TicketsNuevos::$ticketsNuevos = $this;
    }
	
	public static function |getTicketsNuevos()
	{
		return TicketsNuevos::$ticketsNuevos;
	}
	
	private function cargarTickets()
	{
		Ticket::
	}

    public function crearNuevoTicket($datosTicket, $idEncargado)
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
