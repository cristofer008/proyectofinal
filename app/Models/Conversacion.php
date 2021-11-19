<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;
use App\Models\Comentario;

class Conversacion extends Model
{
    use HasFactory;

    protected $table = 'conversaciones';

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket', 'id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_conversacion', 'id');
    }
}
