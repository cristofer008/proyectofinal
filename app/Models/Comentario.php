<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Conversacion;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentarios';

    public function conversacion()
    {
        return $this->belongsTo(Conversacion::class, 'id_conversacion', 'id');
    }
}
