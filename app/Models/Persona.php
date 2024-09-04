<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ship;
use App\Models\Rango;
use App\Models\Documento;
use App\Models\Trayectoria;

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
        'fc_baja',
        'contrato_tipo_id',
        'foto'
    ];

    // relacion uno a muchos inversa

    public function ship(){
        return $this->belongsTo(Ship::class);
    }

    public function rango(){
        return $this->belongsTo(Rango::class);
    }

    public function contratoTipo(){
        return $this->belongsTo(ContratoTipo::class);
    }

    // relacion muchos a muchos
    public function documento(){
        return $this->belongsToMany(Documento::class)->withPivot(['id', 'persona_id', 'documento_id', 'rango_id', 'fc_inicio', 'fc_fin', 'estado','nm_archivo_guardado','nm_archivo_original','semaforo']);
    }

    public function trayectoria(){
        return $this->hasOne(Trayectoria::class);
    }
    
}
