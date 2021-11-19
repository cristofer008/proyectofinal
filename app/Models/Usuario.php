<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Solicitud;
use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketCerrado;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'id_solicitante', 'id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_solicitante', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function ticketsCerrados()
    {
        return $this->hasMany(TicketCerrado::class, 'id_solicitante', 'id');
    }
}
