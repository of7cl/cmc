<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ship;

class ShipTipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre'
    ];

    public function ship(){
        return $this->hasMany(Ship::class);
    }

    // relacion muchos a muchos
    public function rangos(){
        return $this->belongsToMany(Rango::class)->withPivot('obligatorio');
    }

    // relacion muchos a muchos
    public function documentos(){
        return $this->belongsToMany(Documento::class)->withPivot('obligatorio', 'rango_id');
    }
}
