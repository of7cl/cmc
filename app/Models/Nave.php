<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nave extends Model
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

    public function getRouteKeyName()
    {
        return "codigo";
    }

    // relacion uno a muchos

    public function personas(){
        return $this->hasMany(Personal::class);
    }
}
