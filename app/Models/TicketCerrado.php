<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\Fuente;
use App\Models\Prioridad;
use App\Models\Coordinador;
use App\Models\Usuario;
use App\Models\Tecnico;

class TicketCerrado extends Model
{
    use HasFactory;

    protected $table = 'tickets_cerrados';

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area', 'id');
    }

    public function fuente()
    {
        return $this->belongsTo(Fuente::class, 'id_fuente', 'id');
    }

    public function prioridad()
    {
        return $this->belongsTo(Prioridad::class, 'id_prioridad', 'id');
    }

    public function coordinador()
    {
        return $this->belongsTo(Coordinador::class, 'id_coordinador', 'id');
    }

    public function solicitante()
    {
        return $this->belongsTo(Solicitante::class, 'id_solicitante', 'id');
    }

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class, 'id_tecnico', 'id');
    }
}
