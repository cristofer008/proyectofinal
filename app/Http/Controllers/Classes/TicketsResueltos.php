<?php

namespace App\Http\Controllers\Classes;

use App\Http\Controllers\Classes\Tickets;
use App\Models\Ticket;
use Illuminate\Support\Collection;

class TicketsResueltos extends Tickets {

    private static $ticketsResueltos;

    public function __construct()
    {
        parent::__construct();
    }
	
	public static function getTicketsResueltos()
	{
		return TicketsResueltos::$ticketsResueltos;
	}
	
	private function cargarTickets()
	{
		Tickets::where('estado', '')
	}

    public function cerrarTicket($idTicket, $motivo)
    {
		$ticketACerrar = Ticket::find($idTicket);
        $tickets[$idTicket]->
    }
	
	//Método utilizado por cerrarTicket($idTicket, $motivo)
	private function crearTicketCerrado($datosTicket, $motivo)
	{
		
	}

    public function create()
    {
        // create notification
        // send email
        // return output
    }
}
