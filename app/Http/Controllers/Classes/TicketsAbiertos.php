<?php

namespace App\Http\Controllers\Classes;

use App\Http\Controllers\Classes\Tickets;
use App\Models\Ticket;
use Illuminate\Support\Collection;

class TicketsAbiertos extends Tickets{

    private static $ticketsAbiertos;

    public function __construct()
    {
		parent::__construct();
       // $this->tickets = array();
		TicketsAbiertos::$ticketsAbiertos = $this;
    }
	
	public static function getTicketsAbiertos()
	{
		return TicketsAbiertos::$ticketsAbiertos;
	}
	
	private function cargarTickets()
	{
		Ticket::
	}

    public function cerrarTicket($idTicket, $datosTicket)
    {

    }

    public function resolverTicketTecnico($idTicket, $mensaje)
    {

    }
	
	public function resolverTicketUsuario($idTicket, $mensaje)
    {
		
	}
	
	public function resolverTicketCoordinador($idTicket, $mensaje, $plazoReapertura)
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
