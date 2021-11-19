<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use Illuminate\Http\Request;
use App\Http\Controllers\Classes\Solicitudes;

class SolicitudesController extends Controller
{
	private $solicitudes;
	private static solicitudesController;
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function __construct()
	{
		$this->solicitudes = new Solicitudes();
		SolicitudesController::$solicitudesController = $this;
	} 
	 
	public static function getSolicitudesController()
	{
		return SolicitudesController::$solicitudesController;
	} 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agregarNuevaSolicitud(Request $request)
    {
        return $this->solicitudes->agregarNuevaSolicitud($request->input());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function getSolicitudes()
    {
        return response()->json(
		    array('solicitudes_nuevas' => $solicitudes->getSolicitudesNuevas(), 'solicitudes_curso' => $solicitudes->getSolicitudesEnCurso())
		);
    }
	
	public function getSolicitudesNuevas()
	{
		return response()->json(
		    array($solicitudes->getSolicitudesNuevas())
	    );
	}

    /**
     * Método para obtener una solicitud específica según el ID.
     *
     * @param  Request ()
     * @return Solicitud específica
     */
    public function getSolicitud(Request $request)
    {
        return response()->json( 
		    ['solicitud' => $solicitudes->getSolicitud($request->input('id_solicitud'))]
        );
	}

    /**
     * Método para modificar una solicitud específica, según el ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function modificarSolicitud(Request $request)
    {
        $datosSolicitud = $request->input();
		$solicitudes->($datosSolicitud['id_solicitud'], array($datosSolicitud['asunto'], $datosSolicitud['desc_problema']))
		return response()->json(
		    array()
		);
    }
	
	public function ponerSolicitudEnCurso(Request $request)
	{
		return response()->json(
		    array('confirmacion' => $solicitudes->ponerSolicitudEnCurso($request->input('id_solicitud')))
	    );
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function eliminarSolicitud(Request $request)
    {
		return response()->json(
            array('confirmacion' => $solicitudes->eliminarSolicitud($request->input('id_solicitud')) )
		);
    }
}
