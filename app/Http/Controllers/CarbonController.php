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

    public function boSistemaAntiguo($fc_ingreso)
    {
        $boSistemaAntiguo = 0;
        $fcIngreso = Carbon::parse($fc_ingreso);
        $fcFinSistemaAntiguo = Carbon::parse('2022/03/31');
        $boSistemaAntiguo = $fcIngreso->isBefore($fcFinSistemaAntiguo);        
        return $boSistemaAntiguo; // 1=> Pertenece al sistema antiguo 2=> No pertenece al sistema antiguo
    }

    public function getFechaEsMenorHoy($fecha)
    {
        $now = now()->toDateString();
        $fc = Carbon::parse($fecha);        
        $hoy = Carbon::parse($now);
        return $fc->lessThan($hoy);        
    }

    public function getFechaEsMenorIgualHoy($fecha)
    {
        $now = now()->toDateString();
        $fc = Carbon::parse($fecha);
        $hoy = Carbon::parse($now);
        return $fc->lessThanOrEqualTo($hoy);        
    }

    public function getFechaEsMayorIgualHoy($fecha)
    {
        $now = now()->toDateString();
        $fc = Carbon::parse($fecha);
        $hoy = Carbon::parse($now);
        return $fc->greaterThanOrEqualTo($hoy);        
    }

    public function getFechaEsMayorHoy($fecha)
    {
        $now = now()->toDateString();
        $fc = Carbon::parse($fecha);
        $hoy = Carbon::parse($now);
        return $fc->greaterThan($hoy);        
    }
    
    public function getFechaEsMayorAOtra($fecha_ini, $fecha_fin)
    {
        $fc_ini = Carbon::parse($fecha_ini);
        $fc_fin = Carbon::parse($fecha_fin);        
        return $fc_ini->greaterThan($fc_fin);        
    }
        
}
