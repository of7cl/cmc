<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class CarbonController extends Controller
{
    
    public function fecha_hoy()
    {
        $fecha = Carbon::now();
        return $fecha;
    }

    public function diffFechaActual($fc_fin)
    {
        $now = Carbon::now()->timeZone('America/Santiago');
        $diff = $now->diffInDays($fc_fin);
        return $diff;
    }   
    
    public function formatodmY($fecha)
    {
        $fc = new Carbon ($fecha);
        return $fc->format('d/m/Y');
    }
        
}
