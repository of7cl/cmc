<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Persona;
use App\Models\ShipTipo;

class Ship extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre',
        'imo',
        'dwt',
        'trg',
        'loa',
        'manga',
        'descripcion',
        'ship_tipo_id'
    ];

    // relacion uno a muchos

    public function personas(){
        return $this->hasMany(Persona::class);
    }

    // uno a muchos 
    public function detalle_trayectoria(){
        return $this->hasMany(DetalleTrayectoria::class);
    }

    public function ship_tipo(){
        return $this->belongsTo(ShipTipo::class);
    }
}
