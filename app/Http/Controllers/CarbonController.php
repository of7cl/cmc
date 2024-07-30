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
        $diff = $now->diffInDays($fc_fin, false);
        return $diff;
    } 
    
    public function diffEntreFechas($fc_ini, $fc_fin)
    {
        $fcIni = Carbon::parse($fc_ini);
        $fcFin = Carbon::parse($fc_fin);

        $diff = $fcIni->diffInDays($fcFin, false);
        return $diff;
    } 
    
    public function formatodmY($fecha)
    {
        $fc = new Carbon ($fecha);
        return $fc->format('d/m/Y');
    }
        
}
