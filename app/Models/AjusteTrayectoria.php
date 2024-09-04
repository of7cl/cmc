<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AjusteTrayectoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'trayectoria_id',
        'vac_legales_lv',
        'vac_legales_ld',
        'embarco_1x1',
        'ajuste_descanso',
        'feriado_progresivo'
    ];

    // uno a muchos inversa
    public function trayectoria()
    {
        return $this->belongsTo(Trayectoria::class);
    }

}
