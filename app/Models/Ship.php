<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Persona;

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
        'descripcion'
    ];

    // relacion uno a muchos

    public function personas(){
        return $this->hasMany(Persona::class);
    }
}
