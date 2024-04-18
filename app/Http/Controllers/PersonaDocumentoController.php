<?php

namespace App\Http\Controllers;
use App\Http\Controllers\CarbonController;
use App\Models\ParameterDoc;
use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaDocumentoController extends Controller
{
    //
    public function getPersonasDocumentos()    
    {
        /*$personas = Persona::where('id', 251)->get();
        foreach ($personas as $persona) {
            foreach ($persona->documento as $documento) {
                dd($documento->pivot->fc_fin);
            }
            
        }*/
        $personas = Persona::with('documento')
                    //->where('id', 251)
                    ->get();        
        return $personas;
    }

    public function getDocumentosVencidos($personas)    
    {
        $parameterdocs = ParameterDoc::all();
        $flag_red = $parameterdocs[0]->flag_red;
        $flag_yellow = $parameterdocs[0]->flag_yellow;        
        $fecha = new CarbonController();
        $vencimientos = [];
        $i=0;
        foreach ($personas as $persona) {
            foreach ($persona->documento as $documento) {
                $fc_fin = $documento->pivot->fc_fin;
                $diff = $fecha->diffFechaActual($fc_fin);
                //dd($documento->codigo_omi);
                if ($diff <= $flag_red){
                    $vencimientos[$i]['icon'] = 'fas fa-user';
                    $vencimientos[$i]['text'] = 'Documento '.$documento->nr_documento.' '.$documento->codigo_omi.' se encuentra vencido con fecha '.$fecha->formatodmY($fc_fin).', para '.$persona->nombre;
                    $vencimientos[$i]['alert'] = 'danger';
                    $vencimientos[$i]['codigo'] = $persona->id;
                    $i++;                  
                }else if($diff > $flag_red && $diff < $flag_yellow){
                    $vencimientos[$i]['icon'] = 'fas fa-user';
                    $vencimientos[$i]['text'] = 'Documento '.$documento->nr_documento.' '.$documento->codigo_omi.' está por vencer con fecha '.$fecha->formatodmY($fc_fin).', para '.$persona->nombre;
                    $vencimientos[$i]['alert'] = 'warning';
                    $vencimientos[$i]['codigo'] = $persona->id;
                    $i++;                    
                }                              
            }            
        }        
        return $vencimientos;
    }
}
