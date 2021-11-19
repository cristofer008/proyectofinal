<?php

namespace App\Models;

use App\Models\Solicitud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    use HasFactory;

    protected $table = 'imagenes';

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'id_solicitud', 'id');
    }
}
