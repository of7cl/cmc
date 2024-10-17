<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motivo extends Model
{
    use HasFactory;

    // uno a muchos 
    public function detalle_trayectoria(){
        return $this->hasMany(DetalleTrayectoria::class);
    }
}
