<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleTrayectoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'trayectoria_id',
        'ship_id',
        'estado_id',
        'fc_desde',
        'fc_hasta',
    ];

    // uno a muchos inversa
    public function trayectoria()
    {
        return $this->belongsTo(Trayectoria::class);
    }

    // uno a muchos inversa
    public function ship(){
        return $this->belongsTo(Ship::class);
    }

    // uno a muchos inversa
    public function estado(){
        return $this->belongsTo(Estado::class);
    }
    
}
