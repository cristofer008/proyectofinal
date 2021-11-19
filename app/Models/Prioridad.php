<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;
use App\Models\TicketCerrado;

class Prioridad extends Model
{
    use HasFactory;

    protected $table = 'prioridades';

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_prioridad', 'id');
    }

    public function ticketsCerrados()
    {
        return $this->hasMany(TicketCerrado::class, 'id_prioridad', 'id');
    }
}
