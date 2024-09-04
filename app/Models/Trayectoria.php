<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trayectoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'persona_id'
    ];

    // uno a uno
    public function persona(){
        return $this->belongsTo(Persona::class);
    }

    // uno a muchos
    public function cabecera_trayectoria(){
        return $this->hasMany(CabeceraTrayectoria::class);
    }

    // uno a muchos
    public function detalle_trayectoria(){
        return $this->hasMany(DetalleTrayectoria::class);
    }

    // uno a muchos
    public function ajuste_trayectoria(){
        return $this->hasMany(AjusteTrayectoria::class);
    }
    
}
