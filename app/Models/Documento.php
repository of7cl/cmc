<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    // relacion muchos a muchos
    public function personas(){
        return $this->belongsToMany(Persona::class);
    }

    // relacion muchos a muchos
    public function rangos(){
        return $this->belongsToMany(Rango::class);
    }
}
