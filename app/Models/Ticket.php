<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\EstadoTicket;
use App\Models\Fuente;
use App\Models\Prioridad;
use App\Models\Tecnico;
use App\Models\Usuario;
use App\Models\Coordinador;
use App\Models\Solicitud;
use App\Models\Conversacion;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area', 'id');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoTicket::class, 'id_estado', 'id');
    }

    public function fuente()
    {
        return $this->belongsTo(Fuente::class, 'id_fuente', 'id');
    }

    public function prioridad()
    {
        return $this->belongsTo(Prioridad::class, 'id_prioridad', 'id');
    }

    public function conversaciones()
    {
        return $this->hasMany(Conversacion::class, 'id_ticket', 'id');
    }

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class, 'id_tecnico', 'id');
    }

    public function solicitante()
    {
        return $this->belongsTo(Usuario::class, 'id_solicitante', 'id');
    }

    public function coordinador()
    {
        return $this->belongsTo(Coordinador::class, 'id_coordinador', 'id');
    }

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'id_solicitud', 'id');
    }
}
