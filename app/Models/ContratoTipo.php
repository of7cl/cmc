<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratoTipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre'
    ];

    // relacion uno a muchos
    public function persona(){
        return $this->hasMany(Persona::class);
    }
}
