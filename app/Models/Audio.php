<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Solicitud;

class Audio extends Model
{
    use HasFactory;

    protected $table = 'audios';

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'id_solicitud', 'id');
    }
}
