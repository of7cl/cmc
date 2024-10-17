<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmbarcoProgramacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_programacion',
        'persona_id',
        'ship_id',
        'rango_id',
        'nr_semana',
        'nr_mes',
        'nr_anio',
        'id_estado',
        'str_color',
        'id_celda'
    ];

    // relacion uno a muchos
    public function persona(){
        return $this->hasMany(Persona::class);
    }

    // uno a muchos inversa
    public function ship(){
        return $this->belongsTo(Ship::class);
    }

    public function rango(){
        return $this->belongsTo(Rango::class);
    }

}
