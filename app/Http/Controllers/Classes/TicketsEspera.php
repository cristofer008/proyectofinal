<?php

namespace App\Http\Controllers\Classes;

use App\Http\Controllers\Classes\Tickets;
use App\Models\Ticket;
use Illuminate\Support\Collection;

class TicketsEspera extends Tickets {
	
	private static $ticketsEspera;

    public function __construct()
    {
        parent::__construct();
		TicketsEspera::$ticketsEspera = $this;
    }
	
	public static function getTicketsEspera()
	{
		return TicketsEspera::$ticketsEspera;
	}
	
	private function cargarTickets()
	{
		Tickets::where('estado', '')-get();
	}

    public function reabrirTicket($idTicket)
    {
		$this->
    }

    public function notificarReapertura($ ,$)
	{
		
	}
}
