<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketCerrado;

class Coordinador extends Model
{
    use HasFactory;

    protected $table = 'coordinadores';

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_coordinador', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function ticketsCerrados()
    {
        return $this->hasMany(TicketCerrado::class, 'id_coordinador', 'id');
    }

    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'id_coordinador', 'id');
    }
}
