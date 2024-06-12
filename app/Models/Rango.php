<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rango extends Model
{
    use HasFactory;    

    protected $fillable = [
        'codigo',
        'nombre',
        'nombre_completo'
    ];

    /* public function getRouteKeyName()
    {
        return "codigo";
    }
 */
    // relacion uno a muchos
    public function persona(){
        return $this->hasMany(Persona::class);
    }

    // relacion muchos a muchos
    public function documentos(){
        return $this->belongsToMany(Documento::class)->withPivot('obligatorio');
    }

    // uno a muchos 
    // public function cabecera_trayectoria(){
    //     return $this->hasMany(CabeceraTrayectoria::class);
    // }
}
