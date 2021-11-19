<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketCerrado;

class Tecnico extends Model
{
    use HasFactory;

    protected $table = 'tecnicos';

	public function __construct($datosTecnico)
	{

	}

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_tecnico', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function ticketsCerrados()
    {
        return $this->hasMany(TicketCerrado::class, 'id_tecnico', 'id');
    }
}
