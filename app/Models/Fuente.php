<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;
use App\Models\TicketCerrado;

class Fuente extends Model
{
    use HasFactory;

    protected $table = 'fuentes';

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_fuente', 'id');
    }

    public function ticketsCerrados()
    {
        return $this->hasMany(TicketCerrado::class, 'id_fuente', 'id');
    }
}
