<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ship;
use App\Models\Rango;
use App\Models\Documento;

class Persona extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'rut',
        'rango_id',
        'ship_id',
        'fc_nacimiento',
        'fc_ingreso',
        'fc_baja'
    ];

    // relacion uno a muchos inversa

    public function ship(){
        return $this->belongsTo(Ship::class);
    }

    public function rango(){
        return $this->belongsTo(Rango::class);
    }

    // relacion muchos a muchos
    public function documento(){
        return $this->belongsToMany(Documento::class)->withPivot(['persona_id', 'documento_id', 'rango_id', 'fc_inicio', 'fc_fin']);
    }
    
}
