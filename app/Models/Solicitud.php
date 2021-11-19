<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;
use App\Models\Usuario;
use App\Models\Coordinador;
use App\Models\Audio;
use App\Models\Imagen;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_solicitante', 'id');
    }

    public function ticket()
    {
        return $this->hasOne(Ticket::class, 'id_solicitud', 'id');
    }

    public function audios()
    {
        return $this->hasMany(Audio::class, 'id_solicitud', 'id');
    }

    public function imagenes()
    {
        return $this->hasMany(Imagen::class, 'id_solicitud', 'id');
    }

    public function coordinador()
    {
        return $this->belongsTo(Coordinador::class, 'id_coordinador', 'id');
    }
}
