<?php

namespace App\Http\Controllers\Classes;

use Illuminate\Support\Collection;
use App\Models\Solicitud;

class Solicitudes {

    private $solicitudes;
    private $solicitudesNuevas;
	private $solicitudesEnCurso;

    public function __construct()
    {
		$solicitudes = array();
        $solicitudesNuevas = array();
		$solicitudesEnCurso = array();
		cargarSolicitudes();
    }
	
	private function cargarSolicitudes()
	{
		$coleccionSolicitudesNuevas = Solicitud::where('en_curso', 'false')->get();
		$coleccionSolicitudesEnCurso = Solicitud::where('en_curso', 'true')->get();
		
		foreach ($coleccionSolicitudesNuevas as $solicitudNueva) {
			$solicitudesNuevas[$solicitudNueva->id] = $solicitudNueva;
		}
		
		foreach ($coleccionSolicitudesEnCurso as $solicitudEnCurso) {
			$solicitudesEnCurso[$solicitudEnCurso->id] = $solicitudEnCurso;
		}
		
		$solicitudes = array_merge($solicitudesNuevas, $solicitudesEnCurso); 
	}
	
	//Método que permite obtener una determinada solicitud.
	public function getSolicitud($idSolicitud)
	{
		return $solicitudes[$idSolicitud];
	}
	
	//Método que permite obtener el listado con todas las solicitudes.
	public function getSolicitudesNuevas()
	{
		return $solicitudesNuevas;
	}
	
	public function getSolicitudesEnCurso()
	{
		return $solicitudesEnCurso;
	}
	
	public function ponerSolicitudEnCurso($idSolicitud)
	{
		$solicitud = Solicitud::find($idSolicitud);
		if(!is_null($solicitud))
		{
			if(!$solicitud->en_curso)
			{
				$solicitudes[$idSolicitud]->en_curso = true;
				$solicitud->en_curso = true;
				$solicitud->save();
				unset($solicitudesNuevas[$idSolicitud]);
				$solicitudesEnCurso[$idSolicitud] = $solicitud;
				return true;
			}
		}
		return false;
	}
	
	//Método que permite al cliente registrar una nueva solicitud.
	public function agregarNuevaSolicitud($datosNuevaSolicitud)
	{
		$nuevaSolicitud = new Solicitud();
		
		$nuevaSolicitud->asunto = $datosNuevaSolicitud['asunto'];
		$nuevaSolicitud->en_curso = false;
		date_default_timezone_set("America/Santiago");
		$nuevaSolicitud->fecha_hora = date("Y/m/d H:i:s");
		$nuevaSolicitud->desc_problema = $datosNuevaSolicitud['desc_problema'];
		$nuevaSolicitud->id_solicitante = $datosNuevaSolicitud['id_solicitante'];
		
		$nuevaSolicitud->save();
		$solicitudes[$nuevaSolicitud->id] = $nuevaSolicitud; 
		$solicitudesNuevas[$nuevaSolicitud->id] = $nuevaSolicitud;
		return;
	}

    //Método que permite al cliente o al coordinador suspender una solicitud enviada.
    public function eliminarSolicitud($idSolicitud)
    {
		$solicitud = Solicitud::find($idSolicitud);
		
		if (is_null($solicitud) {
		    return false;	
		}
		$estaActiva = $solicitud->en_curso;
		
		Solicitud::destroy($idSolicitud);
		unset($solicitudes[$idSolicitud]);
		
		if ($estaActiva)
		{
			unset($solicitudesEnCurso[$idSolicitud]);
		}
		else
		{
			unset($solicitudesNuevas[$idSolicitud]);
		}
		return true;

    }

	//Método que permite al cliente modificar el texto de una solicitud enviada.
    public function modificarSolicitud($idSolicitud, $nuevosDatosSolicitud)
    {
		$solicitud = Solicitud::find($idSolicitud);
		$estaActiva = $solicitud->en_curso;
		
		if($nuevosDatosSolicitud['asunto'] != "")
		{
			$solicitud->asunto = $nuevosDatosSolicitud['asunto'];
			$solicitud->save();
			$solicitudes[$idSolicitud]->asunto = $nuevosDatosSolicitud['asunto'];
			if(!$estaActiva)
			{
				$solicitudesNuevas[$idSolicitud]->asunto = $nuevosDatosSolicitud['asunto'];
			}
			else
			{
				$solicitudesEnCurso[$idSolicitud]->asunto = $solicitudesEnCurso['asunto'];
			}
		}
		if ($nuevosDatosSolicitud['desc_problema'] != "")
		{
			$solicitud->desc_problema = $nuevosDatosSolicitud['desc_problema'];
			$solicitud->save();
			$solicitudes[$idSolicitud]->desc_problema = $nuevosDatosSolicitud['desc_problema'];
			if(!$estaActiva)
			{
				$solicitudesNuevas[$idSolicitud]->desc_problema = $nuevosDatosSolicitud['desc_problema'];
			}
			else
			{
				$solicitudesEnCurso[$idSolicitud]->desc_problema = $solicitudesEnCurso['desc_problema'];
			}
        }			
		return;
    }

  

}
