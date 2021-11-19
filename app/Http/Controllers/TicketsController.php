<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Controllers\Classes\Tickets;

use Illuminate\Support\Collection

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private static $ticketsController;
	private $ticketsTodos;
    private $ticketsNuevos;
    private $ticketsAbiertos;
    private $ticketsEspera;
    private $ticketsResueltos;

    public function __construct()
    {
        parent::__construct();
        $this->ticketsNuevos = new TicketsNuevos();
        $this->ticketsAbiertos = new TicketsAbiertos();
        $this->ticketsEspera = new TicketsEspera();
        $this->ticketsResueltos = new TicketsResueltos();
		$this->ticketsTodos = new Tickets();
		$this->ticketsTodos->insertarTickets(TicketsNuevos::getTicketsNuevos(), TicketsAbiertos::getTicketsAbiertos(), TicketsEspera::getTicketsEspera(), TicketsResueltos::getTicketsResueltos() );
		
		
        TicketsController::$ticketsController = $this;
    }

    public static function getTicketsController()
    {
        return TicketsController::$ticketsController;
    }

    public function index()
    {
        //
    }
	
	private function cargarTickets()
	{
		$arregloTickets = array();
		
		for( Ticket::all() as $ticket ) {
			$arregloTickets + [$ticket->id => $ticket];
		}
		
		$this->ticketsTodos = $arregloTickets;
		
		
	}

    /**
     * Crea un nuevo ticket
     *
     * @return Boolean
     */
    public function crearNuevoTicket($datosTicket, $idEncargado, $idSolicitud)
    {
		$ticket = new Ticket();
		$ticket->nombre = ;
		$ticket->id_fuente = ;
		$ticket->id_estado = ;
		$ticket->id_area = ;
		$ticket->id_prioridad = ;
		$ticket->tipo_problema = ;
		$ticket->desc_problema = ;
		$ticket->id_solicitante = ;
		$ticket->id_coordinador = ;
		
		if ($idSolicitud != null)
		{
			$ticket->id_solicitud = $idSolicitud;
		}
			
		if ($idEncargado != null)
        {
            //insertarTicket  Ticket::
            
			$ticket->id_encargado = $idEncargado;
            $ticketsAbiertos = $ticketsAbiertos + array($ticket->id => $ticket);
        }
		
		
        $ticketsNuevos = $ticketsNuevos + array($ticket->id => $ticket);
	    
    }
	
	public function suspenderTicket($idTicket, $idUsuario, $mensaje)
	{
		
	}
	
	public function eliminarTicket($ , $)
	{
		
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function asignarEncargado($idTecnico)
    {
        $ticketsNuevos->asignarEncargado($idTecnico);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function modificarDatoTicket($idTicket, $campo, $nuevoDato)
    {
        $ticketsNuevos->modificarDatoTickets($idTicket, $campo, $nuevoDato)
    }
	
	public function modificarDatosTicket($idTicket, $nuevosDatos)
	{
		$ticketsNuevos->modificarDatosTicket($idTicket, $nuevosDatos);
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function reabrirTicket($idTicket)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function resolverTicketTecnico($idTicket, $mensaje)
    {
        
    }
	
	public function resolverTicketUsuario($idTicket, $mensaje)
	{
		
	}
	
	public function resolverTicketCoordinador($idTicket, $mensaje, $plazoReapertura)
	{
		
	}
	
	private function fijarPlazoReapertura($idTicket, $plazo)
	{
	    
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function cerrarTicket($idTicket)
    {
        
    }
}
