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
        'plaza_id',
        'fc_desde',
        'fc_hasta',
        'total_dias_calendario',
        'descanso_convenio',
        'saldo_descanso',
        'dias_vacaciones_consumidas',
        'dias_inhabiles_generados',
        'dias_inhabiles_favor',
        'dias_inhabiles_consumidos',
        'ajuste',
        'motivo_id',
        'observaciones'
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

    // uno a muchos inversa
    public function motivo(){
        return $this->belongsTo(Motivo::class);
    }
    
}
