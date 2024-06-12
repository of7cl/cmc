<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CabeceraTrayectoria extends Model
{
    use HasFactory;

    // uno a muchos inversa
    public function trayectoria()
    {
        return $this->belongsTo(Trayectoria::class);
    }

    // uno a muchos inversa
    // public function rango(){
    //     return $this->belongsTo(Rango::class);
    // }
}
